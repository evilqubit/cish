<?php
class MyWebsite
{
	public $pagesIDs = array();
	public $parentSlug = '';
	public $childSlug = '';
	public $sD = '';
	public $sB = '';
	public $lang = array();
	public $events = array();
	public $eventsJson = '""';
	public $siteMenu = '';
	public $activeMenu = array();
	public $data = array();
	public $is = array();
	public $permalinks = array();
	
	function __construct(){
		$this->sD = get_bloginfo('stylesheet_directory');
		$this->sB = get_bloginfo('wpurl');
		
		// Set site language (using WPML language variable)
		$this->setLanguage();
	}
	function kickstart(){
		$this->checkSlugs();
		
		// for menu
		$this->setPrograms();
		$this->setCenterPage();
		$this->setPressCategories();
		
		// Menu
		$this->setSiteMenu();
		
		// Calendar on homepage (fetch events via json)
		if ( $this->isHome() ){
			$this->setCalendarEvents();
		}
		
		// Social media in footer (or used anywhere else like in contact page) (query done once)
		$this->setSocialMedia();
	}
	function sD($return=0){
		if ( $return ) return $this->sD;
		else echo $this->sD;
	}
	function sB(){
		echo $this->sB;
	}
	function sBL(){
		$lang = ( ICL_LANGUAGE_CODE != 'en' ) ? '/'.ICL_LANGUAGE_CODE : '';
		echo $this->sB.$lang;
	}
	public function isLang($lang){
		return ( isset($this->lang[$lang]) ) ? 1 : 0;
	}
	function setLanguage(){
		$this->lang[ICL_LANGUAGE_CODE] = 1;
	}
	function getEventsJson(){
		return $this->eventsJson;
	}
	function setIsHome($value){
		$this->is['home'] = $value;
	}
	function isHome(){
		return ( isset($this->is['home']) ) ? $this->is['home'] : 0;
	}
	function bodyStyle(){
		$backgroundColor = $this->getSetting('site_background_color', 1);
		$backgroundImage = $this->getSetting('site_background_image', 1);
		
		if ( $backgroundImage ){
			$output = "background: url({$backgroundImage}) {$backgroundColor} top right no-repeat";
		}
		else{
			$output = "background: {$backgroundColor}";
		}
		
		echo $output;
	}
	
