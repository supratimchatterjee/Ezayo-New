
<?php $profile_page_url = wc_customer_edit_account_url(); ?>

<div class="woocommerce-message thankyou-redirect">

	<p>You are now being automatically redirected to your <a href="<?php echo $profile_page_url; ?>">profile page</a> in <span class="redirect-seconds">10</span> seconds</p>

	<a href="#" class="button cancel-redirect">Cancel This Action</a>

</div>


<script type="text/javascript">

	jQuery(document).ready(function($) {
		
		function redirect_countdown() {

			var i = $('.redirect-seconds');

			if ( parseInt( i.html() ) <= 0 ) {

				clearInterval(redirect_interval);

				$('.thankyou-redirect').fadeOut();

				location.href = '<?php echo $profile_page_url; ?>';

			}

			i.html( parseInt( i.html() ) - 1 ) ;

		}

		var redirect_interval = setInterval(function() {

			redirect_countdown();

		}, 1000 );


		$('.cancel-redirect').click(function(event) {

			/* Act on the event */
			event.preventDefault();

			clearInterval(redirect_interval);

			$('.thankyou-redirect').fadeOut();

		});	

	});


</script>
