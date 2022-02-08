</main> <!--#page-content end-->
<?php
$copyright = get_field('copyright', 'option');
$linkedin = get_field('linkedin', 'option');
$instagram = get_field('instagram', 'option');
$facebook = get_field('facebook', 'option');
$twitter = get_field('twitter', 'option');
$site_description = get_field('site_description', 'option');
?>
<footer class="site-footer">
    <div class="section-content">
        <div class="subscription">
            <h2>Get the SMS know-how</h2>
            <p>Navigate the telecom world with knowledge. Subscribe to our blogs to receive the latest industry news, tips, and guidance.</p>
            <form action="">
                <input type="email" name="email" placeholder="Your Email Address">
                <input type="submit" value="Get Started">
            </form>
        </div>
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
</footer>
</div>  <!--#page end-->

<?php wp_footer(); ?>

</body>

</html>
