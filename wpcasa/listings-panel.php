<div class="listings-panel-wrap">

	<div class="listings-panel">
		
		<div class="listings-panel-title">
	
			<div class="listings-panel-title-archive">
				<?php wpsight_archive_title(); ?>
			</div>
	
		</div><!-- .listings-panel-title -->
		
		<div class="listings-panel-actions">
		
			<div class="listings-panel-action">
				<?php wpsight_orderby(); ?>
			</div>
			
			<?php do_action( 'wpsight_listings_panel_actions' ); ?>
		
		</div><!-- .listings-panel-actions -->
	
	</div><!-- .listings-panel -->

</div>