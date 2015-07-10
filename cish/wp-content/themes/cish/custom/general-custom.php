<?php
function echoV ( $input, $array_keys='', $return='' ){
	// will take keys up to 2 levels only
  if ( $array_keys && is_array ($input) ){
		$output = '';
		$keys = '';
		if ( is_string ($array_keys) ){
			$keys = explode(',', $array_keys);
		}
		if ( isset($keys[0]) ){
			$keyOne = $keys[0];
			$output = (isset ($input[$keyOne])) ? $input[$keyOne] : '';
		}
		if ( isset($keys[1]) ){
			$keyTwo = $keys[1];
			$output = (isset ($input[$keyOne][$keyTwo])) ? $input[$keyOne][$keyTwo] : '';
		}
	}
  else
    $output = ( isset ($input) ) ? $input : '';  
    
  if ( $return ) return $output;
  else echo $output;
}

add_theme_support('post-thumbnails');

function my_add_excerpts_to_pages() {
	add_post_type_support( 'page', 'excerpt' );
}

function remove_menus(){
	if ( !current_user_can( 'manage_options' ) ){
		remove_menu_page( 'edit.php' );                   //Posts
		remove_menu_page( 'upload.php' );                 //Media
		// remove_menu_page( 'edit.php?post_type=page' );    //Pages
		// remove_menu_page( 'edit-comments.php' );          //Comments
		remove_menu_page( 'themes.php' );                 //Appearance
		// remove_menu_page( 'plugins.php' );                //Plugins
		remove_menu_page( 'users.php' );                  //Users
		// remove_menu_page( 'tools.php' );                  //Tools
		remove_menu_page( 'options-general.php' );        //Settings
		remove_menu_page ( 'edit.php?post_type=acf');
		// remove_menu_page ( 'admin.php?page=itsec');
	}
}
// Adds gallery shortcode defaults of size="medium" and columns="2"  
function myPostGalleryFullSize(){
	function custom_post_gallery_atts($out, $pairs, $atts) {
		$atts = shortcode_atts( array(
			'size' => 'full',
		), $atts );

		$out['size'] = $atts['size'];

		return $out;
	}
	add_filter( 'shortcode_atts_gallery', 'custom_post_gallery_atts', 10, 3 );
}

function my_sd(){
  bloginfo('stylesheet_directory');
}
function wphidenag() {
  remove_action( 'admin_notices', 'update_nag', 3 );
}
function myRemAdBar(){
  remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 );
  function my_frontend_adbar() {echo '<style>html, * html body{margin-top:0 !important}</style>';}
  add_filter('wp_head','my_frontend_adbar', 99);
  if ( !is_admin() ){
    wp_deregister_script('admin-bar');
    wp_deregister_style('admin-bar');
  }
}
function set_html_content_type() {
  return 'text/html';
}
function myExcerpt($text, $text_length = 20){
  $text = str_replace(']]>', ']]&gt;', $text);
  $text = strip_tags($text);
 
  $words = explode(' ', $text, $text_length + 1);

  if (count($words)> $text_length){
    array_pop($words);
    array_push($words, '...');
    $text = implode(' ', $words);
  }
  return $text;
}

