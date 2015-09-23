<?php
/**
 * The Template for displaying all job posting single posts.
 *
 * @package WordPress
 * @subpackage agriflex
 * @since agriflex 1.0
 */

get_header(); ?>

		<div id="wrap">
			<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>

						<?php if ( 'post' == get_post_type() ) : ?>
						<div class="entry-meta">
							<?php agriflex_posted_on(); ?>
						</div><!-- .entry-meta -->
						<?php endif; ?>
					</header><!-- .entry-header -->	
					<section class="entry-content">
						<?php 
						
						// Use Custom Fields (these will work with Gravity Forms submitted jobs
						$custom = get_post_custom($post->ID);
						
						// Still Support the legacy _my_meta fields
						$my_meta = get_post_meta($post->ID,'_my_meta',TRUE); 
						
						$job_number 	= (is_array($my_meta)&&$my_meta['job_number']<>''? $my_meta['job_number'] : $custom["job_number"][0]);
						$agency 		= (is_array($my_meta)&&$my_meta['agency']<>'' ? $my_meta['agency'] 		: $custom["agency"][0]);
						$location		= (is_array($my_meta)&&$my_meta['location']<>'' ? $my_meta['location'] 	: $custom["location"][0]);
						$type			= (is_array($my_meta)&&$my_meta['type'] <>'' ? $my_meta['type']			: $custom["classification"][0]);
						$salary			= (is_array($my_meta)&&$my_meta['salary']<>'' ? $my_meta['salary']		: $custom["salary"][0]);
						$website		= (is_array($my_meta)&&$my_meta['website']<>'' ? $my_meta['website']		: $custom["website"][0]);
						$apply_date		= (is_array($my_meta)&&$my_meta['apply-date'] <> '' ? $my_meta['apply-date'] : $custom["apply_date"][0]);
						$start_date		= (is_array($my_meta)&&$my_meta['start-date'] <> '' ? $my_meta['start-date'] : $custom["start_date"][0]);
						$description  	= (is_array($my_meta)&&$my_meta['description'] <> '' ? $my_meta['description'] : $custom["description"][0]);
						$qualifications	= (is_array($my_meta)&&$my_meta['qualifications'] <> '' ? $my_meta['qualifications'] : $custom["qualifications"][0]);
						$contact_name 	= (is_array($my_meta)&&$my_meta['contact-name'] <> '' ? $my_meta['contact-name'] : $custom["contact_name"][0]);
						$contact_phone	= (is_array($my_meta)&&$my_meta['contact-phone'] <> '' ? $my_meta['contact-phone'] : $custom["contact_phone"][0]);
						$contact_email	= (is_array($my_meta)&&$my_meta['contact-email'] <> '' ? $my_meta['contact-email'] : $custom["contact_email"][0]);
						$fileupload	= (is_array($my_meta)&&$my_meta['fileupload'] <> '' ? $my_meta['fileupload'] : $custom["fileupload"][0]);
						$job_categories   = get_the_terms( $post->ID, 'job_category');
						?>
						<div class="job-posting-details">
							<dl class="job-posting-dl">	
							<?php if ($agency) { ?>
							<dt class="job-posting-dt">Agency</dt>
								<dd class="job-posting-dd"><?php echo $agency; ?></dd>
							<?php } ?>
							<?php if ($location) { ?> 
							<dt class="job-posting-dt">Location</dt>	
								<dd class="job-posting-dd"><?php echo $location;?></dd> 
							<?php } ?>
							<?php 
							if ( $job_categories && ! is_wp_error( $job_categories ) ) {							
								$job_category_names = array();
								foreach ( $job_categories as $term ) {
									$job_category_names[] = $term->name;
								}						
								$the_job_category = join( ", ", $job_category_names );
								?>
								<dt class="job-posting-dt">Job Category</dt>	 
								<dd class="job-posting-dd"><?php echo $the_job_category;?></dd> 
							<?php } ?>
							
							<?php if ($website) { ?>	
							<dt class="job-posting-dt">Website</dt>							
								<dd class="job-posting-dd"><?php
								if($website[0] == "<" && $website[1] == "a"){
									echo $website;
								} else {
									echo '<a target="_blank" href="' . $website . '">' . $website . '</a>';
								}
								?></dd>
							<?php } ?>
								
							<?php if ($salary) { ?>	
							<dt class="job-posting-dt">Salary</dt>							
								<dd class="job-posting-dd"><?php echo $salary;?></dd>
							<?php } ?>
							
							<?php if ($start_date) { ?>	
							<dt class="job-posting-dt">Start Date</dt>							
								<dd class="job-posting-dd"><?php echo $start_date;?></dd>
							<?php } ?>
							
							<?php if ($apply_date) { ?>	
							<dt class="job-posting-dt">Last Date to Apply</dt>							
								<dd class="job-posting-dd"><?php echo $apply_date;?></dd>
							<?php } ?>							
														
							<?php if ($description) { ?>	
							<dt class="job-posting-dt">Description</dt>	
								<dd class="job-posting-dd"><?php echo $description;?></dd>
							<?php } ?>	
								
							<?php if ($qualifications) { ?>
							<dt class="job-posting-dt">Qualifications</dt>	 
								<dd class="job-posting-dd"><?php echo $qualifications;?></dd> 
							<?php } ?>
							
							<?php if ($job_number) { ?>
							<dt class="job-posting-dt">Job Number</dt>											
								<dd class="job-posting-dd"><?php echo $job_number;?></dd>
							<?php } ?>
							
							<?php if ($contact_name) { ?>	 	
							<dt class="job-posting-dt">Contact Person</dt>
								<dd class="fn job-posting-dd"><?php echo $contact_name;?></dd>
							<?php } ?>
								
							<?php if ($contact_phone) { ?>	
							<dt class="job-posting-dt">Contact Phone</dt>	
								<dd class="tel job-posting-dd"><?php echo $contact_phone;?></dd> 
							<?php } ?>
								
							<?php if ($contact_email) { ?>	
							<dt class="job-posting-dt">Contact eMail</dt>							
								<dd class="email job-posting-dd"><a href="mailto:<?php echo $contact_email;?>"><?php echo $contact_email;?></a></dd> 
							<?php } ?>		

							<?php if ($fileupload) { ?>
							<dt class="job-posting-dt">File</dt>
								<dd class="fileupload job-posting-dd"><?php
									echo '<a href="' . $fileupload . '">';
									$pattern = '/[^\/]*$/';
									preg_match($pattern, $fileupload, $matches);
									print_r($matches[0]);
									echo '</a>';
								?></dd>
							<?php } ?>
							</dl>
								
						</div>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'agriflex' ), 'after' => '</div>' ) ); ?>
					</section><!-- .entry-content -->

						<section class="entry-utility">
							<?php agriflex_posted_in(); ?>
							<?php edit_post_link( __( 'Edit', 'agriflex' ), '<span class="edit-link">', '</span>' ); ?>
						</section><!-- .entry-utility -->
					</footer><!-- .entry-meta -->
				</article><!-- #post-<?php the_ID(); ?> -->
				
				<nav id="nav-below" class="navigation">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'agriflex' ) . '</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'agriflex' ) . '</span>' ); ?></div>
				</nav><!-- #nav-below -->

				<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>
			</div><!-- #content -->
		</div><!-- #wrap -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>