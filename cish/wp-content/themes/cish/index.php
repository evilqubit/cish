<?php get_header();?>

<?php
$args = array (
	'post_type'=> 'event',
	'showposts'=> 12,
	'meta_key'=> 'date',
	'orderby' => 'meta_value',
	'order' => 'DESC'
);
$wp_query = new WP_Query($args);
?>
<div id="section-latest-events">
	<div class="container">
		<div class="block-w">
			<div class="head"><?php _e('Latest Events', 'cish');?></div>
			<?php include (locate_template('reusable/loop-inline-entries.php'));?>
		</div>
	</div>
</div>

<?php
$statsPrograms = new WP_Query('post_type=program&showposts=-1');
$statsPublications = new WP_Query('post_type=publication&showposts=-1');

$programConferencesID = _GetPostIDCurrentLanguage ('conferences', 'program');
$statsConferences = 0;
if ( $programConferencesID > 0 ) :
	$statsEvents = new WP_Query(
		array(
			'post_type' => 'event',
			'showposts' => '-1',
			'meta_query' => array(
				array(
					'key' => 'program',
					'value' => $programConferencesID,
					'compare' => '='
				)
			)
		)
	);
	$statsConferences = $statsEvents->found_posts;
endif;

$stats = array (
	'programs' => $statsPrograms->found_posts,
	'events' => $statsConferences,
	'publications' => $statsPublications->found_posts
);
?>
<div id="section-statistics">
	<div class="container">
		<div class="block-w">
			<div class="row">
				<div class="col-sm-3">
					<img class="img-responsive" src="<?php bloginfo('stylesheet_directory');?>/assets/img/icon-stats-students.png" />
					<div class="stats">
						<span><?php echo $MAIN->replaceArabicNum($MAIN->getSetting('students_count', 1));?></span>
						<span><?php _e('Students','cish');?></span>
					</div>
				</div>
				<div class="col-sm-3">
					<img class="img-responsive" src="<?php bloginfo('stylesheet_directory');?>/assets/img/icon-stats-projects.png" />
					<div class="stats">
						<span><?php echo $MAIN->replaceArabicNum($stats['programs']);?></span>
						<span><?php _e('Projects','cish');?></span>
					</div>
				</div>
				<div class="col-sm-3">
					<img class="img-responsive" src="<?php bloginfo('stylesheet_directory');?>/assets/img/icon-stats-conferences.png" />
					<div class="stats">
						<span><?php echo $MAIN->replaceArabicNum($stats['events'])?></span>
						<span><?php _e('Conferences','cish');?></span>
					</div>
				</div>
				<div class="col-sm-3">
					<img class="img-responsive" src="<?php bloginfo('stylesheet_directory');?>/assets/img/icon-stats-publications.png" />
					<div class="stats">
						<span><?php echo $MAIN->replaceArabicNum($stats['publications']);?></span>
						<span><?php _e('Books','cish');?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="section-calendar">
	<div class="container">
		<div class="block-w">
			<div class="row">
				<div class="col-md-4">
					<div class="head"><?php _e('Calendar', 'cish');?></div>
					<div id="calendar-events-w">
						<div id="calendar-events"></div>
					</div>
				</div>
				
				<?php if ( $MAIN->getSetting ('featured_program_informative', 1) ) :?>
					<?php $entryID = _GetPostIDByIDForCurrentLang ( $MAIN->getSetting ('featured_program_informative', 1), 'program' );?>
					<div class="col-md-4 col-inline-images">
						<div class="head"><?php _e('Informative Programs', 'cish');?></div>
						<div class="entry tinted">
							<div class="entry-image-w">
								<a class="entry-image" href="<?php echo get_the_permalink($entryID);?>"><img class="img-responsive" src="<?php echo featuredImg($entryID);?>"/>
									<div class="overlay">
										<?php if ( get_post_field('post_excerpt', $entryID) ) :?>
											<h2 class="excerpt"><?php echo get_post_field('post_excerpt', $entryID);?></h2>
										<?php endif;?>
										<h1 class="title"><?php echo get_the_title($entryID)?></h1>
									</div>
								</a>
							</div>
						</div>
					</div>
				<?php endif;?>
				
				<?php if ( $MAIN->getSetting ('featured_program_practice', 1) ) :?>
					<?php $entryID = _GetPostIDByIDForCurrentLang ( $MAIN->getSetting ('featured_program_practice', 1), 'program' );?>
					<div class="col-md-4 col-inline-images">
						<div class="head"><?php _e('Practice Programs', 'cish');?></div>
						<div class="entry tinted">
							<div class="entry-image-w">
								<a class="entry-image" href="<?php echo get_the_permalink($entryID);?>"><img class="img-responsive" src="<?php echo featuredImg($entryID);?>"/>
									<div class="overlay">
										<?php if ( get_post_field('post_excerpt', $entryID) ) :?>
											<h2 class="excerpt"><?php echo get_post_field('post_excerpt', $entryID);?></h2>
										<?php endif;?>
										<h1 class="title"><?php echo get_the_title($entryID)?></h1>
									</div>
								</a>
							</div>
						</div>
					</div>
				<?php endif;?>
				
			</div>
		</div>
	</div>
