<?php
/**
 * The template for displaying Ideas Archive pages.
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.6
 */

get_header();
if (have_posts() ) ;?>

<div class="container">

	<header class="jumbotron subhead" id="overview">
		<h1><?php if ( is_category() ) {
			printf( __( '%s', 'bootstrapwp' ), '<span>' . single_cat_title( '', false ) . '</span>' );
					// Show an optional category description
			$category_description = category_description();
			if ( $category_description )
				echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
		} else {
			_e( 'Blog Archives', 'bootstrapwp' );
		}
		?></h1>
	</h1>
</header>

<div class="row content">

	<div class="span8">
		<?php while ( have_posts() ) : the_post(); ?>
		<div <?php post_class(); ?>>

				<div class="row">
					<div class="span7 well">
						<a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><h3><?php the_title();?></h3></a>
							<p class="meta"><?php echo bootstrapwp_posted_on();?> <?php the_tags( 'Tags: ', ', ', $after );
						?></p>
							
						<?php the_excerpt();?>
					</div>	
				
					<footer class="span7"> 
							<div class="pull-right">
								<?php //get cats
								$category = get_the_category(); 
								if($category[0]){
								echo '<a href="'.get_category_link($category[0]->term_id ).'">View all the '.$category[0]->cat_name.'</a>';
								}
								?>
							</div>
					</footer> 
				</div>
		</div>		

			<?php endwhile; ?>
			<?php bootstrapwp_content_nav('nav-below');?>

	</div><!-- /.span8 -->
		<?php get_sidebar('ideas'); ?>
</div>		

		<?php get_footer(); ?>