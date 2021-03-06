<?php
global $wp_query;

$perPage = $args['posts_per_page'];
$paged = ( $args['paged'] > 0 ) ? $args['paged'] : 1;
?>
<?php if (have_posts()) :?>
	<?php
	$currentPostCount = _GetCurrentPagePostCount( array('perPage'=> $perPage, 'paged'=>$paged, 'foundPosts'=> $wp_query->found_posts ) );
	$c = 0;
	?>
	<?php while ( have_posts() ) : the_post();?>
		<?php
		$authorName = get_field('author_name');
		$event = get_field('event');
		$program = get_field('program', $event->ID);
		$date = get_field('date');
		$downloadFile = get_field('download_file');
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
														<?php if ($downloadFile) :?>
															<li class="download">
																<div class="icon-overlay"><?php _e('Download','cish');?><span>&nbsp;</span></div>
																<a target="_blank" href="<?php echo $downloadFile;?>">&nbsp;</a>
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
<?php
else:
includeNoResults();
endif;
wp_reset_postdata();
wp_reset_query();
?>