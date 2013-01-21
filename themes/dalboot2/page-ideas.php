<?php
/**
 *
 * Template Name: ideas
 * 
 * Page template for ideas, requires User-Submitted-Posts Plugin .
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 1.0
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
   <div class="container"> 
        <div class="row content">
			<div class="span12">


				<div class="well sidebar-nav sidebar-top-ideas">
					<h1><?php the_title();?></h1>   <br />
					<?php 
					if($post->post_content !="") {
						echo '<div class="widget" >';
						the_content();
						echo '</div>';

					}else {
						echo '';
				
					}
					?>           
		            <div class="widget" >
		            	<?php if(function_exists('public_submission_form')) public_submission_form(true); ?>
		            </div>	
		            
					<?php endwhile; // end of the loop. ?>
					<div class="widget">
					
					<?php
					    // Get the ID of a given category
					    $category_id = get_cat_ID( 'Ideas' );

					    // Get the URL of this category
					    $category_link = get_category_link( $category_id );
					?>

					<!-- Print a link to this category -->
					<a class="btn btn-danger span4 btn-xlarge" href="<?php echo esc_url( $category_link ); ?>" title="Ideas"><?php _e( 'View all ideas', 'bootstrapwp' ); ?></a>
				

							
					</div>
					
				</div>

			</div><!-- /.span12 -->
		</div>
	</div>

	          
          


<?php get_footer(); ?>