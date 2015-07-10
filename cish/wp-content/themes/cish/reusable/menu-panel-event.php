<?php
global $MAIN;
$activeSection = ( isset ($activeSection) && !empty($activeSection) ) ? $activeSection : 'home';
$activeSectionA = array ($activeSection => 'active');

$download = get_field('download_file');
$hasRegistration = get_field('has_registration');

$subPage = ( get_query_var('subpage') ) ? get_query_var('subpage') : '';
?>
<div class="col-sm-4">
	<div class="block-w menu-inpage">
		<div id="single-event-menu" class="panel-menu">
			<div class="head"><?php the_title();?></div>
			<ul>
				<?php $permalink = get_the_permalink( get_the_ID() );?>
				<li class="<?php echoV($activeSectionA, 'home');?>"><a href="<?php echo $permalink;?>"><?php _e('Details', 'cish');?></a></li>
				
				<?php if ( $MAIN->getCurrentEventCustomField('summary') ) :?>
					<li class="<?php echoV($activeSectionA, 'summary');?>"><a href="<?php echo $permalink;?>summary"><?php _e('Summary', 'cish');?></a></li>
				<?php endif;?>
				
				<?php if ( $MAIN->getCurrentEventCustomField('concept_note') ) :?>
					<li class="<?php echoV($activeSectionA, 'concept-note');?>"><a href="<?php echo $permalink;?>concept-note"><?php _e('Concept Note', 'cish');?></a></li>
				<?php endif;?>
				
				<?php
				$taxonomies = $MAIN->getCurrentEventTaxonomies();
				?>
				<?php foreach ($taxonomies as $tax=>$taxQuery) :?>
					<?php if ( $taxQuery->found_posts > 0 ) :?>
						<?php
						$taxonomy = get_term_by('slug', $tax, 'press-category');
						$translated_term_id = icl_object_id(intval($taxonomy->term_id), $taxonomy->taxonomy, true, 'en');

						remove_all_filters('get_term');
						$originalTerm = get_term_by('id', $translated_term_id, $taxonomy->taxonomy);
						?>
						<li class="<?php echoV($activeSectionA, $originalTerm->slug);?>"><a href="<?php echo $permalink;?><?php echo $originalTerm->slug;?>"><?php echo $taxonomy->name;?></a></li>
					<?php endif;?>
				<?php endforeach;?>
				
				<?php if ( $MAIN->getCurrentEventPublications() ) :?>
					<li class="<?php echoV($activeSectionA, 'publications');?>"><a href="<?php echo $permalink;?>publications"><?php _e('Publications', 'cish');?></a></li>
				<?php endif;?>
				
				<?php $gallery = get_field('gallery', get_the_ID() );?>
				<?php if ( $gallery ) :?>
					<li class="<?php echoV($activeSectionA, 'gallery');?>"><a href="<?php echo $permalink;?>gallery"><?php _e('Gallery', 'cish');?></a></li>
				<?php endif;?>
				
				<?php if ($download):?>
					<li><a target="_blank" href="<?php echo $download;?>"><?php _e('Download', 'cish');?></a></li>
				<?php endif;?>
				
				<?php if ( $hasRegistration ) : ?>
					<li class="<?php echoV($activeSectionA, 'registration');?>"><a href="<?php echo $permalink;?>registration"><?php _e('Registration', 'cish');?></a></li>
				<?php endif;?> 
				
			</ul>
		</div>
	</div>
</div>