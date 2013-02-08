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
	  <div class="container">
	   	<?php if (function_exists('bootstrapwp_breadcrumbs')) bootstrapwp_breadcrumbs(); ?>
	  </div><!--/.container -->
  </div><!--/.row -->
   
  <div class="container">
     
 <!-- Masthead
      ================================================== -->
     
         
    <div class="content entryApp row">
        
		<div class="span8">
			<div class=" well paperwell">
	            <?php 
	            //getting the content
	            the_content();

	            //getting post meta data
				$post_meta_data = get_post_custom($post->ID);

				//getting pais 

				global $post;
				$paises = get_the_terms($post->id, 'appcountry');
				foreach ($paises as $pais => $valorpais) {
						$mycountry= $valorpais->name;
						$mycountryslug = $valorpais->slug;
						}	

				//getting tracks

				$tracks = get_the_terms($post->id, 'apps_tracks');

				//getting the prizes

				$premionacs = get_the_terms($post->id, 'premiopais');
				 if (!empty($premionacs)){
					foreach ($premionacs as $premionac => $premionacional) {
							$premiopais= $premionacional->name;
							$premiopaisslug= $premionacional->slug;
							}	
					}


				$premioreg = get_the_terms($post->id, 'premioregional');
				 if (!empty($premioreg)){
					foreach ($premioreg as $premiore => $premioregional) {
							$premioregion= $premioregional->name;
							$premioregionslug= $premioregional->slug;
							}
					}
				?>

            	 <!--the custom portfolio content-->

           		<article>

           		 	<header class="jumbotron subhead" id="overview">

				        <h1><?php the_title();?></h1>
				        <hr />
				       
				         		
				    </header>
					<section class="infoApp" >
							 
						<div class="row">
								<div class="thumbspan span4">
									<?php the_post_thumbnail( $size, $attr ); ?> 
									<div class="datitos">
				        	
							        	<?php 
							        		echo '<span><i class="flag flag-'.$mycountryslug.'" ></i></span>  <span>  &nbsp '  .$mycountry. ' </span> '; 
							        		echo $post_meta_data[custom_ano][0];
							        	?>
							        	<div class="pull-right">
							        		<?php echo '<span class="dal-portf-premio premioNac dal-portf-'.$premiopaisslug.'"></span><span>'.$premiopais. ' </span> '; ?>
								        </div>
								        
							      	</div>
								</div>	
							<div class="span3">

							<?php
							
							 if (!empty($premioreg)){ //do not draw it if there is no prize assigned
							echo '<div class="ganadorRegional"> </div>'; 
								}
							?>
							        	
							        
									<ul id="infoAppUl" style="list-style: none;">
										<li> 
											<strong><?php _e( '&lt; Team &gt;', 'bootstrapwp' ); ?></strong><div class="appresponse teamName"><?php echo $post_meta_data[custom_equipo][0]; ?></div>
										</li>
										<li><strong> <?php _e( '&lt; Team Members &gt;', 'bootstrapwp' ); ?></strong>
											<ul class="appresponse" style="list-style:none"> 
												<?php  $custom_integrantes = get_post_meta($post->ID, 'custom_integrante', true);
												if (!empty($custom_integrantes)){
													foreach ($custom_integrantes as $key => $custom_integrante) {
													  	echo '<li>'.$custom_integrante.'</li>'; // echo out the member	
													}  
												}
										 		?>	
											</ul>
										</li>
										
												<?php
												 if (!empty($tracks)){ //do not draw it if there is not term assigned
												 	echo ' <li> <strong>'. __( '&lt; Tracks &gt;', 'bootstrapwp' ) .' </strong><div class="appresponse">';
												 	foreach ($tracks as $track => $eltrack) {
																$mytrack= $eltrack->name;
																echo '<span class="track">'.$mytrack. '</span> ';
													}	
													echo '</div></li>';
												}

											?>
										<li class="row fullcentered">	
											<?php 

											if (!empty($post_meta_data[custom_urlapp][0])){
											echo'<a class= "btn btn-large btn-primary span3" href="'.$post_meta_data[custom_urlapp][0].'">'. __( '&lt; Go to the App &gt;', 'bootstrapwp' ) .' </a>';
											}
											?>

										</li>
										<li class="row fullcentered"> 
											
											
												<?php 

													if (!empty($post_meta_data[custom_github][0])){
													echo'<a href="'.$post_meta_data[custom_github][0].'"><i class="ic-github"></i> '. __( '&lt; Go to code repository &gt;', 'bootstrapwp' ) .'</a>'; 
												}
												?>
											
										</li>
									</ul>
										
						
								

								
								
							</div><!--/row-->
			
						</section>
						<section class="descApp">
							<?php 

								

								echo '<h3>'. __( 'Social Problem', 'bootstrapwp' ) .'</h3>';
								echo apply_filters('the_content', $post_meta_data[custom_problema][0]);
								echo '<h3>'. __( 'Proposed solution', 'bootstrapwp' ) .'</h3>';
								echo apply_filters('the_content', $post_meta_data[custom_solucion][0]);  
								echo '<h3>'. __( 'Screencast', 'bootstrapwp' ) .'</h3>';
								echo $post_meta_data[custom_screencast][0];  

								echo '<div class="well"><h3> '. __( 'Datasets used', 'bootstrapwp' ) .'</h3><ul class="databaseList">';

								$custom_databases = get_post_meta($post->ID, 'custom_database', true);
								if (!empty($custom_databases )){
									foreach ($custom_databases as $key => $custom_database) {
										
										 echo '<li><a href="http://'. $custom_database .'">'. $custom_database .'</a></li>'; 
									}  
								}
							
								echo '</ul></div>';

							?>
						</section>
						<?php 
							if (!empty($post_meta_data[custom_contactoequipo][0])){
								echo '<aside class="appresponse"><h3> '. __( 'About the Team', 'bootstrapwp' ) .'</h3>';
								echo $post_meta_data[custom_contactoequipo][0]; 
								echo '</aside>';	
							}
						?>

				</article>
		
        		<?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>

        		<hr />	

        		<?php bootstrapwp_content_nav('nav-below');?>
		
            </div>	<!--/paper-->


		<?php endwhile; // end of the loop. ?>


		<?php comments_template(); ?>

 		

 		

    </div><!-- /span8 -->      
          
<?php get_sidebar('apps'); ?>


<?php get_footer(); ?>

