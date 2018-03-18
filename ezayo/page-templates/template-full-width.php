<?php
/**
 * The template for displaying all pages
 * Template Name: Full Width
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package Ezayo
 */

get_header(); ?>
	<?php while ( have_posts() ) : the_post(); ?>

			<!--Body part-->
			<div class="uk-grid uk-margin-top uk-grid-small" data-uk-margin="{cls:'uk-margin-top'}">
				<div class="uk-width-medium-1-1">
					<div class="tm-content-bg">
						<header class="title-header">
							<h1 class="page-title"><?php the_title();?></h1>
							<?php if(get_field('post_subtitle')) : ?>
							<h5 class="page-subtitle uk-margin-remove"><?php the_field('post_subtitle');?></h5>
							<?php endif; ?>
						</header>
						<div class="page-entry uk-clearfix">
							<?php the_content();?>
						</div>
					</div>
				</div>
			</div>
			<!--End-->


	<?php endwhile; // End of the loop. ?>
<?php
get_footer();
