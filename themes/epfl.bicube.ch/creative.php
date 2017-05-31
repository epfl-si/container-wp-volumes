<?php /* Template Name: Creative */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width" />
  <title><?php wp_title( ' | ', true, 'right' ); ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php the_post(); ?>
  <?php the_content(); ?>
  <div class="entry-links"><?php wp_link_pages(); ?></div>
  <?php edit_post_link(); ?>
  <?php wp_footer(); ?>
</body>
</html>
