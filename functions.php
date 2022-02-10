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

require_once("inc/posts-filter.php");
require_once("inc/forms-integrations.php");