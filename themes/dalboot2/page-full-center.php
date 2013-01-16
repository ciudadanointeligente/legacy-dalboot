<?php
/**
 * Template Name: Full-width centered Page
 * Description: A full-width template with no sidebar, centered title
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
  <div class="row">

   </div><!--/.row -->
   <div class="container">
     <!--<nav class="span12 ">
          <ul class="nav nav-tabs tabs-siblings">
           
                 <?php /* $parent = $post->post_parent; ?>
                 <?php

                  query_posts('post_type=page&post_parent='.$parent);
                  ?>
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post() ?>
                        <li>
                <a href=" <?php the_permalink(); ?> "> <span>›</span>  <?php the_title(); ?> </a>
              </li> 
            <?php endwhile; else: ?>
                  <?php endif; ?>
                </ul>  
             <br/>
          <?php wp_reset_query(); */ ?>
    </nav>-->


      
 <!-- Masthead
      ================================================== -->
      <header class="jumbotron subhead fullcentered" id="overview">
        <h1><?php the_title();?></h1>
      </header>
			
				<div class="row content fullcentered">
				  <?php the_content();?>
				<?php endwhile; // end of the loop. ?>

		
				</div><!-- .row content -->
		<div class="container img-footer">
           </div> 

<?php get_footer(); ?>