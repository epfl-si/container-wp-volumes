
  <div class="header">
    <h1 class="entry-title"><?php
      if ( is_day() ) { printf( __( 'Daily Archives: %s', 'supersimple' ), get_the_time( get_option( 'date_format' ) ) ); }
      elseif ( is_month() ) { printf( __( 'Monthly Archives: %s', 'supersimple' ), get_the_time( 'F Y' ) ); }
      elseif ( is_year() ) { printf( __( 'Yearly Archives: %s', 'supersimple' ), get_the_time( 'Y' ) ); }
      else { _e( 'Archives', 'supersimple' ); }
      ?></h1>
    </div>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <?php get_template_part( 'entry' ); ?>
    <?php endwhile; endif; ?>
    <?php get_template_part( 'nav', 'below' ); ?>

