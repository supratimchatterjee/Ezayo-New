<?php

remove_action( 'single_job_listing_start', 'job_listing_meta_display', 20 );
remove_action( 'single_job_listing_start', 'job_listing_company_display', 30 );

/*
 * Custom validation based on data posted on job form
 */
add_filter( 'submit_job_form_validate_fields', 'validate_industry_field' );
function validate_industry_field( $success ) {

	$job_category = isset( $_POST['job_category'] ) ? $_POST['job_category'] : '';

	$tax_input = isset( $_POST['tax_input'] ) ? $_POST['tax_input'] : '';
	$industry_field = isset( $tax_input['job_listing_industry'] ) ? $tax_input['job_listing_industry'] : '';

	$search_firm_post = isset( $_POST['search_firm_post'] ) ? $_POST['search_firm_post'] : false;
	$custom_company_name = isset( $_POST['custom_company_name'] ) ? $_POST['custom_company_name'] : false;

	if($job_category == '19' && empty($industry_field))
		return new WP_Error( 'validation-error', 'Job Industry is a required field.' );

	if($search_firm_post && !$custom_company_name)
		return new WP_Error( 'validation-error', 'Company name is a required field when posting on their behalf.' );

	return $success;
}

/**
 * Enqueue scripts and styles realted to job manager
 */
function ezayo_wpjm_scripts() {

	// Get the WP Version global.
	global $wp_version;

	// Enqueue location autocomplete for post a job page
	if(is_page(4) || is_page(5)) :
		#CSS
		wp_enqueue_style( 'jrange-css', get_template_directory_uri() . '/assets/vendor/jRange-master/jquery.range.css' );

		#JS
		wp_enqueue_script( 'glocation-sensor', '//maps.googleapis.com/maps/api/js?libraries=places&key=' . GMAPS_API_KEY, false, false, false );
		wp_enqueue_script( 'jrange-js', get_template_directory_uri() . '/assets/vendor/jRange-master/jquery.range.js', array('jquery'), '0.1', true );
		wp_enqueue_script( 'geocomplete-js', get_template_directory_uri() . '/assets/vendor/geocomplete-master/jquery.geocomplete.js', false, '1.7.0', true );
	endif;

	wp_enqueue_script( 'site-job-manager-js', get_template_directory_uri() . '/assets/js/theme-job-manager.js', false, '1.0.1', true );

}
add_action( 'wp_enqueue_scripts', 'ezayo_wpjm_scripts' );


add_filter( 'facetwp_index_row', function( $params, $class ) {
    if ( 'companies' == $params['facet_name'] ) {
        $raw_value = $params['facet_value'];
		$company_name = get_the_author_meta( 'billing_company', $raw_value );
        $params['facet_display_value'] = $company_name;
    }
    return $params;
}, 10, 2 );

add_filter( 'facetwp_proximity_radius_options', function( $options ) {
    return array( 5, 10, 25, 50, 100, 250 );
});

add_filter( 'facetwp_result_count', function( $output, $params ) {
    $output = $params['total'] . ' results';
    return $output;
}, 10, 2 );

add_filter( 'facetwp_facet_html', function( $output, $params ) {
    if ( 'companies' == $params['facet']['name'] ) {
		$facet = $params['facet'];

        $output = '';
        $values = (array) $params['values'];
        $selected_values = (array) $params['selected_values'];

        $key = 0;
        foreach ( $values as $key => $result ) {
			$user_id = $result['facet_value'];
			$company_name = get_user_meta($user_id, 'billing_company', true);

			if(!$company_name)
				continue;

            $selected = in_array( $result['facet_value'], $selected_values ) ? ' checked' : '';
            $selected .= ( 0 == $result['counter'] && '' == $selected ) ? ' disabled' : '';
            $output .= '<div class="facetwp-radio' . $selected . '" data-value="' . esc_attr( $result['facet_value'] ) . '">';
            $output .= esc_html( $company_name ) . ' <span class="facetwp-counter">(' . $result['counter'] . ')</span>';
            $output .= '</div>';
        }

        return $output;
    }
    return $output;
}, 10, 2 );


/**
 * Appending the Job ID to the permalink slug and remove country name
 * @link https://wpjobmanager.com/document/tutorial-changing-the-job-slugpermalink/
 */

