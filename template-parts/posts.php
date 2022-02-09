<?php
$title = $args['data']['title'];
$title_type = $args['title_type'];
$query = $args['data']['query'];

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
                    <h2 class="letter_wrap title <?= $title_type ?>"><?= $title ?></h2>
                <?php endif; ?>

                <div class="posts">
                    <?php while( $query->have_posts() ): $query->the_post(); ?>
                        <div class="post-container fadein_wrap">
                            <article class="post">
                                <div class="post-image">
                                    <?php the_post_thumbnail('full'); ?>
                                </div>
                                <div class="post-info">
                                    <div class="post-date tag"><?= get_the_date() ?></div>
                                    <h2 class="post-title"><?php the_title() ?></h2>
                                    <a href="<?php the_permalink() ?>" class="link">Read More<img src="<?= get_template_directory_uri() ?>/images/blue_arrow_right.svg" alt=""></a>
                                </div>
                            </article>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>