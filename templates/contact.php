<?php
/* Template Name: Contact */
get_header(); ?>
    <div class="page-template-contact-container">
        <section class="hero-section">
            <h1 class="title">Let’s chat about messaging opportunities</h1>
            <p class="description">Fill out the form below and we’ll be in touch. </p>
        </section>

        <div class="form-section">
            <ul class="form-selector">
                <li class="active" data-form=".form-1">Contact Us</li>
                <li data-form=".form-2">Join the team</li>
            </ul>
            <div class="forms">
                <div class="form-container form-holder form-1 active">
                    <form action="">
                        <div class="two-cols">
                            <div class="input-holder">
                                <label for="first-name">Name</label>
                                <input type="text" name="first-name" id="first-name" placeholder="First Name">
                            </div>

                            <div class="input-holder">
                                <input type="text" name="last-name" id="last-name" placeholder="Last Name">
                            </div>
                        </div>


                        <div class="input-holder">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" placeholder="What can we help you with?"></textarea>
                        </div>

                        <input type="submit" value="Submit">
                    </form>
                </div>

                <div class="form-container form-holder form-2">
                    <form action="">
                        <div class="input-holder">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" placeholder="What can we help you with?"></textarea>
                        </div>

                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php get_footer();