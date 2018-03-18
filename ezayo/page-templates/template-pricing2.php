<?php
/**
 * The template for displaying all pages
 * Template Name: Pricing 2
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package Ezayo
 */

get_header(); ?>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
</script>
<?php while ( have_posts() ) : the_post();?>
<div class="pricing-ad">
  <?php if(function_exists('the_ad_group')) the_ad_group(83); ?>
</div>
<div class="page-heading tm-margin-large-top uk-width-medium-5-10 uk-text-center uk-container-center">
  <h2 class="uk-text-bold tm-custom">
    <?php the_field('p_description');?>
  </h2>
</div>


<!--job-posting section-->
<div class="job_post_section">
  <div class="job_pos_box_inner broad_inner">
    <div class="job_pos_box broad_box">
      <h2>Post Your Jobs Now:</h2>
      <p style="display: none;">Job Postings are available for use within 12 months of purchase.</p>
      <div class="buy-box__job-toggle" id="buy-box__job-toggle">
        <div id="tabs" class="form-check broad_tabs">
          <ul>
            <li class="first_child"><!--<label class="container_price">
  <input type="checkbox" checked="checked">
  <span class="checkmark" tabid="#tabs-1"></span>
</label>--><a href="#tabs-1">Pay Per Post</a></li>
            <li class="sec_child"><!--<label class="container_price">
  <input type="checkbox" checked="checked">
  <span class="checkmark" tabid="#tabs-2"></span>
</label>--><a href="#tabs-2">Unlimited Postings</a></li>
          </ul>
          <div id="tabs-1" class="tabs_content">
            <div class="Posting_form">
              <div class="form_inner form_inner_broad">
                <form action="<?php echo site_url('checkout'); ?>" method="get" name="job_posting"  class="posting">
                  <label id="offmsg"></label>
                  <div class="center-block center_broad">
                  <label class="post_label post_label_broad">Quantity of Jobs</label>
                  <?php if(have_rows('job_posting_packages')):?>
                  	
                  <select name="add-to-cart"  id="multi_select" class="multi_select_broad" title="job_post_selectors">
                    <?php $cnt=1; ?>
                    <?php while(have_rows('job_posting_packages')): the_row();?>
                    	<?php 	if($cnt==1){
                    		 		$price_jp=get_sub_field('price_j_p');
                    		 		$product_id=get_sub_field('button_link_j_p');
                            $yousave=get_sub_field('button_label_j_p');
                    		 	}
                    	?>
                    <option value="<?php echo get_sub_field('button_link_j_p'); ?>" youprice="<?php the_sub_field('price_j_p');?>" yousave="<?php the_sub_field('button_label_j_p');?>" offmsg="<?php the_sub_field('description_j_p');?>">
                    <?php the_sub_field('time_j_p');?>
                    </option>
                    <?php $cnt++; ?>
                    <?php endwhile;?>
                  </select>
                </div>
                   <?php endif;?>
                  <p class="desc desc_broad">
                    <span>TOTAL</span>
                    <label id="yousave"><?php echo $yousave; ?></label>
                    <span class="rate broad_rate" id="youprice"><?php echo $price_jp; ?></span>
                  </p>
                  
                  <!-- <input type="submit" value="ADD TO CART"  class="sumbit_btn"> -->
                  <?php $button_link1 = get_bloginfo('url'). '/checkout/?add-to-cart='.$product_id; ?>
                  <a id="addtocart" href="<?php echo $button_link1; ?>"  class="sumbit_btn broad_submit">ADD TO CART</a>
                </form>
              </div>
            </div>
          </div>
          <div id="tabs-2" class="tabs_content tab-2_broad">
            <?php if (have_rows('unlimited_posting')):?>
				<?php while(have_rows('unlimited_posting')): the_row();?>
		            <div class="plans_sec plans_sec_broad">
		                <p><span class="p_head"><?php the_sub_field('description_u_p');?></p>
		               
		            </div>

                <p class="desc desc_broad">
                    <span>TOTAL</span>
                    <label id="yousave"><?php echo $yousave; ?></label>
                    <span class="rate broad_rate"><?php the_sub_field('price_u_p');?></span>
                  </p>

	      
	            <?php $button_link = get_bloginfo('url'). '/checkout/?add-to-cart=' . get_sub_field('button_link_u_p'); ?>
	            <a href="<?php echo $button_link;?>" class="sumbit_btn broad_submit">ADD TO CART</a>
	         	<?php endwhile;?>
			<?php endif;?>   
          </div>
        </div>
      </div>
      <!--posting-form-start--> 
      <!--posting-form-end--> 
    </div>
  </div>
</div>
<!--job-posting section end-->

<div class="uk-margin-top tm-help centercontent">
    <?php the_field('quaries_b');?>
</div>
<div class="more-features uk-width-medium-9-10 uk-clearfix uk-container-center">
  <div class="uk-grid uk-grid-divider" data-uk-margin>
    <div class="uk-width-medium-1-2">
      <?php the_field('impressive_reach_and_effectiveness_section');?>
    </div>
    <div class="uk-width-medium-1-2">
      <?php the_field('easy_to_use');?>
    </div>
  </div>
</div>
<div class="uk-margin-large-top companies-logo">
  <h6>
    <?php the_field('title_logo_sec');?>
  </h6>
  <?php if(have_rows('logo_section')):?>
  <ul class="uk-margin-top uk-grid uk-grid-width-large-1-6 uk-grid-width-medium-1-3 uk-grid-width-small-1-1 uk-flex-middle" data-uk-margin="{cls:'uk-margin-large-top'}">
    <?php while(have_rows('logo_section')): the_row();?>
    <li class="uk-text-center"><img src="<?php the_sub_field('logo');?>"></li>
    <?php endwhile;?>
  </ul>
  <?php endif;?>
</div>
<div class="helpbox">
  <?php the_field('question');?>
</div>
<?php endwhile;?>
<script type="text/javascript">
	jQuery('#multi_select').on('change', function() {
		var yousave = jQuery('option:selected', this).attr('yousave');
		var offmsg = jQuery('option:selected', this).attr('offmsg');
		var youprice = jQuery('option:selected', this).attr('youprice');
		var value = jQuery(this).val();
		jQuery('#yousave').html(yousave);
		jQuery('#offmsg').html(offmsg);
		jQuery('#youprice').html(youprice);
		var link = '<?php echo site_url(); ?>/checkout/?add-to-cart='+value;
        jQuery('#addtocart').attr("href", link); // Set herf value
		
	});

  jQuery("#tabs li .checkmark").click(function (e) {
     e.preventDefault();
     jQuery("#tabs li").removeClass("ui-tabs-active");
     jQuery("#tabs li").removeClass("ui-state-active");
     jQuery(this).closest('li').addClass('ui-tabs-active');
     jQuery(this).closest('li').addClass('ui-state-active');
     var tabid = jQuery(this).attr("tabid");
     jQuery('.tabs_content').hide(); 
     jQuery(tabid).show(); 
  });
</script>
<?php
get_footer();
