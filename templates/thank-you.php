<?php
/* Template Name: Thank you */
get_header(); ?>
    <div class="page-template-thank-you-container">
        <div class="hero-section">
            <div class="content-container">
                <div class="section-content">
                    <div class="image-holder">
                        <div class="image">
                            <img src="<?= get_template_directory_uri() ?>/images/image.jpg" alt="">
                        </div>
                    </div>

                    <h1 class="title">Thank you for reaching out!</h1>
                    <p class="description">Our team of experts will be in touch with you soon. </p>
                </div>
            </div>
        </div>

        <?php get_template_part( 'template-parts/posts',null, array(
                'title_type' => 'type_2',
                'data' => array (
                    'title' => 'Browse the blog posts while you wait',
                )
        )); ?>
    </div>
<?php get_footer();