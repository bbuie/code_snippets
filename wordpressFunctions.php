<?php 

//HELPFUL WORDPRESS FUNCTIONS 

// Hide notices to upgrade, install woocommerce updater
remove_action( 'admin_notices', 'woothemes_updater_notice' );

//debug queries
function varDumpVariable($result){
	echo '<pre>';
	var_dump($result);
	echo '</pre>';
}

// cache query
function yourFunction() {
	static $cachedVariable;
	//only look if we haven't already
	if (!isset($cachedVariable)) {
		//put the code that find the variable here
		
	}
	return $cachedVariable;
}

//remove default image sizes
function remove_default_image_sizes( $sizes) {
    unset( $sizes['thumbnail']);
    unset( $sizes['medium']);
    unset( $sizes['large']);
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'remove_default_image_sizes');


// add sizes
function add_image_sizes() {
    add_image_size( 'largeRetina', 2800, '', false);
	update_option('large_size_w', 1400);
	update_option('large_size_h', '');
	update_option('large_crop', false);
}
add_action( 'init', 'add_image_sizes' );

// rename the files
// The filter runs when resizing an image to make a thumbnail or intermediate size.
function rename_intermediates_wpse_82193( $image ){
    // Split the $image path into directory/extension/name
    
    $info = pathinfo($image);
    $dir = $info['dirname'] . '/';
    $ext = '.' . $info['extension'];
    $name = wp_basename( $image, "$ext" );

    // Build our new image name
    $name_prefix = substr( $name, 0, strrpos( $name, '-' ) );

    $size_extension = substr( $name, strrpos( $name, '-' ) + 1 );
	if(preg_match('/2800x/', $size_extension) == 1){
		$size_name = 'large@2x';
	} else if(preg_match('/1400x/', $size_extension) == 1){
		$size_name = 'large';
	} else if(preg_match('/916x616/', $size_extension) == 1){
		$size_name = 'medium@2x';
	} else if(preg_match('/458x308/', $size_extension) == 1){
		$size_name = 'medium';
	} else if(preg_match('/444x294/', $size_extension) == 1){
		$size_name = 'thumbnail@2x';
	} else if(preg_match('/222x147/', $size_extension) == 1){
		$size_name = 'thumbnail';
	} else {
		$size_name = 'original';
	}

    $new_name = $dir . $name_prefix . "-". $size_name . $ext;

    // Rename the intermediate size
    $did_it = rename( $image, $new_name );

    // Renaming successful, return new name
    if( $did_it )
        return $new_name;

    return $image;
}
add_filter( 'image_make_intermediate_size', 'rename_intermediates_wpse_82193' );

//adding short codes for service workshop page
function shortcode_service_workshop( $atts ) {
    ob_start();  
    get_template_part('templates/snippet-serviceWorkshop');  
    $snippet = ob_get_contents();  
    ob_end_clean();  
    return $snippet;
}
//shortcode for upcoming workshops
add_shortcode('service_workshop', 'shortcode_service_workshop');

