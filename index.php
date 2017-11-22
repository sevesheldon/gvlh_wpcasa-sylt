<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WPCasa Sylt
 */
get_header(); the_post(); ?>

	<?php if( is_home() && get_option('page_for_posts') ) : ?>

	<div class="site-top site-section site-page-title">
	
		<div class="container">
			<h2 class="page-title"><?php echo apply_filters( 'the_title', get_page( get_option( 'page_for_posts' ) )->post_title ); ?></h2>
		</div>
	
	</div>
	
	<?php endif; ?>

	<div class="site-main site-section">
	
		<div class="container">
		
			<div class="content-sidebar-wrap row 150%">
	
				<main class="content 8u 12u$(medium)" role="main" itemprop="mainContentOfPage">
					
					<?php if ( have_posts() ) : ?>
					
						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>
					
							<?php
								/* Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content', get_post_format() );
							?>
					
						<?php endwhile; ?>
					
						<?php the_posts_navigation(); ?>
					
					<?php else : ?>
					
						<?php get_template_part( 'template-parts/content', 'none' ); ?>
					
					<?php endif; ?>
				
				</main>
				
				<?php get_sidebar(); ?>
			
			</div><!-- .content-sidebar-wrap -->
		
		</div><!-- .container -->
	
	</div><!-- .site-main -->

<?php get_footer(); ?>