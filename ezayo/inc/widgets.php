<?php

class Job_Summary_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'job_summary_widget',
			'description' => 'Display single job listing summary',
		);
		parent::__construct( 'job_summary_widget', 'Job Summary', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget

		global $post;

		$post_date = time_ago('post');

		$salary			= get_post_meta( $post->ID, '_job_pay', true );
		$education		= get_post_meta( $post->ID, '_job_qualification', false );
		$experience		= get_post_meta( $post->ID, '_job_experience', false );
		$industries		= wp_get_post_terms($post->ID, 'job_listing_industry', array("fields" => "names"));

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
	?>
		<div class="uk-margin-top">
			<span class="uk-display-block"><?php _e('Location', 'ezayo');?></span>
			<span class="uk-display-block"><strong><?php echo str_replace(', United States', '', get_the_job_location($post)); ?></strong></span>
		</div>

		<?php if(!empty($industries)) : ?>
			<div class="uk-margin-top">
				<span class="uk-display-block"><?php _e('Industry', 'ezayo');?></span>
				<?php foreach($industries as $industry) : ?>
					<span class="uk-display-block"><strong><?php echo $industry; ?></strong></span>
				<?php endforeach;?>
			</div>
		<?php endif; ?>


		<div class="uk-margin-top">
			<span class="uk-display-block"><?php _e('Posted', 'ezayo');?></span>
			<span class="uk-display-block"><strong><?php echo $post_date; ?></strong></span>
		</div>

		<?php if($salary && $salary != '0,0') : ?>

		<?php $salary		= explode(',', $salary); ?>
		<?php $salary_type	= get_post_meta( $post->ID, '_job_pay_type', true ); ?>
		<?php $suffix		= $salary_type == 'hour' ? '' : 'K'; ?>
		<?php $apnd			= $salary_type == 'hour' ? ' / hour' : ' / year'; ?>
		<?php $mult			= $salary_type == 'hour' ? 0.1 : 1; ?>

		<div class="uk-margin-top">
			<span class="uk-display-block"><?php _e('Salary', 'ezayo');?></span>
			<span class="uk-display-block"><strong><?php echo '$' . $salary[0] * $mult . $suffix . ' - ' . '$' . $salary[1] * $mult . $suffix . $apnd; ?></strong></span>
		</div>
		<?php endif;?>

		<?php if(!empty($education[0])) : ?>
		<div class="uk-margin-top">
			<span class="uk-display-block"><?php _e('Education level', 'ezayo');?></span>
			<span class="uk-display-block"><strong><?php echo implode(', ', $education[0]); ?></strong></span>
		</div>
		<?php endif;?>

		<?php if(!empty($experience[0])) : ?>
		<div class="uk-margin-top">
			<span class="uk-display-block"><?php _e('Career level', 'ezayo');?></span>
			<span class="uk-display-block"><strong><?php echo implode(', ', $experience[0]); ?></strong></span>
		</div>
		<?php endif;?>

	<?php
		echo $args['after_widget'];

	}


	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}

//comoany Jobs Widget
class Company_Jobs_Widget extends WP_Widget {

   function __construct() {
	   parent::__construct(
	   'company_jobs_widget', //Base ID
	   __('Company Jobs', 'text_domain'), // Name
	   array( 'description' => __( 'Widget containing Latest Jobs by this company', 'ezayo' ), ) // Args
	   );
   }

   public function widget( $args, $instance ) {
	   echo $args['before_widget'];
	   /*if ( ! empty( $instance['title'] ) ) {
		   echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
	   }*/
	?>
		<?php $post_count = get_field('number_of_post', 'widget_' . $this->id); ?>
		<?php global $post; ?>
		<?php $post_id = $post->ID; ?>
		<?php $company = $post->post_author; ?>
		<?php $company_name = get_the_author_meta( 'billing_company', $company ) ? get_the_author_meta( 'billing_company', $company ) : 'this company'; ?>
		<h4>Other jobs from <?php echo $company_name; ?></h4>
		<ul class="uk-list uk-list-line">
			<?php $query_args = array( 'post_type' => 'job_listing', 'author' => $company, 'posts_per_page' => $post_count, 'post__not_in' => array($post_id) ); ?>
			<?php $query = new WP_Query($query_args); ?>
			<?php if ($query->have_posts()) : ?>
				<?php while ($query->have_posts()) : $query->the_post(); ?>
				<li><i class="uk-icon-angle-double-right"></i> <a href="<?php the_permalink();?>"><?php the_title();?></a></li>
				<?php endwhile; ?>
			<?php endif; wp_reset_query(); ?>
		</ul>
		<?php
		echo $args['after_widget'];
   }
   /**
	* Back-end widget form.
	*
	* @see WP_Widget::form()
	*
	* @param array $instance Previously saved values from database.
	*/
   public function form( $instance ) {
	   $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
	   ?>
	   <p>
		   <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
		   <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
	   </p>
	   <?php
   }

   /**
	* Sanitize widget form values as they are saved.
	*
	* @see WP_Widget::update()
	*
	* @param array $new_instance Values just sent to be saved.
	* @param array $old_instance Previously saved values from database.
	*
	* @return array Updated safe values to be saved.
	*/
   public function update( $new_instance, $old_instance ) {
	   $instance = array();
	   $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

	   return $instance;
   }

}



