/** Post a Job : Job Function **/
jQuery(document).ready(function($) {

	$('.trigger-mobile-filter').on('click', function(event) {
		event.preventDefault();
		$('body').toggleClass('open-filter');
	});

	$('.filter-top a').click(function(event) {
		event.preventDefault();
		$('body').removeClass('open-filter');
	});

	if($('#submit-job-form').length < 1)
		return;

	var cat_select				= $('#job_category'),
		dynamic_checklists		= $('.job-manager-term-checklist-job_functions, .fieldset-job_industry'),
		anon_post_check			= $('.fieldset-search_firm_post input'),
		function_description	= $('.fieldset-job_functions .description'),
		default_description		= 'Choose the primary function for this job.';

	function change_job_functions_on_cat_select() {

		var cat_selected = cat_select.find('option:selected').val();

		$('.fieldset-job_functions').show(); // Show the functions on load

		if(cat_selected == 20) { // If Executive
			$('#job_function-68').show();
			$('#job_function-67, .fieldset-job_industry').hide();
			allowed_selection = 1;
			default_description	= 'Choose the primary function for this job.';
		} else if(cat_selected == 19) { // uf HR
			$('#job_function-67, .fieldset-job_industry').show();
			$('#job_function-68').hide();
			allowed_selection = 2;
			default_description	= 'Choose the primary and secondary (if applicable) function for this job. Click "Make Primary" next to the primary function.';
		}

		function_description.text(default_description);
	}


	$('.job-manager-term-checklist-job_functions input[type=checkbox]').on('change', function(){
		var cat_selected = cat_select.find('option:selected').val(),
			allowed_selection = 1;

		if(cat_selected == 19) {
			allowed_selection = 2;
		}
		else if(cat_selected == 19) {
			allowed_selection = 1;
		}

		var total_selected = $('.job-manager-term-checklist-job_functions input[type=checkbox]:checked').length;

		//console.log('Total :' + total_selected );

		if(total_selected > allowed_selection)
			$(this).prop('checked', false);
	});

	$('.job-manager-term-checklist-job_industry input[type=checkbox]').on('change', function(){
		var total_selected = $('.job-manager-term-checklist-job_industry input[type=checkbox]:checked').length;

		//console.log('Total :' + total_selected );

		if(total_selected > 2)
			$(this).prop('checked', false);
	});

	// Fire when the category changes
	cat_select.on('change', function(event) {
		dynamic_checklists.find('input').prop('checked', false); // Unchecks it
		change_job_functions_on_cat_select();
		total_selected = 0;
	});

	function anon_posting(){
		var anon_selected_value = false;

		if($('.fieldset-search_firm_post input:checked').length > 0 )
			anon_selected_value = $('.fieldset-search_firm_post input:checked').val();

		if(anon_selected_value == 1) {
			$('.fieldset-job_category').addClass('field-disabled');
			$('#job_category').val(19).trigger('change');
			$('.fieldset-custom_company_name').show();
		} else {
			$('.fieldset-job_category').removeClass('field-disabled');
			$('.fieldset-custom_company_name').hide();
		}
	}

	anon_post_check.on('change', function(event) {
		anon_posting();
	});

	//Run on page load
	anon_posting();
	change_job_functions_on_cat_select();
});
/** Job Function **/

/** Post a Job : Location GeoComplete **/
jQuery(document).ready(function($) {
	var $location_field		= $("#job_location"),
		$latlng_field		= $('#job_latlng');
		$country_field		= $('#job_location_country'),
		$state_field		= $('#job_location_state'),
		$city_field			= $('#job_location_city');
	if($location_field.length) {
		$location_field.geocomplete().bind("geocode:result", function(event, result) {

			console.log(result.address_components);

			var loc		= result.geometry.location,
				lat		= loc.lat(),
				lng		= loc.lng(),
				arrAddress	= result.address_components,
				state_name	= null,
				city_name	= null;

				$latlng_field.val(lat + ',' + lng);

				// iterate through address_component array
				$.each(arrAddress, function (i, address_component) {
				   // console.log('address_component:'+i);

				    if (address_component.types[0] == "administrative_area_level_1"){
				        //console.log(i+": state:"+address_component.long_name);
				        state_name = address_component.short_name;
				    }

					if (address_component.types[0] == "locality"){
				        //console.log("city:"+address_component.long_name);
				        city_name = address_component.long_name;
				    }

					if (address_component.types[0] == "country"){
				        //console.log("city:"+address_component.long_name);
				        country_name = address_component.long_name;
				    }

				});

				if(state_name) {
					$state_field.val(state_name);
				}
				if (city_name) {
					$city_field.val(city_name);
				}

				if (country_name) {
					$country_field.val(country_name);
				}

		}).bind("geocode:error", function(event, status) {
			alert("ERROR: " + status);
		});
	}
});
/** Location GeoComplete **/

