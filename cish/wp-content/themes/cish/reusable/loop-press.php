<?php
if ( isset ($data) ){
	$wp_query = $data;
}
else{
	global $wp_query;
}

if ( !isset ($wp_query) || ( isset ($wp_query) && $wp_query->found_posts <= 0 ) ){
	includeNoResults();
}

else {
		
	?>
	<?php if ($wp_query->have_posts()) :?>
		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post()?>
			<?php
			$date = str_replace('-','.',get_field('date'));
			$externalLink = get_field('external_url');
			$downloadFile = get_field('download_file');
			?>
			<div class="entry entry-listing">
				<div class="row">
					<div class="col-lg-4 col-sm-5 entry-image-w">
						<a href="<?php the_permalink();?>"><img class="img-responsive" src="<?php echo featuredImg();?>"/></a>
					</div>
					<div class="col-lg-8 col-sm-7">
						<div class="entry-title">
							<a href="<?php the_permalink();?>"><?php the_title();?> | <span class="date"><?php echo $date;?></span></a>
						</div>
						<div class="entry-content">
							<?php the_excerpt();?>
							<?php if ( get_the_excerpt() ) :?>
								<div class="more">
									<a href="<?php the_permalink();?>"><?php _e('more', 'cish');?></a>
								</div>
							<?php endif;?>
							<?php if ($externalLink) :?>
								<div class="original-link">
									<?php _e('To check the original article published by The Telegraph please follow this','cish');?> <a target="_blank" href="<?php echo $externalLink;?>">link</a>.
								</div>
							<?php endif;?>
						</div>
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
		<?php endwhile;?>
		<?php if ( !isset($noPagination) ) :?>
			<?php _MyPagination( array('wp_query'=>$wp_query) );?>
		<?php endif;?>
		
	<?php
	else:
	includeNoResults();
	endif;
	wp_reset_postdata();
	wp_reset_query();
	?>
	<?php
}
?>