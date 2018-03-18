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

		<?php $user_id		= $post->post_author; ?>
		<?php $user_banner	= get_user_meta($user_id, 'user_banner', true) ? get_user_meta($user_id, 'user_banner', true) : get_field('job_post_fallback_banner', 'option'); ?>
		<?php $user_company	= get_user_meta($user_id, 'billing_company', true) ? get_user_meta($user_id, 'billing_company', true) : ''; ?>
		<?php $category		= wp_get_post_terms($post->ID, 'job_listing_category', array("fields" => "ids")); ?>
		<?php $search_link	= $category[0] == 19 ? get_permalink(406) : get_permalink(410); ?>
		<?php $is_search_post = get_post_meta($post->ID, '_search_firm_post', true) ? get_post_meta($post->ID, '_search_firm_post', true) : false; ?>


		<!--Content Banner-->
		<div class="content-banner">
			<div class="uk-panel uk-panel-box">
				<?php if($user_banner) : ?>
					<?php $image_array	= wp_get_attachment_image_src( $user_banner, 'full' ); ?>
					<?php $image_url	= $image_array[0]; ?>
					<div class="uk-panel-teaser">
						<img class="uk-width-1-1" src="<?php echo $image_url; ?>">
					</div>
				<?php endif;?>
				<div class="uk-grid uk-flex-middle">
					<div class="uk-width-medium-1-2">
						<h1 class="page-title"><?php the_title(); ?></h1>
						<?php $address = array(); ?>
						<?php $address['city'] = get_post_meta($post->ID, '_job_location_city', true) ; ?>
						<?php $address['state'] = get_post_meta($post->ID, '_job_location_state', true) ; ?>
						<?php $address['country'] = get_post_meta($post->ID, '_job_location_country', true) ; ?>
						<?php $address = array_filter($address); ?>
						<h3 class="uk-margin-remove">
							<?php if($is_search_post) : ?>
								<?php echo get_post_meta($post->ID, '_custom_company_name', true); ?>
								<?php if(!empty($address)) : ?>
									<?php if(isset($address['country'])) : ?>
										<?php if($address['country'] == 'United States') : ?>
											<?php unset($address['country']); ?>
										<?php else : ?>
											<?php unset($address['state']); ?>
										<?php endif; ?>
									<?php endif; ?>
									<?php echo '- ' . implode(', ', $address); ?>
								<?php endif; ?>
							<?php else: ?>
								<?php echo $user_company; ?>
								<?php if(!empty($address)) : ?>
									<?php if(isset($address['country'])) : ?>
										<?php if($address['country'] == 'United States') : ?>
											<?php unset($address['country']); ?>
										<?php else : ?>
											<?php unset($address['state']); ?>
										<?php endif; ?>
									<?php endif; ?>
									<?php echo '- ' . implode(', ', $address); ?>
								<?php endif; ?>
							<?php endif; ?>
						</h3>
						<?php if($is_search_post) : ?>
							<h6 class="uk-margin-top anon-post-notify">This job posted on behalf of a client by <?php echo rtrim($user_company, '-'); ?></h6>
						<?php endif; ?>
					</div>
					<div class="uk-width-medium-1-2 uk-text-right">
						<a class="uk-button uk-button-primary uk-button-large" href="#">Apply for job</a>
					</div>
				</div>
			</div>
		</div>
		<!--End-->
		<!--Body part-->
		<div class="uk-grid uk-margin-top uk-grid-small" data-uk-margin="{cls:'uk-margin-top'}">
			<div class="uk-width-medium-2-3">
				<div class="tm-content-bg">
					<a href="<?php echo $search_link; ?>" class="uk-margin-bottom uk-display-block"><i class="uk-icon-chevron-left"></i> back to search</a>
					<?php the_content();?>
				</div>
			</div>
			<div class="uk-width-medium-1-3">
				<?php get_sidebar();?>
			</div>
		</div>
		<!--End-->
	<?php endwhile;?>
<?php get_footer();
