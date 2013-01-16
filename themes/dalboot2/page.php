<?php
/**
 * COUNTRY PAGE TEMPLATE
 * In this theme this is the default template for displaying pages.
 *
 * 
 * Description: Page template with a content container and right sidebar. 
 * Sidebar automatically loads: 
 * -A siblings menu 
 * -Organizers CPT called by taxonomy "Pais"
 * -A sponsors footer called by taxonomy "Pais"
 * -Latest posts on the same "Pais" taxonomy.
 * 
 *
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
  <div class="row">
  <div class="container countryPage">
    
   <?php// if (function_exists('bootstrapwp_breadcrumbs')) bootstrapwp_breadcrumbs(); ?>
   </div><!--/.container -->
   </div><!--/.row -->
   <div class="container">

      
 
 <!-- Content
      ================================================== -->      
       <?php 
            $termstaxi = get_the_terms($post->ID, 'pais');
            $count = count($termstaxi);

            if (!empty($termstaxi)){
            foreach ( $termstaxi as $termi) {
             $terminame = $termi->name;
             $termislug = $termi->slug;
             }
           }
        ?>
      <?php if ($termislug !== null){
        echo '<div class="row content rowPais">';
      }else{
         echo '<div class="row content nopais">';
      }?>
      <div class="span8">
        <!-- Masthead
      ================================================== -->
      <header class="jumbotron subhead" id="overview">

      <?php
        if ($termislug !== null){
          echo '<h1 class="Hcountry"><small><span class="flag32 flag32-'.($termislug).'"></span>';
          echo '<span>'.$terminame.'</span></small> <br />';
          echo the_title();
          echo '</h1>';
        }else{
          echo '<h1 class="country">';
          echo the_title();
          echo '</h1>';
        }
      ?>
              </header>
     
        <?php the_content();?>
        <?php endwhile; // end of the loop. ?>
          </div><!-- /.span8 -->


  <!-- Sidebar
      ================================================== -->         

        <?php 
            $termstaxi = get_the_terms($post->ID, 'pais');
            $count = count($termstaxi);

            if ( is_array($termstaxi) && $count > 0 ){
                get_sidebar('pais');

              }
            else {
                 echo get_sidebar();
                }    
        ?>
     
 <!-- Footer Sponsors & Organizers
      ================================================== -->
      <?php 
            $termstaxi = get_the_terms($post->ID, 'pais');
            $count = count($termstaxi);
            if ( is_array($termstaxi) && $count > 0 ){
    
              //call the organizers
              get_template_part( 'local-organizers' );

              // call the sponsors area
              get_template_part( 'local-sponsors' );
            }
            
        ?>

       
          


<?php get_footer(); ?>