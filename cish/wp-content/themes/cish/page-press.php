<?php
$isInfoSection = 0;
$isTaxonomySection = 0;
$taxonomy = '';
$subpage = ( get_query_var('subpage') ) ? get_query_var('subpage') : '';
if ( $subpage ) :
	switch ($subpage) {
		default:
			// default is the taxonomy page
			$isTaxonomySection = 1;
			$taxonomy = get_term_by('slug', $subpage, 'press-category');
			if ( !$taxonomy ){
				wp_redirect( home_url() ); exit;
			}
			else{
				includePressListing();
				exit;
			}
		break;
		case 'info':
			$isInfoSection = 1;
		break;
	}
	if ( $isInfoSection ){
		includeNormalPage();
		exit;
	}
endif;
?>

<?php
/*
Template Name: press | main
*/
get_header();?>
	
<?php
$terms = get_terms(
	'press-category', array(
		'orderby' => 'count',
		'hide_empty' => 0,
));

foreach ($terms as $term) :
	$originalTerm = $MAIN->getOriginalTerm($term->slug);
	?>
	<div id="section-press-<?php echo $term->name;?>">
		<div class="container">
			<div class="block-w">
				<div class="head">
					<?php echo $term->name;?> <a href="<?php $MAIN->getPermalink('press');?><?php echo $originalTerm->slug;?>"><?php _e('View All','cish');?></a>
				</div>
				<?php
				$term_id = intval($term->term_id);
				$args = array (
					'post_type' => 'press-info',
					'suppress_filters' => false,
					'posts_per_page' => 4,
					'tax_query' => array(
						array(
							'taxonomy' => 'press-category',
							'field' => 'id',
							'terms' => $term_id
						)
					)
				);
				$data = new WP_Query ($args);
				$noPagination = 1;
				?>
				<?php include (locate_template('reusable/loop-press.php'));?>
			</div>
		</div>
	</div>
<?php endforeach;?>

<?php get_footer();?>