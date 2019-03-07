<?php
global $am_option;

$am_option['shortname'] = "am";
$am_option['textdomain'] = "am";

// Functions
require get_parent_theme_file_path( '/includes/fn-core.php' );
require get_parent_theme_file_path( '/includes/fn-custom.php' );

// Extensions
require get_parent_theme_file_path( '/includes/extensions/breadcrumb-trail.php' );

/* Theme Init */
require get_parent_theme_file_path( '/includes/theme-widgets.php' );
require get_parent_theme_file_path( '/includes/theme-init.php' );

function additional_custom_styles() {
	/*Enqueue The Styles*/
    wp_enqueue_style( 'uniquestylesheetid', get_template_directory_uri() . '/new.css' ); 
}
add_action( 'wp_enqueue_scripts', 'additional_custom_styles' );
// callbacks












?>