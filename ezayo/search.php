<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Ezayo
 */

get_header(); ?>
			<div class="uk-grid uk-margin-top uk-grid-small" data-uk-margin="{cls:'uk-margin-top'}">
				<div class="uk-width-medium-2-3">
					<div class="tm-content-bg career-insight">
						<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'ezayo' ), '<span>' . get_search_query() . '</span>' );?></h1>
						<?php while ( have_posts() ) : the_post();?>
				    		<div class="tm-panel uk-clearfix">
								<a href="<?php the_permalink();?>">
									<?php the_post_thumbnail(array(150,100), array('class' => 'uk-align-left wp-post-image uk-margin-bottom-remove')); ?>
								</a>
								<div class="archive-post-content">
									<a href="<?php the_permalink();?>"><h5 class="uk-margin-small"><?php the_title();?></h5></a>
									<?php  $query_content = get_the_content();?>
									<?php echo wp_trim_words( $query_content, 30, '..' ); ?>
								</div>
								<?php /*<a href="<?php echo get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j'));  ?>"><span><strong><?php the_time('F j, Y');?></strong></span></a> */?>
							</div>
						<?php endwhile; ?>
						<?php wp_pagenavi(); ?>
					</div>
				</div>
				<div class="uk-width-medium-1-3">
					<?php get_sidebar();?>
				</div>
			</div>


<?php
get_footer();
