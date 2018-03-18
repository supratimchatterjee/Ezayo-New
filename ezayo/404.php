<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Ezayo
 */

get_header(); ?>
		<!--Body part-->
		<div class="uk-grid uk-margin-top uk-grid-small" data-uk-margin="{cls:'uk-margin-top'}">
			<div class="uk-width-medium-2-3">
				<div class="tm-content-bg">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'ezayo' ); ?></h1>
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'ezayo' ); ?></p>
					<p><?php get_search_form();?></p>
				</div>
			</div>
			<div class="uk-width-medium-1-3">
				<?php get_sidebar();?>
			</div>
		</div>
		<!--End-->
<?php
get_footer();
