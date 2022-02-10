<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
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
    ?>
    <header class="site-header <?= ( $is_dark_header ) ? ' dark-header' : null; ?>">
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

