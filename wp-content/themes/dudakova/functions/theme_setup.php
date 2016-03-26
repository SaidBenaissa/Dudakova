<?php
/**
 * Add post thumbnails theme support
 */
add_theme_support( 'post-thumbnails' );

/**
 * Enable shortcodes in widgets
 */
add_filter('widget_text', 'do_shortcode');

/**
 * Custom excerpt length
 *
 * @param $length
 * @return int
 */
function customExcerptLength( $length ) {
    return 40;
}
add_filter( 'excerpt_length', 'customExcerptLength', 999 );

/**
 * Add custom image sizes
 */

add_image_size( 'favicon', 16, 16 );