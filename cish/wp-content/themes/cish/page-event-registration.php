<?php get_header();?>
<?php global $wp_query;?>

<div id="section-program-single">
	<div class="container">
		<div class="row">
			
			<?php includeEventMenu($wp_query->query_vars['subpage']);?>
			
			<div class="col-sm-8">
				<div class="block-w">
					<div class="head"><?php _e('Register for ', 'cish');?> <?php the_title();?></div>
					<div class="row">
						<div class="col-sm-12">
							<div class="entry">
								<div class="entry-content">
									<form class="form-horizontal" id="form-event-register" action="" method="post">
										<input type="hidden" name="event" value="<?php the_ID();?>" />
										<input id="ch" name="ch" value="" />
										<div class="form-group">
											<label for="inputName" class="col-sm-2 control-label"><?php _e('Name','cish');?> *</label>
											<div class="col-sm-10">
												<input name="name" type="text" class="form-control" id="inputName" placeholder="" required>
											</div>
										</div>
										<div class="form-group">
											<label for="inputEmail" class="col-sm-2 control-label"><?php _e('Email','cish');?> *</label>
											<div class="col-sm-10">
												<input name="email" type="email" class="form-control" id="inputEmail" placeholder="" required>
											</div>
										</div>
										<div class="form-group">
											<label for="inputPhone" class="col-sm-2 control-label"><?php _e('Phone','cish');?> *</label>
											<div class="col-sm-10">
												<input name="phone" type="text" class="form-control" id="inputPhone" placeholder="" >
											</div>
										</div>
										<div class="form-group">
											<label for="inputMobile" class="col-sm-2 control-label"><?php _e('Mobile','cish');?> *</label>
											<div class="col-sm-10">
												<input name="mobile" type="text" class="form-control" id="inputMobile" placeholder="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label"></label>
											<div class="col-sm-10">
												<button class="submit"><?php _e('Register', 'cish');?></button>
											</div>
										</div>
										<?php wp_nonce_field( 'contact-form-submit', '_wpnonce-contact-form-submitted' ); ?>
									</form>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer();?>