<?php 
/*
 * Plugin Name: Agrilife Jobs
 * Plugin URI: https://github.com/channeleaton/AgriLife-Jobs
 * Description: A job posting WordPress plugin for Texas A&M AgriLife
 * Version: 1.0
 * Author: J. Aaron Eaton
 * Author URI: http://channeleaton.com
 * License: GPL2
 */

// NOTE: This plugin previously lived inside AgriLife themes.

function job_posting_search($job_type_selected='',$term='') {
    do_action('job_posting_search',$job_type_selected,$term);
}

add_action('job_posting_search','job_posting_search_form',5,3);

function job_posting_search_form($job_type_selected='',$term='Wildlife Biologist') { ?>
	<div class="job_posting-search-form">
	<label>
	<h4>Search Job Postings</h4>
	</label>
	<form role="search" class="searchform" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	  <input type="text" class="s" name="searchjobpostings" id="s" placeholder="<?php echo $term; ?>" onfocus="if(this.value==this.defaultValue)this.value='<?php echo $term; ?>';" onblur="if(this.value=='<?php echo $term; ?>')this.value=this.defaultValue;"/>
	  <input class="job_posting-submit" type="submit" name="submit" value="Search" />	
	  <input type="hidden" name="post_type" value="job_posting" />
	</form>
	</div>
<?php 
}



add_action( 'init', 'create_job_posting_post_type' );
function create_job_posting_post_type() {
     register_post_type( 'job_posting',
          array(
               'labels' => array(
                    'name' => __( 'Job Posting' ),
                    'singular_name' => __( 'Job' ),
                    'add_new_item' => __( 'Add New Job Posting' ),
                    'add_new' => __( 'Add New' ),
                    'edit' => __( 'Edit' ),
                    'edit_item' => __( 'Edit Job Posting' ),
                    'new_item' => __( 'New Job Posting' ),
                    'view' => __( 'View Job Posting' ),
                    'view_item' => __( 'View Job Posting' ),
                    'search_items' => __( 'Search Job Postings' ),
                    'not_found' => __( 'No Job Posting found' ),
                    'not_found_in_trash' => __( 'No Job Postings found in Trash' ),

               ),
          '_builtin' => false, // It's a custom post type, not built in!
          '_edit_link' => 'post.php?post=%d',
          'capability_type' => 'post',
          'hierarchical' => false,
          'public' => true,
          'rewrite' => array('slug' => 'jobs'),
          'supports' => array( 'title', 'editor' ),
          )
     );
}

// hook into the init action and call create_job_taxonomies() when it fires
add_action( 'init', 'create_job_taxonomies', 0 );

// create three taxonomies, species and lab sections for the post type "job_posting"
function create_job_taxonomies() {

     // Add new taxonomy, make it hierarchical (like categories)
     $labels = array(
          'name' => _x( 'Job Category', 'taxonomy general name' ),
          'singular_name' => _x( 'Job Category', 'taxonomy singular name' ),
          'search_items' =>  __( 'Search Job Categories' ),
          'all_items' => __( 'All Job Categories' ),
          'parent_item' => __( 'Parent Job Category' ),
          'parent_item_colon' => __( 'Parent Job Category:' ),
          'edit_item' => __( 'Edit Job Category' ),
          'update_item' => __( 'Update Job Category' ),
          'add_new_item' => __( 'Add New Job Category' ),
          'new_item_name' => __( 'New Job Category Name' ),
     );     

     register_taxonomy( 'job_category', array( 'job_posting' ), array(
          'hierarchical' => true,
          'labels' => $labels, /* NOTICE: Here is where the $labels variable is used */
          'show_ui' => true,
          'query_var' => true,
          'rewrite' => false,
     ));

}

/* Define the custom box for job posting custom post type */
//add_action('admin_init','job_posting_meta_init'); 
add_action('admin_init','job_posting_meta_init'); 

function job_posting_meta_init() {
	add_meta_box('job_posting_details_meta', 'Enter Job Details', 'job_posting_details_meta', 'job_posting', 'normal', 'high');
}

function job_posting_details_meta() {
	global $post;
	$custom = get_post_custom($post->ID);
	
	// Still Support the legacy _my_meta fields
	$my_meta = get_post_meta($post->ID,'_my_meta',TRUE);
  
  $job_number   = (is_array($my_meta)&&$my_meta['job_number']<>''? $my_meta['job_number'] : $custom["job_number"][0]);
	$agency 		= (is_array($my_meta)&&$my_meta['agency']<>'' ? $my_meta['agency'] 		: $custom["agency"][0]);
	$location		= (is_array($my_meta)&&$my_meta['location']<>'' ? $my_meta['location'] 	: $custom["location"][0]);
	$type			= (is_array($my_meta)&&$my_meta['type'] <>'' ? $my_meta['type']			: $custom["classification"][0]);
	$salary			= (is_array($my_meta)&&$my_meta['salary']<>'' ? $my_meta['salary']		: $custom["salary"][0]);
	$website		= (is_array($my_meta)&&$my_meta['website']<>'' ? $my_meta['website']		: $custom["website"][0]);
	$apply_date		= (is_array($my_meta)&&$my_meta['apply-date'] <> '' ? $my_meta['apply-date'] : $custom["apply_date"][0]);
	$start_date		= (is_array($my_meta)&&$my_meta['start-date'] <> '' ? $my_meta['start-date'] : $custom["start_date"][0]);
	$description  	= (is_array($my_meta)&&$my_meta['description'] <> '' ? $my_meta['description'] : $custom["description"][0]);
	$qualifications	= (is_array($my_meta)&&$my_meta['qualifications'] <> '' ? $my_meta['qualifications'] : $custom["qualifications"][0]);
	$contact_name 	= (is_array($my_meta)&&$my_meta['contact-name'] <> '' ? $my_meta['contact-name'] : $custom["contact_name"][0]);
	$contact_phone	= (is_array($my_meta)&&$my_meta['contact-phone'] <> '' ? $my_meta['contact-phone'] : $custom["contact_phone"][0]);
  $contact_email  = (is_array($my_meta)&&$my_meta['contact-email'] <> '' ? $my_meta['contact-email'] : $custom["contact_email"][0]);
  $fileupload  = (is_array($my_meta)&&$my_meta['fileupload'] <> '' ? $my_meta['fileupload'] : $custom["fileupload"][0]);
	include('jobs_meta_html.php');
}



