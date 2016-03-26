<?php
/**
 * Page displaying About Page (Slider with Text).
 *
 * Template Name: About Page
 *
 * @package dudakova
 */
?>

<?php get_header(); ?>

<div id="slider_about">
    <?php

    // check if the repeater field has rows of data
    if( have_rows('slider_text') ):

        // loop through the rows of data
        while ( have_rows('slider_text') ) : the_row();

            $image = get_sub_field('image');

            ?>

                <div class="about_slide">
                    <div class="text_div col-md-5">
                        <?php the_sub_field('content'); ?>
                    </div>
                    <img class="col-md-7" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" title="<?php echo $image['title']; ?>">
                </div>
        <?php endwhile;

    else :

        // no rows found

    endif;

    ?>
</div>

<?php get_footer(); ?>