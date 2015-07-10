<?php
/*
Template Name: center| info
*/
get_header();?>

<?php
$pageSlug = _GetCurrentPageSlug();
?>

<?php if ( have_posts() ) : while( have_posts() ) : the_post();?>

<div id="section-center-achievements">
	<div class="container">
		<div class="row">
			<?php includeCenterMenu( $pageSlug );?>

			<div class="col-sm-8">
				<div class="block-w">
					<div class="head"><?php the_title();?></div>
					<div class="entry entry-listing">
						<div class="row">
							<div class="col-md-4 col-sm-12 col-sm-full">
								<div class="entry-image-w">
									<a href="<?php echo featuredImg();?>" class="fancybox">
										<img class="img-responsive" src="<?php echo featuredImg();?>"/>
									</a>
								</div>
							</div>
							<div class="col-md-8 col-sm-12">
								<div class="entry-content">
									<?php the_content();?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php endwhile; endif;?>

<?php get_footer();?>