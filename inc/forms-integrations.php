<?php

//This loads fields for MC and Salesforce because they share fields with same name
function acf_load_form_matching_fields( $field ) {
    // reset choices
    $field['sub_fields'][0]['choices'] = array();

    global $post;

    $form = af_get_form( $post->ID );

    // Get field groups for the current form
    $field_groups = af_get_form_field_groups( $form['key'] );

    if ( !empty( $field_groups ) ) :
        foreach ( $field_groups as $field_group ) :
            // Get all fields for this field group
            $fields = acf_get_fields( $field_group );

            foreach ( $fields as $index => $field_item ):
                $field['sub_fields'][0]['choices'][ $field_item['name'] ] = $field_item['name'];
            endforeach;
        endforeach;
    endif;

    // return the field
    return $field;
}
add_filter('acf/load_field/name=matching_fields', 'acf_load_form_matching_fields');

function acf_load_mc_email_matching_field_choices( $field ) {
    // reset choices
    $field['choices'] = array();

    global $post;

    $form = af_get_form( $post->ID );

    // Get field groups for the current form
    $field_groups = af_get_form_field_groups( $form['key'] );

    if ( !empty( $field_groups ) ) :
        foreach ( $field_groups as $field_group ) :
            // Get all fields for this field group
            $fields = acf_get_fields( $field_group );

            foreach ( $fields as $index => $field_item ):
                $field['choices'][ $field_item['name'] ] = $field_item['name'];
            endforeach;
        endforeach;
    endif;

    // return the field
    return $field;
}
add_filter('acf/load_field/name=mc_email_matching_field', 'acf_load_mc_email_matching_field_choices');

