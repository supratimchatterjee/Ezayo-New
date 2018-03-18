<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Ezayo
 */
?>



<aside id="secondary" class="widget-area" role="complementary">
	<div  data-uk-margin="{cls:'uk-margin-top'}">
		<?php if ( is_active_sidebar( 'sidebar-right' ) ) : ?>
			<?php dynamic_sidebar( 'sidebar-right' ); ?>
		<?php endif; ?>
		<div>
			<?php get_sidebar('Company_Jobs_Widget');?>
		</div>
	</div>
</aside><!-- #secondary -->
