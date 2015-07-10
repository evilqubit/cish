<?php
$subpage = ( get_query_var('subpage') ) ? get_query_var('subpage') : '';
$pagedCustom = ( get_query_var('pagedCustom') ) ? get_query_var('pagedCustom') : 1;
$taxonomy = get_term_by('slug', $subpage, 'press-category');

if ( !$taxonomy ) :
	wp_redirect( home_url() ); exit;
endif;

get_header();
?>

<div id="section-press-listing">
	<div class="container">
		<div class="block-w">
			<div class="head"><?php echo $taxonomy->name;?></div>
			
			<?php
			$taxonomyID = '';
			$englishPressReleases = get_term_by('slug', $subpage, 'press-category');
			$currentLanguageTaxID = icl_object_id(intval($englishPressReleases->term_id), $englishPressReleases->taxonomy, true, ICL_LANGUAGE_CODE);
			if ( intval($currentLanguageTaxID) > 0 ){
				remove_all_filters('get_term');
				$taxonomy = get_term_by('id', $currentLanguageTaxID, $englishPressReleases->taxonomy);
				$taxonomyID = $taxonomy->term_id;
			}
			$args = array (
				'post_type' => 'press-info',
				'suppress_filters' => false,
				'posts_per_page' => 8,
				'paged' => $pagedCustom,
				'tax_query' => array(
					array(
						'taxonomy' => 'press-category',
						'field' => 'id',
						'terms' => $taxonomyID
					)
				)
			);
			$data = new WP_Query ($args);
			// var_dump($data);
			?>
			<?php include (locate_template('reusable/loop-press.php'));?>
		</div>
	</div>
</div>

<?php get_footer();?>