function handle_form_submission( $form, $fields, $args ) {
    $form_id = $form['post_id'];
    $mc_settings = get_field('mailchimp_settings',$form_id);
    $slack_settings = get_field('slack_settings',$form_id);
    $saleforce_settings = get_field('saleforce_settings',$form_id);

    if( $fields ) {
        // var_dump($form['title']);var_dump($fields);die;
        //SLACK WEBHOOK
        if( $slack_settings['enabled'] && $slack_settings['webhook_url'] ){
            $slack_message_title = $slack_settings['slack_title'];
            $slack_message_title_link = $slack_settings['title_link'];
            $slack_message = "";

            if( $slack_message_title && $slack_message_title_link ) {
                $slack_message.= "<".$slack_message_title_link."|*".$slack_message_title."*>";
            } elseif( $slack_message_title ) {
                $slack_message.= "*".$slack_message_title."*";
            }

            $slack_message.="\n\n";

            if( $slack_settings['text'] ) {
//                'New message from '.$form['title'].' form.'
                $slack_message.= $slack_settings['text']."\n\n";
            }

            foreach ( $fields as $field ){
                if( $field['name'] != 'recaptcha' ) {
                    $value = $field['value'];

                    if( $field['name'] == 'attachment' ) {
                        if( !$value ) {
                            $value = 'No attachment';
                        } else {
                            $value = $field['value']['url'];
                        }
                    } else {
                        if( !$value ) {
                            $value = 'NA';
                        }
                    }

                    $slack_message .= "*".$field['label']."* \n".$value."\n\n";
                }
            }
            $data = json_encode(array(
                "text" => $slack_message
            ));

            $ch = curl_init($slack_settings['webhook_url']);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, array('payload' => $data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
        }
        //SLACK WEBHOOK END

        //MAILCHIMP WEBHOOK
        if( $mc_settings['enabled'] && $mc_settings['mc_email_matching_field'] && $mc_settings['api_key'] && $mc_settings['list_id'] ) {
            $email = '';
            $list_tags = array();
            $merge_fields = array();

            foreach( $fields as $field ) {
                //Match email
                if( !$email && $field['name'] == $mc_settings['mc_email_matching_field'] ) {
                    $email = $field['value'];
                }

                //Match other fields
                if( $mc_settings['matching_fields'] ) {
                    foreach( $mc_settings['matching_fields'] as $m_field ) {
                        if( $field['name'] == $m_field['form_field'] ) {
                            $merge_fields[$m_field['mailchimp_filed']] = $field['value'];
                        }
                    }
                }
            }

            if( $email ) {
                if( $mc_settings['tags'] ) {
                    $list_tags = explode(',',$mc_settings['tags']);
                }

                $api_key = $mc_settings['api_key'];

                // server name followed by a dot.(us14.)
                // We use us13 because us13 is present in API KEY
                $server = $mc_settings['server_name'];

                $list_id = $mc_settings['list_id'];

                $auth = base64_encode( 'user:'.$api_key );

                $data = array(
                    'apikey'        => $api_key,
                    'email_address' => $email,
                    'status'        => 'subscribed',
                    'tags'  => $list_tags,
                    'merge_fields'  => $merge_fields
                );
                $json_data = json_encode($data);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://'.$server.'api.mailchimp.com/3.0/lists/'.$list_id.'/members/');
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                    'Authorization: Basic '.$auth));
                curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

                $result = curl_exec($ch);

                $result_obj = json_decode($result);

                // printing the result obtained
                // echo $result_obj->status;
                // echo '<br>';
                // echo '<pre>'; print_r($result_obj); echo '</pre>';
                curl_close($ch);
            }
        }
        //MAILCHIMP WEBHOOK END

        //SALEFROCE WEBHOOK
        if( $saleforce_settings['enabled'] && $saleforce_settings['my_saleforce_url'] && $saleforce_settings['cleint_id'] && $saleforce_settings['cleint_secret'] && $saleforce_settings['saleforce_username'] && $saleforce_settings['saleforce_password']) {

            $salesforce_matched_fields = array();
            if( $saleforce_settings['matching_fields'] ) {
                //Check if matching fields exists

                foreach( $fields as $field ) {
                    //Loop all form fields

                    foreach( $saleforce_settings['matching_fields'] as $m_field ) {
                        //Loop all matching fields

                        //Concatenated matching fields (full_name = first_name & last_name for example)
                        if( in_array( $field['name'], $m_field['form_field'] ) ) {
                            //Check if form field is in current matching fields array

                            foreach ( $m_field['form_field'] as $index => $item ) {
                                //Loop current matching fields

                                if( $field['name'] == $item ) {
                                    $salesforce_matched_fields[$m_field['salesforce_filed']] .= $field['value'];

                                    if( ( sizeof( $m_field['form_field'] ) - 1 ) != $index ) {
                                        //Add spacing between concatenated fields
                                        $salesforce_matched_fields[$m_field['salesforce_filed']] .= ' ';
                                    }
                                }
                            }
                        }
                        //Concatenated matching fields (full_name = first_name & last_name for example) END

                        //If you don't need concatenation(multiple fields select) you can remove above code and uncomment bellow code
                        //In acf fields settings just disable multi select option
//                        if( $field['name'] == $m_field['form_field'] ) {
//                            $salesforce_matched_fields[$m_field['salesforce_filed']] = $field['value'];
//                        }
                    }
                }
            }

//            $form_name = $form['title'];
//            var_dump($salesforce_matched_fields);
//            var_dump(json_encode($salesforce_matched_fields));

            session_start();
            $my_url = $saleforce_settings['my_saleforce_url'];
            $clientId = $saleforce_settings['cleint_id'];
            $clientSecret = $saleforce_settings['cleint_secret'];
            $saleforceUsername = $saleforce_settings['saleforce_username'];
            $saleforcePassword = $saleforce_settings['saleforce_password'];

            $token_url ="$my_url/services/oauth2/token";
            $params =
            "grant_type=password"
            . "&client_id=$clientId"
            . "&client_secret=$clientSecret"
            . "&username=$saleforceUsername"
            . "&password=$saleforcePassword";
            $curl = curl_init($token_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            $json_response = curl_exec($curl);
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ( $status != 200 )
                {
                    die("Error: call to token URL $token_url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
                }
            curl_close($curl);
            $response = json_decode($json_response, true);

            $access_token = $response['access_token'];
            $instance_url= $response['instance_url'];

            $url = "$instance_url/services/data/v47.0/sobjects/Contact__c/";
            $content = json_encode($salesforce_matched_fields);
//            $content = json_encode(array("Name" => $name.' '.$lastName, "First_Name__c" => $name, "Last_Name__c" =>$lastName, "Email__c" =>$email, "Message__c" =>$message, "Number__c" =>$number, "Form_Name__c" => $form_name, "Company__c" => $company, "Company_Website__c" => $company_website, "Country__c" => $country, "Other_Country__c" => $other_country, "Messaging_Volume__c" => $messaging_volume, "Average_Annual_Text_Volume__c" => $text_volume));
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER,array("Authorization: Bearer $access_token","Content-type: application/json"));
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
            $json_response = curl_exec($curl);
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if ( $status != 201 )
                {
                    die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
                }

            curl_close($curl);
//            $response = json_decode($json_response, true);
//            $id = $response["id"];
        }
        //SALEFROCE WEBHOOK END
    }
}
add_action( 'af/form/submission', 'handle_form_submission', 10, 3 );