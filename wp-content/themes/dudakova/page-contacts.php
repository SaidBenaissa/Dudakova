<?php
/**
 * Page displaying static Contacts Page.
 *
 * Template Name: Contacts Page
 *
 * @package dudakova
 */
?>

<?php get_header(); ?>

    <div id="contacts_line"></div>
    
    <div class="container contacts">
        <div class="row">
            <div class="col-md-5">
                <h5><?php the_field('address', 'option'); ?></h5>
            </div>
            <div class="col-md-2">
                <h5><?php _e('Telephone', 'dudakova'); ?> <br>
		    <a href="tel:<?php the_field('phone', 'option'); ?>">
                    <?php the_field('phone', 'option'); ?>
		    </a>
                </h5>
            </div>
            <div class="col-md-2">
                <h5><?php _e('Fax', 'dudakova'); ?> <br>
		    <a href="tel:<?php the_field('fax', 'option'); ?>">
                    <?php the_field('fax', 'option'); ?>
		    </a>
                </h5>
            </div>
            <div class="col-md-2">
                <h5><?php _e('E-mail', 'dudakova'); ?> <br>
		    <a href="mailto:office@dudakova.com?subject=Mail for Dudakova & Co GmbH">
                    <?php the_field('email', 'option'); ?>
		    </a>
                </h5>
            </div>
        </div>
    </div>

    <?php if(have_posts()): while(have_posts()): the_post(); ?>
    
        <div class="container inputs">
            <div class="row">
               <?php the_content(); ?>
            </div>
        </div>
        
    <?php endwhile; endif; ?>

    <div id="googleMap"></div>

<?php get_footer(); ?>