//make wordpress menu links dynamic using string replace with http://###site_url###
function add_site_url( $atts, $item, $args ) {
	$siteURL = site_url();
    $newlink = str_replace("###site_url###", $siteURL, $atts['href']);
    $atts['href'] = $newlink;
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_site_url', 10, 3 );

//make links in content dynamic
function replace_content($content){
	$siteURL = site_url()."/";
	$content = str_replace('http://###site_url###', $siteURL,$content);
	return $content;
}
add_filter('the_content','replace_content');

//function to flush all rewrite rules (for custom post types and taxonomies) at the same time if $flush is set to true
function flush_all_rewrite_rules(){
	$flush = false;	
	if($flush){
		flush_rewrite_rules( false );
	}
}

//add article custom post type
function uys_articles_init() {	
	$articleLabels = array(
	    'name'               => 'Articles',
	    'singular_name'      => 'Article',
	    'add_new'            => 'Add New',
	    'add_new_item'       => 'Add New Article',
	    'edit_item'          => 'Edit Article',
	    'new_item'           => 'New Article',
	    'all_items'          => 'All Articles',
	    'view_item'          => 'View Article',
	    'search_items'       => 'Search Articles',
	    'not_found'          => 'No Articles Found',
	    'not_found_in_trash' => 'No Articles Found in Trash',
	    'parent_item_colon'  => '',
	    'menu_name'          => 'Articles'	    
	  );	
	$articleArgs = array(
	  	'labels'             	=> $articleLabels,
		'public'             	=> true,
		'menu_icon' 		 	=> 'dashicons-text', //http://melchoyce.github.io/dashicons/
		'capability_type'      	=> 'post',
		'supports'           	=> array( 'title','editor') ,
		'has_archive'   		=> true ,
		'rewrite'				=> array(
									'slug'=>'learning-library/%article_category%',
									'with_front'=>false
									)
	);
	register_post_type( 'articles', $articleArgs );
	flush_all_rewrite_rules();
}
add_action( 'init', 'uys_articles_init' );

//get article_category to show in url of article post types
function article_category($permalink, $post_id, $leavename) {
    if (strpos($permalink, '%article_category%') === FALSE) return $permalink;
     
        // Get post
        $post = get_post($post_id);
        if (!$post) return $permalink;
 
        // Get taxonomy terms
        $terms = wp_get_object_terms($post->ID, 'article_category');   
        if (!is_wp_error($terms) && !empty($terms) && is_object($terms[0])) $taxonomy_slug = $terms[0]->slug;
        else $taxonomy_slug = '';
 
    return str_replace('%article_category%', $taxonomy_slug, $permalink);
}   
add_filter('post_link', 'article_category', 10, 3);
add_filter('post_type_link', 'article_category', 10, 3); 

//add taxonomies
function taxonomies_article() {
	$labels = array(
		'name'              => _x( 'Article Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Article Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Article Categories' ),
		'all_items'         => __( 'All Article Categories' ),
		'parent_item'       => __( 'Parent Article Category' ),
		'parent_item_colon' => __( 'Parent Article Category:' ),
		'edit_item'         => __( 'Edit Article Category' ), 
		'update_item'       => __( 'Update Article Category' ),
		'add_new_item'      => __( 'Add New Article Category' ),
		'new_item_name'     => __( 'New Article Category' ),
		'menu_name'         => __( 'Categories' ),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		'rewrite'		=> array(
			'slug'=>'learning-library',
			'with_front'=>false
		)
	);
	register_taxonomy( 'article_category', 'articles', $args );
	flush_all_rewrite_rules();
}
add_action( 'init', 'taxonomies_article', 0 );

//add a custom excerpt
class Excerpt {

  // Default length (by WordPress)
  public static $length = 55;

  // So you can call: my_excerpt('short');
  public static $types = array(
      'short' => 25,
      'regular' => 55,
      'long' => 100
    );

  /**
   * Sets the length for the excerpt,
   * then it adds the WP filter
   * And automatically calls the_excerpt();
   *
   * @param string $new_length 
   * @return void
   * @author Baylor Rae'
   */
  public static function length($new_length = 55) {
    Excerpt::$length = $new_length;

    add_filter('excerpt_length', 'Excerpt::new_length');

    Excerpt::output();
  }

  // Tells WP the new length
  public static function new_length() {
    if( isset(Excerpt::$types[Excerpt::$length]) )
      return Excerpt::$types[Excerpt::$length];
    else
      return Excerpt::$length;
  }

  // Echoes out the excerpt
  public static function output() {
    the_excerpt();
  }

}

// An alias to the class
function uys_excerpt($length = 55) {
  Excerpt::length($length);
}


//change read more of excerpt
function new_excerpt_more($more) {
       global $post;
	return ' <a class="readMore" href="'. get_permalink($post->ID) . '">Read More >></a>';
}
add_filter('excerpt_more', 'new_excerpt_more');


//change overall excerpt length
function custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

//adding style buttons to wysiwyg editor
function wpb_mce_buttons_2($buttons) {//adds a dropdown button to the 2nd row of editor options
	array_unshift($buttons, 'styleselect');
	return $buttons;
}
add_filter('mce_buttons_2', 'wpb_mce_buttons_2');
function my_mce_before_init_insert_formats( $init_array ) {  //adds three style options

// Define the style_formats array

	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(  
			'title' => 'Content Block',  
			'block' => 'span',  
			'classes' => 'content-block',
			'wrapper' => true,
			
		),  
		array(  
			'title' => 'Blue Button',  
			'block' => 'span',  
			'classes' => 'blue-button',
			'wrapper' => true,
		),
		array(  
			'title' => 'Red Button',  
			'block' => 'span',  
			'classes' => 'red-button',
			'wrapper' => true,
		),
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	
	return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' ); 


?>