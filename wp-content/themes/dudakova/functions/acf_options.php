<?php

/**
 * ACF Option pages
 */
$page = array(
    'page_title'    => 'Theme Options',
    'menu_slug'     => 'main_options',
    'position'      => 79,
);

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page($page);

}

if( function_exists('acf_add_options_sub_page') )
{
    acf_add_options_sub_page(array(
        'title'         => 'General',
        'slug'          => 'general_page',
        'parent'        => 'main_options',
        'capability'    => 'manage_options'
    ));
}

if( function_exists('acf_add_options_sub_page') )
{
    acf_add_options_sub_page(array(
        'title'         => 'Header',
        'slug'          => 'header_page',
        'parent'        => 'main_options',
        'capability'    => 'manage_options'
    ));
}

if( function_exists('acf_add_options_sub_page') )
{
    acf_add_options_sub_page(array(
        'title'         => 'Social Links',
        'slug'          => 'social_links_page',
        'parent'        => 'main_options',
        'capability'    => 'manage_options'
    ));
}

if( function_exists('acf_add_options_sub_page') )
{
    acf_add_options_sub_page(array(
        'title'         => 'Footer',
        'slug'          => 'footer_page',
        'parent'        => 'main_options',
        'capability'    => 'manage_options'
    ));
}