/* Save The Post Meta */
add_action('save_post', 'save_job_meta');

function save_job_meta(){
  global $post;

  $safe_url = $_POST["website"];
  if($safe_url[0] == "<" && $safe_url[1] == "a"){
    $website_pattern = '#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si';
    preg_match($website_pattern, $safe_url, $website_matches);
    $safe_url = $website_matches[0];
  }
 
  update_post_meta($post->ID, "job_number", $_POST["job_number"]);
  update_post_meta($post->ID, "agency", $_POST["agency"]);
  update_post_meta($post->ID, "location", $_POST["location"]);
  update_post_meta($post->ID, "salary", $_POST["salary"]);
  update_post_meta($post->ID, "website", $safe_url);
  update_post_meta($post->ID, "apply_date", $_POST["apply_date"]);
  update_post_meta($post->ID, "start_date", $_POST["start_date"]);
  update_post_meta($post->ID, "description", $_POST["description"]);
  update_post_meta($post->ID, "qualifications", $_POST["qualifications"]);
  update_post_meta($post->ID, "contact_name", $_POST["contact_name"]);
  update_post_meta($post->ID, "contact_email", $_POST["contact_email"]);
  update_post_meta($post->ID, "contact_phone", $_POST["contact_phone"]);
  update_post_meta($post->ID, "fileupload", $_POST["fileupload"]);
  
}

/**
 * The Job Postings shortcode. [job_postings]
 *
 * Shows the entries in the job_postings custom post type. Just points to the archive page.
 **
 */
function job_postings_shortcode() {
	global $post;

	$paged = 1; 
	if ( get_query_var('paged') ) $paged = get_query_var('paged'); 
	if ( get_query_var('page') ) $paged = get_query_var('page'); 
	 
	query_posts( '&post_type=job_posting&post_status=publish&posts_per_page='.get_option('posts_per_page').'&paged=' . $paged ); 
	include( 'loop-job_listings.php');

}
add_shortcode('job_postings', 'job_postings_shortcode');

/**
 * Get the requested templates
 */
add_filter( 'archive_template', 'jobs_get_archive_template' );
function jobs_get_archive_template( $archive_template ) {
  global $post;
  $plugindir = dirname( __FILE__ );
  
  if(is_archive() && get_post_type() == 'job_posting'){
    $archive_template = $plugindir . '/archive-job_posting.php';
  }
  return $archive_template;
}

add_filter( 'search_template', 'jobs_get_search_template' );
function jobs_get_search_template( $search_template ) {
  global $post;
  $plugindir = dirname( __FILE__ );
  
  if( get_query_var( 'post_type' ) == 'job_posting' ) {
    $search_template = $plugindir . '/archive-job_posting.php';
  }
  return $search_template;
}

add_filter( 'single_template', 'jobs_get_single_template' );
function jobs_get_single_template( $single_template ) {
  global $post;
  $plugindir = dirname( __FILE__ );
  
  if( get_query_var( 'post_type' ) == 'job_posting' ) {
    $single_template = $plugindir . '/single-job_posting.php';
  }
  return $single_template;
}

/**
 * Enqueue the required style
 */
add_action( 'wp_enqueue_scripts', 'jobs_add_frontend_style' );
function jobs_add_frontend_style() {
  wp_register_style( 'jobs-front-style', plugins_url( 'jobs-frontend-style.css', __FILE__ ) );
  wp_enqueue_style( 'jobs-front-style' );
}

if ( ! function_exists( 'agriflex_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since AgriFlex 1.0
 * @author J. Aaron Eaton <aaron@channeleaton.com>
 */
function agriflex_posted_on() {
     printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'twentyeleven' ),
          esc_url( get_permalink() ),
          esc_attr( get_the_time() ),
          esc_attr( get_the_date( 'c' ) ),
          esc_html( get_the_date() ),
          esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
          sprintf( esc_attr__( 'View all posts by %s', 'agriflex' ), get_the_author() ),
          esc_html( get_the_author() )
     );
}
endif; // agriflex_posted_on

if ( ! function_exists( 'agriflex_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since AgriFlex 1.0
 * @author J. Aaron Eaton <aaron@channeleaton.com>
 */
function agriflex_posted_in() {
     // Retrieves tag list of current post, separated by commas.
     $tag_list = get_the_tag_list( '', ', ' );
     if ( $tag_list ) {
          $posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'agriflex' );
     } elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
          $posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'agriflex' );
     } else {
          $posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'agriflex' );
     }
     // Prints the string, replacing the placeholders.
     printf(
          $posted_in,
          get_the_category_list( ', ' ),
          $tag_list,
          get_permalink(),
          the_title_attribute( 'echo=0' )
     );
}
endif; // agriflex_posted_in
?>
