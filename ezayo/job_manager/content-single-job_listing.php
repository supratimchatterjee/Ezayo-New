<?php global $post; ?>

<?php $job_duties		= get_post_meta( $post->ID, '_job_duties', true ); ?>
<?php $job_requirements	= get_post_meta( $post->ID, '_job_requirements', true ); ?>
<?php $job_offering		= get_post_meta( $post->ID, '_job_offering', true ); ?>
<?php $job_testimonial	= get_post_meta( $post->ID, '_job_testimonial', true ); ?>


<div class="single_job_listing">
	
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