/** Post a Job : Salary Range **/
jQuery(document).ready(function($) {
	var $salary_field		= $("#job_pay"),
		$salary_type_field	= $('#job_pay_type');

	var currency	= '$',
		suffix		= '',
		apnd		= '/ hour',
		lower		= 0,
		higher		= 0,
		multiplier	= 1;


	function update_range_view(type) {

		var type = $salary_type_field.val();

		suffix = type == 'hour' ? '' : 'K';
		apnd = type == 'hour' ? ' / hour' : ' / year';
		multiplier = type == 'hour' ? 0.1 : 1;

		$('.range-view').text(currency + (lower * multiplier) + suffix + ' - ' + currency + (higher * multiplier) + suffix + apnd);
	}


	$salary_type_field.on('change', function(event) {
		update_range_view();
	});

	if($salary_field.length) {
		$salary_field.before('<span class="range-view"></span>');
		$salary_field.jRange({
			from: 0,
			to: 1000,
			step: 5,
			scale: false,
			format: '%s',
			showLabels: false,
			isRange : true,
			theme: 'theme-blue',
			onstatechange: function(value){
				//console.log($salary_type_field.val());
				var val_ar	= value.split(",");

				lower	= val_ar[0];
				higher	= val_ar[1];

				update_range_view();
			}
		});
	}
});


jQuery(document).ready(function($) {

	$('.job-manager-term-checklist-job_functions li > label').each(function(index, val){
		$(this).after('<span class="make-primary no-primary">Make Primary</span>');
	});

	var $functions_checklist_container = $('.job-manager-term-checklist-job_functions'),
		$functions_checklists = $functions_checklist_container.find('ul li'),
		$primary_function_field = $('#yoast_wpseo_primary_job_function'),
		$current_checklist = $term_id = false;

	function make_primary(el){
		$term_id = el.find('input').val();

		remove_primary($functions_checklists);

		$primary_function_field.val($term_id);

		el.addClass('this-primary');
		el.find('.make-primary').removeClass('no-primary').addClass('yes-primary').text('Remove Primary');
	}

	function remove_primary(el){
		el.removeClass('this-primary');
		el.find('.make-primary').removeClass('yes-primary').addClass('no-primary').text('Make Primary');
		$primary_function_field.val(null);
	}

	$functions_checklists.on('click', '.no-primary', function(event) {
		$current_checklist = $(this).parent('li');
		make_primary($current_checklist);
	});

	$functions_checklists.on('click', '.yes-primary', function(event) {
		$current_checklist = $(this).parent('li');
		remove_primary($current_checklist);
	});

	var $init_value = $primary_function_field.val();
	if($init_value > 1) {
		var $found = $('#job_function-' + $init_value );
		if ($found.length) {
			make_primary($found);
		}
	}

});


jQuery(document).ready(function($) {

	$('.job-manager-term-checklist-job_industry li > label').each(function(index, val){
		$(this).after('<span class="make-primary no-primary">Make Primary</span>');
	});

	var $industry_checklist_container = $('.job-manager-term-checklist-job_industry'),
		$industry_checklists = $industry_checklist_container.find('li'),
		$primary_industry_field = $('#yoast_wpseo_primary_job_industry'),
		$current_checklist = $term_id = false;

	function make_primary(el){
		$term_id = el.find('input').val();

		remove_primary($industry_checklists);

		$primary_industry_field.val($term_id);

		el.addClass('this-primary');
		el.find('.make-primary').removeClass('no-primary').addClass('yes-primary').text('Remove Primary');
	}

	function remove_primary(el){
		el.removeClass('this-primary');
		el.find('.make-primary').removeClass('yes-primary').addClass('no-primary').text('Make Primary');
		$primary_industry_field.val(null);
	}

	$industry_checklists.on('click', '.no-primary', function(event) {
		$current_checklist = $(this).parent('li');
		make_primary($current_checklist);
	});

	$industry_checklists.on('click', '.yes-primary', function(event) {
		$current_checklist = $(this).parent('li');
		remove_primary($current_checklist);
	});

	var $init_value = $primary_industry_field.val();
	if($init_value > 1) {
		var $found = $('#job_listing_industry-' + $init_value );
		if ($found.length) {
			make_primary($found);
		}
	}


});

/** Job Locations **/
/* Disable for now
jQuery(document).ready(function($) {
	var location_select = $('#job_locations');
	location_select.select2({
		placeholder: 'Select a location',
		minimumInputLength : 3,
		allowClear: true,
		ajax: {
			cache : false,
			url : woocommerce_params.ajax_url,
			dataType: 'json',
			delay: 250,
			data: function(params) {
				return {
					term: params.term, // search term
					action : 'get_locations',
				};
			},
			processResults: function(data) {
				var items=[];

				$.each( data, function( i, item ) {
					items.push( { id: item.id, text: item.text  } );
				});
				return { results: items };
			}
		}
	});

});
*/
/** Job Location **/
