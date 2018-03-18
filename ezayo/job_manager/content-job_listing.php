<?php global $post; ?>
<?php $company = $post->post_author; ?>
<?php $company_name = get_the_author_meta( 'billing_company', $company ) ? get_the_author_meta( 'billing_company', $company ) : ''; ?>
<?php $address = array(); ?>
<?php $address['city'] = get_post_meta($post->ID, '_job_location_city', true) ; ?>
<?php $address['state'] = get_post_meta($post->ID, '_job_location_state', true) ; ?>
<?php $address['country'] = get_post_meta($post->ID, '_job_location_country', true) ; ?>
<?php $address = array_filter($address); ?>
<?php $is_search_post = get_post_meta($post->ID, '_search_firm_post', true) ? get_post_meta($post->ID, '_search_firm_post', true) : false; ?>
<?php $custom_company = get_post_meta($post->ID, '_custom_company_name', true); ?>

<tr>
	<td>
		<a href="<?php the_job_permalink(); ?>"><strong class="uk-visible-small">Job Title : </strong> <?php echo esc_html( get_the_title() ); ?></a>
	</td>

	<td>
		<strong class="uk-visible-small">Company : </strong>
		<?php if($is_search_post) : ?>
			<?php echo $custom_company;?>
		<?php else : ?>
			<?php echo $company_name; ?>
		<?php endif; ?>
	</td>

	<td>
		<?php if(!empty($address)) : ?>
			<strong class="uk-visible-small">Location : </strong>
			<?php if(isset($address['country'])) : ?>
				<?php if($address['country'] == 'United States') : ?>
					<?php unset($address['country']); ?>
				<?php else : ?>
					<?php unset($address['state']); ?>
				<?php endif; ?>
			<?php endif; ?>
			<?php echo implode(', ', $address); ?>
		<?php endif; ?>
	</td>

	<td>
		<a href="<?php the_job_permalink(); ?>" class="uk-button uk-button-primary">View Job</a>
	</td>
</tr>
