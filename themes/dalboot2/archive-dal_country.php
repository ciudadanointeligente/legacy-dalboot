<?php
/**
 *Template Name: archive-dal_country.php 
 *The template for displaying Archive for DAL Country pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.6
 */

get_header();
if (have_posts() ) ;?>
<div class="row">

	<div class="container">
		<?php// if (function_exists('bootstrapwp_breadcrumbs')) bootstrapwp_breadcrumbs(); ?>
	</div><!--/.container -->
</div><!--/.row -->
<div class="container">
	<header class="jumbotron subhead" id="overview">
		<h1><?php
			_e( 'Países en DAL', 'bootstrapwp' );
		?></h1>
	</h1>
</header>

<div class="row content nolist">
	<div class="span12">
		<?php while ( have_posts() ) : the_post(); ?>
		<div <?php post_class(); ?>>
			<div class="span well">
				<a class="fullcentered" href="<?php the_permalink(); ?>" title="<?php the_title();?>"><h3><?php the_title();?></h3></a>
                    <?php 
                    //getting the content
                   //the basic conuntry info
              	    get_template_part('content','dal_country');
                    ?>
            </div>        
			
		
		</div><!-- /.post_class -->
		<?php endwhile; ?>
		

		</div><!-- /.span8 -->
		<?php //get_sidebar(''); ?>

		<?php get_footer(); ?>