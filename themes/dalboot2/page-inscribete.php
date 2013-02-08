<?php
/**
 *
 * Template Name: Registration Page
 * 
 * Page template with minimal formatting, a fixed 940px container and right sidebar layout
 *
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

          <?php// wp_reset_query(); ?>

          <?php
            $args = array( 'post_type' => 'dal_country', posts_per_page => 20 );
            $inscriptionloop = new WP_Query( $args );
            while ( $inscriptionloop->have_posts() ) : $inscriptionloop->the_post();
            	
            	echo '<div class="span3 well">';		
            	
            	get_template_part('content','dal_inscribete');

            	echo '</div>';
                             
            endwhile;

          ?>

        </div><!-- /.span8 -->
          
          <?php get_sidebar(); ?>
     

<?php get_footer(); ?>
