<?php
add_action('after_setup_theme', 'uncode_language_setup');
function uncode_language_setup()
{
	load_child_theme_textdomain('uncode', get_stylesheet_directory() . '/languages');
}

function theme_enqueue_styles()
{
	$production_mode = ot_get_option('_uncode_production');
	$resources_version = ($production_mode === 'on') ? null : rand();
	$parent_style = 'uncode-style';
	$child_style = array('uncode-custom-style');
	wp_enqueue_style($parent_style, get_template_directory_uri() . '/library/css/style.css', array(), $resources_version);
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', $child_style, $resources_version);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');



/* Customizations */


/*
* Create the chalet CPT.
*/

function custom_post_type() {
	// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'chalet', 'Post Type General Name', 'chalet-and-caviar' ),
		'singular_name'       => _x( 'Chalet', 'Post Type Singular Name', 'chalet-and-caviar' ),
		'menu_name'           => __( '-> Manage Chalets', 'chalet-and-caviar' ),
		'parent_item_colon'   => __( 'Parent Chalet', 'chalet-and-caviar' ),
		'all_items'           => __( 'All Chalets', 'chalet-and-caviar' ),
		'view_item'           => __( 'View Chalet', 'chalet-and-caviar' ),
		'add_new_item'        => __( 'Add New Chalet', 'chalet-and-caviar' ),
		'add_new'             => __( 'Add New', 'chalet-and-caviar' ),
		'edit_item'           => __( 'Edit Chalet', 'chalet-and-caviar' ),
		'update_item'         => __( 'Update Chalet', 'chalet-and-caviar' ),
		'search_items'        => __( 'Search Chalet', 'chalet-and-caviar' ),
		'not_found'           => __( 'Not Found', 'chalet-and-caviar' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'chalet-and-caviar' ),
	);

// Set other options for Custom Post Type

	$args = array(
		'label'               => __( 'Chalet', 'chalet-and-caviar' ),
		'description'         => __( 'Chalet info', 'chalet-and-caviar' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'category', 'property-type', 'thumbnail', 'revisions', 'custom-fields', ),
		'taxonomies'          => array( 'property-type', 'property-category' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 3,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);

	// Registering your Custom Post Type
	register_post_type( 'chalet', $args );

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/

add_action( 'init', 'custom_post_type', 0 );


// Create property-type taxonomie
add_action( 'init', 'create_chalet_tax' );

function create_chalet_tax() {

	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Property type', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Property Type', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Property Types', 'textdomain' ),
		'all_items'         => __( 'All Property Types', 'textdomain' ),
		'edit_item'         => __( 'Edit Property Type', 'textdomain' ),
		'update_item'       => __( 'Update Property Type', 'textdomain' ),
		'add_new_item'      => __( 'Add New Property Type', 'textdomain' ),
		'new_item_name'     => __( 'New Property Type Name', 'textdomain' ),
		'menu_name'         => __( 'Property Type', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'property-type' ),
	);

	register_taxonomy( 'Property Type', array( 'chalet' ), $args );
}

