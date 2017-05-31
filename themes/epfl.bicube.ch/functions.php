<?php
add_action( 'after_setup_theme', 'supersimple_setup' );
function supersimple_setup()
{
  load_theme_textdomain( 'supersimple', get_template_directory() . '/languages' );
  add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'post-thumbnails' );
  global $content_width;
  if ( ! isset( $content_width ) ) $content_width = 640;
  register_nav_menus(
    array( 'main-menu' => __( 'Main Menu', 'supersimple' ), 'footer-menu' => __( 'Footer Menu', 'supersimple' ) )
    );
}
add_action( 'wp_enqueue_scripts', 'supersimple_load_scripts' );
function supersimple_load_scripts()
{
  wp_enqueue_script( 'jquery' );
  wp_register_script( 'supersimple-videos', get_template_directory_uri() . '/videos.js' );
  wp_enqueue_script( 'supersimple-videos' );
}
add_action( 'wp_head', 'supersimple_print_custom_scripts', 99 );
function supersimple_print_custom_scripts()
{
  if ( !is_admin() ) {
    ?>
    <script type="text/javascript">
      jQuery(document).ready(function($){
        $("#wrapper").vids();
      });
    </script>
    <?php
  }
}
add_action( 'comment_form_before', 'supersimple_enqueue_comment_reply_script' );
function supersimple_enqueue_comment_reply_script()
{
  if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}
add_filter( 'the_title', 'supersimple_title' );
function supersimple_title( $title ) {
  if ( $title == '' ) {
    return '&rarr;';
  } else {
    return $title;
  }
}
add_filter( 'wp_title', 'supersimple_filter_wp_title' );
function supersimple_filter_wp_title( $title )
{
  return $title . esc_attr( get_bloginfo( 'name' ) );
}
add_action( 'widgets_init', 'supersimple_widgets_init' );
function supersimple_widgets_init()
{
  register_sidebar( array (
    'name' => __( 'Sidebar Widget Area', 'supersimple' ),
    'id' => 'primary-widget-area',
    'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
    'after_widget' => "</li>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ) );
  register_sidebar( array (
    'name' => __( 'Header Widget Area', 'supersimple' ),
    'id' => 'header-widget-area',
    'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
    'after_widget' => "</li>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ) );
  register_sidebar( array (
    'name' => __( 'Footer Widget Area', 'supersimple' ),
    'id' => 'footer-widget-area',
    'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
    'after_widget' => "</li>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ) );
}
function supersimple_custom_pings( $comment )
{
  $GLOBALS['comment'] = $comment;
  ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
  <?php
}
add_filter( 'get_comments_number', 'supersimple_comments_number' );
function supersimple_comments_number( $count )
{
  if ( !is_admin() ) {
    global $id;
    $comments_by_type = &separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
    return count( $comments_by_type['comment'] );
  } else {
    return $count;
  }
}
