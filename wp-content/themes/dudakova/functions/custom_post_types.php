<?php

/**
 * Register a product post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
add_action( 'init', 'brandsInit' );

function brandsInit() {
    $labels = array(
        'name'               => _x( 'Brands', 'post type general name', 'dudakova' ),
        'singular_name'      => _x( 'Brand', 'post type singular name', 'dudakova' ),
        'menu_name'          => _x( 'Brands', 'admin menu', 'dudakova' ),
        'name_admin_bar'     => _x( 'Add Brand', 'add new on admin bar', 'dudakova' ),
        'add_new'            => _x( 'Add New', 'product', 'dudakova' ),
        'add_new_item'       => __( 'Add New Brand', 'dudakova' ),
        'new_item'           => __( 'New Brand', 'dudakova' ),
        'edit_item'          => __( 'Edit Brand', 'dudakova' ),
        'view_item'          => __( 'Show Brand', 'dudakova' ),
        'all_items'          => __( 'All Brands', 'dudakova' ),
        'search_items'       => __( 'Search Brands', 'dudakova' ),
        'parent_item_colon'  => __( 'Parent Brand:', 'dudakova' ),
        'not_found'          => __( 'No Brands Found.', 'dudakova' ),
        'not_found_in_trash' => __( 'No Brands Found in the Trash.', 'dudakova' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.', 'dudakova' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'brand' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail' )
    );

    register_post_type( 'brand', $args );
}

