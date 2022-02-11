</main> <!--#page-content end-->
<?php
$copyright = get_field('copyright', 'option');
$linkedin = get_field('linkedin', 'option');
$instagram = get_field('instagram', 'option');
$facebook = get_field('facebook', 'option');
$twitter = get_field('twitter', 'option');
$site_description = get_field('site_description', 'option');
$form_section = get_field('subscription_form_section','option');
?>
<footer class="site-footer">
    <div class="content-container">
        <div class="section-content">
            <?php if ( is_front_page() ): ?>
                <?php
                $banner_section = get_field('banner_section');
                if( $banner_section['title'] || $banner_section['button'] ): ?>
                    <div class="cta_box">
                        <?php if( $banner_section['title'] ): ?>
                            <h3 class="letter_wrap blue"><?= $banner_section['title'] ?></h3>
                        <?php endif; ?>

                        <?php
                        $link = $banner_section['button'];
                        if( $link ):
                            $link_url = $link['url'];
                            $link_title = $link['title'];
                            $link_target = $link['target'] ? $link['target'] : '_self';
                            ?>
                            <div class="button-holder">
                                <a href="<?= esc_url( $link_url ); ?>" target="<?= esc_attr( $link_target ); ?>">
                                    <?= esc_html( $link_title ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php elseif( !is_page_template('templates/about.php') ): ?>
                <?php if( $form_section['title'] || $form_section['description'] || $form_section['form_key'] ): ?>
                    <div class="cta_box">
                        <?php if( $form_section['title'] ): ?>
                            <h2 class="letter_wrap blue"><?= $form_section['title'] ?>s</h2>
                        <?php endif; ?>

                        <?php if( $form_section['description'] ): ?>
                            <p class="fadein_wrap"><?= $form_section['description'] ?></p>
                        <?php endif; ?>

                        <?php
                        if( $form_section['form_key'] ):
                            $args = array(
                                // Whether the title should be displayed or not (true/false)
                                'display_title' => false,

                                // Whether the description should be displayed or not (true/false)
                                'display_description' => false,

                                // Text used for the submit button
                                'submit_text' => 'Subscribe',
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
                            advanced_form( $form_section['form_key'], $args );
                        endif;
                        ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="top">
                <div class="logo-holder">
                    <a class="logo" href="<?= site_url() ?>">
                        <img src="<?= get_template_directory_uri() ?>/images/logo.svg" alt="">
                    </a>
    
                    <?php if( $site_description ): ?>
                        <p><?= $site_description ?></p>
                    <?php endif; ?>
                </div>
    
                <nav>
                    <?php if( has_nav_menu('menu-3') ):
                        wp_nav_menu(
                            array(
                                'theme_location' => 'menu-3',
                                'container' => false,
                            )
                        );
                    endif; ?>
                </nav>
            </div>
            <div class="bottom">
                <div class="copyright">
                    <?php if( $copyright ): ?>
                        <p><?= $copyright ?></p>
                    <?php endif; ?>
                </div>
    
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
    
                <nav>
                    <?php if( has_nav_menu('menu-4') ):
                        wp_nav_menu(
                            array(
                                'theme_location' => 'menu-4',
                                'container' => false,
                            )
                        );
                    endif; ?>
                </nav>
            </div>
        </div>
    </div>
</footer>
</div>  <!--#page end-->

<?php wp_footer(); ?>

</body>

</html>
