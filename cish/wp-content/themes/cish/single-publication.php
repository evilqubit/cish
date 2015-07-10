<?php get_header();?>

<?php
$event = get_field('event');
$program = get_field('program', $event->ID);

$date = get_field('date');
$authorName = get_field('author_name');
$downloadFile = get_field('download_file');
$highResPicture = get_field('high_res_image');
?>

<div id="section-publication-single">
	<div class="container">
		<div class="block-w">
			<div class="head"><?php _e('Publications', 'cish');?></div>
			<div class="row">
				<div class="col-md-3 col-sm-4">
					<div class="panel-info">
						
						<div class="image">
							<?php $image = ( $highResPicture ) ? $highResPicture : featuredImg();?>
							<a class="fancybox" href="<?php echo $image;?>" rel="singlePublication"><img class="img-responsive" src="<?php echo featuredImg();?>" /></a>
						</div>
						
						<label><?php _e('Title','cish');?></label>
						<div class="title"><?php the_title();?></div>
						
						<?php if ($authorName) : ?>
							<label><?php _e('Author','cish');?></label>
							<div class="author-name"><?php echo $authorName;?></div>
						<?php endif;?>
						
						<label><?php _e('Date','cish');?></label>
						<div class="date"><?php echo str_replace('-','.', $date);?></div>
						
						<?php if ($program) :?>
							<label><?php _e('Program','cish');?></label>
							<div class="program"><a href="<?php echo get_permalink($program->ID);?>"><?php echo $program->post_title;?></a></div>
						<?php endif;?>
						
						<?php if ($event) : ?>
							<label><?php _e('Event','cish');?></label>
							<div class="event"><a href="<?php echo get_permalink($event->ID);?>"><?php echo $event->post_title;?></a></div>
						<?php endif;?>
						
						<?php if ($downloadFile):?>
							<div class="download"><a target="_blank" href="<?php echo $downloadFile;?>"><img class="img-responsive" src="<?php bloginfo('stylesheet_directory');?>/assets/img/icon-download-pdf.jpg" /></a></div>
						<?php endif;?>
															
					</div>
				</div>
				<div class="col-md-7 col-sm-8">
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