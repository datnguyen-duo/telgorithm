<?php
$per_page = 2;
function posts_filter() {
    $search = $_GET['search'];
    $current_page = $_GET['page'];
    $posts = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => $GLOBALS['per_page'],
        's' => $search,
        'paged' => $current_page,
    ));

    print_posts($posts);
    die;
}
add_action('wp_ajax_posts_filter', 'posts_filter');
add_action('wp_ajax_nopriv_posts_filter', 'posts_filter');

function print_posts( $query = '' ) {
    if( !$query ) {
        $query = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => $GLOBALS['per_page'],
            'paged' => 1,
        ));
    }
    $posts_per_page = $query->query['posts_per_page'];
    $found_posts = $query->found_posts;
    $current_page = $query->query['paged'];
    $total_pages = ceil($found_posts / $posts_per_page);
    if( $query->have_posts() ): ?>
        <p class="total-posts"><?= $found_posts ?> blog posts</p>

        <div class="posts" id="posts-response">
            <?php while( $query->have_posts() ): $query->the_post();
                $terms = get_the_terms(get_the_ID(),'category'); ?>
                <div class="post-container">
                    <article class="post">
                        <div class="post-image">
                            <?php the_post_thumbnail('full'); ?>

                            <?php if( $terms ): ?>
                                <div class="post-tags">
                                    <?php foreach ( $terms as $term ): ?>
                                        <div class="tag"><?= $term->name ?></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="post-info">
                            <div class="post-date tag"><?= get_the_date() ?></div>
                            <h2 class="post-title"><?php the_title() ?></h2>
                            <?php if( has_excerpt() ): ?>
                                <p class="post-excerpt"><?= get_the_excerpt(); ?></p>
                            <?php else: ?>
                                <p class="post-excerpt"><?= wp_trim_words(get_the_content(),40); ?></p>
                            <?php endif; ?>
                            <a href="<?php the_permalink() ?>" class="link">Read More<img src="<?= get_template_directory_uri() ?>/images/blue_arrow_right.svg" alt=""></a>
                        </div>
                    </article>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <?php if( $total_pages > 1 ): ?>
            <div class="pagination">
                <div class="prev pagination-page circled-button" data-page="<?= ($current_page == 1) ? $total_pages : $current_page-1; ?>">
                    <?php icon_arrow() ?>
                </div>
                <ul>
                    <?php for( $i=1; $i <= $total_pages; $i++ ): ?>
                        <li data-page="<?php echo $i; ?>" class="pagination-page circled-button <?= ($current_page == $i) ? ' active' : null; ?>">
                            <?php echo $i; ?>
                        </li>
                    <?php endfor; ?>
                </ul>
                <div class="next pagination-page circled-button" data-page="<?= ($current_page == $total_pages) ? 1 : $current_page+1; ?>">
                    <?php icon_arrow() ?>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="no-results">
            <h2>No posts found.</h2>
        </div>
    <?php endif; ?>
<?php }