<?php
/*
Template Name: contactus| main
*/
get_header();?>

<div id="section-contactus-map">
	<div class="container">
		<div class="block-w">
			<div class="head"><?php _e('Our Location', 'cish');?></div>
			<div id="contact-us-map"></div>
			<p class="notice">
				<b><?php _e('Unesco', 'cish');?></b>&nbsp;<?php _e('Headquarters is established in Paris.', 'cish');?><br>
				<?php _e('International Center for Human Sciences is located in Byblos - Lebanon', 'cish');?>
			</p>
		</div>
	</div>
</div>
	
<div id="section-contactus-form">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="block-w">
					<div class="head"><?php _e('Contact Form', 'cish');?></div>
					<form class="form-horizontal" id="form-contact" action="" method="post">
						<input id="ch" name="ch" value="" />
						<div class="form-group">
							<label for="inputName" class="col-sm-4 col-md-3 control-label"><?php _e('Name','cish');?></label>
							<div class="col-sm-8 col-md-9">
								<input name="name" type="text" class="form-control" id="inputName" placeholder="" required>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail" class="col-sm-4 col-md-3 control-label"><?php _e('Email','cish');?></label>
							<div class="col-sm-8 col-md-9">
								<input name="email" type="email" class="form-control" id="inputEmail" placeholder="" required>
							</div>
						</div>
						<div class="form-group">
							<label for="inputPhone" class="col-sm-4 col-md-3 control-label"><?php _e('Phone','cish');?></label>
							<div class="col-sm-8 col-md-9">
								<input name="phone" type="text" class="form-control" id="inputPhone" placeholder="" >
							</div>
						</div>
						<div class="form-group">
							<label for="inputMobile" class="col-sm-4 col-md-3 control-label"><?php _e('Mobile','cish');?></label>
							<div class="col-sm-8 col-md-9">
								<input name="mobile" type="text" class="form-control" id="inputMobile" placeholder="">
							</div>
						</div>
						<div class="form-group">
							<label for="inputComment" class="col-sm-4 col-md-3 control-label"><?php _e('Comment','cish');?></label>
							<div class="col-sm-8 col-md-9">
								<textarea rows="8" name="comment" class="form-control" id="inputComment" required></textarea>
							</div>
							<button class="submit"><?php _e('Submit', 'cish');?></button>
						</div>
						
						<?php wp_nonce_field( 'contact-form-submit', '_wpnonce-contact-form-submitted' ); ?>
					</form>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="block-w">
					<div class="head"><?php _e('Information', 'cish');?></div>
					<div class="contact-info"><?php $MAIN->getSettingByLanguage('contact_information','','html');?></div>
				</div>
				<div class="block-w">
					<div class="head"><?php _e('Social Media', 'cish');?></div>
					<?php $MAIN->getSocialMedia();?>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>
	function initializeMaps(){var e={mapTypeId:google.maps.MapTypeId.ROADMAP,mapTypeControl:false};var t=new google.maps.Map(document.getElementById("contact-us-map"),e);var n,r;var i=new google.maps.LatLngBounds;for(r=0;r<markers.length;r++){var s=new google.maps.LatLng(markers[r][1],markers[r][2]);i.extend(s);n=new google.maps.Marker({position:s,map:t})}t.fitBounds(i);var o=google.maps.event.addListener(t,"idle",function(){if(t.getZoom()>5)t.setZoom(16);google.maps.event.removeListener(o)})}var markers=[["Unesco",<?php $MAIN->getSetting('map_coordinates');?>]];
	
jQuery(window).ready(function(){
	initializeMaps();
});
</script>

<?php get_footer();?>