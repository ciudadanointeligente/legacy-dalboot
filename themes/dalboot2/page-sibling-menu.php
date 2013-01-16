<?php
/**
 *
 * Template Name: Sibling-menu Page
 * 
 * Description: Simple page whit superior Sibling items NavBar
 *
 *
 *
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
  <div class="row">
  <div class="container">
 

        <nav class="span12 ">
          <ul class="nav nav-tabs tabs-siblings">
           
                 <?php $parent = $post->post_parent; ?>
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
          <?php wp_reset_query();  ?>

        </nav>  

   </div><!--/.container -->
   </div><!--/.row -->
   <div class="container">

      
 <!-- Masthead
      ================================================== -->
      <header class="" id="overview">
        <h1 class="country"><?php the_title();?></h1> 
      </header>
     
 <!-- Content
      ================================================== -->      
        <div class="row content">
      <div class="span8">
        <?php the_content();?>
        <?php endwhile; // end of the loop. ?>
          </div><!-- /.span8 -->


  <!-- Sidebar
      ================================================== -->         

        <?php 
            $termstax = get_the_terms($post->ID, 'pais');
            $count = count($termstax);
            if ( is_array($termstax) && $count > 0 ){
                get_sidebar('pais');
              }
            else {
                 echo get_sidebar();
                }    
        ?>
     
 <!-- Footer Sponsors & Organizers
      ================================================== -->
      <?php 
            $termstax = get_the_terms($post->ID, 'pais');
            $count = count($termstax);
            if ( is_array($termstax) && $count > 0 ){
    
              //call the organizers
              get_template_part( 'local-organizers' );

              // call the sponsors area
              get_template_part( 'local-sponsors' );
            }
            
        ?>

       
          


<?php get_footer(); ?>