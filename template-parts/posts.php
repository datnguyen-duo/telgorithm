<?php
$title = $args['data']['title'];
$title_type = $args['title_type'];
$query = $args['data']['query'];
$slider = $args['slider'];

if( !$query ) {
    $query = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 3,
    ));
}

if( $query->have_posts() ): ?>
    <section class="template-part-posts-section">
        <div class="content-container">
            <div class="section-content">
                <?php if( $title ): ?>
                    <h2 class="letter_wrap cream title <?= $title_type ?>"><?= $title ?></h2>
                <?php endif; ?>

                <?php if( $slider ): ?>
                    <div class="slider-posts">
                        <div class="swiper-container posts-slider-2">
                            <div class="swiper-wrapper">
                                <?php while( $query->have_posts() ): $query->the_post(); ?>
                                    <div class="swiper-slide">
                                        <div class="post-container fadein_wrap">
                                            <a class="post" href="<?php the_permalink() ?>">
                                                <div class="post-image">
                                                    <?php the_post_thumbnail('full'); ?>
                                                </div>
                                                <div class="post-info">
                                                    <div class="post-date tag"><?= get_the_date() ?></div>
                                                    <h2 class="post-title"><?php the_title() ?></h2>
                                                    <p class="link">Read More<img src="<?= get_template_directory_uri() ?>/images/blue_arrow_right.svg" alt=""></p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php endwhile; wp_reset_postdata(); ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="posts">
                        <?php while( $query->have_posts() ): $query->the_post(); ?>
                            <div class="post-container fadein_wrap">
                                <a class="post" href="<?php the_permalink() ?>">
                                    <div class="post-image">
                                        <?php the_post_thumbnail('full'); ?>
                                    </div>
                                    <div class="post-info">
                                        <div class="post-date tag"><?= get_the_date() ?></div>
                                        <h2 class="post-title"><?php the_title() ?></h2>
                                        <p class="link">Read More<img src="<?= get_template_directory_uri() ?>/images/blue_arrow_right.svg" alt=""></p>
                                    </div>
                                </a>
                            </div>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>