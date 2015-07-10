<?php
// Publications check
$subPage = ( get_query_var('subpage') ) ? get_query_var('subpage') : '';
$pagedCustom = ( get_query_var('pagedCustom') ) ? get_query_var('pagedCustom') : 1;
$taxonomy = get_term_by('slug', $subPage, 'press-category');
$urlTaxonomy = $taxonomy;

// all custom fields for this program
$allCustomFields = ( get_fields(get_the_ID()) ) ? get_fields(get_the_ID()) : array();
$MAIN->setCurrentEventCustomFields ($allCustomFields);

$argsPublications = array(
	'post_type' => 'publication',
	'posts_per_page' => 6,
	'suppress_filters' => false,
	'paged' => $pagedCustom,
	'meta_query' => array(
		array(
			'key' => 'event',
			'value' => get_the_ID(),
			'compare' => '='
		)
	)
);
$qPublications = new WP_Query ( $argsPublications );
$MAIN->setCurrentEventPublications ( $qPublications );
wp_reset_query();
wp_reset_postdata();

$pressReleasesSlug = '';
if ( isset ($taxonomy->slug) && !empty($taxonomy->slug) ){
	$pressReleasesSlug = $taxonomy->slug;
}
else{
	$englishPressReleases = get_term_by('slug', 'press-releases', 'press-category');
	$currentLanguageTaxID = icl_object_id(intval($englishPressReleases->term_id), $englishPressReleases->taxonomy, true, ICL_LANGUAGE_CODE);
	if ( intval($currentLanguageTaxID) > 0 ){
		remove_all_filters('get_term');
		$taxonomy = get_term_by('id', $currentLanguageTaxID, $englishPressReleases->taxonomy);
	}
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
			'value' => get_the_ID(),
			'compare' => '='
		)
	)
);
$qPressReleases = new WP_Query ( $argsPressReleases );
$MAIN->setCurrentEventTaxonomies ($taxonomy->slug, $qPressReleases );
wp_reset_query();
wp_reset_postdata();

$pressReleasesSlug = '';
if ( isset ($taxonomy->slug) && !empty($taxonomy->slug) ){
	$pressReleasesSlug = $taxonomy->slug;
}
else{
	$englishPressReleases = get_term_by('slug', 'press-room', 'press-category');
	$currentLanguageTaxID = icl_object_id(intval($englishPressReleases->term_id), $englishPressReleases->taxonomy, true, ICL_LANGUAGE_CODE);
	if ( intval($currentLanguageTaxID) > 0 ){
		remove_all_filters('get_term');
		$taxonomy = get_term_by('id', $currentLanguageTaxID, $englishPressReleases->taxonomy);
	}
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
			'value' => get_the_ID(),
			'compare' => '='
		)
	)
);
$qPressRooms = new WP_Query ( $argsPressRooms );
$MAIN->setCurrentEventTaxonomies ($taxonomy->slug, $qPressRooms );
wp_reset_query();
wp_reset_postdata();

?>

<?php
$isLanding = 1;
$isACFNormalPage = 0;
$isPressSection = 0;
$isNormalSection = 0;
$isPublicationsSection = 0;
$isGallerySection = 0;
$isRegistrationSection = 0;

if ( $urlTaxonomy ){
	$isPressSection = 1;
}
else{
	if ( $subPage ){
		switch ($subPage){
			default:
				$isACFNormalPage = 1;
			break;
			case 'gallery':
				$isGallerySection = 1;
			break;
			case 'publications':
				$isPublicationsSection = 1;
			break;
			case 'registration':
				$isRegistrationSection = 1;
			break;
		}
	}
	if ( $isGallerySection ){
		includeGalleryPage();
		exit;
	}
	if ( $isRegistrationSection ){
		includeEventRegistrationPage();
		exit;
	}
	
	if ( $isACFNormalPage ){
		$acfFieldName = str_replace('-', '_', $subPage);
		$presetData = $MAIN->getCurrentEventCustomField($acfFieldName);
		includeEventNormalPage( $presetData );
		exit;
	}
	
}
?>

<?php get_header();?>

<?php
if ( have_posts() ) : while (have_posts()) : the_post();
//$gallery = get_field('gallery');
// $program = get_field('program');
// $galleryLimit = 6;
?>

<div id="section-program-single">
	<div class="container">
		<div class="row">
			
			<?php includeEventMenu($wp_query->query_vars['subpage']);?>
			
			<?php if ( $isLanding && !$subPage ) :?>
				<div class="col-sm-8">
					<div class="block-w">
						<div class="row">
							<div class="col-sm-12">
								<div class="head"><?php the_title();?></div>
								<div id="single-program-info">
									<?php the_content();?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif;?>
			
			<?php if( $isPublicationsSection ) :?>
				<div class="col-sm-8">
					<div class="block-w">
						<div class="head"><?php _e('Publications','cish');?></div>
						<?php
						$wp_query = $qPublications;
						$args = $argsPublications;
						?>
						<?php include (locate_template('reusable/loop-publications.php'));?>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if( $isPressSection ) :?>
				<div class="col-sm-8">
					<div class="block-w">
						<div class="head"><?php _e('Press Releases','cish');?></div>
						<?php $wp_query = $MAIN->getCurrentEventTaxonomy( $taxonomy->slug );?>
						<?php include (locate_template('reusable/loop-press.php'));?>
					</div>
				</div>
			<?php endif;?>
			
		</div>
	</div>
</div>

<?php endwhile; endif;?>

<?php get_footer();?>