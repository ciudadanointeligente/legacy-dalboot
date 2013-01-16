<div class="row sponsorFooter well nolist"> 
	

	<ul class="sponsorlist">
		<li><h2>Organiza:</h2></li>
	<?php

	$term = get_the_terms($post->ID, 'pais');
	//print_r($term);

        query_posts( array( 'post_type' => 'dal_organizers', 'pais'=>array_pop($term)->name, 'paged' => get_query_var('taxonomy'), 'posts_per_page' => 30, 'orderby' => 'title', 'order' => 'DESC' ) ); ?>
       
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <li>
                    		<?php $post_meta_data = get_post_custom($post->ID); ?>
							<?php 
								echo '<a href="'.$post_meta_data['org_link'][0].'">';
								$org_logo = $post_meta_data['org_logo'][0];  
								echo wp_get_attachment_image($org_logo, 'medium'); 
								echo '</a>';
							?>
                    </li>
                 
                      
		<?php endwhile; else: ?>
		<?php endif; ?>
    </ul>  
   
 	<?php wp_reset_query();  ?>

     </ul>   
	

</div>