	function setSiteMenu (){
		$this->activeMenu = array ($this->getParentPageSlug() => 'active');
		ob_start();
		?>
		<li class="<?php echo ( $this->isHome() ) ? 'active' : '';?>">
			<a href="<?php $this->sBL();?>"><?php _e('Home', 'cish');?></a>
		</li>
		<li class="<?php echo $this->activeMenu['center'];?>">
			<a href="<?php $this->getPermalink('center');?>"><?php _e('Center', 'cish');?></a>
			<ul class="submenu"><?php $this->getCenterPageMenu();?></ul>
		</li>
		<?php
		$entry = $this->getProgram('conferences');
		?>
		<li class="<?php echo ( $this->isProgram('conferences') || $this->isEventInProgram($entry->post_name) ) ? 'active' : '';?>">
			<a href="<?php $this->getPermalink('conferences','program');?>"><?php echo $entry->post_title;?></a>
		</li>
		<?php
		$entry = $this->getProgram('citizenship');
		?>
		<li class="<?php echo ( $this->isProgram('citizenship') || $this->isEventInProgram($entry->post_name) ) ? 'active' : '';?>">
			<a href="<?php $this->getPermalink('citizenship','program');?>"><?php echo $entry->post_title;?></a>
		</li>
		<?php
		$entry = $this->getProgram('byblos-autumn');
		?>
		<li class="<?php echo ( $this->isProgram('byblos-autumn') || $this->isEventInProgram($entry->post_name) ) ? 'active' : '';?>">
			<a href="<?php $this->getPermalink('byblos-autumn', 'program');?>"><?php echo $entry->post_title;?></a>
		</li>
		<?php
		$entry = $this->getProgram('research-and-studies');
		?>
		<li class="<?php echo ( $this->isProgram('research-and-studies') || $this->isEventInProgram($entry->post_name) ) ? 'active' : '';?>">
			<a href="<?php $this->getPermalink('research-and-studies', 'program');?>"><?php echo $entry->post_title;?></a>
		</li>
		<li class="menu-activities">
			<a href="javascript:void(0)"><?php _e('Activities', 'cish');?></a>
			<ul class="submenu third">
				<?php
				$programs = $this->getPrograms();
				?>
				<?php foreach ($programs as $entry) :?>
					<li class="<?php echo ( $this->isProgram($entry->post_name) || $this->isEventInProgram($entry->post_name) ) ? 'active' : '';?>">
						<a href="<?php echo get_the_permalink($entry->ID);?>"><?php echo get_the_title($entry->ID);?></a>
					</li>
				<?php endforeach;?>
			</ul>
		</li>
		<li class="<?php echo $this->activeMenu['press'];?>">
			<a href="<?php $this->getPermalink('press');?>"><?php _e('Press', 'cish');?></a>
			<ul class="submenu">
				<?php
				$c = 0;
				$press = $this->getPressCategories();
				?>
				<?php foreach ($press as $entry) :?>
					<li><a href="<?php echo esc_url(get_term_link($entry));?>"><?php echo $entry->name;?></a></li>
				<?php endforeach;?>
			</ul>
		</li>
		<li class="<?php echo $this->activeMenu['gallery'];?>">
			<a href="<?php $this->getPermalink('gallery');?>"><?php _e('Gallery', 'cish');?></a>
		</li>
		<li class="menu-publications <?php echo $this->activeMenu['publications'];?>">
			<a href="<?php $this->getPermalink('publications');?>"><?php _e('Publications', 'cish');?></a>
		</li>
		<?php
		
		$this->siteMenu = ob_get_contents();
		ob_end_clean();
	}
	function getPressTaxonomy ($slug){
		return ( isset($this->data['press-taxonomy'][$slug]) ) ? $this->data['press-taxonomy'][$slug] : '';
	}
	function checkActiveMenu($input){
		echo ( isset ( $this->activeMenu[$input] ) ) ? 'active' : '';
	}
	function getSiteMenu($args = array()){
		$submenuClass = ( isset($args['hideSubmenu']) ) ? 'hide-submenus' : '';
		
		echo '<ul class="'.$submenuClass.'">'.$this->siteMenu.'</ul>';
	}
	function setEvent ($post){
		$slug = $post->post_name;
		$id = $post->ID;
		
		$this->data['event'][$slug] = 1;
		
		$program = get_field('program', $id);
		$this->data['currentEventProgram'][$program->post_name] = 1;
	}
	function isEventInProgram($programSlug){
		return ( isset ($this->data['currentEventProgram'][$programSlug]) ) ? 1 : 0;
	}
	function getPrograms(){
		return ( isset($this->data['programs']) ) ? $this->data['programs'] : array();
	}
	function setProgram ($slug){
		$this->data['program'][$slug] = 1;
	}
	function isProgram($slug){
		return ( isset ($this->data['program'][$slug]) ) ? 1 : 0;
	}
	function setPrograms(){
		$this->data['programs'] = get_posts(
			array (
				'post_type'=> 'program',
				'posts_per_page' => "-1",
				'suppress_filters'=> false,
				'meta_query' => array(
					array(
						'key' => 'hide_from_menu',
						'value' => 0,
						'compare' => '='
					)
				)
			)
		);
	}
	function getOriginalTerm($slug){
		$taxonomy = get_term_by('slug', $slug, 'press-category');
		$translated_term_id = icl_object_id(intval($taxonomy->term_id), $taxonomy->taxonomy, true, 'en');

		remove_all_filters('get_term');
		return get_term_by('id', $translated_term_id, $taxonomy->taxonomy);
	}
	function getProgram ($slug){
		$output = array();
		
		if ( !isset ($this->data['programs'][$slug]) ){
			$args = array(
				'post_type' => 'program',
				'name' => $slug,
				'suppress_filters' => false,
				'posts_per_page' => 1
			);
			$q = get_posts( $args );
			if( $q ) {
				$output = reset($q);
			}
		}
		else{
			$output = $this->data['programs'][$slug];
		}
		
		return $output;
	}
	function getCenterPageMenu($activeSection = ''){
		$activeSectionA = array ($activeSection => 'active');
		
		$centerMenu = $this->getCenterPageEntries();
		?>
		<?php foreach ($centerMenu as $entry) :?>
			<li class="<?php echo ( isset($activeSectionA[$entry->post_name]) ) ? 'active' : '';?>"><a href="<?php echo get_the_permalink($entry->ID);?>"><?php echo get_the_title($entry->ID);?></a></li>
		<?php endforeach;?>
		
		<?php
		switch ( ICL_LANGUAGE_CODE ):
			default:
			case 'en':
				$key = 'field_54d68a63f3ecd';
			break;
			
			case 'fr':
				$key = 'field_556d616d8bc97';
			break;
			
			case 'ar':
				$key = 'field_556d61724d5a6';
			break;
			
		endswitch;
		
		$allMemberTypes = $this->getCustomField($key);
		
		if( $allMemberTypes ){
			foreach( $allMemberTypes['choices'] as $k => $v ){
				?>
				<li class="<?php echo ( isset($activeSectionA[$k]) ) ? 'active' : '';?>"><a href="<?php echo $this->getPermalink('center').'profiles/'.$k;?>"><?php echo $v;?></a></li>
				<?php
			}
		}
	}
	function getCenterPageEntries(){
		return ( isset($this->data['center']) ) ? $this->data['center'] : array();
	}
	function setCenterPage(){
		$centerPageID = _GetPostIDCurrentLanguage('center');
		$this->data['center'] = get_posts (
			array(
				'post_type'=>'page',
				'post_parent'=>$centerPageID,
				'orderby'=>'menu_order',
				'order'=>'ASC',
				'suppress_filters' => true
			)
		);
	}
	function setPressCategories(){
		$this->data['press'] = get_terms( 'press-category', array(
			'hide_empty' => 0,
			'taxonomy' => 'press-category'
		 )
	 );
	}
	function getCustomField($field){
		if ( !isset ( $this->customFields[$field]) )
			$this->customFields[$field] = get_field_object($field);
		
		return $this->customFields[$field];
	}
	function getPressCategories(){
		return ( isset($this->data['press']) ) ? $this->data['press'] : array();
	}
	function setCalendarEvents(){
		$output = array();
		$args = array(
			'post_type' => 'event',
			'suppress_filters' => false
		);
		$events = get_posts( $args );
		
		if ( $events ){
			foreach ($events as $entry){
				$date = strtotime( get_field('date', $entry->ID) );
				$newEntry['title'] = $entry->post_title;
				$newEntry['date'] = date('Y-m-d', $date);
				$newEntry['permalink'] = get_permalink($entry->ID);
				$output[] = $newEntry;
			}
		}
		
		$this->events = $output;
		$this->eventsJson = json_encode($output);
	}
	function setSocialMedia(){
		ob_start();
		?>
		<ul class="social-media">
			<?php if ( $val = $this->getSetting('facebook_link', 1) ) :?>
				<li class="icon-facebook"><a target="_blank" href="<?php echo $val;?>"></a></li>
			<?php endif;?>
			
			<?php if ( $val = $this->getSetting('youtube_link', 1) ) :?>
				<li class="icon-youtube"><a target="_blank" href="<?php echo $val;?>"></a></li>
			<?php endif;?>
			
			<?php if ( $val = $this->getSetting('linkedin_link', 1) ) :?>
				<li class="icon-linkedin"><a target="_blank" href="<?php echo $val;?>"></a></li>
			<?php endif;?>
			
			<?php if ( $val = $this->getSetting('googleplus_link', 1) ) :?>
				<li class="icon-googleplus"><a target="_blank" href="<?php echo $val;?>"></a></li>
			<?php endif;?>
			
			<?php if ( $val = $this->getSetting('instagram_link', 1) ) :?>
				<li class="icon-instagram"><a target="_blank" href="<?php echo $val;?>"></a></li>
			<?php endif;?>
			
			<?php if ( $val = $this->getSetting('tumblr_link', 1) ) :?>
				<li class="icon-tumblr"><a target="_blank" href="<?php echo $val;?>"></a></li>
			<?php endif;?>
			
			<?php if ( $val = $this->getSetting('twitter_link', 1) ) :?>
				<li class="icon-twitter"><a target="_blank" href="<?php echo $val;?>"></a></li>
			<?php endif;?>
			
		</ul>
		<?php
		$this->data['socialMedia'] = ob_get_contents();
		ob_end_clean();
	}
	function getSocialMedia(){
		echo $this->data['socialMedia'];
	}
	function setCurrentEventCustomFields($customFieldsArray){
		$this->data['currentEvent']['customFields'] = $customFieldsArray;
	}
	function setCurrentEventPublications($publications){
		$this->data['currentEvent']['publications'] = ( $publications->found_posts ) ? $publications : array();
	}
	function getCurrentEventCustomField($key){
		return ( isset($this->data['currentEvent']['customFields'][$key]) ) ? $this->data['currentEvent']['customFields'][$key] : '';
	}
	function getCurrentEventPublications(){
		return $this->data['currentEvent']['publications'];
	}
	function getCurrentProgramEvents(){
		return ( isset($this->data['currentProgram']['events']) && !empty($this->data['currentProgram']['events']) ) ? $this->data['currentProgram']['events'] : array();
	}
	function setProgramEvents($events){
		$this->data['currentProgram']['events'] = $events;
	}
	function setCurrentProgramPublications($publications){
		$this->data['currentProgram']['publications'] = ( $publications->found_posts ) ? $publications : array();
	}
	function setCurrentProgramGallery($data){
		$this->data['currentProgram']['gallery'] = ( $data->found_posts ) ? $data : array();
	}
	function checkCurrentProgramGallery(){
		return ($this->data['currentProgram']['gallery']->found_posts > 0) ? 1 : 0;
	}
	function getCurrentProgramGallery(){
		return $this->data['currentProgram']['gallery'];
	}
	function setCurrentProgramCustomFields($customFieldsArray){
		$this->data['currentProgram']['customFields'] = $customFieldsArray;
	}
	function getCurrentProgramCustomField($key){
		return ( isset($this->data['currentProgram']['customFields'][$key]) ) ? $this->data['currentProgram']['customFields'][$key] : '';
	}
	function getCurrentProgramPublications(){
		return $this->data['currentProgram']['publications'];
	}
	function getCurrentEventTaxonomies(){
		return ( isset ($this->data['currentEvent']['taxonomies']) ) ? $this->data['currentEvent']['taxonomies'] : array();
	}
	function getCurrentEventTaxonomy($taxonomy){
		return ( isset($this->data['currentEvent']['taxonomies'][$taxonomy]) ) ? $this->data['currentEvent']['taxonomies'][$taxonomy] : '';
	}
	function setCurrentEventTaxonomies($taxSlug, $data){
		$this->data['currentEvent']['taxonomies'][$taxSlug] = $data;
	}
	function getCurrentProgramPress($taxonomy){
		return ( isset($this->data['currentEvent'][$taxonomy]) && !empty($this->data['currentEvent'][$taxonomy]) ) ? 1 : 0;
	}
	function checkSlugs(){
		global $post;
		global $wp_query;
		
		$postType = $post->post_type;
		$pageSlug = ( isset($post->post_parent) && $post->post_parent > 0 ) ? get_post($post->post_parent)->post_name : get_post($post)->post_name;
		$childSlug = $post->post_name;

		if ( $postType != 'page' && $postType != 'post' && $postType != 'attachment'){
			switch ($postType):
				default:
					$pageSlug = $postType;
				break;
				case 'program':
					$pageSlug = 'programs';
				break;
				case 'event':
					$pageSlug = 'events';
				break;
			endswitch;
			
			$childSlug = $postType;
		}
		if ( isset($wp_query->query_vars['subpage']) ){
			$childSlug .= '-'.$wp_query->query_vars['subpage'];
		}
		
		$this->setChildPageSlug ($childSlug);
		$this->setParentPageSlug ($pageSlug);
	}
	function getPermalink($slug, $post_type = 'page'){
		$output = ( isset ( $this->permalinks[$post_type][$slug] ) ) ? $this->permalinks[$post_type][$slug] : '';
		
		if ( !$output ) {
			$output = get_post_permalink_current_language($slug, $post_type);
			$this->permalinks[$post_type][$slug] = $output;
		}
		
		echo $output;
	}
	function setChildPageSlug($slug){
		$this->childSlug = $slug;
	}
	function setParentPageSlug($slug){
		$this->parentSlug = $slug;
	}
	function getChildPageSlug(){
		return $this->childSlug;
	}
	function getParentPageSlug(){
		return $this->parentSlug;
	}
	function getHeadIncludesBefore(){
		echo '<script>
		var HTML_SITE = "'.$this->sD(1).'",
		ajaxurl = "'.admin_url('admin-ajax.php').'",
		currentLang = "'.ICL_LANGUAGE_CODE.'",
		eventsJson = '.$this->getEventsJson().';
		</script>';
	}
	function getSettingByLanguage ($setting_key, $return='', $extra=''){
		return $this->getSetting ( $setting_key.'_'.ICL_LANGUAGE_CODE, $return, $extra);
	}
	function getSetting ($setting_key, $return='', $extra=''){
		$prefix = 'psettings_';
		$setting_key = $prefix.$setting_key;

		$old_key = $setting_key;
		$found_value = ( get_option($setting_key) != '' ) ? 1 : 0;

		// revert to old key if we dont find a setting value for the current language
		$setting_key = ( !$found_value ) ? $old_key : $setting_key;

		$output = stripslashes ( get_option ($setting_key) );
		if ( $extra == 'html' ){
			$output = wpautop($output);
		}
		
		if ($return!='') return $output;
		else echo $output;
	}

