<?php
/* Sidebars */
if (function_exists('register_sidebar')){
	register_sidebar(array(
	'name' => 'Sidebar Footer',
	'id' => 'sidebar-footer',
	'before_widget' => '<div class="sidebar-box">',
	'after_widget' => '</div></div>',
	'before_title' => '<div class="widget-title"><span class="w-title">',
	'after_title' => '</span></div><div class="widget-content">'
	));
}
?>