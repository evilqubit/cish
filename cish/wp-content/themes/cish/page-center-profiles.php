<?php get_header();?>

<?php
$subpage = ( get_query_var('subpage') ) ? get_query_var('subpage') : '';

$entries = get_posts(
	array(
		'suppress_filters' => false,
		'post_type' => 'profile',
		'showposts' => '-1',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'meta_query' => array(
			array(
				'key' => 'member_type',
				'value' => $subpage,
				'compare' => '='
			)
		)
	)
);
?>
<?php if (have_posts()) : while(have_posts()) : the_post();?>

<div id="section-center-members">
	<div class="container">
		<div class="row">
			<?php includeCenterMenu($subpage);?>

			<div class="col-sm-8">
				<div class="block-w">
					<div class="head"><?php the_title();?></div>
					<?php if( $entries ) :?>
						<?php foreach( $entries as $entry ): ?>
							<?php
							$entryID = $entry->ID;
							$permalink = get_permalink($entryID);
							?>
							<div class="entry entry-listing">
								<div class="row">
									<div class="col-lg-4 col-sm-5">
										<div class="entry-image-w">
											<a href="<?php echo $permalink;?>"><img class="img-responsive" src="<?php echo featuredImg($entryID);?>"/></a>
										</div>
									</div>
									<div class="col-lg-8 col-sm-7">
										<div class="entry-title"><a href="<?php echo $permalink;?>"><?php echo get_the_title($entryID);?></a></div>
										<div class="entry-content">
											<?php if ( get_post_field('post_excerpt', $entryID) ) :?>
											<?php echo get_post_field('post_excerpt', $entryID);?>
												<div class="more"><a href="<?php echo $permalink;?>"><?php _e('more', 'cish');?></a></div>
											<?php endif;?>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach;?>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php endwhile; endif;?>

<?php get_footer();?>