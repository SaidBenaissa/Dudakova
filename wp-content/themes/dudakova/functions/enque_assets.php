<?php
/**
 * Enqueue scripts and styles.
 */

wp_deregister_script( 'jquery' );

function dudakovaAssets() {

    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );

    wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/css/slick.min.css' );

    wp_enqueue_style( 'main', get_template_directory_uri() . '/assets/css/style.css' );

    wp_enqueue_style( 'new', get_template_directory_uri() . '/assets/css/stylesheet.css' );

    wp_enqueue_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery-1.11.3.min.js', null, '1.0', true );

    wp_enqueue_script( 'jquery-ui', get_template_directory_uri() . '/assets/js/jquery-ui.min.js', null, '1.0', true );

    wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/slick.min.js', null, '1.0', true );

    wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js', null, '1.0', true );

    wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/script.js', null, '1.0', true );

}

add_action( 'wp_enqueue_scripts', 'dudakovaAssets' );