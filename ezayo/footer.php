<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Ezayo
 */

?>

	</div>
</div>

<!-- This is the modal -->
<div id="subscribe-form" class="uk-modal subscribe-form">
	<div class="uk-modal-dialog">
		<a class="uk-modal-close uk-close"></a>
		<div class="uk-clearfix"></div>
		<?php echo do_shortcode( '[mc4wp_form id="178"]'); ?>
	</div>
</div>


<footer class="footer uk-text-center">
	<div class="uk-container uk-container-center">
		<div class="uk-grid" data-uk-margin="{cls:'uk-margin-top'}">
			<div class="uk-width-large-2-3 uk-push-1-3 tm-text-right">
				<?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'menu_id' => 'footer-menu', 'menu_class' => 'tm-navbar-nav', 'container' => false ) ); ?>
			</div>
			<div class="uk-width-large-1-3 uk-pull-2-3 tm-text-left">	
				©Ezayo - Copyright 2017 All Rights Reserved
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>

</body>
</html>
