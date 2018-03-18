<?php
/**
 * The template for displaying all pages
 * Template Name: Job search
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package Ezayo
 */
 get_header(); ?>

	 <?php $args = array(
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => 'user_is_search_firm',
				'compare' => 'EXISTS'
			),
			array(
				'key' => 'user_is_search_firm',
				'value' => '1',
				'compare' => '='
			)
		),
		'fields' => 'ID'
	);
	?>
	<?php $search_firms = get_users( $args ); ?>
	<?php if(count($search_firms) && is_page(406)) : ?>
		<style>
		<?php foreach($search_firms as $search_firm) : ?>
			.facetwp-facet-companies .facetwp-radio[data-value="<?php echo $search_firm; ?>"] { display: none; }
		<?php endforeach; ?>
		</style>
	<?php endif; ?>

 	<?php while ( have_posts() ) : the_post(); ?>

 			<!--Body part-->
 			<div class="uk-grid uk-margin-top uk-grid-small" data-uk-margin="{cls:'uk-margin-top'}">
 				<div class="uk-width-medium-2-3">
					<div class="uk-visible-small uk-text-center uk-margin-bottom">
						<a class="trigger-mobile-filter uk-button uk-button-primary">Show Filters</a>
					</div>
 					<div class="job-search">
 						<?php the_content();?>
						<?php echo facetwp_display( 'pager' ); ?>
 					</div>
 				</div>
 				<div class="uk-width-medium-1-3">
 					<?php get_sidebar();?>
 				</div>
 			</div>
 			<!--End-->


 	<?php endwhile; // End of the loop. ?>
 <?php
 get_footer();
