<?php
$term = get_the_terms($post->ID, 'pais');
//print_r($term);

query_posts( array( 'post_type' => 'post', 'pais'=>array_pop($term)->name, 'paged' => get_query_var('taxonomy'), 'posts_per_page' => 30, 'orderby' => 'title', 'order' => 'DESC' ) ); 
?>



<div class="well nofillwell">  
            
    <h3> <?php _e( 'Latest News', 'bootstrapwp' ); ?></h3>
        <ul class="dalLinklist">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <li>
           
                    <a href=" <?php the_permalink(); ?> "> <?php the_title(); ?> </a>
                
            
            </li>
              <?php endwhile; else: ?>
              <?php endif; ?>
         
       </ul>      
        
</div>
   
   
    
   
<?php wp_reset_query();  ?>
   
