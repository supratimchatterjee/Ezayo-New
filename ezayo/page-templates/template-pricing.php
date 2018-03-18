<?php
/**
 * The template for displaying all pages
 * Template Name: Pricing
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package Ezayo
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post();?>
		<div class="pricing-ad">
			<?php if(function_exists('the_ad_group')) the_ad_group(83); ?>
		</div>
		<div class="page-heading tm-margin-large-top uk-width-medium-5-10 uk-text-center uk-container-center">
			<h2 class="uk-text-bold tm-custom"><?php the_field('p_description');?></h2>
		</div>
		<!-- Tab section -->
		<div class="tm-margin-large-top">
			<ul class="tab-selector" data-uk-switcher="{connect:'#tab', animation: 'uk-animation-fade'}">
				<li><a class="uk-button" href="">job posting packages</a></li>
				<li><a class="uk-button" href="">Unlimited postings</a></li>
			</ul>

			<div class="tab-content">
				<?php /*<h4 class="uk-text-capitalize"><?php the_field('time_duration_u_p');?></h4>*/ ?>
				<ul id="tab" class="uk-switcher">
					<li data-uk-margin>
						<div class="tm-block uk-clearfix">
							<?php if(have_rows('job_posting_packages')):?>
								<?php while(have_rows('job_posting_packages')): the_row();?>
								<div class="uk-panel uk-panel-box uk-flex uk-flex-center uk-flex-middle">
									<div class="uk-width-medium-9-10 uk-container-center">
										<h2><?php the_sub_field('time_j_p');?></h2>
										<p><?php the_sub_field('description_j_p');?></p>
										<span><i><?php the_sub_field('price_j_p');?></i></span>
										<?php $button_link = get_bloginfo('url'). '/checkout/?add-to-cart=' . get_sub_field('button_link_j_p'); ?>
										<a href="<?php echo $button_link;?>" class="uk-button uk-button-primary uk-width-1-1"><?php the_sub_field('button_label_j_p');?></a>
									</div>
								</div>
								<?php endwhile;?>
							<?php endif;?>
						</div>
					</li>					
					<li data-uk-margin>
						<div class="tm-block uk-clearfix">
							<?php if (have_rows('unlimited_posting')):?>
								<?php while(have_rows('unlimited_posting')): the_row();?>
							<div class="uk-panel uk-panel-box uk-flex uk-flex-center uk-flex-middle">
								<div class="uk-width-medium-9-10 uk-container-center">
									<h2><?php the_sub_field('time_u_p');?></h2>
									<p><?php the_sub_field('description_u_p');?></p>
									<span><i><?php the_sub_field('price_u_p');?></i></span>
									<?php $button_link = get_bloginfo('url'). '/checkout/?add-to-cart=' . get_sub_field('button_link_u_p'); ?>
									<a href="<?php echo $button_link;?>" class="uk-button uk-button-primary uk-width-1-1"><?php the_sub_field('button_label_u_p');?></a>
								</div>
							</div>
								<?php endwhile;?>
							<?php endif;?>
						</div>
					</li>
				</ul>
				<div class="uk-margin-top tm-help">
					<?php the_field('quaries_b');?>
				</div>
			</div>
		</div>

		<div class="more-features uk-width-medium-9-10 uk-clearfix uk-container-center">
			<div class="uk-grid uk-grid-divider" data-uk-margin>
				<div class="uk-width-medium-1-2">
						<?php the_field('impressive_reach_and_effectiveness_section');?>
				</div>
				<div class="uk-width-medium-1-2">
						<?php the_field('easy_to_use');?>
				</div>
			</div>
		</div>

		<div class="uk-margin-large-top companies-logo">
			<h6><?php the_field('title_logo_sec');?></h6>
			<?php if(have_rows('logo_section')):?>
			<ul class="uk-margin-top uk-grid uk-grid-width-large-1-6 uk-grid-width-medium-1-3 uk-grid-width-small-1-1 uk-flex-middle" data-uk-margin="{cls:'uk-margin-large-top'}">
				<?php while(have_rows('logo_section')): the_row();?>
					<li class="uk-text-center"><img src="<?php the_sub_field('logo');?>"></li>
				<?php endwhile;?>
			</ul>
	<?php endif;?>
		</div>

		<div class="helpbox">
			<?php the_field('question');?>
		</div>
	<?php endwhile;?>
<?php
get_footer();