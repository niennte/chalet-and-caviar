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
		'menu_name'           => __( '!!! Chalets', 'chalet-and-caviar' ),
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
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor', 'excerpt', 'category', 'property-type', 'thumbnail', 'revisions', 'custom-fields', ),
		// You can associate this CPT with a taxonomy or custom taxonomy. 
		'taxonomies'          => array( 'property-type', 'property-category' ),
		/* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
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

/*
	register_taxonomy(
		'property-type',
		'chalet',
		array(
			'label' => __( 'Property Type' ),
			'rewrite' => array( 'slug' => 'property-type' ),
			'hierarchical' => true,
		)
	);
*/
}


/*
add_action('init','add_property-types_to_chalet');
function add_property-types_to_chalet(){
	register_taxonomy_for_object_type('property-type', 'chalet');
}
*/


//add_action('init','add_categories_to_chalet');
/*
function add_categories_to_chalet(){
	register_taxonomy_for_object_type('category', 'chalet');
}
*/






/**
 * Define Video Background's post types
 *
 * @since 2.5.7
 * @author Push Labs
 * @param array $post_types
 * @return array Array of post types Video Background should use
 */
/*
function themeprefix_vidbg_post_types( $post_types ) {
	$post_types = array( 'chalet', 'page', 'post' );
	return $post_types;
}
add_filter( 'vidbg_post_types', 'themeprefix_vidbg_post_types' );
*/

/**
 * Support for Google Maps API
 *
 * @param $api
 * @return mixed
 */

/*
function my_acf_google_map_api( $api ){

	$api['key'] = 'AIzaSyCCd5yApgSR3BYKV5KKfCtJG5bi2E7h78w';

	return $api;

}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
*/


