<?php get_header();?>

<?php
$event = get_field('event');
$program = get_field('program', $event->ID);

$date = get_field('date');
$externalLink = get_field('external_url');
$downloadFile = get_field('download_file');
$gallery = get_field('gallery');
?>

<div id="section-press-single">
	<div class="container">
		<div class="block-w">
			<div class="head"><?php _e('Press', 'cish');?></div>
			<div class="row">
				<div class="col-md-4 col-sm-4">
					<div class="panel-info panel-publication-info">
					
						<label><?php _e('Title','cish');?></label>
						<div class="title"><?php the_title();?></div>
						
						<label><?php _e('Date','cish');?></label>
						<div class="date"><?php echo str_replace('-','.', $date);?></div>
						
						<?php if ($program) :?>
							<div class="program-event">
								<a href="<?php echo get_permalink($program->ID);?>"><?php echo $program->post_title;?></a>
								<?php if ( $event ) :?>
									/ <a href="<?php echo get_permalink($event->ID);?>"><?php echo $event->post_title;?></a>
								<?php endif;?>
							</div>
						<?php endif;?>
						
						<?php if ($downloadFile):?>
							<div class="download"><a target="_blank" href="<?php echo $downloadFile;?>"><img class="img-responsive" src="<?php bloginfo('stylesheet_directory');?>/assets/img/icon-download-pdf.jpg" /></a></div>
						<?php endif;?>
						
						<?php if ($externalLink) :?>
							<div class="original-link">
								<?php _e('To check the original article published by The Telegraph please follow this','cish');?> <a target="_blank" href="<?php echo $externalLink;?>">link</a>.
							</div>
						<?php endif;?>
						
					</div>
				</div>
				<div class="col-md-6 col-sm-8">
					<article>
						<?php if ($gallery) :?>
							<div class="gallery">
								<ul>
									<?php
									$c = 0;
									foreach ($gallery as $entry):?>
										<li class="<?php echo ($c==0) ? 'active' : '';?>">
											<a title="View Large Image" class="fancybox"  href="<?php echo $entry['url'];?>" rel="article-<?php the_ID();?>-gallery"><img class="img-responsive" src="<?php echo $entry['url'];?>" /></a></li>
										<?php $c++;?>
									<?php endforeach;?>
								</ul>
								<?php if ( count ($gallery) > 1 ): ?>
									<div class="gallery-nav">
										<span class="prev disabled"><</span>
										<span class="next">></span>
									</div>
								<?php endif;?>
							</div>
						<?php endif;?>
						<div class="content"><?php the_content();?></div>
					</article>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer();?>