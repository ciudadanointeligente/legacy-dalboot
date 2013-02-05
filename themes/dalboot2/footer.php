<?php
/**
 * Default Footer
 *
 * @package WP-Bootstrap
 * @subpackage Default_Theme
 * @since WP-Bootstrap 0.1
 *
 * Last Revised: February 4, 2012
 */
?>
    <!-- End Template Content -->

		</div>
	</div><!--/.container -->
</div><!--/#content-wrapper -->
	<footer id="dalFooter">
		<div class="container">
			<div class="row">
		      <p class="pull-right"><a href="#">Back to top</a></p>
		        <!--<p>&copy; <?php// bloginfo('name'); ?> <?php// the_time('Y') ?></p>-->
		          <?php
				    if ( function_exists('dynamic_sidebar')) dynamic_sidebar("footer-content");
				?>
			</div>	<!--row-->

		</div> <!-- /container -->
		<div class="fullwidhtRow">
			<div class="container">
				<h4><?php _e( 'With the support of', 'bootstrapwp' ); ?></h4>
				
					<div class="sponsorFooter nolist row">

			<div class="sponsorlist">
				<?php
				//print_r($term);

				        query_posts( array( 'post_type' => 'dal_regional_sponsor', 'paged' => get_query_var('taxonomy'), 'posts_per_page' => 30, 'orderby' => 'title', 'order' => 'DESC' ) ); ?>
				       
							<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				                    <span>
				                        <?php 

											if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
										?>
											 <?php  the_post_thumbnail(); ?>
											
											
										<?php 
												}  
											else
												{
										?>

											 <h2><?php the_title(); ?> </h2>
										
										<?php

											}	
										?>
				                	
				                    </span>
				                 
				                      
				             <?php endwhile; else: ?>
				            <?php endif; ?>
				            </ul>  
				           
				   	 	<?php wp_reset_query();  ?>
				     </div>  
				</div>	
			</div>	

							
		</div>	
			<div class="container fullcentered opacity"><?php _e( 'Site developed by:', 'bootstrapwp' ); ?> <a class="fci-link" href="http://ciudadanointeligente.org"></a></p>
	 </footer>

		<?php wp_footer(); ?>
		<script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>


  </body>
</html>