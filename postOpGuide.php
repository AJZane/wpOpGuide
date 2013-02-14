<?php
/*
Plugin Name: Post Type: Operations Guide
Plugin URI: http://AJZane.com
Description: A hidden post type for editors about how to use WordPress and the theme
Author: L7 Creative
Version: 0.1
Author URI: http://AJZane.com
*/
/*
Use:
This plugin automatically creates the category and post type
To hide : 

I suggest creating a special category template:
<?php get_header(); 
	if ( is_user_logged_in() ){
		echo "<div class=\"row\">";
			include('flesh/paginate.php');
			$loop = new WP_Query( array( 
				'post_type' => 'opGuide'
				)
			);
			while ( $loop->have_posts() ) {
				$loop->the_post();
				echo '<a href="'.get_permalink().'">'.get_the_title().'</a><br/>';
				echo the_excerpt();								
			}//while
			wp_reset_query();	
			include('flesh/paginate.php');
		echo "</div>";
	}
	else{
		echo "<div class=\"hero-unit\">";
		echo apply_filters('the_content', get_page_by_path('about')->post_content);
		echo "</div>";
		echo "<div class=\"row\">";
		include('flesh/thumbnail-gallery.php');
		include('flesh/paginate.php');
		echo "</div><!--row-->";
	}
get_footer(); ?>

*/
// Create the 'opguide' category:
$taxonomy = 'category';
$args = array(
  'description' => 'Guide to using this theme'
  , 'slug' => 'opguide'
);
//'parent' => 'parent'
if(!is_term('Operations Guide', $taxonomy)){
	$opguideID = wp_insert_term('Operations Guide', $taxonomy, $args);
}

//Create the Operation Guide post type:
add_action( 'init', 'create_post_type_opguide' );
function create_post_type_opguide() {
	register_post_type( 'opguide',
			array(
				'labels' => array(
					'name' => __( 'Operations Guide' )
				)
				, 'description' => 'Guide to this theme'
				, 'taxonomies' => array('category')
				, 'public' => true
				, 'has_archive' => true
				, 'exclude_from_search' => true
				, 'hierarchical' => true
				, 'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' )
			)
	);
}//create_post_type()

//automatically asign the 'opguide' category to these posts
function add_opguidecat_automatically($post_ID){
	global $wpdb;
	$cat = 'opguide';
	wp_set_object_terms( $post_ID, $cat, 'category');
}
add_action('publish_opguide', 'add_opguidecat_automatically');

//FUNCTIONS:

//Can View Guide returns true if the current user can view the Operations Guide
	//Future functionality: Definition by user role
function opGuide_canViewGuide(){
	if ( is_user_logged_in() ){
		return true;
	}
	else{
		return false;
	}
}
// function add_housecategory_automatically($post_ID) {
	// global $wpdb;
	// if(!wp_is_post_revision($post_ID)) {
	// $housecat = array (4);
	// wp_set_object_terms( $post_ID, $housecat, 'category');
	// }
// }
// add_action('publish_houses', 'add_housecategory_automatically');

// //Only set the cateogry if the post doesn't have one:
// function add_stiwti_category_automatically($post_ID) {
	// global $wpdb;
	// if(!has_term('','category',$post_ID)){
		// $cat = array(4);
		// wp_set_object_terms($post_ID, $cat, 'category');
	// }
// }
// add_action('publish_stiwti', 'add_stiwti_category_automatically');

// $category_ids = array( $opguideID );
// // wp_set_object_terms( 'opguide', $category_ids, 'category');
// $taxonomy = 'opguidetaxon';
// $object_type = 'opguide';
// $args = array(
	// 'show_in_nav_menus' => false
	// , 'show_tagcloud' => false
	// , 'hierarchical' => true
// );
// // register_taxopnomy rewrite slug? http://codex.wordpress.org/Function_Reference/register_taxonomy
// register_taxonomy( $taxonomy, $object_type );
// // register_taxonomy( $taxonomy, $object_type, $args );

/*Features:
	Create a settings panel for options -  http://tutorialzine.com/2012/11/option-panel-wordpress-plugin-settings-api/
	Hide/Show the posts of this cat
	Who can read
		and list all user roles
	Who can create 
	Who can comment
	Display comments
	opguide Page
	Categories
BUGS:
	In teh category viewer, the 'how many posts this category has' cloumn is named 'Operation Guide'
*/
?>