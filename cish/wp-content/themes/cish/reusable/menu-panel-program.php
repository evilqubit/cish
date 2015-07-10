<?php
global $MAIN;
$activeSection = ( isset ($activeSection) && !empty($activeSection) ) ? $activeSection : 'home';
$activeSectionA = array ($activeSection => 'active');
?>
<div class="col-sm-4">
	<div class="block-w menu-inpage">
		<div id="single-program-menu" class="panel-menu">
			<div class="head"><?php the_title();?></div>
			<ul>
				<?php $permalink = get_the_permalink( get_the_ID() );?>
				
				<?php if ( $MAIN->getCurrentProgramEvents() ):?>
					<li class="<?php echoV($activeSectionA, 'home');?>"><a href="<?php echo $permalink;?>"><?php _e('Events', 'cish');?></a></li>
				<?php endif;?>
				
				<li class="<?php echoV($activeSectionA, 'details');?>"><a href="<?php echo $permalink;?>details"><?php _e('Details', 'cish');?></a></li>
				
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
				
				<?php if ( $MAIN->getCurrentProgramPublications() ) :?>
					<li class="<?php echoV($activeSectionA, 'publications');?>"><a href="<?php echo $permalink;?>publications"><?php _e('Publications', 'cish');?></a></li>
				<?php endif;?>
				
				<?php if ( $MAIN->checkCurrentProgramGallery() ) :?>
					<li class="<?php echoV($activeSectionA, 'gallery');?>"><a href="<?php echo $permalink;?>gallery"><?php _e('Gallery', 'cish');?></a></li>
				<?php endif;?>
				
			</ul>
		</div>
	</div>
</div>