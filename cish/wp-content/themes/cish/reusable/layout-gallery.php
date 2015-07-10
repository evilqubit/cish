<?php
global $wp_query;
?>

<?php get_header();?>

<?php $gallery = get_field('gallery');?>

<div id="section-gallery">
	<div class="container">
	
		<?php includeEventMenu($wp_query->query_vars['subpage']);?>
		
		<div class="col-sm-8">
			<div class="block-w">
				<div class="head"><?php the_title();?> | <?php _e('Gallery','cish');?></div>
				<?php if( $gallery ) :?>
					<div class="row">
						<?php foreach( $gallery as $image ) :?>
							<div class="col-sm-3 col-inline-images">
								<div class="entry-image-w">
									<a class="fancybox entry-image" href="<?php echo $image['url'];?>" rel="eventGallery"><img class=	"img-responsive" src="<?php echo $image['url'];?>"/></a>
								</div>
							</div>
							<?php endforeach;?>
					</div>
				<?php else: ?>
				<?php includeNoResults();?>
				<?php endif; ?>
			</div>
		</div>
		
	</div>
</div>
<?php get_footer();?>