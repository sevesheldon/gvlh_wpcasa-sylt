<?php
/**
 * Listings slider widget
 *
 * @package WPCasa Sylt
 */

/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpsight_sylt_register_widget_listings_slider' );
 
function wpsight_sylt_register_widget_listings_slider() {
	register_widget( 'WPSight_Sylt_Listings_Slider' );
}

/**
 * Listings slider widget class
 *
 * @since 1.0.0
 */

class WPSight_Sylt_Listings_Slider extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget_listings_slider',
			'description' => _x( 'Display listings in a slider.', 'listing wigdet', 'wpcasa-sylt' )
		);

		parent::__construct( 'wpsight_sylt_listings_slider', '&rsaquo; ' . WPSIGHT_SYLT_NAME . ' ' . _x( 'Listings Slider', 'listing widget', 'wpcasa-sylt' ), $widget_ops );

	}

	public function widget( $args, $instance ) {
		
		$title 				= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id );
		$nr 				= absint( $instance['nr'] );

		$offer_filter		= isset( $instance['offer_filter'] ) ? strip_tags( $instance['offer_filter'] ) : false;
		$taxonomy_filters	= array();
		
		foreach( get_object_taxonomies( wpsight_post_type(), 'objects' ) as $key => $taxonomy )
			$taxonomy_filters[ $key ] = isset( $instance[ 'taxonomy_filter_' . $key ] ) ? strip_tags( $instance[ 'taxonomy_filter_' . $key ] ) : false;
		
		$defaults = array(
			'nr'					=> 10,
			'slider_margin'			=> 0,
			'slider_stage_padding'	=> 0,
			'slider_loop'			=> true,
			'slider_nav'			=> true,
			'slider_dots'			=> true,
			'slider_autoplay'		=> false,
			'slider_autoplay_time'	=> 6000,
			'slider_full_width'		=> false
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		// slider settings
		
		$slider_margin 			= absint( $instance['slider_margin'] );
		$slider_stage_padding 	= absint( $instance['slider_stage_padding'] );		
		$slider_loop 			= isset( $instance['slider_loop'] ) ? (bool) $instance['slider_loop'] : false;
		$slider_nav 			= isset( $instance['slider_nav'] ) ? (bool) $instance['slider_nav'] : false;
		$slider_dots 			= isset( $instance['slider_dots'] ) ? (bool) $instance['slider_dots'] : false;
		$slider_autoplay 		= isset( $instance['slider_autoplay'] ) ? (bool) $instance['slider_autoplay'] : false;
		$slider_autoplay_time 	= absint( $instance['slider_autoplay_time'] );
		$slider_full_width 		= isset( $instance['slider_full_width'] ) ? (bool) $instance['slider_full_width'] : false;
		
		// Set up args for slider

		$slider_args = array(
			'class_slider'   		=> 'wpsight-listings-slider-' . $this->id . ' wpsight-listings-slider',
			'class_item'	   		=> 'wpsight-listings-slider-item',
			'slider_margin'			=> $slider_margin,
			'slider_stage_padding'	=> $slider_stage_padding,
			'slider_loop'			=> $slider_loop,
			'slider_nav'			=> $slider_nav,
			'slider_dots'			=> $slider_dots,
			'slider_autoplay'		=> $slider_autoplay,
			'slider_autoplay_time'	=> $slider_autoplay_time,
			'slider_full_width'		=> $slider_full_width
		);
		
		$listings_args = array(
			'nr'				=> $nr,
			'offer'				=> $offer_filter,
			'meta_query'		=> array(
				array(
					'key'		=> '_thumbnail_id',
					'compare'	=> 'EXISTS'
				)
			),
			'show_paging'		=> false
		);
		
		// Merge taxonomy filters into args and apply filter hook
		$listings_args = apply_filters( 'wpsight_sylt_widget_listings_slider_query_args', array_merge( $listings_args, $taxonomy_filters ), $instance, $this->id );
		
		// Finally get listings
		$listings = wpsight_get_listings( $listings_args );
		
		// When no listings, don't any produce output
		
		if( ! $listings )
			return;
		
		// Echo before_widget
        echo $args['before_widget'];
        
        if ( $title )
			echo $args['before_title'] . $title . $args['after_title'];
        
        // Echo listings slider
		wpsight_sylt_listings_slider( $listings, $slider_args );
		
		// Echo after_widget
		echo $args['after_widget'];

	}

	public function update( $new_instance, $old_instance ) {
	    
	    $instance = $old_instance;
	    
	    $instance['title'] 					= strip_tags( $new_instance['title'] );
	    $instance['nr'] 					= absint( $new_instance['nr'] );
	    $instance['offer_filter'] 			= strip_tags( $new_instance['offer_filter'] );
	    
	    foreach( get_object_taxonomies( wpsight_post_type(), 'objects' ) as $key => $taxonomy )
			$instance[ 'taxonomy_filter_' . $key ] = strip_tags( $new_instance[ 'taxonomy_filter_' . $key ] );
	    
	    // slider settings
	    
	    $instance['slider_margin'] 			= absint( $new_instance['slider_margin'] );
	    $instance['slider_stage_padding'] 	= absint( $new_instance['slider_stage_padding'] );
	    $instance['slider_loop'] 			= ! empty( $new_instance['slider_loop'] ) ? 1 : 0;
	    $instance['slider_nav'] 			= ! empty( $new_instance['slider_nav'] ) ? 1 : 0;
	    $instance['slider_dots'] 			= ! empty( $new_instance['slider_dots'] ) ? 1 : 0;
	    $instance['slider_autoplay'] 		= ! empty( $new_instance['slider_autoplay'] ) ? 1 : 0;
	    $instance['slider_autoplay_time'] 	= absint( $new_instance['slider_autoplay_time'] );

        return $instance;

    }

	public function form( $instance ) {
		
		$defaults = array(
			'title' 				=> '',
			'nr'					=> 10,
			'slider_margin'			=> 0,
			'slider_stage_padding'	=> 0,
			'slider_loop'			=> true,
			'slider_nav'			=> true,
			'slider_dots'			=> true,
			'slider_autoplay'		=> false,
			'slider_autoplay_time'	=> 6000
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$title 				= strip_tags( $instance['title'] );
		$nr 				= absint( $instance['nr'] );
		$offer_filter		= isset( $instance['offer_filter'] ) ? strip_tags( $instance['offer_filter'] ) : false;
		
		$taxonomy_filters	= array();
		
		foreach( get_object_taxonomies( wpsight_post_type(), 'objects' ) as $key => $taxonomy )
			$taxonomy_filters[ $key ] = isset( $instance[ 'taxonomy_filter_' . $key ] ) ? strip_tags( $instance[ 'taxonomy_filter_' . $key ] ) : false;
		
		// Slider settings
		
		$slider_margin 			= absint( $instance['slider_margin'] );
		$slider_stage_padding 	= absint( $instance['slider_stage_padding'] );		
		$slider_loop 			= isset( $instance['slider_loop'] ) ? (bool) $instance['slider_loop'] : false;
		$slider_nav 			= isset( $instance['slider_nav'] ) ? (bool) $instance['slider_nav'] : false;
		$slider_dots 			= isset( $instance['slider_dots'] ) ? (bool) $instance['slider_dots'] : false;
		$slider_autoplay 		= isset( $instance['slider_autoplay'] ) ? (bool) $instance['slider_autoplay'] : false;
		$slider_autoplay_time 	= absint( $instance['slider_autoplay_time'] ); ?>
		
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpcasa-sylt' ); ?>: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
		
		<p><label for="<?php echo $this->get_field_id( 'nr' ); ?>"><?php _e( 'Listings', 'wpcasa-sylt' ); ?>: <input class="widefat" id="<?php echo $this->get_field_id( 'nr' ); ?>" name="<?php echo $this->get_field_name( 'nr' ); ?>" type="text" value="<?php echo esc_attr( $nr ); ?>" /></label><br />
			<span class="description"><?php _e( 'Please enter the number of listings', 'wpcasa-sylt' ); ?></span></p>
		
		<p><label><?php _e( 'Filters', 'wpcasa-sylt' ); ?>:</label></p>
		
		<p><select class="widefat" id="<?php echo $this->get_field_id( 'offer_filter' ); ?>" name="<?php echo $this->get_field_name( 'offer_filter' ); ?>">
				<option value=""<?php selected( $offer_filter, '' ); ?>><?php _e( 'All Offers', 'wpcasa-sylt' ); ?></option>
				<?php foreach( wpsight_offers() as $key => $offer ) : ?>
				<option value="<?php echo esc_attr( $key ); ?>"<?php selected( $offer_filter, $key ); ?>><?php echo esc_attr( $offer ); ?></option>
				<?php endforeach; ?>
			</select></p>
		
		<?php foreach( get_object_taxonomies( wpsight_post_type(), 'objects' ) as $key => $taxonomy ) : ?>
		
			<p><select class="widefat" id="<?php echo $this->get_field_id( 'taxonomy_filter_' . $key ); ?>" name="<?php echo $this->get_field_name( 'taxonomy_filter_' . $key ); ?>">
				<option value=""<?php selected( 'taxonomy_filter_' . $key, '' ); ?>><?php printf( __( 'All %s', 'wpcasa-sylt' ), esc_attr( $taxonomy->label ) ); ?></option>
				<?php
			    	// Add taxonomy term options
			    	$terms = get_terms( array( $key ), array( 'hide_empty' => 0 ) );
			    	foreach( $terms as $term ) {
			    	   echo '<option value="' . esc_attr( $term->slug ) . '"' . selected( $taxonomy_filters[ $key ], $term->slug ) . '>' . esc_attr( $term->name ) . '</option>';
			    	}
			    ?>
				</select></p>
		
		<?php endforeach; ?>
		
		<p><label for="<?php echo $this->get_field_id( 'slider_margin' ); ?>"><?php _e( 'Margin', 'wpcasa-sylt' ); ?>:</label><br />
			<select class="widefat" id="<?php echo $this->get_field_id( 'slider_margin' ); ?>" name="<?php echo $this->get_field_name( 'slider_margin' ); ?>">
				<option value="0"<?php selected( $slider_margin, 0 ); ?>>0px</option>
				<option value="10"<?php selected( $slider_margin, 10 ); ?>>10px</option>
				<option value="20"<?php selected( $slider_margin, 20 ); ?>>20px</option>
				<option value="30"<?php selected( $slider_margin, 30 ); ?>>30px</option>
				<option value="40"<?php selected( $slider_margin, 40 ); ?>>40px</option>
				<option value="50"<?php selected( $slider_margin, 50 ); ?>>50px</option>
				<option value="60"<?php selected( $slider_margin, 60 ); ?>>60px</option>
			</select><br />
			<span class="description"><?php _e( 'Please select the space between slider items', 'wpcasa-sylt' ); ?></span></p>
		
		<p><label for="<?php echo $this->get_field_id( 'slider_stage_padding' ); ?>"><?php _e( 'Stage padding', 'wpcasa-sylt' ); ?>:</label><br />
			<select class="widefat" id="<?php echo $this->get_field_id( 'slider_stage_padding' ); ?>" name="<?php echo $this->get_field_name( 'slider_stage_padding' ); ?>">
				<option value="0"<?php selected( $slider_stage_padding, 0 ); ?>>0px</option>
				<option value="20"<?php selected( $slider_stage_padding, 20 ); ?>>20px</option>
				<option value="40"<?php selected( $slider_stage_padding, 40 ); ?>>40px</option>
				<option value="60"<?php selected( $slider_stage_padding, 60 ); ?>>60px</option>
				<option value="80"<?php selected( $slider_stage_padding, 80 ); ?>>80px</option>
				<option value="100"<?php selected( $slider_stage_padding, 100 ); ?>>100px</option>
				<option value="120"<?php selected( $slider_stage_padding, 120 ); ?>>120px</option>
				<option value="140"<?php selected( $slider_stage_padding, 140 ); ?>>140px</option>
			</select><br />
			<span class="description"><?php _e( 'Please select the stage padding (left and right space to see neighbour items)', 'wpcasa-sylt' ); ?></span></p>
		
		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'slider_loop' ); ?>" name="<?php echo $this->get_field_name( 'slider_loop' ); ?>"<?php checked( $slider_loop ); ?> />
				<label for="<?php echo $this->get_field_id( 'slider_loop' ); ?>"><?php _e( 'Loop slider to be infinite', 'wpcasa-sylt' ); ?></label></p>
		
		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'slider_nav' ); ?>" name="<?php echo $this->get_field_name( 'slider_nav' ); ?>"<?php checked( $slider_nav ); ?> />
				<label for="<?php echo $this->get_field_id( 'slider_nav' ); ?>"><?php _e( 'Show prev/next slider navigation', 'wpcasa-sylt' ); ?></label></p>
		
		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'slider_dots' ); ?>" name="<?php echo $this->get_field_name( 'slider_dots' ); ?>"<?php checked( $slider_dots ); ?> />
				<label for="<?php echo $this->get_field_id( 'slider_dots' ); ?>"><?php _e( 'Show <em>dots</em> slider navigation', 'wpcasa-sylt' ); ?></label></p>
		
		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'slider_autoplay' ); ?>" name="<?php echo $this->get_field_name( 'slider_autoplay' ); ?>"<?php checked( $slider_autoplay ); ?> />
				<label for="<?php echo $this->get_field_id( 'slider_autoplay' ); ?>"><?php _e( 'Slide through items automatically', 'wpcasa-sylt' ); ?></label></p>
		
		<div<?php if( ! $slider_autoplay ) echo ' style="display:none"'; ?>>
		
			<p><label for="<?php echo $this->get_field_id( 'slider_autoplay_time' ); ?>"><?php _e( 'Autoplay interval', 'wpcasa-sylt' ); ?>:</label><br />
				<select class="widefat" id="<?php echo $this->get_field_id( 'slider_autoplay_time' ); ?>" name="<?php echo $this->get_field_name( 'slider_autoplay_time' ); ?>">
					<option value="2000"<?php selected( $slider_autoplay_time, 2000 ); ?>>2 <?php _ex( 'seconds', 'listing widget', 'wpcasa-sylt' ); ?></option>
					<option value="4000"<?php selected( $slider_autoplay_time, 4000 ); ?>>4 <?php _ex( 'seconds', 'listing widget', 'wpcasa-sylt' ); ?></option>
					<option value="6000"<?php selected( $slider_autoplay_time, 6000 ); ?>>6 <?php _ex( 'seconds', 'listing widget', 'wpcasa-sylt' ); ?></option>
					<option value="8000"<?php selected( $slider_autoplay_time, 8000 ); ?>>8 <?php _ex( 'seconds', 'listing widget', 'wpcasa-sylt' ); ?></option>
					<option value="10000"<?php selected( $slider_autoplay_time, 10000 ); ?>>10 <?php _ex( 'seconds', 'listing widget', 'wpcasa-sylt' ); ?></option>
				</select><br />
				<span class="description"><?php _e( 'Please select the autoplay interval timeout', 'wpcasa-sylt' ); ?></span></p>
		
		</div><?php

	}

}