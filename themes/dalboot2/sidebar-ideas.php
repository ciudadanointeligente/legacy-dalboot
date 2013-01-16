<?php
/**
 * The Sidebar containing ideas.
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */
?>

<div class="span4">
	<div class="well sidebar-nav sidebar-side-ideas">

            <?php
    if ( function_exists('dynamic_sidebar')) dynamic_sidebar("ideas");
?>
	</div><!--/.well .sidebar-nav -->  
</div><!-- /.span4 -->


