<?php
//Posts page
get_header(); ?>
    <div class="blog-page-container">
        <?php $hero_section = get_field('hero_section', get_option('page_for_posts')); ?>
        <section class="hero-section">
            <div class="content-container">
                <?php if( $hero_section['small_title'] ): ?>
                    <p class="sub-title fadein_wrap"><?= $hero_section['small_title'] ?></p>
                <?php endif; ?>

                <?php if( $hero_section['title'] ): ?>
                    <h1 class="title letter_wrap green"><?= $hero_section['title'] ?></h1>
                <?php endif; ?>

                <?php if( $hero_section['active'] && ( $hero_section['post'] || $hero_section['image'] ) ): ?>
                    <div class="post fadein_wrap">
                        <?= wp_get_attachment_image( $hero_section['image']['id'], 'full', '' ,array('class'=>'post-image') ) ?>

                        <?php if( $hero_section['post'] ):
                            foreach( $hero_section['post'] as $post ): setup_postdata($post);
                                $terms = get_the_terms(get_the_ID(),'category');
                                if( $terms ): ?>
                                    <div class="post-tags">
                                        <?php foreach ( $terms as $term ): ?>
                                            <div class="tag"><?= $term->name ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="post-info">
                                    <h2>Find out everything that’s happening at Telgorithm.</h2>

                                    <h3 class="post-title"><?php the_title(); ?></h3>

                                    <?php if( has_excerpt() ): ?>
                                        <p class="post-excerpt"><?= get_the_excerpt(); ?></p>
                                    <?php else: ?>
                                        <p class="post-excerpt"><?= wp_trim_words(get_the_content(),40); ?></p>
                                    <?php endif; ?>

                                    <a href="<?php the_permalink() ?>" class="link">
                                        Learn More
                                        <img src="<?= get_template_directory_uri() ?>/images/blue_arrow_right.svg" alt="">
                                    </a>
                                </div>
                            <?php endforeach; wp_reset_postdata();
                        endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php
        $featured_posts_section = get_field('featured_posts_section', get_option('page_for_posts'));
        if( $featured_posts_section['posts'] ): ?>
            <section class="posts-slider-section">
                <div class="content-container">
                    <div class="title-container">
                        <?php if( $featured_posts_section['title'] ): ?>
                            <h2 class="title letter_wrap cream"><?= $featured_posts_section['title']; ?></h2>
                        <?php endif; ?>

                        <div class="slider-buttons fadein_wrap">
                            <div class="posts-slider-btn-prev circled-button prev"><?php icon_arrow() ?></div>
                            <div class="posts-slider-btn-next circled-button"><?php icon_arrow() ?></div>
                        </div>
                    </div>

                    <div class="posts-slider-pagination"></div>
                            
                    <div class="swiper-container posts-slider fadein_wrap">
                        <div class="swiper-wrapper">
                            <?php foreach( $featured_posts_section['posts'] as $post ): setup_postdata($post);
                                $terms = get_the_terms(get_the_ID(),'category');
                                ?>
                                <div class="swiper-slide">
                                    <a href="<?php the_permalink() ?>" class="post">
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
                                            <h2 class="post-title"><?php the_title(); ?></h2>
                                            <?php if( has_excerpt() ): ?>
                                                <p class="post-excerpt"><?= get_the_excerpt(); ?></p>
                                            <?php else: ?>
                                                <p class="post-excerpt"><?= wp_trim_words(get_the_content(),40); ?></p>
                                            <?php endif; ?>
                                            <p class="link">Read More<img src="<?= get_template_directory_uri() ?>/images/blue_arrow_right.svg" alt=""></p>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; wp_reset_postdata(); ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php
        $posts = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => -1,
        ));

        if( $posts->have_posts() ): ?>
            <section class="blog-section">
                <div class="content-container">
                    <form class="section-content" id="posts-form">
                        <div class="title-container">
                            <h2 class="title letter_wrap cream">See all blog posts</h2>

                            <div class="search-container fadein_wrap">
                                <label for="search">Looking for something specific?</label>
                                <input type="text" id="search-posts" name="search" placeholder="Search key terms">
                                <input type="hidden" name="action" value="posts_filter">
                                <input type="hidden" name="page" value="1" id="posts-page-input">
                            </div>
                        </div>

                        <div class="posts-container fadein_wrap" id="posts-response">
                            <?php print_posts(); ?>
                        </div>
                    </form>
                </div>
            </section>
        <?php endif; ?>
    </div>
<?php get_footer();