<?php get_header();?>
<?php
global $wp_query;
?>

<div id="section-program-single">
	<div class="container">
		<div class="row">
			
			<?php includeProgramMenu($wp_query->query_vars['subpage']);?>
			
			<div class="col-sm-8">
				<div class="block-w">
					<div class="head"><?php the_title();?></div>
					<div id="single-program-info">
						<?php
						if ( isset($data) && !empty($data) ){
							echo $data;
						}
						else{
							the_content();
						}
						?>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>

<?php get_footer();?>