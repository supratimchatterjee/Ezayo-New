<?php
/**
 * The template for displaying all pages
 * Template Name: Marquee
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package Ezayo
 */
?>
<!doctype html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Ezayo</title>
	<link href="<?php echo get_template_directory_uri();?>/assets/css/marquee.css" rel="stylesheet" type="text/css" />

</head>

	<body>
		<div class="marquee-container">
			<div class="marquee-caption">
				<a href="https://ezayo.com/" target="_blank"><img src="https://ezayo.com/wp-content/uploads/2017/07/ezayo-logo-for-ticker.png" alt=""></a>
			</div>
			<div class="marquee">
				<div class="marquee_one bg" data-duration='32000' data-gap='22' data-duplicated='true' data-startvisible='true' data-pauseonhover='true'>
					<ul class="uk-clearfix">
					<?php
						$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
						$args = array(
							'post_type'			=> 'job_listing',
							'posts_per_page'	=> 25
						);

						$query = new WP_Query($args);
						if ($query->have_posts()) :
							while ($query->have_posts()) : $query->the_post();
							$id = $query->post->ID;
					?>

								<?php $functions = wp_get_post_terms( $id, 'job_function' ); $first_function = ''; ?>

								<?php if ($functions) : ?>

									<?php if ( class_exists('WPSEO_Primary_Term') ) : ?>
										<?php $wpseo_primary_term = new WPSEO_Primary_Term( 'job_function', $id ); ?>
										<?php $wpseo_primary_term = $wpseo_primary_term->get_primary_term(); ?>
										<?php $term = get_term( $wpseo_primary_term ); ?>

										<?php if (is_wp_error($term)) :  ?>
											<?php $first_function = $functions[0]; ?>
										<?php else : ?>
											<?php $first_function = $term; ?>
										<?php endif; ?>

									<?php else : ?>
										<?php $first_function = $functions[0]; ?>
									<?php endif; ?>

									<?php $first_function_short_name = get_field('short_text', 'job_function_' . $first_function->term_id ) ? get_field('short_text', 'job_function_' . $first_function->term_id ) : $first_function->name;  ?>
									<?php $first_function_color = get_field('highlight_color', 'job_function_' . $first_function->term_id ) ? get_field('highlight_color', 'job_function_' . $first_function->term_id ) : '#8cc14c';  ?>

									<li>
										<a href="<?php the_permalink();?>" target="_blank">
											<span class="uk-badge uk-badge-success" style="background-color: <?php echo $first_function_color; ?>"><?php echo $first_function_short_name; ?></span>
											<span><?php the_title();?></span>
											<span class="date">&nbsp;<?php the_time('d M Y');?></span>
										</a>
									 </li>

								<?php endif; ?>
							<?php endwhile; ?>
						<?php endif; wp_reset_query(); ?>
					</ul>
				</div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/assets/js/jquery.marquee.min.js"></script>
		<script>
		jQuery(document).ready(function($) {

			/** Marquee **/
		 	$('.marquee > div').marquee();
		 	/** Marquee **/

		 });
		</script>
	</body>
</html>
