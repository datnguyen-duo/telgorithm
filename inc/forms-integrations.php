<?php
function handle_form_submission( $form, $fields, $args ) {
    $form_id = $form['post_id'];
    $mc_settings = get_field('mailchimp_settings',$form_id);
    $slack_settings = get_field('slack_settings',$form_id);

    if( $fields ) {
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
    }
}
add_action( 'af/form/submission', 'handle_form_submission', 10, 3 );