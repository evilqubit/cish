<?php
global $post;
global $MAIN;

$activeSection = ( isset ($activeSection) ) ? $activeSection : '';
$activeSectionA = array ($activeSection => 'active');

$centerPageID = ( isset($centerPageID) ) ? $centerPageID : _GetPostIDCurrentLanguage('center');

// get all subpages of Center page
$centerMenu = ( isset($centerMenu) ) ? $centerMenu : new WP_Query ('post_type=page&post_parent='.$centerPageID.'&orderby=menu_order&order=ASC');
?>
<div class="col-sm-4">
	<div class="block-w menu-inpage">
		<div id="single-center-administration" class="panel-menu">
			<div class="head"><?php _e('Center', 'cish');?></div>
			<ul><?php $MAIN->getCenterPageMenu($activeSection);?></ul>
		</div>
	</div>
</div>