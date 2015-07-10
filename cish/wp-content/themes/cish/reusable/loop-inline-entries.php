<?php
$urlAdditions = ( isset($urlAdditions) ) ? $urlAdditions : '';
$showExcerpt = ( isset($showExcerpt) && $showExcerpt == 'f' ) ? false : true;
$showGalleryCover = ( isset($showGalleryCover) && $showGalleryCover == 'y' ) ? true : false;
?>

<?php if ( have_posts() ) :?>
	<div class="owl-carousel">
		<?php while (have_posts()) : the_post();?>
			
			<?php
			$galleryCover = '';
			if ( $showGalleryCover ){
				$galleryCover = get_field('gallery_cover');
				$galleryCover = ( $galleryCover ) ? $galleryCover : '';
			}
			?>
			
			<div class="item entry-inline col-inline-images">
				<div class="entry tinted">
					<div class="entry-image-w">
						<a class="entry-image" href="<?php the_permalink();?><?php echo $urlAdditions;?>"><img class="img-responsive" src="<?php echo ($galleryCover) ? $galleryCover : featuredImg();?>"/>
							<div class="overlay">
								<?php if ( has_excerpt() && $showExcerpt ) :?>
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
<?php
else :
includeNoResults();
endif;
wp_reset_postdata();
wp_reset_query();
?>