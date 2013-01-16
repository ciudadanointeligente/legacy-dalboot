<?php
/**
 *
 * Template Name: LIVE streaming
 * 
 * Page template for livestreaming page
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 1.0
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
   <div class="container">
        <h1><?php the_title();?></h1>    
        <div class="row content">
<div class="span8">

            <?php the_content();?>
<?php endwhile; // end of the loop. ?>
          </div><!-- /.span8 -->
          
          <?php get_sidebar('livestreaming'); ?>


<?php get_footer(); ?>