function remove_country_from_slug( $post_id, $post ) {

	// don't add the id if it's already part of the slug
	$permalink = $post->post_name;
	if ( strpos( $permalink, strval( $post_id ) ) ) {
		return;
	}

	// unhook this function to prevent infinite looping
	remove_action( 'save_post_job_listing', 'remove_country_from_slug', 10, 2 );

		// add the id to the slug and remove country name
	$permalink = str_replace('-united-states', '', $permalink) . '-' . $post_id;

	// update the post slug
	wp_update_post( array(
    	'ID' => $post_id,
    	'post_name' => $permalink
	));

	// re-hook this function
	add_action( 'save_post_job_listing', 'remove_country_from_slug', 10, 2 );
}
add_action( 'save_post_job_listing', 'remove_country_from_slug', 10, 2 );

/**
 * Append class based on user type
 */
add_filter('body_class', 'custom_body_classes');
function custom_body_classes($classes) {
	if (is_user_logged_in()) {
		$current_user_id = get_current_user_id();
		$user_is_search_firm = get_user_meta($current_user_id, 'user_is_search_firm', true);

		if($user_is_search_firm == 'Yes')
			$classes[] = 'user-is-search-firm';
	}

	return $classes;
}

/**
 * exclude filled jobs
 */
function sitemap_exclude_post( $url, $type, $post ) {
	$post_id = $post->ID;
	$filled = get_post_meta( $post_id, '_filled', true );
	if ( $filled ) {
		return false;
	}
	return $url;
}
add_filter( 'wpseo_sitemap_entry', 'sitemap_exclude_post', 1, 3 );
add_filter('wpseo_enable_xml_sitemap_transient_caching', '__return_false');

add_action( 'restrict_manage_posts', 'wpse45436_admin_posts_filter_restrict_manage_posts' );
/**
 * First create the dropdown
 * make sure to change POST_TYPE to the name of your custom post type
 *
 * @author Ohad Raz
 *
 * @return void
 */
function wpse45436_admin_posts_filter_restrict_manage_posts(){
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }

    //only add filter to post type you want
    if ('job_listing' == $type){
        //change this to the list of values you want to show
        //in 'label' => 'value' format
        $values = array(
			'Show Open Jobs' => 0,
			'Show Filled Jobs' => 1
        );
        ?>
        <select name="ADMIN_FILTER_FIELD_VALUE">
        <option value=""><?php _e('Filter By ', 'wose45436'); ?></option>
        <?php
            $current_v = isset($_GET['ADMIN_FILTER_FIELD_VALUE'])? $_GET['ADMIN_FILTER_FIELD_VALUE']:'';
            foreach ($values as $label => $value) {
                printf
                    (
                        '<option value="%s"%s>%s</option>',
                        $value,
                        $value == $current_v? ' selected="selected"':'',
                        $label
                    );
                }
        ?>
        </select>
        <?php
    }
}


add_filter( 'parse_query', 'wpse45436_posts_filter' );
/**
 * if submitted filter by post meta
 *
 * make sure to change META_KEY to the actual meta key
 * and POST_TYPE to the name of your custom post type
 * @author Ohad Raz
 * @param  (wp_query object) $query
 *
 * @return Void
 */
function wpse45436_posts_filter( $query ){
    global $pagenow;
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
    if ( 'job_listing' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['ADMIN_FILTER_FIELD_VALUE']) && $_GET['ADMIN_FILTER_FIELD_VALUE'] != '') {
        $query->query_vars['meta_key'] = '_filled';
        $query->query_vars['meta_value'] = $_GET['ADMIN_FILTER_FIELD_VALUE'];
    }
}


/**
 * to exclude field from notification add 'exclude[ID]' option to {all_fields} tag
 * 'include[ID]' option includes HTML field / Section Break field description / Signature image in notification
 * see http://www.gravityhelp.com/documentation/page/Merge_Tags for a list of standard options
 * example: {all_fields:exclude[2,3]}
 * example: {all_fields:include[6]}
 * example: {all_fields:include[6],exclude[2,3]}
 */
