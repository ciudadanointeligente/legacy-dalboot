<?php
/**
 * Single app
 *
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
  <div class="row">
    <div class="container ">
      <?php if (function_exists('bootstrapwp_breadcrumbs')) bootstrapwp_breadcrumbs(); ?>
    </div><!--/.container -->
  </div><!--/.row -->
   <div class="container entryApp nolist">
     
 <!-- Masthead
      ================================================== -->
      <header class="jumbotron subhead" id="overview">
        <h1><?php the_title();?></h1>
      </header>
         
      <div class="row content entryApp">

        <div class="span well">
                    <?php 
                    //getting the content
                   //the basic conuntry info
              	    get_template_part('content','dal_country');
                    ?>

          <?php endwhile; // end of the loop. ?>
        </div><!-- /.span5 -->
        <div class="span">
          
          <h4 class="hr"> Organizan:</h4>
          
          <?php get_template_part('local-organizers')?>

        </div>
        <hr class="row span12"/>
         <div class="span12">
         <?php bootstrapwp_content_nav('nav-below');?>
       </div>
         <hr class="row span12"/>
        <div class="span12 well">
           <?php comments_template(); ?>
        </div>
      </div>         
      


        <?php get_footer(); ?>

