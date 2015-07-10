<?php get_header();?>

<?php
global $wp_query;
$paged = ( get_query_var('pagedCustom') ) ? get_query_var('pagedCustom') : 1;
?>

<div id="section-program-gallery">
	<div class="container">
		<div class="row">

			<?php includeProgramMenu($wp_query->query_vars['subpage']);?>
		
			<div class="col-sm-8">
				<div class="block-w">
					<div class="head"><?php _e('Gallery', 'cish');?></div>
					<?php
					$args = array (
						'post_type' => 'event',
						'paged' => $paged,
						'showposts' => 12,
						'meta_query' => array(
							'relation' => 'AND',
							array(
								'key' => 'gallery_cover',
								'value' => '',
								'compare' => '!='
							),
							array(
								'key' => 'program',
								'value' => get_the_ID(),
								'compare' => '=',
							)
						)
					);
					?>
					<?php $wp_query = new WP_Query( $args );?>
					<?php if( have_posts() ) : ?>
						<div class="row">
							<?php while (have_posts()) : the_post();?>
								<?php $galleryCover = get_field('gallery_cover');?>
								<div class="col-sm-4 entry-inline col-inline-images">
									<div class="entry tinted">
										<div class="entry-image-w">
											<a class="entry-image" href="<?php the_permalink();?>gallery"><img class="img-responsive" src="<?php echo $galleryCover;?>"/>
												<div class="overlay">
													<?php if ( has_excerpt() ) :?>
														<h2 class="excerpt"><?php the_excerpt();?></h2>
													<?php endif;?>
													<h1 class="title"><?php the_title();?></h1>
												</div>
											</a>
										</div>
									</div>
								</div>
							<?php endwhile;?>
						</div>
						<?php _MyPagination();?>
					<?php endif;?>
					<?php wp_reset_postdata();?>
					<?php wp_reset_query();?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer();?>