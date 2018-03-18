<?php
/**
 * The template for displaying all pages
 * Template Name: Partners
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package Ezayo
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post();?>
	<div class="tm-content-bg partners">
		<div class="uk-grid uk-grid-divider" data-uk-margin="{cls:'uk-margin-top'}">
			<div class="uk-width-medium-1-2">
				<h1 class="page-title"><?php the_title();?></h1>
				<?php the_field('left_content');?>
			</div>
			<div class="uk-width-medium-1-2">
				<?php the_field('right_content');?>
			</div>
		</div>
	</div>

	<div class="uk-text-center uk-margin-large-top uk-margin-bottom testimonials">
		<h1 class="page-title copy"><?php the_field('title_gps') ;?></h1>
		<em>
			<?php the_field('description_gps') ;?>
		</em>
	</div>

	<div class="company-logo uk-text-center">
		<div>
			<div class="uk-grid" data-uk-margin="{cls:'tm-margin-top'}">
				<?php $images = get_field('logo_gallery'); ?>
				<?php foreach( $images as $image ): ?>
					<div class="uk-width-medium-1-3">
						<div style="background: #fff; padding: 15px 0;">
							<?php $link = get_field('launch_partner_link', $image['ID']); ?>
							<?php if($link):?>
							<a target="_blank" href="<?php echo get_field('launch_partner_link', $image['ID']);?>">
								<img src="<?php echo $image['url']; ?>">
							</a>
							<?php else: ?>
								<img src="<?php echo $image['url']; ?>">
							<?php endif; ?>

						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
<?php endwhile;?>
<?php
get_footer();
