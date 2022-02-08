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
                            <h1 class="title"><?= $hero_section['title'] ?></h1>
                        <?php endif; ?>

                        <?php if( $hero_section['list'] ): ?>
                            <ul class="list">
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
                        <?php if( $hero_section['image'] ): ?>
                            <div class="image-holder">
                                <?= wp_get_attachment_image($hero_section['image']['id'],'full') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php $form_section = get_field('form_section') ?>
        <div class="form-section">
            <div class="form-container form-holder">
                <?php if( $form_section['title'] ): ?>
                    <h2 class="title"><?= $form_section['title'] ?></h2>
                <?php endif; ?>

                <?php if( $form_section['subtitle'] ): ?>
                    <p class="subtitle"><?= $form_section['subtitle'] ?></p>
                <?php endif; ?>

                <form action="">
                    <div class="two-cols">
                        <div class="input-holder">
                            <label for="first-name">Name</label>
                            <input type="text" name="first-name" id="first-name" placeholder="First Name">
                        </div>

                        <div class="input-holder">
                            <input type="text" name="last-name" id="last-name" placeholder="Last Name">
                        </div>

                        <div class="input-holder">
                            <label for="email">Email Address</label>
                            <input type="text" name="email" id="email" placeholder="Email Address">
                        </div>

                        <div class="input-holder">
                            <label for="company-name">Company Name</label>
                            <input type="text" name="last-name" id="company-name" placeholder="Company Name">
                        </div>

                        <div class="input-holder">
                            <label for="company-website">Company Website</label>
                            <input type="text" name="last-name" id="company-website" placeholder="Company Website">
                        </div>
                        <div class="input-holder">
                            <label for="phone">Phone Number</label>
                            <input type="text" name="last-name" id="phone" placeholder="Phone Number">
                        </div>
                    </div>


                    <div class="input-holder">
                        <label for="message">What brings you to Telgorithm?</label>
                        <textarea name="message" id="message" placeholder="What can we help you with?"></textarea>
                    </div>

                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>
<?php get_footer();