<ul class="wpsight-term-checklist wpsight-term-checklist-<?php echo $key ?>">
<?php 
	require_once( ABSPATH . '/wp-admin/includes/template.php' );
		
	if ( empty( $field['default'] ) )
		$field['default'] = '';

	$args = array(
		'descendants_and_self'  => 0,
		'selected_cats'         => isset( $field['value'] ) ? $field['value'] : ( is_array( $field['default'] ) ? $field['default'] : array( $field['default'] ) ),
		'popular_cats'          => false,
		'taxonomy'              => $field['taxonomy'],
		'checked_ontop'         => true,
		'walker'				=> new wpsight_sylt_Walker_Category_Checklist()
	);

	// $field['post_id'] needs to be passed via the args so we can get the existing terms
	wp_terms_checklist( 0, $args );
?>
</ul>
<?php if ( ! empty( $field['description'] ) ) : ?><small class="description"><?php echo $field['description']; ?></small><?php endif; ?>