	// Get categories of a post
	function getPostCats ( $post_id ){
		$post_categories = wp_get_post_categories( $post_id );
		$cats = array();
		foreach($post_categories as $c_id){
			$cat = get_category( $c_id );
			$category_link = get_category_link( $c_id ).$this->getLangUrl();      
			$cats[] = array( 'id'=>$c_id, 'name' => $cat->name, 'slug' => $cat->slug, 'link' => $category_link );
		}
		return $cats;
	}
	
	function replaceArabicNum ($input){
		$output = $input;
		if ( $this->isLang('ar') ){
			$english = array('0','1','2','3','4','5','6','7','8','9');
			$arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');
			$output = str_replace($english, $arabic, $output);
		}
		
		return $output;
	}
	function doEventActions(){
		
		$download = get_field('download');
		// Publications check
		$argsPublications = array(
			'post_type' => 'publication',
			'suppress_filters' => false,
			'posts_per_page' => 1,
			'meta_query' => array(
				array(
					'key' => 'event',
					'value' => get_the_ID(),
					'compare' => 'LIKE'
				)
			)
		);
		$publicationsCount = get_posts ( $argsPublications );
		$permalink = get_the_permalink( get_the_ID() );
		?>
		<ul class="event-actions">
			<li class="details">
				<div class="icon-overlay"><?php _e('Details','cish');?><span>&nbsp;</span></div>
				<a href="<?php echo $permalink;?>">&nbsp;</a>
			</li>
			<li class="press">
				<div class="icon-overlay"><?php _e('Press','cish');?><span>&nbsp;</span></div>
				<a href="<?php echo $permalink;?>press">&nbsp;</a>
			</li>
			<li class="gallery">
				<div class="icon-overlay"><?php _e('Gallery','cish');?><span>&nbsp;</span></div>
				<a href="<?php echo $permalink;?>gallery">&nbsp;</a>
			</li>
			<?php if ( count($publicationsCount) > 0 ) :?>
				<li class="publications">
					<div class="icon-overlay"><?php _e('Publications','cish');?><span>&nbsp;</span></div>
					<a href="<?php echo $permalink;?>publications">&nbsp;</a>
				</li>
			<?php endif;?>
			<?php if ($download) :?>
				<li class="download">
					<div class="icon-overlay"><?php _e('Download','cish');?><span>&nbsp;</span></div>
					<a href="<?php echo $download;?>">&nbsp;</a>
				</li>
			<?php endif;?>
		</ul>
		<?php
	}
	function translateManual ($string){
		switch($string) :
			case 'publications':
				$array = __('Publications', 'cish');
			break;
			case 'gallery':
				$value = __('Gallery', 'cish');
			break;
			case 'details':
				$value = __('Details', 'cish');
			break;
			case 'concept-note':
				$value = __('Concept Note', 'cish');
			break;
			case 'press-room':
				$value = __('Press Room', 'cish');
			break;
			case 'press-releases':
				$value = __('Press Releases', 'cish');
			break;
			case 'summary':
				$value = __('Summary', 'cish');
			break;
		endswitch;
		
		return $value;
	}
}

// init
$MAIN = new MyWebsite();
?>