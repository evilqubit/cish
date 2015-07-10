<?php
/*
Template Name: media | main
*/

$galleryAlbum = ( get_query_var('album') ) ? get_query_var ('album') : 0;

if ( $galleryAlbum > 0 ){
	includeSingleMediaAlbum();
	exit;
}

get_header();

$pageGallery = new WP_Query('pagename='.$MAIN->getParentPageSlug().'/gallery');
$limitGallery = 8;
$pageVideos = new WP_Query('pagename='.$MAIN->getParentPageSlug().'/videos');
$limitVideo = 6;
?>

<?php if ($pageGallery): ?>
	<div id="section-gallery">
		<div class="container">
			<div class="block-w">
				<div class="head"><?php _e('Gallery','cish');?><a href="<?php _GetPagePermalinkBySlug($MAIN->getParentPageSlug().'/gallery');?>"><?php _e('View All','cish');?></a></div>
				<div class="row">
					<?php while ($pageGallery->have_posts()) : $pageGallery->the_post();?>
						<?php
						$albums = get_field('albums');
						$count = 0;
						if ($albums) :
							foreach ($albums as $albumGallery) : 
								$entry = $albumGallery['album_gallery'];
								
								if ($count < $limitGallery) :?>
									<div class="col-sm-3 entry-inline col-inline-images">
										<div class="entry tinted">
											<div class="entry-image-w">
												<a class="entry-image" href="gallery/<?php echo ($count+1);?>"><img class="img-responsive" src="<?php echo $entry[0]['url']?>"/>
													<div class="overlay">
														<h1 class="title"><?php echo $albumGallery['album_title'];?></h1>
													</div>
												</a>
											</div>
										</div>
									</div>
									<?php $count++;?>
								<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>
					<?php endwhile;?>
					<?php wp_reset_postdata();?>
					<?php wp_reset_query();?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if ($pageVideos): ?>
	<div id="section-video">
		<div class="container">
			<div class="block-w">
				<div class="head"><?php _e('Videos','cish');?><a href="<?php _GetPagePermalinkBySlug($MAIN->getParentPageSlug().'/videos');?>"><?php _e('View All','cish');?></a></div>
				<div class="row">
					<?php while ($pageVideos->have_posts()) : $pageVideos->the_post();?>
						<?php
						$videosURLs = get_field('repeater_video');
						$count = 0;
						if ($videosURLs) :
							foreach ($videosURLs as $entry) : 
								if ($count < $limitVideo) :?>
									<div class="col-md-4 col-sm-6 entry-inline">
										<iframe class="media-video" src="https://www.youtube.com/embed/<?php echo getYoutubeVideoID($entry['video_url']);?>" frameborder="0" allowfullscreen></iframe>
									</div>
									<?php $count++;?>
								<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>
					<?php endwhile;?>
					<?php wp_reset_postdata();?>
					<?php wp_reset_query();?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php get_footer();?>