add_filter( 'gform_merge_tag_filter', 'all_fields_extra_options', 11, 5 );
function all_fields_extra_options( $value, $merge_tag, $options, $field, $raw_value ) {
    if ( $merge_tag != 'all_fields' ) {
        return $value;
    }

    // usage: {all_fields:include[ID],exclude[ID,ID]}
    $include = preg_match( "/include\[(.*?)\]/", $options , $include_match );
    $include_array = explode( ',', rgar( $include_match, 1 ) );

    $exclude = preg_match( "/exclude\[(.*?)\]/", $options , $exclude_match );
    $exclude_array = explode( ',', rgar( $exclude_match, 1 ) );

    $log = "all_fields_extra_options(): {$field->label}({$field->id} - {$field->type}) - ";

    if ( $include && in_array( $field->id, $include_array ) ) {
        switch ( $field->type ) {
            case 'html' :
                $value = $field->content;
                break;
            case 'section' :
                $value .= sprintf( '<tr bgcolor="#FFFFFF">
                                                        <td width="20">&nbsp;</td>
                                                        <td>
                                                            <font style="font-family: sans-serif; font-size:12px;">%s</font>
                                                        </td>
                                                   </tr>
                                                   ', $field->description );
                break;
            case 'signature' :
                $url = GFSignature::get_signature_url( $raw_value );
                $value = "<img alt='signature' src='{$url}'/>";
                break;
        }
        GFCommon::log_debug( $log . 'included.' );
    }
    if ( $exclude && in_array( $field->id, $exclude_array ) ) {
        GFCommon::log_debug( $log . 'excluded.' );
        return false;
    }
    return $value;
}

/**
 * Fitler Job Manager editor for more tags
 */
//add_filter('submit_job_form_wp_editor_args', 'customize_wpjm_editor_tags');
function customize_wpjm_editor_tags($args){
	$args['tinymce']['toolbar1'] = 'bold,italic,del,|,bullist,numlist';
	return $args;
}

/*
 * Ajax Callback action to get the list of all locations based on search term
 */
//add_action( 'wp_ajax_get_locations', 'get_locations_ajax_callback' ); // wp_ajax_{action}
//add_action( 'wp_ajax_nopriv_get_locations', 'get_locations_ajax_callback' );
function get_locations_ajax_callback() {

	if ( isset( $_GET['term'] ) && $_GET['term'] ) :

		$results = array();
		$locations = get_terms( 'job_listing_location', 'orderby=count&hide_empty=0&search=' . $_GET['term']);

		if( ! is_wp_error( $locations ) ) :
			foreach ($locations as $location) :
				$results[] = array(
					'id' => $location->term_id,
					'text' => $location->name
				);
			endforeach;
			echo json_encode( $results );
			die;
		endif;

	endif;
}

/*
 * Render the location select field in the job posting form
 */
//add_action( 'job_manager_field_actionhook_job_locations', 'render_location_select', 10, 2 );
function render_location_select( $field, $key ) {
	$option = '';
	if( isset( $field['value'] ) ) :
		$term = get_term_by('id', $field['value'], 'job_listing_location');
		$option = '<option class="level-0" value="'.$field['value'].'" selected>'.$term->name.'</option>';
	endif;

	echo '<select required="" name="'.$key.'" id="'.$key.'" class="postform">';
		echo $option;
	echo '</select>';
}


/*
 * Save/Update Listing when Save/Update from Frontend
 */
//add_action( 'job_manager_update_job_data', 'update_location_fields', 100, 2 );
function update_location_fields( $job_id, $values ){
	// Check for value in $_POST, then set var with sanitized value, CHANGE my_input_name to the NAME used in the input HTML element
	$job_locations = isset( $_POST['job_locations'] ) ? sanitize_text_field( $_POST['job_locations'] ) : false;
	// Update the listing with the value, !! ALL META KEYS SHOULD BE PREPENDED WITH AN UNDERSCORE !!!

	$cats = array($job_locations);

	$cats = array_map( 'intval', $cats );

	if( $cats ) {
		wp_set_object_terms( $job_id, $cats, 'job_listing_location' );
		update_post_meta( $job_id, '_job_locations', $job_locations );
	}
}


//add_action( 'job_manager_save_job_listing', 'save_admin_location_fields', 100, 2 );
function save_admin_location_fields( $post_id, $post ) {

	//Abort if not in admin
	if(!is_admin())
		return;

	$term_list = wp_get_post_terms($post_id, 'job_listing_location', array("fields" => "all"));

	if( !empty( $term_list) ) :
		$term_list = $term_list[0];
		$term_id = $term_list->term_id;
		update_post_meta( $post_id, '_job_locations', $term_id );
	endif;


}
