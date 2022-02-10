<?php
if ( ! function_exists( 'site_setup' ) ) :
    function site_setup() {
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );

        register_nav_menus(
            array(
                'menu-1' => esc_html__( 'Header - Primary', 'telgorithm' ),
                'menu-2' => esc_html__( 'Header - Top Bar', 'telgorithm' ),
                'menu-3' => esc_html__( 'Footer - Primary', 'telgorithm' ),
                'menu-4' => esc_html__( 'Footer - Bottom Bar', 'telgorithm' ),
            )
        );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );
    }
endif;
add_action( 'after_setup_theme', 'site_setup' );

function site_scripts() {
    wp_enqueue_style( 'site-style', get_stylesheet_uri(), array(), '1.0' );

    wp_enqueue_style( 'slick-css', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.0' );

    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), '3.1.1', true);
    wp_enqueue_script('swiper-js', get_theme_file_uri('/js/swiper-min.js'), NULL, '6.8.1', true);

    wp_enqueue_script('slick-js','https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', array(), true);
    wp_enqueue_script('gsap-js','https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.0/gsap.min.js', array(), true);
    wp_enqueue_script('ScrollTrigger-js','https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.0/ScrollTrigger.min.js', array(), true);
    
    wp_enqueue_script('split-text', get_theme_file_uri('/js/SplitText.min.js'), NULL, '1.0', true);
    wp_enqueue_script('main', get_theme_file_uri('/js/main.js'), NULL, '1.0', true);
    wp_localize_script('main','site_data',array(
        'site_url' => site_url(),
        'theme_url' => get_template_directory_uri(),
    ));
}
add_action( 'wp_enqueue_scripts', 'site_scripts' );

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Global Settings',
        'menu_title' => 'Global Settings',
        'menu_slug' => 'global-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}

require_once("inc/posts-filter.php");

function icon_arrow() { ?>
    <svg xmlns="http://www.w3.org/2000/svg" width="17.065" height="16.098" viewBox="0 0 17.065 16.098">
        <g id="Group_601" data-name="Group 601" transform="translate(-843.499 -780.451)">
            <g id="Group_595" data-name="Group 595" transform="translate(-540.673 -5799.777)">
                <path id="Path_43" data-name="Path 43" d="M-16527.684,6577.908l6.635,6.636-6.635,6.634" transform="translate(17921.287 3.735)" fill="none" stroke="#0e183f" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                <line id="Line_497" data-name="Line 497" x2="15.063" transform="translate(1385.172 6588.279)" fill="none" stroke="#0e183f" stroke-linecap="round" stroke-width="2"/>
            </g>
        </g>
    </svg>
<?php }

function handle_form_submission( $form, $fields, $args ) {
    
    if($fields){
        //SLACK WEBHOOK
        $data = json_encode(array(
            "text" => 'New message from '.$form['title'].' form', //"Hello, Foo-Bar channel message.",
        ));
    
        $ch = curl_init('https://hooks.slack.com/services/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');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('payload' => $data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        //MAILCHIMP WEBHOOK
        $email = '';
        $first_name = '';
        $last_name = '';
        
        foreach($fields as $field){
            if($field['type'] == 'email'){
                $email = $field['value'];
            }

            if($field['name'] == 'first_name'){
                $first_name = $field['value'];
            }

            if($field['name'] == 'last_name'){
                $last_name = $field['value'];
            }
        }
        
        if($email){

            $api_key = '161c573517003678b6dccd2ddbf933a8-us14'; // YOUR API KEY

            // server name followed by a dot. 
            // We use us13 because us13 is present in API KEY
            $server = 'us14.'; 

            $list_id = '5d1bacc37c'; // YOUR LIST ID

            $auth = base64_encode( 'user:'.$api_key );
                
            $data = array(
                'apikey'        => $api_key,
                'email_address' => $email,
                'status'        => 'subscribed',
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
        }
    }
}
add_action( 'af/form/submission', 'handle_form_submission', 10, 3 );



