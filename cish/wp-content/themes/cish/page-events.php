<?php
/*
Template Name: events | listing
*/
get_header();?>

<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$wp_query = new WP_Query ('post_type=event&posts_per_page=8&paged='.$paged);
?>

<div id="section-events">
	<div class="container">
		<div class="block-w">
			<div class="head"><?php _e('Events','cish');?></div>
			
			<?php if( have_posts() ): ?>
				<?php while (have_posts()) : the_post()?>
					<?php
					$entryID = $entry->ID;
					$permalink = get_permalink($entryID);
					?>
					<div class="entry entry-listing">
						<div class="row">
							<div class="col-lg-4 col-sm-5">
								<div class="entry-image-w">
									<a href="<?php the_permalink();?>"><img class="img-responsive" src="<?php echo featuredImg();?>"/></a>
								</div>
							</div>
							<div class="col-lg-8 col-sm-7">
								<div class="entry-title"><a href="<?php  the_permalink();?>"><?php the_title();?></a></div>
								<div class="entry-content">
									<?php if ( get_the_excerpt() ) :?>
										<?php the_excerpt();?>
										<div class="more">
											<a href="<?php  the_permalink();?>"><?php _e('more', 'cish');?></a>
										</div>
									<?php endif;?>
								</div>
							</div>
						</div>
					</div>
				<?php endwhile;?>
				<?php _MyPagination();?>
			<?php endif;?>
			<?php wp_reset_postdata();?>
			<?php wp_reset_query();?>
		</div>
	</div>
</div>

<?php get_footer();?>