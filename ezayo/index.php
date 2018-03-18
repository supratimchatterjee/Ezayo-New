<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ezayo
 */

get_header(); ?>
	<?php $page_for_posts = get_option( 'page_for_posts' ); ?>
			<div class="uk-grid uk-margin-top" data-uk-margin="{cls:'uk-margin-top'}">
				<div class="uk-width-medium-2-3">
					<div class="tm-content-bg career-insight">
						<?php echo apply_filters( 'the_content', get_the_content_by_id($page_for_posts) ); ?>
						<?php if ( have_posts() ) : ?>
							<?php while ( have_posts() ) : the_post();?>
								<?php get_template_part('template-parts/content', 'post-with-thumbnail'); ?>
							<?php endwhile; ?>
							<?php wp_pagenavi(); ?>
						<?php endif; ?>
					</div>
				</div>
				<div class="uk-width-medium-1-3">
					<?php get_sidebar();?>
				</div>
			</div>
<?php get_footer();
