<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Ezayo
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P629C8S');</script>
<!-- End Google Tag Manager -->

<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link href="https://fonts.googleapis.com/css?family=Cabin:400,400i,500,600,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">

<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=gAaa4RXrlr">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=gAaa4RXrlr">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=gAaa4RXrlr">
<link rel="manifest" href="/manifest.json?v=gAaa4RXrlr">
<link rel="mask-icon" href="/safari-pinned-tab.svg?v=gAaa4RXrlr" color="#5bbad5">
<link rel="shortcut icon" href="/favicon.ico?v=gAaa4RXrlr">
<meta name="theme-color" content="#f4f4f4">

<?php wp_head(); ?>

<!-- Hotjar Tracking Code for https://ezayo.com -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:25133,hjsv:5};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
</script>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
 
fbq('init', '922781171106016');
fbq('track', "PageView");</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=922781171106016&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

</head>

<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P629C8S"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<header class="site-header">
	<div class="uk-container uk-container-center">
		<div class="tm-utility-bar-one uk-visible-large">
			<nav class="uk-navbar uk-navbar-attached">
			    <div class="uk-navbar-flip">
	            	<div class="uk-button-group">
						<?php if(is_user_logged_in()) : ?>
						<a class="uk-button uk-button-primary" href="/my-account">employer dashboard</a>
						<?php else : ?>
				    	<a class="uk-button uk-button-primary" href="<?php the_field('employer_login_link','option');?>">employer log in</a>
						<?php endif; ?>
						<a class="uk-button uk-button-primary faded" href="<?php the_field('sign_up_link','option');?>">sign up</a>
					</div>
			    </div>
			</nav>
		</div>
		<div class="tm-utility-bar-two">
			<nav class="uk-navbar uk-navbar-attached">
			    <!--Logo-->
			    <a href="<?php bloginfo( 'url' ); ?>" class="uk-navbar-brand" style="height:auto">
		    		<?php if(is_front_page()):?>
		    			<img src="<?php the_field('logo','option');?>" alt="<?php echo get_bloginfo( 'name' );?>">
		    		<?php else: ?>
		    			<img src="<?php the_field('logo_internal_pages','option');?>" alt="<?php echo get_bloginfo( 'name' );?>">
		    		<?php endif; ?>
			    </a>
			    <!--End-->

			    <div class="uk-navbar-flip">
			    	<div class="uk-visible-large">
				    	<a class="uk-button" href="<?php the_field('search_hr_jobs_link','option');?><?php the_field('','option');?>">search hr jobs</a>
				    	<a class="uk-button" href="<?php the_field('executive_recruting_link','option');?>">Search jobs in executive recruiting</a>
			    	</div>

			    	<?php $t_link = get_field('twiter_link','option');?>
			    	<?php $l_link = get_field('linkedin_link','option');?>
			    	<?php $f_link = get_field('facebook_link','option');?>
			    	<div class="tm-header-social uk-text-right uk-visible-large">
			    		<?php if ($t_link):?><a target="_blank" href="<?php echo $t_link; ?>"> <i class="uk-icon-twitter"></i> </a><?php endif;?>
			    		<?php if ($l_link):?><a target="_blank" href="<?php echo $l_link; ?>"> <i class="uk-icon-linkedin"></i> </a><?php endif;?>
			    		<?php if ($f_link):?><a target="_blank" href="<?php echo $f_link; ?>"> <i class="uk-icon-facebook"></i> </a><?php endif;?>
			    	</div>

			    	<!--Mobile menu-->
				    <a class="uk-hidden-large" href="#offcanvas" data-uk-offcanvas><i class="uk-icon-navicon uk-icon-large"></i></a>
			    </div>



			</nav>
		</div>
		<nav class="uk-navbar uk-navbar-attached tm-main-nav uk-visible-large">
			<?php wp_nav_menu( array( 'theme_location' => 'menu-primary', 'menu_id' => 'menu-primary', 'menu_class' => 'uk-navbar-nav', 'container' => false ) ); ?>
		</nav>
	</div>

	<div id="offcanvas" class="uk-offcanvas">
	    <div class="uk-offcanvas-bar uk-offcanvas-bar-flip">
			<?php wp_nav_menu( array( 'theme_location' => 'mobile-menu', 'menu_id' => 'mobile-menu', 'menu_class' => 'uk-nav uk-nav-offcanvas', 'container' => false ) ); ?>
			<div class="tm-header-social uk-text-center">
	    		<?php if ($t_link):?><a target="_blank" href="<?php echo $t_link; ?>"> <i class="uk-icon-twitter"></i> </a><?php endif;?>
	    		<?php if ($l_link):?><a target="_blank" href="<?php echo $l_link; ?>"> <i class="uk-icon-linkedin"></i> </a><?php endif;?>
	    		<?php if ($f_link):?><a target="_blank" href="<?php echo $f_link; ?>"> <i class="uk-icon-facebook"></i> </a><?php endif;?>
	    	</div>
	    </div>
	</div>
</header>
<div id="page" class="uk-block">
	<div class="uk-container uk-container-center">
