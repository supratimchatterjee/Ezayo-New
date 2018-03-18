<?php
add_action( 'woocommerce_thankyou', 'woocommerce_thankyou_redirect', 6 );
if ( ! function_exists( 'woocommerce_thankyou_redirect' ) ) {

	/**
	 * Displays order details in a table.
	 *
	 * @param mixed $order_id
	 * @subpackage	Orders
	 */
	function woocommerce_thankyou_redirect( $order_id ) {
		if ( ! $order_id ) return;

		wc_get_template( 'custom/thankyou-redirect.php', array(
			'order_id' => $order_id,
		) );
	}
}

add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

function my_custom_checkout_field_process() {
    // Check if set, if its not set add an error.
    if ( $_POST['user_is_search_firm'] == '0' )
        wc_add_notice( __( '<strong>Executive Search Firm</strong> is a required field.' ), 'error' );
}

/*  Woocommerce: Remove Company Input Field and Additional Notes in Checkout Page */
add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
	//unset($fields['billing']['billing_company']);
    unset($fields['order']['order_comments']);
	return $fields;
}

function sv_require_wc_company_field( $fields ) {
    $fields['company']['required'] = true;
    return $fields;
}
add_filter( 'woocommerce_default_address_fields', 'sv_require_wc_company_field' );

/**
 * This example redirects everything to the index.php page
 * You can do the same for the dashboard with admin_url( '/' );
 * Or simply base the redirect on conditionals like
 * is_*() functions, current_user_can( 'capability' ), globals, get_current_screen()...
 *
 * @return void
 */
function wpse12535_redirect_sample() {
	if (is_singular('product') || is_post_type_archive('product')) {
		exit( wp_redirect( home_url( '/pricing' ) ) );
	}
}

add_action( 'template_redirect', 'wpse12535_redirect_sample' );

// Auto Update Woocommerce billing and shipping name,email on profile update
add_filter( 'profile_update' , 'custom_update_checkout_fields', 10, 2 );
function custom_update_checkout_fields($user_id, $old_user_data ) {
	$current_user = wp_get_current_user();

	// Updating Billing info
	if($current_user->user_firstname != $current_user->billing_first_name)
		update_user_meta($user_id, 'first_name', $current_user->billing_first_name);

	if($current_user->user_lastname != $current_user->billing_last_name)
		update_user_meta($user_id, 'last_name', $current_user->billing_last_name);
}
