<?php
/**
 *
 * Template Name: Home DAL 2012
 *
 *
 * @package WP-Bootstrap
 * @subpackage Default_Theme
 * @since WP-Bootstrap 0.5
 *
 * Last Revised: March 4, 2012
 */
get_header(); ?>
<div class="container">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <header class="jumbotron nolist">
  
       
            <div class="row">
              <div class="blackground span">
                <div class="span5">
                  <?php
                    if ( function_exists('dynamic_sidebar')) dynamic_sidebar("hero-left");
                  ?>
         
                  <?php
                      if ( function_exists('dynamic_sidebar'));
                      echo '<div class="row">'.dynamic_sidebar("hero-right").'</div>';
                  ?>
                </div>
                <div class="span5">
                  <?php wp_nav_menu( array( 'theme_location' => 'hero-menu', 'container_class' => 'hero-menu' ) ); ?> 
                </div><!--/row-->
             
               
            </div>  
         <div class="blackbottom span"> 
              </div>
                
</header>

    <div class="row wrapper">
      <div class="span12">
            <?php
             get_template_part('content','banderas');?>
            <?php wp_reset_query(); ?>
      </div>
      <div class="span12 citaHome">
         <?php
            if ( function_exists('dynamic_sidebar')) dynamic_sidebar("slogan-area");
          ?>
      </div>  
      
      <div class="row">
          <div class="span4">
             <?php
              if ( function_exists('dynamic_sidebar')) dynamic_sidebar("home-left");
              ?>
           </div>
           <div class="span4">
              <?php
              if ( function_exists('dynamic_sidebar')) dynamic_sidebar("home-middle");
              ?>
            </div>
            <div class="span4">

             <?php
              if ( function_exists('dynamic_sidebar')) dynamic_sidebar("home-right");
              ?>
            </div> 
      </div>
      <div class="span12">
        <?php the_content();?>

       
      </div> 
    </div>  
            <?php endwhile; endif; ?>
  </div>  
<?php get_footer();?>
