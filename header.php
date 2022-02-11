<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>

    <?php the_field('site_script','option') ?>
</head>

<body <?php body_class('loading'); ?>>
<?php wp_body_open(); ?>

<div id="page">
    <?php
    $templates_with_dark_header = array(
        'templates/contact.php',
        'templates/get-started.php',
        'templates/thank-you.php',
        'templates/about.php',
    );
    $is_dark_header = is_page_template($templates_with_dark_header) || is_front_page() || ( is_page() && !is_page_template() );

    $linkedin = get_field('linkedin', 'option');
    $instagram = get_field('instagram', 'option');
    $facebook = get_field('facebook', 'option');
    $twitter = get_field('twitter', 'option');
    ?>
    <header class="site-header <?= ( $is_dark_header ) ? ' dark-header dark-logo' : null; ?>">
        <div class="mobile_navigation">
            <div class="mobile_navigation_content">
                <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'menu-5',
                            'container' => false,
                        )
                    );
                ?>

                <div class="social-media-wrap">
                    <p>Contact Us</p>
                    <a href="mailto:hello@telgorithm.com">hello@telgorithm.com</a>
                    <div class="social-media">
                        <?php if( $linkedin || $instagram || $facebook || $twitter ): ?>
                            <ul>
                                <?php if( $linkedin ): ?>
                                    <li><a href="<?= $linkedin ?>"><img src="<?= get_template_directory_uri() ?>/images/linkedin.svg" alt=""></a></li>
                                <?php endif; ?>
                                <?php if( $instagram ): ?>
                                    <li><a href="<?= $instagram ?>"><img src="<?= get_template_directory_uri() ?>/images/instagram.svg" alt=""></a></li>
                                <?php endif; ?>
                                <?php if( $facebook ): ?>
                                    <li><a href="<?= $facebook ?>"><img src="<?= get_template_directory_uri() ?>/images/facebook.svg" alt=""></a></li>
                                <?php endif; ?>
                                <?php if( $twitter ): ?>
                                    <li><a href="<?= $twitter ?>"><img src="<?= get_template_directory_uri() ?>/images/twitter.svg" alt=""></a></li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-content">
            <?php if( has_nav_menu('menu-2') ): ?>
                <div class="top">
                    <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'menu-2',
                                'container' => false,
                            )
                        );
                    ?>
                </div>
            <?php endif; ?>

            <div class="bottom">
                
                <nav>
                    <div class="logo">
                        <a href="<?= site_url() ?>">
                            <img src="<?= get_template_directory_uri() ?>/images/logo<?= ( $is_dark_header ) ? '-dark' : null; ?>.svg" alt="">
                        </a>
                    </div>

                    <?php if( has_nav_menu('menu-1') ):
                        wp_nav_menu(
                            array(
                                'theme_location' => 'menu-1',
                                'container' => false,
                            )
                        );
                    endif; ?>
                </nav>

                <div class="mobile_opener">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <?php
                $link = get_field('button','option');
                if( $link ):
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>
                    <div class="button-holder">
                        <a class="button" href="<?= esc_url( $link_url ); ?>" target="<?= esc_attr( $link_target ); ?>">
                            <?= esc_html( $link_title ); ?>
                        </a>
                    </div>
                <?php endif; ?>


            </div>
        </div>
    </header>

    <main id="page-content">

