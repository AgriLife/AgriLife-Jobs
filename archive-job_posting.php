<?php
/**
 * Archive: job_posting
 * @package WordPress
 */

get_header();

if( !function_exists('genesis') ) : ?>
		<div id="wrap">
			<div id="content" role="main">
<?php else : ?>
		<div class="content-sidebar-wrap">
			<main class="content">
				<a id="content" title="content"></a>
<?php endif; ?>
				<h1 class="entry-title">Jobs</h1>
				<?php include( 'loop-job_listings.php' );

if( !function_exists('genesis') ) : ?>
			</div><!-- #content -->
		</div><!-- #wrap -->
		<?php get_sidebar(); ?>
<?php else : ?>
			</main>
			<?php get_sidebar(); ?>
		</div>
<?php endif;

get_footer(); ?>
