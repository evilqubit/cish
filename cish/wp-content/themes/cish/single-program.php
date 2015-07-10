<?php
$subPage = ( get_query_var('subpage') ) ? get_query_var('subpage') : '';
$paged = ( get_query_var('pagedCustom') ) ? get_query_var('pagedCustom') : 1;
$taxonomy = get_term_by('slug', $subPage, 'press-category');
$urlTaxonomy = $taxonomy;

// all custom fields for this program
$allCustomFields = ( get_fields(get_the_ID()) ) ? get_fields(get_the_ID()) : array();
$MAIN->setCurrentProgramCustomFields ($allCustomFields);

// Publications check
$args = array(
	'post_type' => 'publication',
	'posts_per_page' => 6,
	'meta_query' => array(
		array(
			'key' => 'program',
			'value' => get_the_ID(),
			'compare' => 'LIKE'
		)
	)
);
$wp_query = new WP_Query ( $args );
$MAIN->setCurrentProgramPublications ( $wp_query );
wp_reset_query();
wp_reset_postdata();

$args = array(
	'post_type' => 'event',
	'suppress_filters' => false,
	'paged'=> $paged,
	'showposts' => '-1',
	'meta_query' => array(
		array(
			'key' => 'program',
			'value' => get_the_ID(),
			'compare' => '='
		)
	)
);
$programEvents = get_posts($args);
$MAIN->setProgramEvents ($programEvents);
$allEventsIDs = array();
foreach ($programEvents as $entry){
	$allEventsIDs[] = $entry->ID;
}

if ( !empty ($allEventsIDs) ){
	
	$taxonomySlug = '';
	$englishPressReleases = get_term_by('slug', 'press-releases', 'press-category');
	$currentLanguageTaxID = icl_object_id(intval($englishPressReleases->term_id), $englishPressReleases->taxonomy, true, ICL_LANGUAGE_CODE);
	if ( intval($currentLanguageTaxID) > 0 ){
		remove_all_filters('get_term');
		$taxonomy = get_term_by('id', $currentLanguageTaxID, $englishPressReleases->taxonomy);
		$taxonomySlug = $taxonomy->slug;
	}
	$term_id = intval($taxonomy->term_id);
	$argsPressReleases = array(
		'post_type' => 'press-info',
		'suppress_filters' => false,
		'posts_per_page' => 6,
		'paged'=> $pagedCustom,
		'tax_query' => array(
			array(
				'taxonomy' => 'press-category',
				'field' => 'id',
				'terms' => $term_id
			)
		),
		'meta_query' => array(
			array(
				'key' => 'event',
				'value' => $allEventsIDs,
				'compare' => 'IN'
			)
		)
	);
	$qPressReleases = new WP_Query ( $argsPressReleases );
	$MAIN->setCurrentEventTaxonomies ($taxonomySlug, $qPressReleases );
	
	wp_reset_query();
	wp_reset_postdata();

	$taxonomySlug = '';
	$englishPressReleases = get_term_by('slug', 'press-room', 'press-category');
	$currentLanguageTaxID = icl_object_id(intval($englishPressReleases->term_id), $englishPressReleases->taxonomy, true, ICL_LANGUAGE_CODE);
	if ( intval($currentLanguageTaxID) > 0 ){
		remove_all_filters('get_term');
		$taxonomy = get_term_by('id', $currentLanguageTaxID, $englishPressReleases->taxonomy);
		$taxonomySlug = $taxonomy->slug;
	}
	$term_id = intval($taxonomy->term_id);
	$argsPressRooms = array(
		'post_type' => 'press-info',
		'posts_per_page' => 6,
		'paged'=> $pagedCustom,
		'tax_query' => array(
			array(
				'taxonomy' => 'press-category',
				'field' => 'id',
				'terms' => $term_id
			)
		),
		'meta_query' => array(
			array(
				'key' => 'event',
				'value' => $allEventsIDs,
				'compare' => 'IN'
			)
		)
	);
	$qPressRooms = new WP_Query ( $argsPressRooms );
	$MAIN->setCurrentEventTaxonomies ($taxonomySlug, $qPressRooms );
	wp_reset_query();
	wp_reset_postdata();
}

$args = array (
	'post_type' => 'event',
	'showposts' => 1,
	'meta_query' => array(
		'relation' => 'AND',
		array(
			'key' => 'gallery_cover',
			'value' => '',
			'compare' => '!='
		),
		array(
			'key' => 'program',
			'value' => get_the_ID(),
			'compare' => '=',
		)
	)
);
$wp_query = new WP_Query ( $args );
$MAIN->setCurrentProgramGallery ( $wp_query );
wp_reset_query();
wp_reset_postdata();
?>

<?php
$isDetailsSection = 0;
$isACFNormalPage = 0;
$isGallerySection = 0;
$isPublicationsSection = 0;
$isPressCategorySection = 0;

if ( $urlTaxonomy ){
	$isPressCategorySection = 1;
}

if ( $subPage ) :
	switch ($subPage) {
		default:
			$isACFNormalPage = 1;
		break;
		case 'details':
			$isDetailsSection = 1;
		break;
		case 'details':
			$isDetailsSection = 1;
		break;
		case 'gallery':
			$isGallerySection = 1;
		break;
		case 'publications':
			$isPublicationsSection = 1;
		break;
	}
endif;

if ( $isPressCategorySection ){
	includeProgramPressCategoryPage( $MAIN->getCurrentEventTaxonomy ($subPage) );
	exit;
}
if ( $isGallerySection ){
	includeProgramGalleryPage();
	exit;
}
if ( $isPublicationsSection ){
	includeProgramPublicationsPage();
	exit;
}
if ( $isDetailsSection ){
	includeProgramDetailsPage();
	exit;
}
if ( $isACFNormalPage ){
	$acfFieldName = str_replace('-', '_', $subPage);
	$presetData = $MAIN->getCurrentProgramCustomField($acfFieldName);
	includeProgramDetailsPage( $presetData );
	exit;
}
?>

<?php get_header();?>

<div id="section-program-single">
	<div class="container">
		<div class="row">
			
			<?php includeProgramMenu($wp_query->query_vars['subpage']);?>
			
			<div class="col-sm-8">
				<div class="block-w">
					<div class="head"><?php the_title();?> <?php _e('Events', 'cish');?></div>
					<?php if( $programEvents ) : ?>
						<?php foreach ($programEvents as $entry) :?>
							<?php $post = $entry;?>
							<?php setup_postdata($post);?>
							<div class="entry entry-listing entry-event">
								<div class="row">
									<div class="col-lg-4 col-sm-5">
										<div class="entry-image-w">
											<a href="<?php the_permalink();?>"><img class="img-responsive" src="<?php echo featuredImg();?>"/></a>
										</div>
									</div>
									<div class="col-lg-8 col-sm-7">
										<div class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></div>
										<div class="entry-content">
											<?php if ( get_the_excerpt() ) :?>
												<?php echo get_the_excerpt();?>
											<?php endif;?>
										</div>
									</div>
								</div>
								<?php $MAIN->doEventActions();?>
							</div>
						<?php endforeach;?>
						<?php _MyPagination();?>
					<?php
					else:
						includeNoResults();
					endif;
					?>
				</div>
			</div>
			
		</div>
	</div>
</div>

<?php get_footer();?>