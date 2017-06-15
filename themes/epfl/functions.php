<?php
  
if ( ! function_exists( 'epfl_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function epfl_setup() {
  
  // Register menus
	register_nav_menus( array(
		'sidebar_nav' => 'Sidebar menu',
	) );
} 
endif;
add_action( 'after_setup_theme', 'epfl_setup' );

/**
* Enqueue theme styles
*
* First we remove regular theme stylesheet and enqueue it again in a function. This allows to enqueue the child theme stylesheet *after* the parent theme's, which is best to keep a low selector specificity. 
*/ 

// Remove Twenty Seventeen styles

function dequeue_twentyseventeen_styles() {
    wp_dequeue_style( 'twentyseventeen-style' );
        wp_deregister_style( 'twentyseventeen-style' );
}
add_action( 'wp_print_styles', 'dequeue_twentyseventeen_styles' );

// enqueue styles for child theme
// @ https://digwp.com/2016/01/include-styles-child-theme/

function enqueue_theme_styles() {
	
	// enqueue parent styles
	wp_enqueue_style('parent-styles', get_template_directory_uri() .'/style.css');
	
	// enqueue extra stylesheets
	wp_enqueue_style('font-awesome', get_stylesheet_directory_uri() .'/assets/css/font-awesome.min.css');
	wp_enqueue_style('grid', get_stylesheet_directory_uri() .'/assets/css/stylisticss.grid.css');
	
	// enqueue child styles
	wp_enqueue_style( 'child-styles', get_stylesheet_uri() );
	
}
add_action('wp_enqueue_scripts', 'enqueue_theme_styles', 10000000001 );

// Enqueue scripts

function epfl_scripts() {
	
	wp_enqueue_script( 'epfl-scripts', get_stylesheet_directory_uri() .'/assets/js/main.js', array(), '20151215', true );

}
add_action( 'wp_enqueue_scripts', 'epfl_scripts' );

// Dequeue Twenty Seventeen Fonts
function dequeue_fonts() {
    wp_dequeue_style( 'twentyseventeen-fonts' );
        wp_deregister_style( 'twentyseventeen-fonts' );
}
add_action( 'wp_print_styles', 'dequeue_fonts' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
 
function unregister_parent_sidebars(){

	// Unregister Twenty Seventeen Sidebars
	unregister_sidebar( 'sidebar-1' );
}
add_action( 'widgets_init', 'unregister_parent_sidebars', 11 );

function epfl_widgets_init() {
  
  register_sidebar( array(
      'name'          => 'Homepage widgets',
      'id'            => 'homepage-widgets',
      'description'   => 'Widgets présents uniquement sur la homepage',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
  		'after_widget'  => '</section>',
  		'before_title'  => '<h3 class="widget-title">',
  		'after_title'   => '</h3>'
  ) );
  
  register_sidebar( array(
      'name'          => 'Page widget',
      'id'            => 'page-widgets',
      'description'   => 'Widgets présents sur toutes les pages, y compris la homepage',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
  		'after_widget'  => '</section>',
  		'before_title'  => '<h3 class="widget-title">',
  		'after_title'   => '</h3>'
  ) );
}
add_action( 'widgets_init', 'epfl_widgets_init' );

// add temp shortcode mp4_video button to Tinmce

function mp4_video($atts, $content = null) {
  extract(shortcode_atts(array(
    "src" => '',
    "width" => '',
    "height" => ''
  ), $atts));
  return '<video src="'.$src.'" width="'.$width.'" height="'.$height.'" controls autobuffer>';
}
add_shortcode('mp4', 'mp4_video');


function tiny_mce_add_buttons( $plugins ) {
  $plugins['mp4'] = get_template_directory_uri() . '/../epfl/js/tiny-mce/tiny-mce.js';
  return $plugins;
}

function tiny_mce_register_buttons( $buttons ) {
  $newBtns = array(
    'mp4'
  );
  $buttons = array_merge( $buttons, $newBtns );
  return $buttons;
}

add_action( 'init', 'tiny_mce_new_buttons' );

function tiny_mce_new_buttons() {
  add_filter( 'mce_external_plugins', 'tiny_mce_add_buttons' );
  add_filter( 'mce_buttons', 'tiny_mce_register_buttons' );
}
?>