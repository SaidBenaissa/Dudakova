<?php
/**
 * Page displaying all Brands Archive.
 *
 * Template Name: Brands Archive
 *
 * @package dudakova
 */
?>

<?php get_header(); ?>

    <div class="brands_line"></div>

    <?php
    $args = array(
        'post_type'         => 'brand',
        'posts_per_page'    => -1
    );

    $loop = new WP_Query( $args );

    if ( $loop->have_posts() ) : ?>
        <div class="brands_container">
            <div class="container clearfix">
                <?php while ( $loop->have_posts() ) : $loop->the_post();?>

                    <div class="brands col-md-4">
                        <?php the_post_thumbnail('full') ?>
                        <div class="about">
                            <a id="loriblu" href="<?php the_permalink(); ?>"></a>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/about_btn.png" class="about_img">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/about_btn_overlay.png" class="about_img_overlay">
                        </div>
                    </div>


                <?php endwhile; ?>
            </div>
        </div>

    <?php endif; ?>

    <div class="brands_line second"></div>

<?php get_footer(); ?>