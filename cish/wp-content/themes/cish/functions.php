<?php
/* Wordpress Backend Customizations */
include (TEMPLATEPATH.'/custom/dashboard-custom.php');

/* Sidebar */
include (TEMPLATEPATH.'/custom/sidebar-custom.php');

/* Wordpress General functions */
include (TEMPLATEPATH.'/custom/general-custom.php');

/* MAIN */
include (TEMPLATEPATH.'/custom/class.main.php');

/* psettngs */
include (TEMPLATEPATH.'/custom/psettings.php');

/* Ajax Custom */
include (TEMPLATEPATH.'/custom/ajax-custom.php');

// Disable admin bar
add_action('init','myRemAdBar');
add_action('admin_menu', 'remove_menus', 999);
add_action( 'init', 'my_add_excerpts_to_pages' );

// Ajax Actions
// check custom/ajax_custom.php file for the functions
if ( is_admin() ) {
	add_action( 'wp_ajax_send_contact_email', 'send_contact_email' );
	add_action( 'wp_ajax_nopriv_send_contact_email', 'send_contact_email' );
	add_action( 'wp_ajax_send_event_register_email', 'send_event_register_email' );
	add_action( 'wp_ajax_nopriv_send_event_register_email', 'send_event_register_email' );
}

/* Scripts */
add_action( 'wp_enqueue_scripts', 'myThemeScripts');
function myThemeScripts (){
	$template_dir = get_template_directory_uri().'/';

	wp_deregister_script('jquery');
	wp_register_script('jquery', $template_dir.'assets/js/jquery.min.js', false, null);
	wp_enqueue_script('jquery');

	wp_localize_script ('frontend-ajax', 'frontendajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
	wp_enqueue_script ('main_js', $template_dir.'assets/js/all.js', array('jquery'), '', true);
	
	wp_enqueue_style ('bootstrap', $template_dir.'assets/css/bootstrap.min.css');
	if ( ICL_LANGUAGE_CODE == 'ar'){
		wp_enqueue_style ('bootstrap-rtl', $template_dir.'assets/css/bootstrap-rtl.css');
	}
	wp_enqueue_style ('fancybox', $template_dir.'assets/css/fancybox/jquery.fancybox.css');
	wp_enqueue_style ('zabuto_calendar', $template_dir.'assets/css/zabuto_calendar.min.css');
	wp_enqueue_style ('flexslider', $template_dir.'assets/css/flexslider.css');
	wp_enqueue_style ('main', $template_dir.'style.css');
		
	if ( ICL_LANGUAGE_CODE == 'ar'){
		wp_enqueue_style ('main-ar', $template_dir.'style-ar.css');
	}
}

/* Custom post types */
add_action( 'init', 'create_custom_posts' );
function create_custom_posts () {
	register_post_type( 'program',
		array(
			'labels' => array(
				'name' => __( 'Programs' ),
				'singular_name' => __( 'Program' )
			),
		'public' => true,
		'supports' => array ('title', 'editor','thumbnail','page-attributes', 'excerpt')
		)
	);
	register_post_type( 'event',
		array(
			'labels' => array(
				'name' => __( 'Events' ),
				'singular_name' => __( 'Event' )
			),
		'public' => true,
		'supports' => array ('title', 'editor','thumbnail','page-attributes', 'excerpt')
		)
	);
	register_post_type( 'profile',
		array(
			'labels' => array(
				'name' => __( 'Profiles' ),
				'singular_name' => __( 'Profile' )
			),
		'public' => true,
		'supports' => array ('title', 'editor','thumbnail','page-attributes', 'excerpt')
		)
	);
	
	register_post_type( 'press-info',
		array(
			'labels' => array(
				'name' => __( 'Press' ),
				'singular_name' => __( 'Press' )
			),
		'public' => true,
		'supports' => array ('title', 'editor','thumbnail','page-attributes', 'excerpt')
		)
	);
	register_taxonomy(
	  'press-category',
	  'press-info',
	  array(
			'labels' => array(
				 'name' => 'Press Categories',
				 'add_new_item' => 'Add New Press Category',
				 'new_item_name' => 'New Press Category'
			),
			'show_ui' => true,
			'show_tagcloud' => false,
			'hierarchical' => true,
			'rewrite' => array('slug'=>'press')
	  )
 	);
	
	register_post_type( 'publication',
		array(
			'labels' => array(
				'name' => __( 'Publications' ),
				'singular_name' => __( 'Publication' )
			),
		'public' => true,
		'supports' => array ('title', 'editor','thumbnail','page-attributes', 'excerpt')
		)
	);
}

function includeCenterMenu($activeSection=''){
	include (locate_template('reusable/menu-panel-center.php'));
}
function includeProgramMenu($activeSection=''){
	$activeSection = ( $activeSection ) ? $activeSection : '';
	include (locate_template('reusable/menu-panel-program.php'));
}
function includeEventMenu($activeSection=''){
	$activeSection = ( $activeSection ) ? $activeSection : '';
	include (locate_template('reusable/menu-panel-event.php'));
}
function includeProgramEvents(){
	global $MAIN;
	include (locate_template('page-program-events.php'));
}
function includeCenterMembersListing(){
	include (locate_template('page-center-profiles.php'));
}
function includeEventNormalPage($presetData = ''){
	$data = $presetData;
	include (locate_template('page-event-normal.php'));
}
function includeProgramDetailsPage($presetData = ''){
	$data = $presetData;
	include (locate_template('page-program-details.php'));
}
function includeProgramGalleryPage(){
	include (locate_template('page-program-gallery.php'));
}
function includeProgramPublicationsPage(){
	include (locate_template('page-program-publications.php'));
}
function includeProgramPressCategoryPage($presetData = ''){
	$data = $presetData;
	include (locate_template('page-program-press-category.php'));
}
function includeEventRegistrationPage(){
	include (locate_template('page-event-registration.php'));
}
function includeNormalPage(){
	include (locate_template('page.php'));
}
function includeSingleMediaAlbum(){
	include (locate_template('reusable/single-media-album.php'));
}
function includeGalleryPage(){
	include (locate_template('reusable/layout-gallery.php'));
}
function includePressListing(){
	include (locate_template('page-press-listing.php'));
}
function includeNoResults(){
	include (locate_template('reusable/no-results.php'));
}

function rewrite_rules_urls(){
	add_rewrite_tag('%subpage%', '([^&]+)');
	add_rewrite_tag('%pagedCustom%', '([^&]+)');
	add_rewrite_tag('%album%', '([^&]+)');
	
	add_rewrite_rule(
		'program/([^/]*)/?([^/]*)(/page/([0-9]+)?)?/?$',
		'index.php?program=$matches[1]&subpage=$matches[2]&pagedCustom=$matches[4]',
		'top'
	);
	add_rewrite_rule(
		'event/([^/]*)/?([^/]*)(/page/([0-9]+)?)?/?$',
		'index.php?event=$matches[1]&subpage=$matches[2]&pagedCustom=$matches[4]',
		'top'
	);
	add_rewrite_rule(
		'press/([^/]*)/?([^/]*)(/page/([0-9]+)?)?/?$',
		'index.php?pagename=press&subpage=$matches[1]&pagedCustom=$matches[4]',
		'top'
  );
	add_rewrite_rule(
		'center/profiles/([^/]*)?/?$',
		'index.php?pagename=center&subpage=$matches[1]',
		'top'
	);
	add_rewrite_rule(
		'gallery/gallery/([^/]*)?/?$',
		'index.php?pagename=gallery&album=$matches[1]',
		'top'
	);
  flush_rewrite_rules();
}
add_action('init', 'rewrite_rules_urls');

add_filter( 'wpseo_breadcrumb_links', 'wpse_100012_override_yoast_breadcrumb_trail' );
function wpse_100012_override_yoast_breadcrumb_trail( $links ) {
	global $post;
	global $wp_query;
	global $MAIN;
	
	$links[0]['text'] = __('Home','cish');
	$breadcrumb[] = $links[0];
	
	if ( is_page ('press') ){
		$subpage = ( get_query_var('subpage') ) ? get_query_var('subpage') : '';
		$breadcrumb[] = array(
			'url' => _GetPagePermalinkBySlug('press', 1),
			'text' => __('Press', 'cish')
		);
		if ( $subpage == 'info' ){
			$breadcrumb[] = array(
				'text' => 'Info'
			);
		}
		else{
			$taxonomy = get_term_by('slug', $wp_query->query_vars['subpage'], 'press-category');
			if ( $taxonomy ) :
				$breadcrumb[] = array(
					'text' => $taxonomy->name
				);
			endif;
		}
		$links = $breadcrumb;
	}
	elseif ( is_page ('gallery') ){
		$albumID = ( get_query_var('album') ) ? get_query_var('album') : 0;
		if ( $albumID > 0 ){
			$albumID = $albumID - 1;
			
			$currentID = get_post($links[1]['id']);
			
			$galleryPage = get_page_by_path('gallery/gallery');
			$albums = get_field ('albums', $galleryPage->ID);
			$albumName = '';
			if ( isset ($albums[$albumID]) ){
				$albumName = $albums[$albumID]['album_title'];
			}
			$breadcrumb[] = array(
				'url' => get_permalink($currentID->ID),
				'text' => $currentID->post_title
			);
			$breadcrumb[] = array(
				'url' => _GetPagePermalinkBySlug('gallery/gallery', 1),
				'text' => __('Albums', 'cish')
			);
			$breadcrumb[] = array(
				'text' => $albumName
			);
			
			$links = $breadcrumb;
		}
	}
	elseif ( is_singular('event') ){
		$program = get_field('program', $post->ID);
		if ( $program ) :
			$currentID = get_post($links[1]['id']);
			
			$breadcrumb[] = array(
				'url' => get_permalink($program->ID),
				'text' => $program->post_title
			);
			$breadcrumb[] = array(
				'url' => get_permalink($currentID->ID),
				'text' => $currentID->post_title
			);
			if ( isset($wp_query->query_vars['subpage']) ){
				$breadcrumb[] = array('text' => ucwords( str_replace('-', ' ', $MAIN->translateManual($wp_query->query_vars['subpage']) )) );
			}
			$links = $breadcrumb;
			//array_splice( $links, 1, -2, $breadcrumb );
		endif;
	}
	elseif ( is_singular('program') ){
		$currentID = get_post($links[1]['id']);
		
		$breadcrumb[] = array(
			'url' => get_permalink($currentID->ID),
			'text' => $currentID->post_title
		);
		
		if ( isset($wp_query->query_vars['subpage']) ){
			$breadcrumb[] = array('text' => ucwords( str_replace('-', ' ', $MAIN->translateManual($wp_query->query_vars['subpage']) )) );
		}
		$links = $breadcrumb;
		//array_splice( $links, 1, -2, $breadcrumb );
	}
	elseif ( is_singular('profile') ){
		$currentID = get_post($links[1]['id']);
		$breadcrumb[] = array(
			'url' => _GetPagePermalinkBySlug('center',1),
			'text' => __('Center','cish')
		);
		$memberType = get_field('member_type', $currentID);
		$memberTypeTitle = ucwords(str_replace('-',' ', $memberType));

		$breadcrumb[] = array(
			'url' => _GetPagePermalinkBySlug('center/'.$memberType, 1),
			'text' => $memberTypeTitle
		);
		$breadcrumb[] = array(
			'url' => get_permalink($currentID->ID),
			'text' => $currentID->post_title
		);
		$links = $breadcrumb;
	}
	elseif ( is_singular('press-info') ){
		$currentID = get_post($links[1]['id']);
		$breadcrumb[] = array(
			'url' => _GetPagePermalinkBySlug('press',1),
			'text' => __('Press','cish')
		);
		$breadcrumb[] = array(
			'url' => get_permalink($currentID->ID),
			'text' => $currentID->post_title
		);
		$links = $breadcrumb;
	}
	elseif ( is_singular('publication') ){
		$currentID = get_post($links[1]['id']);
		$breadcrumb[] = array(
			'url' => _GetPagePermalinkBySlug('publications',1),
			'text' => __('Publications','cish')
		);
		$breadcrumb[] = array(
			'url' => get_permalink($currentID->ID),
			'text' => $currentID->post_title
		);
		$links = $breadcrumb;
	}

	return $links;
}
