<?php
/**
 * The template for displaying all pages
 * Template Name: Home 2
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
		<main class="ezayo-home-banner">
			<div class="uk-container uk-container-center tm-height-1-1">
				<div class="uk-width-large-5-10 uk-margin-top-remove uk-margin-large-bottom">
					<h1><?php the_field('title');?></h1>
					<h2><?php the_field('small_description');?></h2>
					<div data-uk-margin>
						<a class="uk-button uk-button-primary" href="<?php the_field('first_button_link');?>"><?php the_field('button_label');?></a>
						<a class="uk-button uk-button-primary" href="<?php the_field('second_button_link');?>"><?php the_field('second_button_label');?></a>
					</div>
				</div>
                <!--job-posting section-->
                <div class="home_page_css">
<div class="job_post_section">
  <div class="job_pos_box_inner">
    <div class="job_pos_box">
      <h2>Post Your Jobs Now:</h2>
      <p style="display: none;">Job Postings are available for use within 12 months of purchase.</p>
      <div class="buy-box__job-toggle" id="buy-box__job-toggle">
        <div id="tabs" class="form-check">
          <ul>
            <li class="first_child"> <a href="#tabs-1">Pay Per Post</a></li>
            <li class="sec_child"> <a href="#tabs-2">Unlimited Postings</a></li>
          </ul>
          <div id="tabs-1" class="tabs_content">
            <div class="Posting_form">
              <div class="form_inner">
                <form action="" method="get" name="job_posting"  class="posting" >
                  <label id="offmsg"></label>
                  <label class="post_label">Quantity of Jobs</label>
                  <?php if(have_rows('job_posting_packages')):?>
                  <select name="add-to-cart"  id="multi_select" title="job_post_selectors">
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
                  <?php endif;?>
                  <p class="desc">TOTAL
                    <label id="yousave"><?php echo $yousave; ?></label>
                  </p>
                  <p class="rate" id="youprice"><?php echo $price_jp; ?></p>
                  <?php $button_link1 = get_bloginfo('url'). '/checkout/?add-to-cart='.$product_id; ?>
                  <a id="addtocart" href="<?php echo $button_link1; ?>"  class="sumbit_btn">ADD TO CART</a>
                </form>
              </div>
            </div>
          </div>
          <div id="tabs-2" class="tabs_content">
            <?php if (have_rows('unlimited_posting')):?>
			<?php while(have_rows('unlimited_posting')): the_row();?>
            <div class="plans_sec">
              <p><span class="p_head"><?php the_sub_field('description_u_p');?></span></p>
            </div>
            <p class="desc">TOTAL</p>
            <p class="rate" ><?php the_sub_field('price_u_p');?></p>
            <?php $button_link = get_bloginfo('url'). '/checkout/?add-to-cart=' . get_sub_field('button_link_u_p'); ?>
            <a id="addtocart" href="<?php echo $button_link;?>" class="sumbit_btn">ADD TO CART</a>
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
</div>
<!--job-posting section end-->
                
				<div class="homepage-conference-ad">
					<?php if(function_exists('the_ad_placement')) the_ad_placement('homepage-body'); ?>
				</div>
			</div>
		</main>

		<div class="footer-section">
			<div class="uk-container uk-container-center">
				<div class="home-footer tm-margin-top">
					<div class="uk-grid" data-uk-margin="{cls:'uk-margin-top'}">
						<div class="uk-width-medium-1-2 tm-text-left">
							<?php wp_nav_menu( array( 'theme_location' => 'home-left-footer-menu', 'menu_id' => 'footer-left-menu', 'menu_class' => 'tm-navbar-nav', 'container' => false ) ); ?>
						</div>
						<div class="uk-width-medium-1-2 tm-text-right">
							<?php wp_nav_menu( array( 'theme_location' => 'home-right-footer-menu', 'menu_id' => 'footer-right-menu', 'menu_class' => 'tm-navbar-nav', 'container' => false ) ); ?>
						</div>
					</div>
				</div>
			</div>
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
</script>		
<?php get_footer();