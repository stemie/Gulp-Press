<?php // ==== FUNCTIONS ==== //

// An example of how to enqueue scripts and stylesheets
if ( !function_exists( 'my_theme_enqueue_scripts' ) ) : function my_theme_enqueue_scripts() {

  // Front-end scripts
  if ( !is_admin() ) {

    // Load minified scripts if debug mode is off
    if ( WP_DEBUG === true ) {
      $suffix = '';
    } else {
      $suffix = '.min';
    }

    // Load theme-specific JavaScript with versioning based on last modified time; http://www.ericmmartin.com/5-tips-for-using-jquery-with-wordpress/
    wp_enqueue_script( 'my-theme-core', get_stylesheet_directory_uri() . '/js/core' . $suffix . '.js', array( 'jquery' ), filemtime( get_template_directory() . '/js/core' . $suffix . '.js' ), true );

    // Conditionally load another script
    if ( is_singular() ) {
      wp_enqueue_script( 'my-theme-extras', get_stylesheet_directory_uri() . '/js/extras' . $suffix . '.js', array( 'jquery' ), filemtime( get_template_directory() . '/js/extras' . $suffix . '.js' ), true );
    }
  }

  // Register and enqueue our main stylesheet with versioning based on last modified time
  wp_register_style( 'my-theme-style', get_stylesheet_uri(), array(), filemtime( get_template_directory() . '/style.css' ) );
  wp_enqueue_style( 'my-theme-style' );

} endif;
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_scripts' );

/**
 * Enqueue scripts and styles.
 */
function _s_scripts() {
  wp_enqueue_style( '_s-style', get_stylesheet_uri() );

  wp_enqueue_script( '_s-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

  wp_enqueue_script( '_s-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', '_s_scripts' );

/**
 * Customisable read more link
 */
function the_more_excerpt($arg){
    echo apply_filters('the_excerpt',get_the_excerpt().' <a class="read-more" href="'.get_permalink().'">'.$arg.'</a>');
}

/**
 * Subtitle
 */
function sp_subtitle() {
global $post;
$arg = get_post_meta($post->ID, '_subheading', true);
echo '<div class="entry-subtitle">'.$arg.'</div>';
}

/**
 * Post type conditional function
 */ 
function is_sp_post_type($type){
    global $wp_query;
    if($type == get_post_type($wp_query->post->ID)) return true;
    return false;
}

/**
 * Change from slug to normal
 */ 
function inverse_slug($str){
   return ucwords(str_replace('-', ' ', $str));
}

/**
 * Loop shortcode
 */
function sp_loop_shortcode($atts) {
   
   // Defaults
   extract(shortcode_atts(array(
      "the_query" => ''
   ), $atts));

   // de-funkify query
   $the_query = preg_replace('~&#x0*([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $the_query);
   $the_query = preg_replace('~&#0*([0-9]+);~e', 'chr(\\1)', $the_query);

   // query is made               
   query_posts($the_query);
   
   // Reset and setup variables
   $output = '';
   $temp_title = '';
   $temp_link = '';
   
   // the loop
   if (have_posts()) : while (have_posts()) : the_post();
   
      $temp_title = get_the_title($post->ID);
      $temp_link = get_permalink($post->ID);

      $output .= "<li><a href='$temp_link'>$temp_title</a></li>";
          
   endwhile; else:
   
      $output .= "nothing found.";
      
   endif;
   
   wp_reset_query();
   return $output;
   
}
add_shortcode("loop", "sp_loop_shortcode"); // [loop the_query="showposts=100&post_type=page&post_parent=453"]
