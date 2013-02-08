<div class="sponsorFooter nolist row">
	<h4 class="hr"> <?php _e( 'Sponsors:', 'bootstrapwp' ); ?></h4>
	<ul class="sponsorlist">

		
<?php
$term = get_the_terms($post->ID, 'pais');
//print_r($term);

        query_posts( array( 'post_type' => 'dal_country_sponsor', 'pais'=>array_pop($term)->name, 'paged' => get_query_var('taxonomy'), 'posts_per_page' => 30, 'orderby' => 'title', 'order' => 'DESC' ) ); ?>
       
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <li>
                        <?php 

							if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
						?>
							<a href="<?php the_permalink(); ?>"> <?php  the_post_thumbnail(); ?></a>
							
							
						<?php 
								}  
							else
								{
						?>

							<a href=" <?php the_permalink(); ?> "> <?php the_title(); ?> </a>
						
						<?php

							}	
						?>
                	
                    </li>
                 
                      
             <?php endwhile; else: ?>
            <?php endif; ?>
            </ul>  
           
   	 	<?php wp_reset_query();  ?>

     </ul>   
	

</div>

