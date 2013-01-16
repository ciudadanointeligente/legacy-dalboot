<article>
	<div class="infoApp row" >
		<div class="fullcentered nolist" >
			
			<?php 
			$post_meta_data = get_post_custom($post->ID); 
			echo'<a class= "btn btn-large btn-action span2" href="'.$post_meta_data[country_inscribete][0].'" ><i class="icon-pencil icon-white"></i>  Inscríbete en '.get_the_title().'</a>';?>	
		</div>
	</div>
</article>	