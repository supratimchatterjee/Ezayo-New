<?php global $post; ?>

<?php $job_duties		= get_post_meta( $post->ID, '_job_duties', true ); ?>
<?php $job_requirements	= get_post_meta( $post->ID, '_job_requirements', true ); ?>
<?php $job_offering		= get_post_meta( $post->ID, '_job_offering', true ); ?>
<?php $job_testimonial	= get_post_meta( $post->ID, '_job_testimonial', true ); ?>

<?php $salary			= get_post_meta( $post->ID, '_job_pay', true ); ?>
<?php $education		= get_post_meta( $post->ID, '_job_qualification', false ); ?>
<?php $experience		= get_post_meta( $post->ID, '_job_experience', false ); ?>
<?php $functions		= wp_get_post_terms($post->ID, 'job_function', array("fields" => "names")); ?>
<?php $industries		= wp_get_post_terms($post->ID, 'job_listing_industry', array("fields" => "names")); ?>

<?php $address = array(); ?>
<?php $address[] = get_post_meta($post->ID, '_job_location_city', true) ; ?>
<?php $address[] = get_post_meta($post->ID, '_job_location_state', true) ; ?>
<?php $address = array_filter($address); ?>



<div class="single_job_listing">
	<meta content="<?php echo esc_attr( $post->post_title ); ?>" />

	<?php if ( get_option( 'job_manager_hide_expired_content', 1 ) && 'expired' === $post->post_status ) : ?>
		<div class="job-manager-info"><?php _e( 'This listing has expired.', 'wp-job-manager' ); ?></div>
	<?php else : ?>
		<?php
			/**
			 * single_job_listing_start hook
			 *
			 * @hooked job_listing_meta_display - 20
			 * @hooked job_listing_company_display - 30
			 */
			do_action( 'single_job_listing_start' );
		?>

		<div class="job_description">

			<?php if(!empty($address)) : ?>
			<div class="uk-margin-top">
				<span class="uk-display-block"><?php _e('Location', 'ezayo');?></span>
				<span class="uk-display-block"><strong><?php the_job_location(false); ?></strong></span>
			</div>
			<?php endif;?>

			<?php if(!empty($functions)) : ?>
				<div class="uk-margin-top">
					<span class="uk-display-block"><?php _e('Functions', 'ezayo');?></span>
					<?php foreach($functions as $function) : ?>
						<span class="uk-display-block"><strong><?php echo $function; ?></strong></span>
					<?php endforeach;?>
				</div>
			<?php endif; ?>

			<?php if(!empty($industries)) : ?>
				<div class="uk-margin-top">
					<span class="uk-display-block"><?php _e('Industry', 'ezayo');?></span>
					<?php foreach($industries as $industry) : ?>
						<span class="uk-display-block"><strong><?php echo $industry; ?></strong></span>
					<?php endforeach;?>
				</div>
			<?php endif; ?>

			<?php if($salary && $salary != '0,0') : ?>

			<?php $salary		= explode(',', $salary); ?>
			<?php $salary_type	= get_post_meta( $post->ID, '_job_pay_type', true ); ?>
			<?php $suffix		= $salary_type == 'hour' ? '' : 'K'; ?>
			<?php $apnd			= $salary_type == 'hour' ? ' / hour' : ' / year'; ?>
			<?php $mult			= $salary_type == 'hour' ? 0.1 : 1; ?>

			<div class="uk-margin-top">
				<span class="uk-display-block"><?php _e('Salary', 'ezayo');?></span>
				<span class="uk-display-block"><strong><?php echo '$' . $salary[0] * $mult . $suffix . ' - ' . '$' . $salary[1] * $mult . $suffix . $apnd; ?></strong></span>
			</div>
			<?php endif;?>

			<?php if(!empty($education[0])) : ?>
			<div class="uk-margin-top">
				<span class="uk-display-block"><?php _e('Education level', 'ezayo');?></span>
				<span class="uk-display-block"><strong><?php echo implode(', ', $education[0]); ?></strong></span>
			</div>
			<?php endif;?>

			<?php if(!empty($experience[0])) : ?>
			<div class="uk-margin-top">
				<span class="uk-display-block"><?php _e('Career level', 'ezayo');?></span>
				<span class="uk-display-block"><strong><?php echo implode(', ', $experience[0]); ?></strong></span>
			</div>
			<?php endif;?>


			<h4 class="uk-text-bold"><?php _e('Job Description', 'ezayo');?></h4>
			<?php echo apply_filters( 'the_job_description', get_the_content() ); ?>

			<?php if($job_duties) : ?>
				<h4 class="uk-text-bold"><?php _e('Duties and Responsibilities', 'ezayo');?></h4>
				<?php echo apply_filters('the_content', $job_duties); ?>
			<?php endif;?>

			<?php if($job_requirements) : ?>
				<h4 class="uk-text-bold"><?php _e('Qualifications/Requirements', 'ezayo');?></h4>
				<?php echo apply_filters('the_content', $job_requirements); ?>
			<?php endif;?>

			<?php if($job_offering) : ?>
				<h4 class="uk-text-bold"><?php _e('We Offer You', 'ezayo');?></h4>
				<?php echo apply_filters('the_content', $job_offering); ?>
			<?php endif;?>

			<?php if($job_testimonial) : ?>
				<h4 class="uk-text-bold"><?php _e('Our Colleagues’ Experience', 'ezayo');?></h4>
				<?php echo apply_filters('the_content', $job_testimonial); ?>
			<?php endif;?>

		</div>

		<?php if ( candidates_can_apply() ) : ?>
			<?php get_job_manager_template( 'job-application.php' ); ?>
		<?php endif; ?>

		<?php
			/**
			 * single_job_listing_end hook
			 */
			do_action( 'single_job_listing_end' );
		?>
	<?php endif; ?>
</div>
