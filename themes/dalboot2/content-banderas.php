<div class="flagList nolist">

	<?php

	$args = array( 'post_type' => 'dal_country', posts_per_page => -1 );
	$listloop = new WP_Query( $args );
	while ( $listloop->have_posts() ) : $listloop->the_post();
	
	global $post;
	$terms = get_the_terms($post->id, 'pais');

	
	foreach ($terms as $term => $valorpais) {
	
		echo '<span class="btn-bandera">';  	
			$mycountry= $valorpais->slug;
	    $post_meta_data = get_post_custom($post->ID); 

		$country_link_id = $post_meta_data[country_post_id][0];
		$country_link = get_permalink($country_link_id);
		echo'<a id="masInfoPais'.$country_link_id.'" class= "btn btn-medium " href="'.$country_link.'"><i class="flag flag-'.$mycountry.'"></i> </a>';

	echo '</span>';
	}                
	endwhile;
	?>
</div>
		


