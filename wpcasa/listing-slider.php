<div class="wpsight-listings-slider-item listing-<?php the_ID(); ?>-slider-wrap listing-slider-wrap">

	<div id="listing-<?php the_ID(); ?>-slider" <?php wpsight_listing_class( 'wpsight-listing-slider' ); ?> itemscope itemtype="http://schema.org/Product">
	
		<meta itemprop="name" content="<?php echo esc_attr( $post->post_title ); ?>" />
		
		<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="clearfix">
	
			<?php do_action( 'wpsight_listing_slider_before', $post ); ?>
				
			<?php wpsight_get_template( 'listing-archive-image.php', array( 'args' => $args ) ); ?>
			
			<?php $full_size = isset( $args['slider_full_width'] ) && $args['slider_full_width'] === true ? true : false; ?>
			
			<?php if( $full_size ) : ?>
			<div class="container">
			<?php endif; ?>
			
				<div class="listing-slider-overlay">
				
					<?php wpsight_get_template( 'listing-archive-title.php' ); ?>
					
					<?php wpsight_get_template( 'listing-archive-info.php' ); ?>
					
					<?php wpsight_get_template( 'listing-archive-summary.php' ); ?>
				
				</div><!-- .listing-slider-overlay -->
			
			<?php if( $full_size ) : ?>
			</div>
			<?php endif; ?>
			
			<?php do_action( 'wpsight_listing_slider_after', $post ); ?>
		
		</div>
	
	</div><!-- #listing-<?php the_ID(); ?>-carousel -->

</div>