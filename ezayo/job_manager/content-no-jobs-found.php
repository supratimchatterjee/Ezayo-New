<?php if ( defined( 'DOING_AJAX' ) ) : ?>
	<li class="no_job_listings_found"><?php _e( "Sorry, we couldn't find any jobs that match your criteria, please search again.", 'wp-job-manager' ); ?></li>
<?php else : ?>
	<p class="no_job_listings_found"><?php _e( "Sorry, we couldn't find any jobs that match your criteria, please search again.", 'wp-job-manager' ); ?></p>
<?php endif; ?>
