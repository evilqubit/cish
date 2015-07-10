<?php
global $wp_query;
global $MAIN;
$pagedCustom = ( get_query_var('pagedCustom') ) ? get_query_var('pagedCustom') : 1;
$subpage = ( get_query_var('subpage') ) ? get_query_var('subpage') : '';
$taxonomy = get_term_by('slug', $subpage, 'press-category');

if ( !$taxonomy ) :
	wp_redirect( home_url() ); exit;
endif;
?>

<?php get_header();?>

<div id="section-program-gallery">
	<div class="container">
		<div class="row">

			<?php includeProgramMenu($subpage);?>
		
			<div class="col-sm-8">
				<div class="block-w">
					<div class="head"><?php echo $taxonomy->name;?></div>
					<?php
					$taxonomySlug = '';
					$englishPressReleases = get_term_by('slug', $subpage, 'press-category');
					$currentLanguageTaxID = icl_object_id(intval($englishPressReleases->term_id), $englishPressReleases->taxonomy, true, ICL_LANGUAGE_CODE);
					if ( intval($currentLanguageTaxID) > 0 ){
						remove_all_filters('get_term');
						$taxonomy = get_term_by('id', $currentLanguageTaxID, $englishPressReleases->taxonomy);
						$taxonomySlug = $taxonomy->slug;
					}
					$data = $MAIN->getCurrentEventTaxonomy( $taxonomySlug );
					// $noPagination = 1;
					?>
					<?php include (locate_template('reusable/loop-press.php'));?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer();?>