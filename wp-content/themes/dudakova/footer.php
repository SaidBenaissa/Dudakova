<?php

/**
 * The template for displaying the footer.
 *
 * @package dudakova
 */
?>
        <div class="footer">
            <div class="social">
                <div class="fb">
                    <a href="<?php the_field('facebook', 'option'); ?>" target="_blank" rel="nofollow"></a>
                    <img class="fb-grey" src="<?php echo get_template_directory_uri(); ?>/assets/img/fb-grey.png">
                    <img class="fb-gold" src="<?php echo get_template_directory_uri(); ?>/assets/img/fb-gold.png">
                </div>
                <div class="insta">
                    <a href="<?php the_field('instagram', 'option'); ?>" target="_blank" rel="nofollow"></a>
                    <img class="insta-grey" src="<?php echo get_template_directory_uri(); ?>/assets/img/insta-grey.png">
                    <img class="insta-gold" src="<?php echo get_template_directory_uri(); ?>/assets/img/insta-gold.png">
                </div>
            </div>
            <h6><?php the_field('copyright', 'option'); ?></h6>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>