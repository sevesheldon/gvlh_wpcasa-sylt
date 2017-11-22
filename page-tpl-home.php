<?php
/**
 * Template Name: Home Page
 *
 * This is the home page template.
 *
 * @package WPCasa Sylt
 */
get_header(); ?>

	<?php get_template_part( 'template-parts/home', 'slider' ); ?>
	
	<?php get_template_part( 'template-parts/home', 'icon-links' ); ?>
	
	<?php get_template_part( 'template-parts/header', 'search' ); ?>
	
	<?php get_template_part( 'template-parts/home', 'listings' ); ?>
	
	<?php get_template_part( 'template-parts/home', 'cta-1' ); ?>
	
	<?php get_template_part( 'template-parts/home', 'carousel' ); ?>
	
	<?php get_template_part( 'template-parts/home', 'cta-2' ); ?>

<?php get_footer(); ?>