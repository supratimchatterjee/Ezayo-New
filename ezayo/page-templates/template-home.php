<?php
/**
 * The template for displaying all pages
 * Template Name: Home
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package Ezayo
 */

get_header(); ?>
	<?php while ( have_posts() ) : the_post();?>
		<main class="ezayo-home-banner">
			<div class="uk-container uk-container-center tm-height-1-1">
				<div class="uk-width-large-5-10 uk-margin-top-remove uk-margin-large-bottom">
					<h1><?php the_field('title');?></h1>
					<h2><?php the_field('small_description');?></h2>
					<div data-uk-margin>
						<a class="uk-button uk-button-primary" href="<?php the_field('first_button_link');?>"><?php the_field('button_label');?></a>
						<a class="uk-button uk-button-primary" href="<?php the_field('second_button_link');?>"><?php the_field('second_button_label');?></a>
					</div>
				</div>
				<div class="homepage-conference-ad">
					<?php if(function_exists('the_ad_placement')) the_ad_placement('homepage-body'); ?>
				</div>
			</div>
		</main>

		<div class="footer-section">
			<div class="uk-container uk-container-center">
				<div class="home-footer tm-margin-top">
					<div class="uk-grid" data-uk-margin="{cls:'uk-margin-top'}">
						<div class="uk-width-medium-1-2 tm-text-left">
							<?php wp_nav_menu( array( 'theme_location' => 'home-left-footer-menu', 'menu_id' => 'footer-left-menu', 'menu_class' => 'tm-navbar-nav', 'container' => false ) ); ?>
						</div>
						<div class="uk-width-medium-1-2 tm-text-right">
							<?php wp_nav_menu( array( 'theme_location' => 'home-right-footer-menu', 'menu_id' => 'footer-right-menu', 'menu_class' => 'tm-navbar-nav', 'container' => false ) ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endwhile;?>
<?php get_footer();