</div>

<?php
$args = array (
	'post_type' => 'event',
	'showposts' => 12,
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
<div id="section-latest-events">
	<div class="container">
		<div class="block-w">
			<div class="head"><?php _e('Photo Gallery', 'cish');?></div>
			<?php
			$urlAdditions = 'gallery';
			$showExcerpt = 'f';
			$showGalleryCover = 'y';
			?>
			<?php include (locate_template('reusable/loop-inline-entries.php'));?>
		</div>
	</div>
</div>

<?php
$publications = get_posts(
	array(
		'post_type' => 'publication',
		'posts_per_page' => '5',
		'meta_key' => 'date',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'suppress_filters' => false
	)
);
?>
<?php if ( $publications ) :?>
	<div id="section-publications">
		<div class="container">
			<div class="block-w">
				<div class="head"><?php _e('Publications', 'cish');?></div>
				<div id="publications-table">
					<img id="image-wooden-table" class="img-responsive" src="<?php bloginfo('stylesheet_directory');?>/assets/img/icon-publications-table.jpg" />
					
					<?php
					// the latest publication needs to be in the center of all others, so we display everything manually to control the order
					?>
					<div class="entries clearfix">
					
						<?php if ( isset ($publications[1]) ) :?>
							<?php $entry = $publications[1];?>
							<div class="entry-publication-table">
								<div class="entry">
									<a href="<?php echo get_the_permalink($entry->ID);?>"><img class="img-responsive" src="<?php echo featuredImg($entry->ID);?>" /></a>
								</div>
							</div>
						<?php endif;?>
						
						<?php if ( isset ($publications[2]) ) :?>
							<?php $entry = $publications[2];?>
							<div class="entry-publication-table">
								<div class="entry">
									<a href="<?php echo get_the_permalink($entry->ID);?>"><img class="img-responsive" src="<?php echo featuredImg($entry->ID);?>" /></a>
								</div>
							</div>
						<?php endif;?>
						
						<?php if ( isset ($publications[0]) ) :?>
							<?php $entry = $publications[0];?>
							<div class="entry-publication-table">
								<div class="entry active">
									<a href="<?php echo get_the_permalink($entry->ID);?>"><img class="img-responsive" src="<?php echo featuredImg($entry->ID);?>" /></a>
								</div>
							</div>
						<?php endif;?>
						
						<?php if ( isset ($publications[3]) ) :?>
							<?php $entry = $publications[3];?>
							<div class="entry-publication-table">
								<div class="entry">
									<a href="<?php echo get_the_permalink($entry->ID);?>"><img class="img-responsive" src="<?php echo featuredImg($entry->ID);?>" /></a>
								</div>
							</div>
						<?php endif;?>
						
						<?php if ( isset ($publications[4]) ) :?>
							<?php $entry = $publications[4];?>
							<div class="entry-publication-table">
								<div class="entry">
									<a href="<?php echo get_the_permalink($entry->ID);?>"><img class="img-responsive" src="<?php echo featuredImg($entry->ID);?>" /></a>
								</div>
							</div>
						<?php endif;?>
						
					</div>
					
				</div>
			</div>
		</div>
	</div>
<?php endif;?>

<script>
 
$(document).ready(function(){
	if ( $(".owl-carousel").length ){
		$(".owl-carousel").owlCarousel({
			<?php if ( $MAIN->isLang('ar') ) :?>
				direction: "rtl",
			<?php endif;?>
			items : 4,
			itemsDesktop : [1199,4],
			itemsDesktopSmall : [980,3],
			itemsTablet: [768,2],
			itemsTabletSmall: false,
			itemsMobile : [479,1],
			pagination: true,
		});
	}
});
</script>

<?php get_footer();?>