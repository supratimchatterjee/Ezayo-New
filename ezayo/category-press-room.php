<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ezayo
 */

get_header(); ?>
<?php $tax = $wp_query->get_queried_object();?>
<?php if ( have_posts() ) : ?>
	<div class="uk-grid uk-margin-top uk-grid-small" data-uk-margin="{cls:'uk-margin-top'}">
		<div class="uk-width-medium-2-3">
			<div class="tm-content-bg all-news">
				<header class="title-header">
					<h1 class="page-title"><?php echo '' . $tax->name . '';?></h1>
					<?php if($tax->description) : ?>
					<p class="uk-margin-remove"><?php echo '' . $tax->description . '';?></p>
					<?php endif; ?>
				</header>
				<div class="uk-margin-large-top all-news-threads">
					<?php while ( have_posts() ) : the_post();?>
					<div class="uk-margin-bottom news-entry">
						<a href="<?php the_permalink();?>">
							<div class="uk-clearfix">
							<span class="date uk-float-left"><?php the_time ('j-M-Y');?></span>
							<span><?php the_title();?></span>
							</div>
						</a>
					</div>
					<?php endwhile; ?>
					<?php wp_pagenavi(); ?>
				</div>
			</div>
		</div>
		<div class="uk-width-medium-1-3">
			<?php get_sidebar();?>
		</div>
	</div>
<?php endif;?>
<?php get_footer();
