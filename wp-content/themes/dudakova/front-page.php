<?php
/**
 * Page displaying static Front Page.
 *
 * Template Name: Front Page
 *
 * @package dudakova
 */
?>

<?php get_header(); ?>

<div id="slider_home">
    <?php

    // check if the repeater field has rows of data
    if( have_rows('slider') ):

        // loop through the rows of data
        while ( have_rows('slider') ) : the_row();

            $imagePc = get_sub_field('image_pc');
            $imageMob = get_sub_field('image_mobile');

            ?>

                <div>
                    <img class="img" src="<?php echo $imagePc['url'] ?>" alt="<?php echo $imagePc['alt'] ?>" title="<?php echo $imagePc['title'] ?>">
                    <img class="img_mob" src="<?php echo $imageMob['url'] ?>" alt="<?php echo $imageMob['alt'] ?>" title="<?php echo $imageMob['title'] ?>">
                </div>
        <?php endwhile;

    else :

        // no rows found

    endif;

    ?>
</div>

<?php get_footer(); ?>