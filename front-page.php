<?php
//Home page
get_header(); ?>
    <div class="front-page-container">
        <?php $hero_section = get_field('hero_section'); ?>
        <section class="hero-section">
            <div class="content-container">
                <div class="section-content">
                    <video muted preload autoplay loop class="desktop_video">
                        <source src="<?= get_template_directory_uri() ?>/videos/home.mp4" type="video/mp4">
                    </video>
                    <video muted preload autoplay loop class="mobile_video">
                        <source src="<?= get_template_directory_uri() ?>/videos/home_mobile1.mp4" type="video/mp4">
                    </video>
                    <div class="headline-holder">
                        <?php if( $hero_section['title'] ): ?>
                            <h1 class="letter_wrap cream"><?= $hero_section['title'] ?></h1>
                        <?php endif; ?>

                        <?php
                        $link = $hero_section['button'];
                        if( $link ):
                            $link_url = $link['url'];
                            $link_title = $link['title'];
                            $link_target = $link['target'] ? $link['target'] : '_self';
                            ?>
                            <div class="button-holder fadein_wrap">
                                <a href="<?= esc_url( $link_url ); ?>" target="<?= esc_attr( $link_target ); ?>">
                                    <?= esc_html( $link_title ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <video muted preload autoplay loop class="mobile_video">
                        <source src="<?= get_template_directory_uri() ?>/videos/home_mobile2.mp4" type="video/mp4">
                    </video>
                </div>
            </div>
                            
            <img src="<?= get_template_directory_uri() ?>/images/pink_shape.svg" class="hero_shape" alt="">    
        </section>

        <?php
        $features_section = get_field('features_section');
        $cards_section = get_field('cards_section');
        if( $features_section['subtitle'] || $features_section['title'] || $features_section['features'] || $cards_section['title'] || $cards_section['cards'] ): ?>
            <section class="features-section">
                <div class="content-container">
                    <?php if( $features_section['subtitle'] || $features_section['title'] ): ?>
                        <div class="headline-holder">
                            <?php if( $features_section['subtitle'] ): ?>
                                <span class="fadein_wrap"><?= $features_section['subtitle'] ?></span>
                            <?php endif; ?>

                            <?php if( $features_section['title'] ): ?>
                                <h2 class="letter_wrap pink"><?= $features_section['title'] ?></h2>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="section-content">
                        <?php if( $features_section['features'] ): ?>
                            <div class="primary-features bound" id="bound-one">
                                <div class="left">
                                    <?php foreach ( $features_section['features'] as $feature ): ?>
                                        <div class="single-feature fadein_wrap">
                                            <?php if( $feature['image'] ): ?>
                                                <div class="feature-image-holder">
                                                    <img src="<?php echo $feature['image']['url']; ?>" alt="">
                                                </div>
                                            <?php endif; ?>

                                            <?php if( $feature['title'] ): ?>
                                                <h2><?= $feature['title'] ?></h2>
                                            <?php endif; ?>

                                            <?php if( $feature['description'] ): ?>
                                                <p><?= $feature['description'] ?></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="right">
                                    <div class="right-content">
                                        <div class="image-holder">
                                            <video muted preload id="features_video">
                                                    <source src="<?= get_template_directory_uri() ?>/videos/features.mp4" type="video/mp4">
                                            </video>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if( $cards_section['title'] || $cards_section['cards'] ): ?>
                            <div class="other-features-wrap">
                                <?php if( $cards_section['title'] ): ?>
                                    <h2 class="letter_wrap pink"><?= $cards_section['title'] ?></h2>
                                <?php endif; ?>

                                <?php if( $cards_section['cards'] ): ?>
                                    <div class="other-features">
                                        <?php foreach ( $cards_section['cards'] as $card ): ?>
                                            <div class="single-feature-box-holder">
                                                <div class="single-feature-box fadein_wrap">
                                                    <?php if( $card['icon'] ): ?>
                                                        <div class="icon_holder">
                                                            <img src="<?= $card['icon']['url'] ?>" alt="<?= $card['icon']['alt'] ?>">
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="feature_info">
                                                        <?php if( $card['title'] ): ?>
                                                            <h3><?= $card['title'] ?></h3>
                                                        <?php endif; ?>

                                                        <?php if( $card['description'] ): ?>
                                                            <p><?= $card['description'] ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php
        $acc_section = get_field('accordions_section');
        if( $acc_section['subtitle'] || $acc_section['title'] || $acc_section['accordions'] || $acc_section['image'] ): ?>
            <section class="faq-section">
                <div class="content-container">
                    <div class="section-content">
                        <div class="left">
                            <div class="headline-holder">
                                <?php if( $acc_section['subtitle'] ): ?>
                                    <span class="fadein_wrap"><?= $acc_section['subtitle'] ?></span>
                                <?php endif; ?>

                                <?php if( $acc_section['title'] ): ?>
                                    <h2 class="fadein_wrap"><?= $acc_section['title'] ?></h2>
                                <?php endif; ?>
                            </div>
                            <?php if( $acc_section['accordions'] ): ?>
                                <div class="accorions-wrap fadein_wrap">
                                    <?php foreach ( $acc_section['accordions'] as $index => $accordion ): $index++; $next = $index + 1; ?>
                                        <div class="single-accordion <?= ( $index == 1 ) ? 'active disabled' : '' ?>" id="accordion_<?= $index ?>" data-next="accordion_<?= ( $index == sizeof( $acc_section['accordions'] ) ) ? 1 : $next ?>">
                                            <div class="accordion-headline">
                                                <span><?= $index ?></span>
                                                <h3><?= $accordion['title'] ?></h3>
                                                <div class="accodion-button">
                                                    <img src="<?= get_template_directory_uri() ?>/images/accordion_opener.svg" alt="">
                                                </div>
                                            </div>
                                            <div class="accordion-description">
                                                <p><?= $accordion['description'] ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="right fadein_wrap">
                            <div class="headline-holder">
                                <?php if( $acc_section['subtitle'] ): ?>
                                    <span class="fadein_wrap"><?= $acc_section['subtitle'] ?></span>
                                <?php endif; ?>

                                <?php if( $acc_section['title'] ): ?>
                                    <h2 class="fadein_wrap"><?= $acc_section['title'] ?></h2>
                                <?php endif; ?>
                            </div>
                            <div class="image-holder">
                                <?php foreach($acc_section['accordions'] as $index => $accordion): ?>
                                    <?php if($accordion['image']): ?>
                                        <img src="<?php echo $accordion['image']['url']; ?>" class="<?= ( $index == 0 ) ? 'active' : '' ?>" data-id="accordion_<?= $index + 1 ?>" alt="">
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </div>
<?php get_footer();