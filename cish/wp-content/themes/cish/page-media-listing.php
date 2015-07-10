<?php
/*
Template Name: media | listing
*/
get_header();?>

<?php
if ( $MAIN->getChildPageSlug() != $MAIN->getParentPageSlug() ) {
	$pageListing = new WP_Query('pagename='.$MAIN->getParentPageSlug().'/'.$MAIN->getChildPageSlug());
}else{
	$pageListing = new WP_Query('pagename='.$MAIN->getChildPageSlug());
}

$limitVideo = 24;

$albums = get_field('albums');
$videosURLs = get_field('repeater_video');
?>

<?php
$eventsAlbums = array();
// Events Albums
$args = array (
	'post_type' => 'event',
	'showposts' => 4,
	'meta_query' => array(
		array(
			'key' => 'gallery_cover',
			'value' => '',
			'compare' => '!='
		)
	)
);
$wp_query = new WP_Query($args);
?>
<?php if ( have_posts() ) : while (have_posts()) : the_post();?>
<?php $eventsAlbums[] = $post; ?>
<?php endwhile; ?>
<?php wp_reset_postdata();?>
<?php wp_reset_query();?>
<?php endif;?>

<?php if ($pageListing && ($albums || $eventsAlbums) ): ?>
	
	<?php while ($pageListing->have_posts()) : $pageListing->the_post();?>
		<div id="section-gallery">
			<div class="container">
				<div class="block-w">
					<div class="head"><?php the_title();?></div>
					<div class="row">
						<?php
						$count = 0;
						foreach ($albums as $albumGallery) :
							$entry = $albumGallery['album_gallery'];
							?>
							<div class="col-sm-3 entry-inline col-inline-images">
								<div class="entry tinted">
									<div class="entry-image-w">
										<a class="entry-image" href="<?php bloginfo('wpurl');?>/gallery/gallery/<?php echo ($count+1);?>"><img class="img-responsive" src="<?php echo $entry[0]['url']?>"/>
											<div class="overlay">
												<h1 class="title"><?php echo $albumGallery['album_title'];?></h1>
											</div>
										</a>
									</div>
								</div>
							</div>
						<?php endforeach;?>
						
						<?php foreach ($eventsAlbums as $entry) : ?>
							<?php $galleryCover = get_field('gallery_cover', $entry->ID);?>
							<div class="col-sm-3 entry-inline col-inline-images">
								<div class="entry tinted">
									<div class="entry-image-w">
										<a class="entry-image" href="<?php echo get_the_permalink($entry->ID);?>gallery"><img class="img-responsive" src="<?php echo $galleryCover;?>"/>
											<div class="overlay">
												<h1 class="title"><?php echo get_the_title($entry->ID);?></h1>
											</div>
										</a>
									</div>
								</div>
							</div>
						<?php endforeach;?>
						
					</div>
				</div>
			</div>
		</div>
	<?php endwhile;?>
	<?php wp_reset_postdata();?>
	<?php wp_reset_query();?>
<?php endif; ?>

<?php if ($pageListing && $videosURLs ): ?>
	<?php while ($pageListing->have_posts()) : $pageListing->the_post();?>
	<div id="section-video">
		<div class="container">
			<div class="block-w">
				<div class="head"><?php the_title()?></div>
				<div class="row">
					<?php
					$count = 0;
					foreach ($videosURLs as $entry) : 
						if ($count < $limitVideo) :?>
							<div class="col-md-4 col-sm-6 entry-inline">
								<iframe class="media-video" src="https://www.youtube.com/embed/<?php echo getYoutubeVideoID($entry['video_url']);?>" frameborder="0" allowfullscreen></iframe>
							</div>
							<?php $count++;?>
						<?php endif;?>
					<?php endforeach;?>
				</div>
			</div>
		</div>
	</div>
	<?php endwhile;?>
	<?php wp_reset_postdata();?>
	<?php wp_reset_query();?>
<?php endif; ?>

<?php get_footer();?>