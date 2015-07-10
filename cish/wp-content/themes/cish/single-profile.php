<?php get_header();?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php
$memberType = get_field('member_type');

$memberTypeText = '';
switch($memberType):
	case 'board-members':
		$memberTypeText = __('Board Members', 'cish');
	break;
	case 'administration':
		$memberTypeText = __('Administration', 'cish');
	break;
	case 'former-board-members':
		$memberTypeText = __('Former Board Members', 'cish');
	break;
endswitch;
?>

<div id="section-single-center-administration">
	<div class="container">
		<div class="row">
			<?php includeCenterMenu($memberType);?>

			<div class="col-sm-8">
				<div class="block-w">
					<div class="head"><?php echo $memberTypeText.' | '.get_the_title();?></div>
					<div class="entry entry-listing">
						<div class="row">
							<div class="col-lg-4 col-sm-12 col-sm-full">
								<div class="entry-image-w">
									<a href="<?php the_permalink();?>"><img class="img-responsive" src="<?php echo featuredImg();?>"/></a>
								</div>
							</div>
							<div class="col-lg-8 col-sm-12">
								<div class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></div>
								<div class="entry-content"><?php the_content();?></div>
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