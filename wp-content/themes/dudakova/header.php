<?php
/**
 * The header for dudakova theme.
 *
 * Displays all of the <head> section and the header
 *
 * @package dudakova
 */
 
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="dudakova">
    <meta name="keywords" content="Dudakova & Co GmbH was founded in 2014 in the capital of Austria, Vienna.      
        Behind the company is a private investment group, business partner BPPA and a young, talented woman.">
    <title><?php wp_title( ' | Dudakova & Co', true, 'right' ); ?></title>
    <link rel="icon" type="image/png" href="<?php the_field('favicon', 'option'); ?>" />
    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

    <header class="site-header">
        
	<a id="logo_link" href="http://dudakova.tk">
        <img id="logo" src=" 
        <?php the_field('logo', 'option'); ?> 
        "></img>
	</a>
        
        <button id="header_list_btn_1">
            <span class="glyphicon glyphicon-align-justify"></span>
        </button>
        <button id="header_list_btn_2">
            <span class="glyphicon glyphicon-align-justify"></span>
        </button>

        <?php
        $args = array (
            'theme_location' => 'primary'
        );
        wp_nav_menu( $args );
        ?>
        
        <?php do_action('wpml_add_language_selector'); ?>

    </header>