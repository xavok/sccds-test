<?php
// DENTIST CUSTOM POST TYPE
function my_custom_post_dentist() {
	$labels = array(
		'name'               => _x( 'Dentists', 'post type general name' ),
		'singular_name'      => _x( 'Dentist', 'post type singular name' ),
		'add_new'            => _x( 'Add New Dentist', 'portfolio' ),
		'add_new_item'       => __( 'Add New Dentist' ),
		'edit_item'          => __( 'Edit Dentist' ),
		'new_item'           => __( 'New Dentist' ),
		'all_items'          => __( 'All Dentists' ),
		'view_item'          => __( 'View Dentist' ),
		'search_items'       => __( 'Search Dentists' ),
		'not_found'          => __( 'No Dentists found' ),
		'not_found_in_trash' => __( 'No Dentists found in the Trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Dentists'
	);
	$args = array(
		'labels'        	     => $labels,
		'description'   	     => 'Holds our dentist and dentist specific data',
		'capablility_type' 	   => 'post',
		'public'        	     => true,
		'show_ui'							 => true,
		'menu_position' 	     => 5,
    'taxonomies'           => array( 'post_tag' ),
		'supports'      	     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields', ),
		'has_archive'   	     => true,
    'menu_icon'            => 'dashicons-businessman',
		'rewrite'							 => array('slug' => 'dentist'),
	);
	register_post_type( 'dentist', $args );
}
add_action( 'init', 'my_custom_post_dentist' );

// Add new image size for Dentists featured image
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'dentist', 500, 500, true ); //(cropped)
	add_image_size( 'blog-featured', 600, 400, true ); //(cropped)
}


// Specialty Taxonomy
function dentist_tax_specialty() {
	$labels = array(
		'name'              => _x( 'Specialties', 'taxonomy general name' ),
		'singular_name'     => _x( 'Specialty', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Specialties' ),
		'all_items'         => __( 'All Specialties' ),
		'parent_item'       => __( 'Parent Specialty' ),
		'parent_item_colon' => __( 'Parent Specialty:' ),
		'edit_item'         => __( 'Edit Specialty' ),
		'update_item'       => __( 'Update Specialty' ),
		'add_new_item'      => __( 'Add New Specialty' ),
		'new_item_name'     => __( 'New Specialty' ),
		'menu_name'         => __( 'Specialties' ),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		'show_ui' => true,
		'query_var' => true,
		'show_admin_column' => true,
	);
	register_taxonomy( 'specialty-cat', 'dentist', $args );
}
add_action( 'init', 'dentist_tax_specialty', 0 );


// SERVICE CUSTOM POST TYPE
// function my_custom_post_services() {
// 	$labels = array(
// 		'name'               => _x( 'Services', 'post type general name' ),
// 		'singular_name'      => _x( 'Service', 'post type singular name' ),
// 		'add_new'            => _x( 'Add New Service', 'service' ),
// 		'add_new_item'       => __( 'Add New Service' ),
// 		'edit_item'          => __( 'Edit Service' ),
// 		'new_item'           => __( 'New Service' ),
// 		'all_items'          => __( 'All Services' ),
// 		'view_item'          => __( 'View Service' ),
// 		'search_items'       => __( 'Search Services' ),
// 		'not_found'          => __( 'No Service items found' ),
// 		'not_found_in_trash' => __( 'No Service items found in the Trash' ),
// 		'parent_item_colon'  => '',
// 		'menu_name'          => 'Services'
// 	);
// 	$args = array(
// 		'labels'        	     => $labels,
// 		'description'   	     => 'Holds our Service and Service specific data',
// 		'capablility_type' 	   => 'post',
// 		'public'        	     => true,
// 		'menu_position' 	     => 5,
//     'taxonomies'           => array( 'post_tag' ),
// 		'supports'      	     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields', ),
// 		'has_archive'   	     => false,
// 		'exclude_from_search'	 => true,
//     'menu_icon'            => 'dashicons-list-view',
// 		'rewrite'							 => array('slug' => 'service'),
// 	);
// 	register_post_type( 'service', $args );
// }
// add_action( 'init', 'my_custom_post_services' );

// Add new image size for Service featured image
// if ( function_exists( 'add_image_size' ) ) {
// 	add_image_size( 'service', 500, 500, true ); //(cropped)
// }

// Category Taxonomy
// function service_tax_category() {
// 	$labels = array(
// 		'name'              => _x( 'Categories', 'taxonomy general name' ),
// 		'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
// 		'search_items'      => __( 'Search Categories' ),
// 		'all_items'         => __( 'All Categories' ),
// 		'parent_item'       => __( 'Parent Category' ),
// 		'parent_item_colon' => __( 'Parent Category:' ),
// 		'edit_item'         => __( 'Edit Category' ),
// 		'update_item'       => __( 'Update Category' ),
// 		'add_new_item'      => __( 'Add New Category' ),
// 		'new_item_name'     => __( 'New Category' ),
// 		'menu_name'         => __( 'Categories' ),
// 	);
// 	$args = array(
// 		'labels' => $labels,
// 		'hierarchical' => true,
// 		'show_ui' => true,
// 		'query_var' => true,
// 		'show_admin_column' => true,
// 	);
// 	register_taxonomy( 'service-cat', 'service', $args );
// }
// add_action( 'init', 'service_tax_category', 0 );
