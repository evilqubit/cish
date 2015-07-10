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
					<div class="head"><?php _e('Publications', 'cish');?></div>
					<?php
					$args = array (
						'post_type' => 'publication',
						'paged' => $paged,
						'showposts' => 12,
						'meta_query' => array(
							array(
								'key' => 'program',
								'value' => get_the_ID(),
								'compare' => 'LIKE',
							)
						)
					);
					?>
					<?php $wp_query = new WP_Query( $args );?>
					<?php if ( have_posts() ) :?>
						<?php
						$c = 0;
						$currentPostCount = _GetCurrentPagePostCount( array('perPage'=> $perPage, 'paged'=>$paged, 'foundPosts'=> $wp_query->found_posts ) );
						?>
						<?php while (have_posts()) : the_post();?>
							<?php
							$authorName = get_field('author_name');
							$event = get_field('event');
							$program = get_field('program', $event->ID);
							$date = get_field('date');
							$download = get_field('download_file');
							?>
							
							<?php if ( $c%2 == 0 || $c == 0 ) :?>
								<div class="row row-publication-listing-main">
									<div class="col-sm-12">
										<div class="row-publication-listing">
											<div class="row">
							<?php endif;?>
												<div class="col-sm-6">
													<div class="panel-info">
														<div class="row">
															<div class="col-sm-4">
																<a class="fancybox" href="<?php the_permalink();?>" rel="publicationsList"><img class="img-responsive" src="<?php echo featuredImg();?>" /></a>
															</div>
															<div class="col-sm-8">
																<div class="panel-publication-info">
																	<label><?php _e('Title','cish');?></label>
																	<div class="title"><?php the_title();?></div>
																	
																	<?php if ($authorName) : ?>
																		<label><?php _e('Author','cish');?></label>
																		<div class="author-name"><?php echo $authorName;?></div>
																	<?php endif;?>
																	
																	<?php if ($date) : ?>
																		<label><?php _e('Date','cish');?></label>
																		<div class="date"><?php echo str_replace('-','.', $date);?></div>
																	<?php endif;?>
																	
																	<?php if ($program) : ?>
																		<div class="program-event">
																			<a href="<?php echo get_permalink($program->ID);?>"><?php echo $program->post_title;?></a>
																			<?php if ( $event ) :?>
																				/ <a href="<?php echo get_permalink($event->ID);?>"><?php echo $event->post_title;?></a>
																			<?php endif;?>
																		</div>
																	<?php endif;?>
																	
																	<div class="entry-actions">
																		<ul>
																			<?php if ($download) : ?>
																				<li class="download">
																					<div class="icon-overlay"><?php _e('Download','cish');?><span>&nbsp;</span></div>
																					<a target="_blank" href="<?php echo $download;?>">&nbsp;</a>
																				</li>
																			<?php endif;?>
																		</ul>
																	</div>
																	
																</div>
															</div>
														</div>
													</div>
												</div>
												<?php $c++;?>
											<?php if ( $c%2 == 0 || $c == $currentPostCount ) :?>
												</div>
											</div>
										</div>
									</div>
								<?php endif;?>
							<?php endwhile;?>
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