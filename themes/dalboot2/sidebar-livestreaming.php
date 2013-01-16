<?php
/**
 * The Sidebar containing the main widget areas, with specific style for livestreaming
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */
?>
<div class="span4 livestreaming">
	<div class="sb-head-livestream"></div>

	
	<div class="well sidebar-nav">
            <?php
    if ( function_exists('dynamic_sidebar')) dynamic_sidebar("sidebar-page");
?>
	</div><!--/.well .sidebar-nav -->
          </div><!-- /.span4 -->
          </div><!-- /.row .content -->

