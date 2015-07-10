<?php
/*
Template Name: center| main
*/
get_header();
?>

<?php
$pageSlug = _GetCurrentPageSlug();
$subpage = ( get_query_var('subpage') ) ? get_query_var('subpage') : '';
$detailsSection = ( $subpage == 'details' ) ? 1 : 0;

// All member Types
$allMemberTypes = $MAIN->getCustomField('field_54d68a63f3ecd');
if ( array_key_exists($subpage, $allMemberTypes['choices']) ){
	includeCenterMembersListing();
	exit;
}

$centerMenu = $MAIN->getCenterPageEntries();
$centerPages = array();
foreach ($centerMenu as $entry) :
	$centerPages[$entry->post_name] = $entry;
endforeach;

$boardMembers = get_posts(array(
	'suppress_filters' => false,
	'post_type' => 'profile',
	'showposts' => '5',
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'meta_query' => array(
		array(
			'key' => 'member_type',
			'value' => 'board-members',
			'compare' => 'LIKE'
		)
	)
));
?>

<div id="section-center-main">
	<div class="container">
		<div class="row">
		
			<?php
			$pageSlug = ($detailsSection) ? 'details' : $pageSlug;
			includeCenterMenu($pageSlug);
			?>

			<div class="col-sm-8">
				<div class="block-w">
					<div class="head"><?php _e('Details', 'cish');?></div>
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
							
								<?php if ( !$detailsSection ) :?>
									<div class="entry-content">
										<?php if ( get_the_excerpt() ) :?>
										<?php the_excerpt();?>
											<div class="more">
												<a href="<?php echo $MAIN->getPermalink('center');?>details"><?php _e('more', 'cish');?></a>
											</div>
										<?php endif;?>
									</div>
								<?php else :?>
									<div class="entry-content">
										<?php the_content();?>
									</div>
								<?php endif;?>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="section-center-functions">
	<div class="container">	
		<div class="block-w">
			<div class="head"><?php echo $centerPages['functions']->post_title;?></div>
			<div class="entry entry-listing">
				<div class="row">
					<div class="col-md-4 col-sm-12 col-sm-full">
						<div class="entry-image-w">
							<a href="<?php echo featuredImg($centerPages['functions']->ID);?>" class="fancybox">
								<img class="img-responsive" src="<?php echo featuredImg($centerPages['functions']->ID);?>"/>
							</a>
						</div>
					</div>
					<div class="col-md-8 col-sm-12">
						<div class="entry-content">
							<?php if ( $centerPages['functions']->post_excerpt ) :?>
							<?php echo $centerPages['functions']->post_excerpt;?>
								<div class="more">
									<a href="<?php echo get_permalink($centerPages['functions']->ID);?>"><?php _e('more', 'cish');?></a>
								</div>
							<?php endif;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="section-center-achievements">
	<div class="container">
		<div class="block-w">
			<div class="head"><?php echo $centerPages['objectives']->post_title;?></div>
			<div class="entry entry-listing">
				<div class="row">
					<div class="col-sm-5">
						<a class="fancybox" href="<?php echo featuredImg($centerPages['objectives']->ID);?>"><img class="img-responsive" src="<?php echo featuredImg($centerPages['objectives']->ID);?>"/></a>
					</div>
					<div class="col-sm-7">
						<div class="entry-content">
							<?php if ( $centerPages['objectives']->post_excerpt ) :?>
							<?php echo $centerPages['objectives']->post_excerpt;?>
								<div class="more">
									<a href="<?php echo get_permalink($centerPages['objectives']->ID);?>"><?php _e('more', 'cish');?></a>
								</div>
							<?php endif;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
<div id="section-center-main-board-members">
	<div class="container">
		<div class="block-w">
			<div class="head"><?php _e('Board Members','cish');?><a class="view-all" href="<?php $MAIN->getPermalink('center/board-members')?>"><?php _e('View All','cish');?></a></div>
			<div class="row">
				<?php if( $boardMembers ) :?>
					<?php foreach( $boardMembers as $post ) : setup_postdata( $post ); ?>
						<div class="col-lg-2 col-sm-4">
							<div class="entry">
								<a class="entry-image" href="<?php the_permalink();?>"><img class="img-responsive" src="<?php echo featuredImg();?>"/></a>
								<div class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></div>
							</div>
						</div>
					<?php endforeach;?>
					<?php wp_reset_postdata();?>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>

<?php get_footer();?>