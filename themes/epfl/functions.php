<?php

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
	wp_enqueue_style('grid', get_stylesheet_directory_uri() .'/assets/css/font-awesome.min.css');
	wp_enqueue_style('grid', get_stylesheet_directory_uri() .'/assets/css/grid.css');
	
	// enqueue child styles
	wp_enqueue_style( 'child-styles', get_stylesheet_uri() );
	
}
add_action('wp_enqueue_scripts', 'enqueue_theme_styles', 10000000001 );

// Dequeue Twenty Seventeen Fonts
function dequeue_fonts() {
    wp_dequeue_style( 'twentyseventeen-fonts' );
        wp_deregister_style( 'twentyseventeen-fonts' );
}
add_action( 'wp_print_styles', 'dequeue_fonts' );

?>