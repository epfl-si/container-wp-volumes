
  <?php if ( have_posts() ) : ?>
    <div class="header">
      <h1 class="entry-title"><?php printf( __( 'Search Results for: %s', 'supersimple' ), get_search_query() ); ?></h1>
    </div>
    <?php while ( have_posts() ) : the_post(); ?>
      <?php get_template_part( 'entry' ); ?>
    <?php endwhile; ?>
    <?php get_template_part( 'nav', 'below' ); ?>
  <?php else : ?>
    <article id="post-0" class="post no-results not-found">
      <div class="header">
        <h2 class="entry-title"><?php _e( 'Nothing Found', 'supersimple' ); ?></h2>
      </div>
      <section class="entry-content">
        <p><?php _e( 'Sorry, nothing matched your search. Please try again.', 'supersimple' ); ?></p>
        <?php get_search_form(); ?>
      </section>
    </article>
  <?php endif; ?>

