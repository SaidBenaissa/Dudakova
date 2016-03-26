<?php
/**
 * Page displaying Single Brand Page.
 *
 * @package dudakova
 */
?>

<?php get_header();

if(have_posts()): while(have_posts()): the_post(); ?>

<div class="brands_line"></div>

<div id="brand">

    <div class="col-md-6">

        <img src="<?php the_field('image'); ?>">

    </div>

    <div class="col-md-6">

        <?php the_content(); ?>

    </div>

    </div>

</div>

<div class="brands_line second"></div>

<?php

endwhile;
endif;

get_footer(); ?>