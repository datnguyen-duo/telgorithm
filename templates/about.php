<?php
/* Template Name: About */
get_header(); ?>
    <div class="page-template-about-container">
        <?php
        $hero_section = get_field('hero_section');
        if( $hero_section['subtitle'] || $hero_section['title'] || $hero_section['description'] ): ?>
            <section class="hero-section">
            
                <div class="content-container">
                    <div class="section-content">
                        <?php if( $hero_section['subtitle'] ): ?>
                            <span class="fadein_wrap"><?= $hero_section['subtitle'] ?></span>
                        <?php endif; ?>

                        <?php if( $hero_section['title'] ): ?>
                            <h1 class="letter_wrap"><?= $hero_section['title'] ?></h1>
                        <?php endif; ?>

                        <?php if( $hero_section['description'] ): ?>
                            <p class="fadein_wrap"><?= $hero_section['description'] ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                
            </section>
        <?php endif; ?>

        <?php
        $cards_section = get_field('cards_section');
        if( $cards_section['title'] || $cards_section['cards'] ): ?>
            <section class="second-section">
                <div class="content-container">
                    <div class="section-content">
                        <h2 class="letter_wrap">
                            Transparency, compliance, and personalization are at the heart of who we are.
                        </h2>
                        <?php if( $cards_section['cards'] ): ?>
                            <div class="boxes-holder fadein_wrap">
                                <?php foreach ( $cards_section['cards'] as $card ): ?>
                                    <div class="single-box-holder">
                                        <div class="single-box">
                                            <?php if( $card['icon'] ): ?>
                                                <div class="icon_holder">
                                                    <img src="<?= $card['icon']['url'] ?>" alt="<?= $card['icon']['alt'] ?>">
                                                </div>
                                            <?php endif; ?>

                                            <div class="box_info">
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
                </div>
                <img src="<?= get_template_directory_uri() ?>/images/green_shape.svg" class="green_shape" alt="">
            </section>
        <?php endif; ?>

        <?php
        $history_section = get_field('history_section');
        if( $history_section['title'] || $history_section['description'] || $history_section['history'] ): ?>
            <section class="history-section">
                <div class="headline-holder">
                    <?php if( $history_section['title'] ): ?>
                        <h2 class="letter_wrap"><?= $history_section['title'] ?></h2>
                    <?php endif; ?>

                    <?php if( $history_section['description'] ): ?>
                        <p class="fadein_wrap"><?= $history_section['description'] ?></p>
                    <?php endif; ?>
                </div>

                <?php if( $history_section['history'] ): ?>
                    <div class="section-content">
                        <div class="left" dir="rtl">
                            <div class="history-slider">
                                <?php foreach ( $history_section['history'] as $history ): ?>
                                    <div class="single-slide">
                                        <div class="image-holder">
                                            <?= wp_get_attachment_image($history['image']['id'],'full') ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="right">
                            <div class="right-contenet">
                                <?php foreach ( $history_section['history'] as $history ): ?>
                                    <div class="single_box">
                                        <div class="year-holder">
                                            <div class="white-line"></div>
                                            <img src="<?= get_template_directory_uri() ?>/images/dashed-line.svg" class="dashed-line" alt="">
                                            <div class="year">
                                                <p><?= $history['year'] ?></p>
                                            </div>
                                        </div>
                                        <div class="info-holder">
                                            <h3><?= $history['title'] ?></h3>
                                            <p><?= $history['description'] ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <?php
        $img_with_desc_section = get_field('image_with_description_section');
        ?>
        <section class="team-section">
            <div class="content-container">
                <div class="section-content">
                    <div class="left">
                        <?php if( $img_with_desc_section['title'] ): ?>
                            <h2 class="letter_wrap"><?= $img_with_desc_section['title'] ?></h2>
                        <?php endif; ?>

                        <?php if( $img_with_desc_section['description'] ): ?>
                            <p class="fadein_wrap"><?= $img_with_desc_section['description'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="right fadein_wrap">
                        <div class="image-holder">
                            <?= wp_get_attachment_image($img_with_desc_section['image']['id'], 'full') ?>
                        </div>
                        <img src="<?= get_template_directory_uri() ?>/images/team_icon2.svg" class="team_icon2" alt="">
                        <div class="team_cta">
                            <img src="<?= get_template_directory_uri() ?>/images/team_icon1.svg" alt="">
                            
                            <div class="team_cta_info">
                                <h3>Our team is growing</h3>
                                <p>
                                    You’ll find only the best of the best on our team—and we intend to keep it that way.
                                </p>
                                <a href="" class="link">Join Us!<img src="<?= get_template_directory_uri() ?>/images/blue_arrow_right.svg" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php get_template_part( 'template-parts/posts',null, array(
            'data' => array (
                'title' => 'Check out our latest blog posts',
            )
        )); ?>
    </div>
<?php get_footer();