class About_Company_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'about_company_widget',
			'description' => 'Display company information for the listing.',
		);
		parent::__construct( 'about_company_widget', 'About Company', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget

		global $post;

		$user_id		= $post->post_author;
		$company_name	= get_user_meta($user_id, 'billing_company', true);
		$description	= get_user_meta($user_id, 'description', true);
		$promo			= get_user_meta($user_id, 'user_promo_video', true);

		$youtube 		= get_user_meta($user_id, 'user_youtube', true);
		$twitter		= get_user_meta($user_id, 'user_twitter', true);
		$linkedin		= get_user_meta($user_id, 'user_linkedin', true);
		$facebook		= get_user_meta($user_id, 'user_facebook', true);
		$gplus			= get_user_meta($user_id, 'user_gplus', true);

		if(!$description && !$promo && !$youtube && !$twitter && !$linkedin && !$facebook && !$gplus )
			return;

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
	?>
		<?php if($company_name) ?>
			<strong><?php echo $company_name; ?></strong>

		<?php if($description) ?>
			<?php echo apply_filters( 'the_excerpt', $description ); ?>

		<?php if($youtube || $twitter || $linkedin || $facebook || $gplus ) : ?>

		 <div class="tm-header-social">
			<?php if($twitter){ ?>
				<a href="<?php echo $twitter; ?>"><img src="<?php echo get_template_directory_uri();?>/assets/images/media-icons/twitter.png"></a>
			<?php } ?>	
			<?php if($linkedin){ ?>
				<a href="<?php echo $linkedin; ?>"><img src="<?php echo get_template_directory_uri();?>/assets/images/media-icons/linkedin.png"></a>
			<?php } ?>	
			<?php if($facebook){ ?>
				<a href="<?php echo $facebook; ?>"><img src="<?php echo get_template_directory_uri();?>/assets/images/media-icons/facebook.png"></a>
			<?php } ?>	
			<?php if($gplus){ ?>
				<a href="<?php echo $gplus; ?>"><img src="<?php echo get_template_directory_uri();?>/assets/images/media-icons/google-plus.png"></a>
			<?php } ?>	
			<?php if($youtube){ ?>
				<a href="<?php echo $youtube; ?>"><img src="<?php echo get_template_directory_uri();?>/assets/images/media-icons/youtube.png"></a>
			<?php } ?> 	
	</div>
		
		

		<?php endif;?>

		<?php if($promo) : ?>
			<?php if( $embed_code = wp_oembed_get($promo) ) ?>
				<?php echo $embed_code; ?>
		<?php endif; ?>

	<?php
		echo $args['after_widget'];

	}


	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}



//Category Post Widget
class Category_Post_widget extends WP_Widget {

   function __construct() {
	   parent::__construct(
	   'category_post_widget', //Base ID
	   __('Category Posts', 'ezayo'), // Name
	   array( 'description' => __( 'Widget to display posts from selected category.', 'ezayo' ), ) // Args
	   );
   }

   public function widget( $args, $instance ) {
	   echo $args['before_widget'];
	   if ( ! empty( $instance['title'] ) ) {
		   echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
	   }
	?>
		<?php $number_of_post = get_field('post_in_widget', 'widget_' . $this->id); ?>
		<?php $categories = get_field('category_term', 'widget_' . $this->id); ?>

		<ul class="uk-list uk-list-line">
			<?php $query_args = array( 'post_type' => 'post', 'cat' => $categories, 'posts_per_page' => $number_of_post ); ?>
			<?php $query = new WP_Query($query_args); ?>
			<?php if ($query->have_posts()) : ?>
				<?php while ($query->have_posts()) : $query->the_post(); ?>
				<li><i class="uk-icon-angle-double-right"></i> <a href="<?php the_permalink();?>"><?php the_title();?></a></li>
				<?php endwhile; ?>
			<?php endif; wp_reset_query(); ?>
		</ul>
		<?php
		echo $args['after_widget'];
   }

   	/**
   	 * Back-end widget form.
   	 *
   	 * @see WP_Widget::form()
   	 *
   	 * @param array $instance Previously saved values from database.
   	 */
   	public function form( $instance ) {
   		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
   		?>
   		<p>
   			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
   			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
   		</p>
   		<?php
   	}

   	/**
   	 * Sanitize widget form values as they are saved.
   	 *
   	 * @see WP_Widget::update()
   	 *
   	 * @param array $new_instance Values just sent to be saved.
   	 * @param array $old_instance Previously saved values from database.
   	 *
   	 * @return array Updated safe values to be saved.
   	 */
   	public function update( $new_instance, $old_instance ) {
   		$instance = array();
   		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

   		return $instance;
   	}
}


function ezayo_register_widget() {
	register_widget( 'Job_Summary_Widget' );
	register_widget( 'About_Company_Widget' );
	register_widget( 'Company_Jobs_Widget' );
	register_widget( 'category_post_widget' );
}
add_action( 'widgets_init', 'ezayo_register_widget' );