/* Pagination - Bootstrap compatible */
function _MyPagination( $args = array() ){

	if ( !isset($args['wp_query']) ){
		global $wp_query;
	}
	else{
		$wp_query = $args['wp_query'];
	}
	$qu = $wp_query->query_vars;
	
	$offset = ( isset($args['offset']) ) ? $args['offset'] : '';
	$offset = ( isset($args['offset']) ) ? $args['offset'] : '';

	// Trick for offset and pagination
	if ($offset){
		$showposts = $qu['showposts'];
		$wp_query->found_posts = $wp_query->found_posts - $offset;
		$wp_query->max_num_pages = ceil($wp_query->found_posts / $showposts);
	}

	if( $wp_query->max_num_pages <= 1 )
		return;

	$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max = intval( $wp_query->max_num_pages );

	/**	Add current page to the array */
	if ( $paged >= 1 )
		$links[] = $paged;

	/**	Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<ul class="pagination">';

	if ( get_previous_posts_link() )
		printf( '<li>%s</li>', get_previous_posts_link('Back') );

	if ( ! in_array( 1, $links ) ) {
		$class = (1 == $paged) ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( 1 ) ), '1' );
	}

	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = ( $paged == $link ) ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( $link ) ), $link );
	}

	if ( ! in_array( $max, $links ) ) {
		$class = ( $paged == $max ) ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( $max ) ), $max );
	}

	if ( get_next_posts_link() )
		printf( '<li>%s</li>', get_next_posts_link('Next') );

	echo '</ul>';
}

function getHeaderStuff (){
	?>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type')?>; charset=<?php bloginfo('charset');?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="pingback" href="<?php bloginfo('pingback_url');?>" />
	<link rel="shortcut icon" type="image/png" href="<?php my_sd();?>/assets/img/favicon.png?v=1.00" />
	<link rel="apple-touch-icon" href="<?php my_sd();?>/assets/img/favicon-touch.png?v=1.00" />
	<title><?php echo (is_home()) ? bloginfo('name') : wp_title('', false)?></title>
  <?php
}

function cleanMeta ($s){
	return cleanHTML(str_replace(array('\n','\r'),'',$s));
}
function cleanHTML($input){
  $input = htmlspecialchars($input, ENT_QUOTES);
  return $input;
}
function featuredImg($postID=''){
	global $post;
  $template_dir = get_template_directory_uri();
	$postID = ( isset($postID) && !empty($postID) ) ? $postID : get_the_ID();
  $postImage = wp_get_attachment_image_src( get_post_thumbnail_id($postID), 'full');
  return ($postImage!='') ? $postImage[0] : '';
}
function my_cf ($key){
  $custom_field = ( get_field($key) != '' ) ? get_field($key) : '';
  echo $custom_field;
}
function get_my_cf ($key){
  $custom_field = ( get_field($key) != '' ) ? get_field($key) : '';
  return $custom_field;
}
function _GetPageBySlug($slug){
	return get_page_by_path($slug);
}
function _GetPagePermalinkBySlug($slug, $return=0){
	$id = _GetPageBySlug($slug)->ID;
	$output = get_permalink ( $id );
	if ( $return ) return $output;
	else echo $output;
}

function get_page_by_slug($page_slug, $output = OBJECT, $post_type = 'page' ) { 
	global $wpdb; 
	$page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s AND post_status = 'publish'", $page_slug, $post_type ) ); 
	if ( $page ) 
		return get_post($page, $output); 
	
	return null; 
}
function _GetCurrentPageSlug(){
	global $post;
	return get_post($post)->post_name;
}
// Linkify youtube URLs which are not already links.
function getYoutubeVideoID($url) {
	$id = preg_replace('~
		# Match non-linked youtube URL in the wild. (Rev:20130823)
		https?://         # Required scheme. Either http or https.
		(?:[0-9A-Z-]+\.)? # Optional subdomain.
		(?:               # Group host alternatives.
			youtu\.be/      # Either youtu.be,
		| youtube         # or youtube.com or
			(?:-nocookie)?  # youtube-nocookie.com
			\.com           # followed by
			\S*             # Allow anything up to VIDEO_ID,
			[^\w\s-]       # but char before ID is non-ID char.
		)                 # End host alternatives.
		([\w-]{11})      # $1: VIDEO_ID is exactly 11 chars.
		(?=[^\w-]|$)     # Assert next char is non-ID or EOS.
		(?!               # Assert URL is not pre-linked.
			[?=&+%\w.-]*    # Allow URL (query) remainder.
			(?:             # Group pre-linked alternatives.
				[\'"][^<>]*>  # Either inside a start tag,
			| </a>          # or inside <a> element text contents.
			)               # End recognized pre-linked alts.
		)                 # End negative lookahead assertion.
		[?=&+%\w.-]*        # Consume any URL (query) remainder.
		~ix', 
		'$1',
		$url);
		
	return $id;
}
function _GetCurrentPagePostCount ( $args = array() ){
	$output = 0;
	
	$foundPosts = ( isset ($args['foundPosts']) ) ? $args['foundPosts'] : 0;
	$perPage = ( isset ($args['perPage']) ) ? $args['perPage'] : 0;
	$paged = ( isset ($args['paged']) ) ? $args['paged'] : 0;
	if ( !$foundPosts || !$perPage || !$paged ){
		return $output;
	}
	$cumulativePostCount = $perPage * $paged;
	
	if ( $foundPosts == $cumulativePostCount ){
		$output = $perPage;
	}
	elseif ( $foundPosts < $cumulativePostCount ){
		//$output = $cumulativePostCount - $foundPosts;
		$output = $foundPosts % $perPage;
	}
	else {
		if ( ($foundPosts - $cumulativePostCount) >= 0 ){
			$output = $perPage;
		}
		else{
			$output = $foundPosts - $cumulativePostCount;
		}
	}
	return $output;
}

function _GetPostIDByIDForCurrentLang ($post_id, $post_type = 'page'){
	$language = ICL_LANGUAGE_CODE;
	return icl_object_id( $post_id, $post_type, true, $language );
}
function _GetPostIDCurrentLanguage ($post_slug, $post_type = 'page'){
	$post = get_page_by_path($post_slug, OBJECT, $post_type);
	$language = ICL_LANGUAGE_CODE;
	return icl_object_id( $post->ID, $post_type, true, $language );
}
function get_post_permalink_current_language( $post_slug, $post_type='page' )
{
	$post = get_page_by_path($post_slug, OBJECT, $post_type);
	
	$language = ICL_LANGUAGE_CODE;
	$lang_post_id = icl_object_id( $post->ID , $post_type, true, $language );
	$url = "";
	
	if($lang_post_id != 0) {
		$url = get_permalink( $lang_post_id );
	}else {
		// No page found, it's most likely the homepage
		global $sitepress;
		$url = $sitepress->language_url( $language );
	}

	return $url;
}
function get_permalink_current_language( $post_slug )
{
	$page = get_page_by_path( $post_slug );
	$language = ICL_LANGUAGE_CODE;
	$lang_post_id = icl_object_id( $page->ID , 'page', true, $language );
	$url = "";
	
	if($lang_post_id != 0) {
		$url = get_permalink( $lang_post_id );
	}else {
		// No page found, it's most likely the homepage
		global $sitepress;
		$url = $sitepress->language_url( $language );
	}

	return $url;
}
?>