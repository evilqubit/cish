<?php
$activeSection = ( isset ($activeSection) ) ? $activeSection : '';
$activeSectionA = array ($activeSection => 'active');

$hasRegistration = get_field('has_registration');
?>
<div class="col-sm-4">
	<div class="block-w menu-inpage">
		<div id="single-program-menu" class="panel-menu">
			<div class="head"><?php the_title();?></div>
			<ul>
				<li class="<?php echo ( !$activeSection ) ? 'active' : '';?>"><a href="<?php the_permalink();?>"><?php _e('Program Home', 'cish');?></a></li>
				<li class="<?php echo ( isset ($activeSectionA['details'] ) ) ? $activeSectionA['details'] : '';?>"><a href="<?php the_permalink();?>details"><?php _e('Program Details', 'cish');?></a></li>
				<li class=""<?php echo ( isset ($activeSectionA['events'] ) ) ? $activeSectionA['events'] : '';?>"><a href="<?php the_permalink();?>events"><?php _e('Events', 'cish');?></a></li>
			</ul>
		</div>
	</div>
</div>