<?php
/* Template Name: Get started */
get_header(); ?>
    <div class="page-template-get-started-container">

        <?php $hero_section = get_field('hero_section') ?>
        <div class="hero-section">
            <div class="content-container">
                <div class="section-content">
                    <div class="left">
                        <?php if( $hero_section['title'] ): ?>
                            <h1 class="title letter_wrap pink"><?= $hero_section['title'] ?></h1>
                        <?php endif; ?>

                        <?php if( $hero_section['list'] ): ?>
                            <ul class="list fadein_wrap">
                                <?php foreach ( $hero_section['list'] as $item ): ?>
                                    <li>
                                        <img src="<?= get_template_directory_uri() ?>/images/checkmark.svg" alt="">
                                        <span><?= $item['title'] ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <div class="right">
                        <?php if( $hero_section['title'] ): ?>
                            <h1 class="title letter_wrap pink"><?= $hero_section['title'] ?></h1>
                        <?php endif; ?>
                        <?php if( $hero_section['image'] ): ?>
                            <div class="image-holder">
                                <?= wp_get_attachment_image($hero_section['image']['id'],'full') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <img src="<?= get_template_directory_uri() ?>/images/shape_cream.svg" class="hero_shape" alt="">    
        </div>

        <?php
        $form_section = get_field('form_section');
        if( $form_section['title'] || $form_section['subtitle'] || $form_section['form_key'] ): ?>
            <div class="form-section">
                <div class="form-container">
                    <?php if( $form_section['title'] ): ?>
                        <h2 class="title letter_wrap cream"><?= $form_section['title'] ?></h2>
                    <?php endif; ?>

                    <?php if( $form_section['subtitle'] ): ?>
                        <p class="subtitle fadein_wrap"><?= $form_section['subtitle'] ?></p>
                    <?php endif; ?>

                    <?php if( $form_section['form_key'] ): ?>
                        <div class="form-holder fadein_wrap">
                            <?php
                            $args = array(
                                // Whether the title should be displayed or not (true/false)
                                'display_title' => false,

                                // Whether the description should be displayed or not (true/false)
                                'display_description' => false,

                                // Text used for the submit button
                                'submit_text' => 'Submit',

                                // The URL to which the form points. Defaults to the current URL which will automatically display a success message after submission
                                // If this is overriden you may use af_has_submission to check for a form submission
                                //                            'target' => CURRENT_URL,

                                // Whether the form output should be echoed or returned
                                'echo' => true,

                                // Field values to pre-fill. Should be an array with format: $field_name_or_key => $field_prefill_value
                                'values' => array(),

                                // Array of field keys or names to exclude from form rendering
                                'exclude_fields' => array(),

                                // Either 'wp' or 'basic'. Whether to use the Wordpress media uploader or a regular file input for file/image fields.
                                'uploader' => 'wp',

                                // The URL to redirect to after a successful submission. Defaults to false for no redirection.
                                'redirect' => home_url('thank-you'),
                            );
                            advanced_form( $form_section['form_key'], $args ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php get_footer();