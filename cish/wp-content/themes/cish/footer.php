<?php
global $MAIN;
?>

<?php
// Latest Events
$args = array (
	'post_type'=> 'event',
	'showposts'=> 5,
	'meta_key'=> 'date',
	'orderby' => 'meta_value',
	'order' => 'DESC'
);
$latestEvents = new WP_Query($args);
?>

</div><!-- #page-...-->

<div class="push"></div>
</div><!-- #wrap -->

<div class="back-to-top-w">
	<a href="#wrap"><?php _e('Back To Top');?></a>
</div>

<footer>
	<?php
	$wp_query = new WP_Query(
		array (
			'pagename' => 'partners',
			'meta_query' => array(
				array(
					'key' => 'gallery',
					'value' => '',
					'compare' => '!='
				)
			)
		)
	);
	?>
	<?php if (have_posts() ) :?>
		<div id="section-partners">
			<div class="container">
				<div class="row">
					<?php while(have_posts()) : the_post();?>
						<?php $count = 0;?>
						<?php $gallery = get_field('gallery');?>
							<?php foreach ($gallery as $entry) :?>
								<?php if ($count > 5 ) :?>
									<?php break;?>
								<?php endif;?>
								<div class="col-lg-2 col-sm-3 col-partner">
									<a target="_blank" href="<?php echo $entry['description'];?>"><img class="img-responsive" src="<?php echo $entry['url'];?>"/></a>
								</div>
							<?php $c++;?>
							<?php endforeach;?>
					<?php
					endwhile;
					wp_reset_postdata();
					wp_reset_query();
					?>
				</div>
			</div>
		</div>
	<?php endif;?>

	<div id="footer-info">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 dis-col-sm">
					<div class="head head-footer-about"><?php _e('About CISH', 'cish');?></div>
					<?php $MAIN->getSettingByLanguage ('about','', 'html');?>
				</div>
				<div class="col-sm-3 dis-col-sm col-footer-fb">
					<div class="head head-footer-fb"><?php _e('Facebook', 'cish');?></div>
					<div class="fb-like-box" data-href="https://www.facebook.com/cishbyblos" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
				</div>
				<div class="col-sm-3 dis-col-sm">
					<div class="head head-footer-tw"><?php _e('Twitter Feeds', 'cish');?></div>
					<?php if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
						<div id="sidebar-twitter">
							<?php dynamic_sidebar( 'sidebar-footer' ); ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="col-sm-3 dis-col-sm">
					<div class="head head-footer-contact"><?php _e('Contact Us', 'cish');?></div>
					<ul class="contact-info">
						<li class="phone">
							<div class="subhead"><?php _e('Contact Phone', 'cish');?></div>
							<div><?php $MAIN->getSettingByLanguage('contact_phone');?></div>
						</li>
						<li class="pobox">
							<div class="subhead"><?php _e('PO. Box', 'cish');?></div>
							<div><?php $MAIN->getSettingByLanguage('pobox');?></div>
						</li>
						<li class="email">
							<div class="subhead"><?php _e('E-Mail Addresses', 'cish');?></div>
							<div><?php $MAIN->getSettingByLanguage('email_address');?></div>
						</li>
						<li class="fax">
							<div class="subhead"><?php _e('Fax', 'cish');?></div>
							<div><?php $MAIN->getSettingByLanguage('fax');?></div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div id="footer-sitemap">
		<div class="container">
			<div class="row">
				
				<div class="col-sm-3 dis-col-sm">
					<div class="head"><?php _e('Sitemap', 'cish');?></div>
					<?php $MAIN->getSiteMenu( array('hideSubmenu'=>1) );?>
				</div>
				
				<div class="col-sm-3 dis-col-sm">
					<div class="head"><?php _e('Center', 'cish');?></div>
					<?php $MAIN->getCenterPageMenu();?>
				</div>
				
				<div class="col-sm-3 dis-col-sm">
					<div class="head"><?php _e('Latest Events', 'cish');?></div>
					<ul>
						<?php if ($latestEvents->have_posts()) : while($latestEvents->have_posts()) : $latestEvents->the_post();?>
							<?php setup_postdata($post) ?>
							<li><a href="<?php the_permalink();?>"><?php the_title();?></a></li>
						<?php endwhile;
						wp_reset_postdata();
						wp_reset_query();
						endif;
						?>
					</ul>
				</div>
				
				<div class="col-sm-3 dis-col-sm">
					<div class="head"><?php _e('Newsletter Signup','cish');?></div>
					<form id="form-newsletter" action="//cish-byblos.us10.list-manage.com/subscribe/post?u=15a22606cbe75c31ad75448cb&amp;id=8f2f0e1aef" method="post" name="mc-embedded-subscribe-form" novalidate>
						<input name="subscribe" type="submit" id="submit" class="submit-btn" value=" ">
						<input name="EMAIL" id="mce-EMAIL" class="form-field" type="email" name="email" value="<?php _e('enter your email ...', 'cish');?>" data-placeholder="" />
						<div style="position: absolute; left: -5000px;"><input type="text" name="b_15a22606cbe75c31ad75448cb_8f2f0e1aef" tabindex="-1" value=""></div>
					</form>
				</div>
				
			</div>
		</div>
	</div>

	<div id="footer-credits">
		<div class="container">
			<div class="row">
				<div class="col-sm-5">
					<div class="credits-left">© <?php echo date('Y', time());?> <a href="<?php bloginfo('url');?>"><?php bloginfo('title');?></a>. <?php _e('All Rights Reserved', 'cish');?>.</div>
				</div>
				<div class="col-sm-4">
					<div class="credits"><?php _e('Designed By', 'cish');?> <a target="_blank" href="http://www.clic-lebanon.com"><?php _e('CLIC Agency', 'cish');?></a></div>
				</div>
				<div class="col-sm-3">
					<div class="social-media">
						<?php $MAIN->getSocialMedia();?>	
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer();?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1497489477171873&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

</body>
</html>