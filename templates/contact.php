<?php
/* Template Name: Contact */
get_header(); ?>
    <div class="page-template-contact-container">
        <?php
        $title = get_field('title');
        $desc = get_field('description');
        if( $title || $desc ): ?>
            <section class="hero-section">
                <?php if( $title ): ?>
                    <h1 class="title letter_wrap cream" id="join"><?= $title ?></h1>
                <?php endif; ?>

                <?php if( $desc ): ?>
                    <p class="description fadein_wrap"><?= $desc ?></p>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <?php
        $Phone = '1111';
        $Title = 'Title';
        $Company = 'company';
        $Industry = 'Industry';
        $OwnerId = 'OwnerId';
        $LeadSource = 'LeadSource';

//        $apiurl = 'https://spotdigital.lightning.force.com/services/data/v37.0/sobjects/Lead/';
//        $apiurl = 'https://spotdigital.lightning.force.comservlet/servlet.WebToLead?encoding=UTF-8';

        //url - test
        $url = 'https://spotdigital.lightning.force.com/servlet/servlet.WebToLead?encoding=UTF-8';

        //your POST data
        $fields = array('first_name'=>urlencode('Test'),
            'last_name'=>urlencode('Test'),
            'company'=>urlencode('Test Inc.'),
            'description'=>urlencode('Test'),
            'phone'=>urlencode('+55 41 0000-0000'),
            'recordType' =>urlencode(''),
            'oid' => '',
            'retURL' => urlencode('/'));

        $fields_string = '';

        //url-ify the data for the POST
        foreach($fields as $key => $value) {
            $fields_string .= $key.'='.$value.'&';
        }

        $fields_string = rtrim($fields_string,'&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION, TRUE);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);


        $forms = get_field('forms');
        if( $forms ): ?>
            <div class="form-section fadein_wrap">
                <ul class="form-selector">
                    <?php foreach ( $forms as $index => $form ): ?>
                        <li class="<?= ( $index == 0 ) ? 'active' : null ?>" data-form=".form-<?= $index ?>"><?= $form['title'] ?></li>
                    <?php endforeach; ?>
                </ul>
                <div class="forms">
                    <?php foreach ( $forms as $index => $form ): $form_key = $form['form_key']; ?>
                        <div class="form-container form-holder form-<?= $index ?> <?= ( $index == 0 ) ? ' active' : null ?>">
                            <?php
                            $args = array(
                                // Whether the title should be displayed or not (true/false)
                                'display_title' => false,

                                // Whether the description should be displayed or not (true/false)
                                'display_description' => false,

                                // Text used for the submit button
                                'submit_text' => 'Submit',
                                // 'ajax' => false,

                                // The URL to which the form points. Defaults to the current URL which will automatically display a success message after submission
                                // If this is overriden you may use af_has_submission to check for a form submission
    //                            'target' => CURRENT_URL,

                                // Whether the form output should be echoed or returned
                                'echo' => true,

                                // Field values to pre-fill. Should be an array with format: $field_name_or_key => $field_prefill_value
                                'values' => array(),

                                // Array of field keys or names to exclude from form rendering
                                'exclude_fields' => array(),

                                // Either 'wp' or 'basic'. Whether to use the Wordpress media uploader or a regular file input for file/image fields.
                                'uploader' => 'wp',

                                // The URL to redirect to after a successful submission. Defaults to false for no redirection.
                                'redirect' => home_url('thank-you'),
                            );
                            advanced_form( $form_key, $args ); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php get_footer();