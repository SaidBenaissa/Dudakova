<?php
/**
 * Hide admin content box for Front Page
 */
function removeEditor() {
    if (isset($_GET['post'])) {
        $id = $_GET['post'];
        $template = get_post_meta($id, '_wp_page_template', true);

        if($template == 'front-page.php' 
        || $template == 'page-about.php' 
        || $template == 'archive-brand.php' ){
            remove_post_type_support( 'page', 'editor' );
        }
    }
}
add_action('init', 'removeEditor');