<?php
/**
 * Template Name: Standard Page
 *
 * @package WPCasa Sylt
 */

get_header(); ?>

	<div class="site-top site-section site-page-title">
	
		<div class="container">
			<?php the_title( '<h2 class="page-title">', '</h2>' ); ?>
		</div>
	
	</div>

	<div class="site-main site-section">
	
		<div class="container">
	
			<div class="content-sidebar-wrap row 150%">
	
				<main class="content 8u 12u$(medium)" role="main" itemprop="mainContentOfPage">

					<?php while ( have_posts() ) : the_post(); ?>
					
						<?php get_template_part( 'template-parts/content', 'page' ); ?>
					
					<?php endwhile; ?>
			
				</main>
				
				<?php get_sidebar(); ?>
			
			</div>
		
		</div>
	</div>

<?php get_footer(); ?>