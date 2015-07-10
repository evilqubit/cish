<?php get_header();?>

<?php
$s = ( get_query_var('s') ) ? get_query_var('s') : '';
$pagedCustom = ( get_query_var('pagedCustom') ) ? get_query_var('pagedCustom') : 1;
?>

<?php
$args = array (
	'post_type'=> 'program',
	'showposts'=> 12,
	's' => $s
);
$wp_query = new WP_Query($args);
?>
<div id="section-latest-programs">
	<div class="container">
		<div class="block-w">
			<div class="head"><?php _e('Programs', 'cish');?></div>
			<?php include (locate_template('reusable/loop-inline-entries.php'));?>
		</div>
	</div>
</div>

<?php
$args = array (
	'post_type'=> 'event',
	'showposts'=> 12,
	's' => $s,
	'meta_key'=> 'date',
	'orderby' => 'meta_value',
	'order' => 'DESC'
);
$wp_query = new WP_Query($args);
?>
<div id="section-latest-events">
	<div class="container">
		<div class="block-w">
			<div class="head"><?php _e('Events', 'cish');?></div>
			<?php include (locate_template('reusable/loop-inline-entries.php'));?>
		</div>
	</div>
</div>

<?php
$args = array (
	'post_type'=> 'press-info',
	'showposts'=> 12,
	's' => $s
);
$wp_query = new WP_Query($args);
?>
<div id="section-latest-press">
	<div class="container">
		<div class="block-w">
			<div class="head"><?php _e('Press', 'cish');?></div>
			<?php include (locate_template('reusable/loop-press.php'));?>
		</div>
	</div>
</div>

<?php
$args = array(
	'post_type' => 'publication',
	'posts_per_page' => 12,
	'paged'=> $pagedCustom,
	's'=> $s
);
?>
<div id="section-publications-listing">
	<div class="container">
		<div class="block-w">
			<div class="head"><?php _e('Publications','cish');?></div>
			<?php $wp_query = new WP_Query( $args ); ?>
			<?php include (locate_template('reusable/loop-publications.php'));?>
		</div>
	</div>
</div>

<div id="section-latest-programs">
	<div class="container">
		<div class="block-w">
			<div class="head"><?php _e('Sitemap', 'cish');?></div>
			<ul class="sitemap">
				<?php wp_list_pages(
					array(
						'exclude' => '',
						'title_li' => '',
					)
				);?>
			</ul>
		</div>
	</div>
</div>

<?php get_footer();?>