<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Ezayo
 */

get_header(); ?>
	<?php while ( have_posts() ) : the_post(); ?>

			<!--Body part-->
			<div class="uk-grid uk-margin-top uk-grid-small" data-uk-margin="{cls:'uk-margin-top'}">
				<div class="uk-width-medium-2-3">
					<div class="tm-content-bg">
						<header class="title-header">
							<h1 class="page-title"><?php the_title();?></h1>
							<?php if(get_field('post_subtitle')) : ?>
							<h5 class="page-subtitle uk-margin-remove"><?php the_field('post_subtitle');?></h5>
							<?php endif; ?>
						</header>
						<div class="post-entry uk-clearfix">
							<?php if(has_post_thumbnail()) : ?>
							<div class="uk-align-left single-post-thubmnail">
								<?php the_post_thumbnail('medium');?>
							</div>
							<?php endif; ?>
							<div class="single-post-content">
								<?php the_content();?>
							</div>
							<?php if ( in_category( array('career-insights','careers','interviews','podcasts','surveys') ) ) : ?>
								<?php comments_template(); ?>
			  				<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="uk-width-medium-1-3">
					<?php get_sidebar();?>
				</div>
			</div>
			<!--End-->
	<?php endwhile; // End of the loop. ?>
<?php get_footer();
