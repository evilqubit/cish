<?php
$galleryAlbum = ( get_query_var('album') ) ? get_query_var ('album') : 0;
// important, because php array start at 0, while our gallery ids are shown starting from 1
$galleryAlbum = $galleryAlbum - 1;

$pageListing = new WP_Query('pagename=gallery/gallery');
?>

<?php while ($pageListing->have_posts()) : $pageListing->the_post();?>
	<?php
	$albums = get_field('albums');
	$album = ( isset ( $albums[$galleryAlbum] ) ) ? $albums[$galleryAlbum] : array();
	if ( !$album ){
		header("Location: ".get_bloginfo('url'));
		exit;
	}
	?>
<?php endwhile;?>
	
<?php
get_header();
?>
<div id="section-gallery" class="section-gallery-album">
	<div class="container">
		<div class="block-w">
			<div class="head"><?php echo $album['album_title'];?></div>
			<div class="row">
				<?php
				$albumGallery = $album['album_gallery'];
				?>
				<?php foreach ($albumGallery as $entry) :?>
					<div class="col-sm-3 col-inline-images">
						<div class="entry-image-w">
							<a class="fancybox entry-image" href="<?php echo $entry['url'];?>" rel="mediaGallery">
								<img class="img-responsive" src="<?php echo $entry['url'];?>">
							</a>	
						</div>
					</div>
				<?php endforeach;?>
			</div>
		</div>
	</div>
</div>

<?php get_footer();?>