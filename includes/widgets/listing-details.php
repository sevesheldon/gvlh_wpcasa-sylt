<?php
/**
 * Listing Details widget
 *
 * @package WPCasa Sylt
 */

/**
 * Register widget
 */
 
add_action( 'widgets_init', 'wpsight_sylt_register_widget_listing_details' );
 
function wpsight_sylt_register_widget_listing_details() {
	register_widget( 'WPSight_Sylt_Listing_Details' );
}

/**
 * Listing title widget class
 *
 * @since 1.0.0
 */

class WPSight_Sylt_Listing_Details extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget_listing_details',
			'description' => _x( 'Display listing details on single listing pages.', 'listing wigdet', 'wpcasa-sylt' )
		);

		parent::__construct( 'wpsight_sylt_listing_details', '&rsaquo; ' . WPSIGHT_SYLT_NAME . ' ' . _x( 'Listing Details', 'listing widget', 'wpcasa-sylt' ), $widget_ops );

	}

	public function widget( $args, $instance ) {
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		// Echo before_widget
        echo $args['before_widget'];
        
        if ( $title )
			echo $args['before_title'] . $title . $args['after_title'];
        
        // Echo listing details
	    wpsight_listing_details();
		
		// Echo after_widget
		echo $args['after_widget'];

	}

	public function update( $new_instance, $old_instance ) {
	    
	    $instance = $old_instance;
	    
	    $instance['title'] = strip_tags( $new_instance['title'] );

        return $instance;

    }

	public function form( $instance ) {
		
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = $instance['title']; ?>
		
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpcasa-sylt' ); ?>: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>

		<p>
			<?php _e( 'This widget has no further settings. It automatically displays the listing details of the current single listing.', 'wpcasa-sylt' ); ?>
		</p><?php

	}

}