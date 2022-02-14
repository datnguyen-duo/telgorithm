<?php
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
        if( $mc_settings['enabled'] && $mc_settings['api_key'] && $mc_settings['list_id'] ) {
            $email = '';
            $first_name = '';
            $last_name = '';
            $list_tags = array();

            foreach( $fields as $field ) {
                if( $field['type'] == 'email') {
                    $email = $field['value'];
                }

                if( $field['name'] == 'first_name' ) {
                    $first_name = $field['value'];
                }

                if( $field['name'] == 'last_name' ) {
                    $last_name = $field['value'];
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
                    'merge_fields'  => array(
                        'FNAME' => $first_name,
                        'LNAME'	=> $last_name
                    )
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
            $formname = $form['title'];
            
            foreach( $fields as $field ) {
                if( $field['type'] == 'email') {
                    $formEmail = $field['value'];
                }
    
                if( $field['name'] == 'first_name' ) {
                    $form_first_name = $field['value'];
                }
    
                if( $field['name'] == 'last_name' ) {
                    $form_last_name = $field['value'];
                }

                if( $field['name'] == 'message' ) {
                    $form_message = $field['value'];
                }

                if( $field['name'] == 'number' ) {
                    $form_number = $field['value'];
                }

                if( $field['name'] == 'company_name' ) {
                    $form_company_name = $field['value'];
                }

                if( $field['name'] == 'company_website' ) {
                    $form_company_website = $field['value'];
                }

                if( $field['name'] == 'country' ) {
                    $form_country = $field['value'];
                }

                if( $field['name'] == 'other_country' ) {
                    $form_other_country = $field['value'];
                }

                if( $field['name'] == 'majority_of_your_messaging_volume' ) {
                    $form_majority_of_your_messaging_volume = $field['value'];
                }

                if( $field['name'] == 'average_annual_text_volume' ) {
                    $form_average_annual_text_volume = $field['value'];
                }
            }
    
            function create_account($name, $lastName, $email, $message, $number, $form_name, $company, $company_website, $country, $other_country, $messaging_volume, $text_volume, $instance_url, $access_token)
            {
                $url = "$instance_url/services/data/v47.0/sobjects/Contact__c/";
                $content = json_encode(array("Name" => $name.' '.$lastName, "First_Name__c" => $name, "Last_Name__c" =>$lastName, "Email__c" =>$email, "Message__c" =>$message, "Number__c" =>$number, "Form_Name__c" => $form_name, "Company__c" => $company, "Company_Website__c" => $company_website, "Country__c" => $country, "Other_Country__c" => $other_country, "Messaging_Volume__c" => $messaging_volume, "Average_Annual_Text_Volume__c" => $text_volume));
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
                $response = json_decode($json_response, true);
    
                $id = $response["id"];
                
            }
            create_account($form_first_name, $form_last_name, $formEmail, $form_message, $form_number, $formname, $form_company_name, $form_company_website, $form_country, $form_other_country, $form_majority_of_your_messaging_volume, $form_average_annual_text_volume, $instance_url, $access_token);
        }
        //SALEFROCE WEBHOOK END
    }
}
add_action( 'af/form/submission', 'handle_form_submission', 10, 3 );