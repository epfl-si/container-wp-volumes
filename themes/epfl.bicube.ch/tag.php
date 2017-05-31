<?php get_header(); ?>
<section id="content-111" role="main">
  <div class="header">
    <h1 class="entry-title"><?php _e( 'Tag Archives: ', 'supersimple' ); ?><?php single_tag_title(); ?></h1>
  </div>
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <?php get_template_part( 'entry' ); ?>
  <?php endwhile; endif; ?>
  <?php get_template_part( 'nav', 'below' ); ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
