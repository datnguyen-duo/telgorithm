<?php get_header();
$terms = get_the_terms(get_the_ID(),'category');
$blog_page_id = get_option('page_for_posts');
$terms_slugs = [];
$post_id = get_the_ID();
?>
    <div class="single-post-page-container">
        <section class="hero-section">
            <div class="post">
                <div class="left">
                    <?php if( $blog_page_id ): ?>
                        <a href="<?= get_the_permalink($blog_page_id) ?>" class="back-button">
                        <img src="<?= get_template_directory_uri() ?>/images/back_icon.svg" alt="">
                            All Posts
                        </a>
                    <?php endif; ?>

                    <h1 class="title letter_wrap green"><?php the_title() ?></h1>
                </div>
                <div class="right fadein_wrap">
                    <div class="image-holder">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                </div>
            </div>
            <div class="post-info">
                <div class="left fadein_wrap">
                    <?php if( $terms ): ?>
                        <p>Tags</p>

                        <div class="posts-tags">
                            <?php foreach ( $terms as $term ): array_push($terms_slugs,$term->slug)?>
                                <div class="tag"><?= $term->name ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="right">
                    <div class="tag"><?= get_the_date() ?></div>
                </div>
            </div>
        </section>

        <section class="editor-section">
            <div class="text-editor">
                <?php
                while( have_posts() ): the_post();
                    the_content();
                endwhile; ?>
            </div>
        </section>

        <?php
        $banner_section = get_field('banner_section','option');
        if( $banner_section['title'] || $banner_section['button'] || $banner_section['image'] ): ?>
        <section class="banner-section">
            <div class="section-content">
                <div class="left fadein_wrap">
                    <div class="image-holder">
                        <?php if( $banner_section['image'] ): ?>
                            <?= wp_get_attachment_image($banner_section['image']['id'],'full') ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="right">
                    <?php if( $banner_section['title'] ): ?>
                        <h2 class="title letter_wrap pink"><?= $banner_section['title'] ?></h2>
                    <?php endif; ?>

                    <?php
                    $link = $banner_section['button'];
                    if( $link ):
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                        ?>
                        <a href="<?= esc_url( $link_url ); ?>" target="<?= esc_attr( $link_target ); ?>" class="fadein_wrap">
                            <?= esc_html( $link_title ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <?php
        $posts = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'post__not_in' => array($post_id),
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $terms_slugs
                )
            )
        ));

        get_template_part( 'template-parts/posts',null, array(
            'slider' => true,
            'data' => array (
                'title' => 'Browse similar posts',
                'query' => $posts
            )
        )); ?>
    </div>
<?php get_footer();