<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ezayo
 */

get_header(); ?>
<?php $tax = get_queried_object();?>
<?php if ( have_posts() ) : ?>
	<div class="uk-grid uk-margin-top uk-grid-small" data-uk-margin="{cls:'uk-margin-top'}">
		<div class="uk-width-medium-2-3">
			<div class="tm-content-bg career-insight">
				<header class="title-header">
					<h1 class="page-title"><?php echo '' . $tax->name . '';?></h1>
					<?php if($tax->description) : ?>
					<p class="uk-margin-remove"><?php echo '' . $tax->description . '';?></p>
					<?php endif; ?>
				</header>
				<?php while ( have_posts() ) : the_post();?>
			    		<div class="tm-panel uk-clearfix">
							<div class="archive-post-thumbnail uk-align-left uk-margin-bottom-remove">
								<a href="<?php the_permalink();?>">
									<?php the_post_thumbnail(array(150,100)); ?>
								</a>
							</div>
							<div class="archive-post-content">
								<a href="<?php the_permalink();?>"><h5 class="uk-margin-small uk-margin-bottom-remove"><?php the_title();?></h5></a>
								<p class="post-excerpt uk-margin-bottom-remove">
									<?php echo get_the_excerpt(); ?>
								</p>
							</div>
							<?php /*<a href="<?php echo get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j'));  ?>"><span><strong><?php the_time('F j, Y');?></strong></span></a> */?>
						</div>
						<hr>
				<?php endwhile; ?>
				<?php wp_pagenavi(); ?>
			</div>
		</div>
		<div class="uk-width-medium-1-3">
			<?php get_sidebar();?>
		</div>
	</div>
	<?php endif; ?>

<?php
get_footer();
