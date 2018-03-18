<div class="tm-panel uk-clearfix">
	<a href="<?php the_permalink();?>"><?php the_post_thumbnail('thumbnail',array( 'class' => 'uk-align-medium-left') );?></a>
	<a href="<?php echo get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j'));  ?>"><span><strong><?php the_time('F j, Y');?></strong></span></a>
	<a href="<?php the_permalink();?>"><h5 class="uk-margin-remove"><?php the_title();?></h5></a>
	<?php the_excerpt(); ?>
</div>