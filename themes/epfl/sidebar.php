<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>





<aside id="secondary" class="sidebar col col-l-4" role="complementary">
  
  <nav class="nav-pages">
        <ul class="nav">
        <?php wp_list_pages(array(
          'title_li' => ''
          )); ?>
        </ul>
      </nav><!-- .nav-pages -->
      
  
  <?php wp_nav_menu( array(
		'theme_location' => 'sidebar_nav',
		'menu_id'        => 'top-menu',
		'menu_class'     => 'nav',
		'container'      => 'nav'
	) ); ?>
  
  <?php if ( is_active_sidebar( 'sidebar-1' ) ): ?>
  
	  <?php dynamic_sidebar( 'sidebar-1' ); ?>
	
	<?php endif; ?>
	
</aside><!-- #secondary -->


