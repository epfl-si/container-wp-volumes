<aside id="sidebar-111" role="complementary" style="<?php if($GLOBALS['type'] == '') echo 'width:98% !important;';if($GLOBALS['type'] == 'insidesidebar-left') echo 'float:left;'?>">

    <div id="primary" class="widget-area">
      <?php if ( is_active_sidebar( 'primary-widget-area' ) ) : ?>
          <ul class="xoxo">
            <?php dynamic_sidebar( 'primary-widget-area' ); ?>
          </ul>
      <?php else:?>
          <div class="no-active-widgets">
              Please activate some Widgets.
          </div>
      <?php endif; ?>
    </div>

</aside>
