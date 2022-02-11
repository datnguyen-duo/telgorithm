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
                            <h1 class="letter_wrap cream"><?= $hero_section['title'] ?></h1>
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
                        <?php if( $cards_section['title'] ): ?>
                            <h2 class="letter_wrap cream"><?= $cards_section['title'] ?></h2>
                        <?php endif; ?>

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
                        <h2 class="letter_wrap green"><?= $history_section['title'] ?></h2>
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
                                            <img src="<?= get_template_directory_uri() ?>/images/mobile_dash.svg" class="mobile_dash" alt="">
                                            
                                            <div class="year">
                                                <p><?= $history['year'] ?></p>
                                            </div>
                                        </div>
                                        <div class="info-holder">

                                            <div class="image-holder-mobile">
                                                <?= wp_get_attachment_image($history['image']['id'],'full') ?>
                                            </div>
                                            <div class="year">
                                                <p class="mobile_year"><?= $history['year'] ?></p>
                                            </div>
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
        $img_desc_section = get_field('image_with_description_section');

        if( $img_desc_section['title'] || $img_desc_section['description'] || $img_desc_section['image'] || $img_desc_section['title_2'] || $img_desc_section['description_2'] || $img_desc_section['link'] ): ?>
            <section class="team-section">
                <div class="content-container">
                    <div class="section-content">
                        <div class="left">
                            <div class="left-content">
                                <?php if( $img_desc_section['title'] ): ?>
                                    <h2 class="letter_wrap cream"><?= $img_desc_section['title'] ?></h2>
                                <?php endif; ?>

                                <?php if( $img_desc_section['description'] ): ?>
                                    <p class="fadein_wrap"><?= $img_desc_section['description'] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="right fadein_wrap">
                            <?= wp_get_attachment_image($img_desc_section['image']['id'], 'full') ?>

                            <?php if( $img_desc_section['title_2'] || $img_desc_section['description_2'] || $img_desc_section['link'] ): ?>
                                <div class="team_cta">
                                    <div class="team_cta_info">
                                        <?php if( $img_desc_section['title_2'] ): ?>
                                            <h3><?= $img_desc_section['title_2'] ?></h3>
                                        <?php endif; ?>

                                        <?php if( $img_desc_section['description_2'] ): ?>
                                            <p><?= $img_desc_section['description_2'] ?></p>
                                        <?php endif; ?>

                                        <?php
                                        $link = $img_desc_section['link'];
                                        if( $link ):
                                            $link_url = $link['url'];
                                            $link_title = $link['title'];
                                            $link_target = $link['target'] ? $link['target'] : '_self'; ?>
                                            <a class="link" href="<?= esc_url( $link_url ); ?>" target="<?= esc_attr( $link_target ); ?>">
                                                <?= esc_html( $link_title ); ?>
                                                <img src="<?= get_template_directory_uri() ?>/images/blue_arrow_right.svg" alt="">
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php get_template_part( 'template-parts/posts',null, array(
            'slider' => true,
            'data' => array (
                'title' => 'Check out our latest blog posts',
            )
        )); ?>
    </div>
<?php get_footer();