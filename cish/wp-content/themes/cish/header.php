<!-- developed by ps -->
<?php
global $post;
global $MAIN;
$MAIN->setIsHome( is_home() );
if ( is_singular ('program') ) :
	$MAIN->setProgram( $post->post_name );
endif;
if ( is_singular ('event') ) :
	$MAIN->setEvent( $post );
endif;

$MAIN->kickstart();
?>
<!DOCTYPE HTML>
<html>

<head>
	<?php
	getHeaderStuff();
	$MAIN->getHeadIncludesBefore();
	wp_head();
	?>
</head>

<body id="daBody" <?php body_class( ICL_LANGUAGE_CODE );?> style="<?php $MAIN->bodyStyle();?>">
	<div class="header-mobile">
		<div class="container">
			<div class="row">
				<div class="col-xs-2">
					<a href="javascript:void(0)" id="menu-button-mobile">
						<span>&nbsp;</span>
						<span>&nbsp;</span>
						<span>&nbsp;</span>
					</a>
				</div>
				<div class="col-lg-8 col-md-7 col-xs-10 col-header-langs">
					<div class="clearfix">
						<ul class="langs">
							<li class="lang-english"><a href="<?php $MAIN->sB()?>">English</a></li>
							<li class="lang-french"><a href="<?php $MAIN->sB();?>/fr">Français</a></li>
							<li class="lang-arabic"><a href="<?php $MAIN->sB();?>/ar">العربية</a></li>
						</ul>
						<span class="label-lang"><?php _e('Language','cish');?>:</span>
					</div>
				</div>
			</div>
		</div>
		<div id="menu-mobile">
			<?php $MAIN->getSiteMenu( array('hideSubmenu'=>1) );?>
		</div>
	</div>
		
	<div id="wrap">
		<header>
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-5">
						<ul class="mini-nav">
							<li class="<?php $MAIN->checkActiveMenu('');?>"><a href="<?php $MAIN->sBL();?>"><?php _e('Home', 'cish');?></a></li>
							<li class="<?php $MAIN->checkActiveMenu('events');?>"><a href="<?php $MAIN->getPermalink('events');?>"><?php _e('Events', 'cish');?></a></li>
							<li class="<?php $MAIN->checkActiveMenu('publications');?>"><a href="<?php $MAIN->getPermalink('publications');?>"><?php _e('Publications', 'cish');?></a></li>
							<li class="<?php $MAIN->checkActiveMenu('contact-us');?>"><a href="<?php $MAIN->getPermalink('contact-us');?>"><?php _e('Contact us', 'cish');?></a></li>
						</ul>
					</div>
					<div class="col-lg-8 col-md-7 col-header-langs">
						<div class="clearfix">
							<div class="phone-number-w">
								<span class="phone-number"><?php _e('+961 9 545400 / 01 / 03','cish');?></span>
							</div>
							<ul class="langs">
								<li class="lang-english"><a href="<?php $MAIN->sB()?>">English</a></li>
								<li class="lang-french"><a href="<?php $MAIN->sB();?>/fr">Français</a></li>
								<li class="lang-arabic"><a href="<?php $MAIN->sB();?>/ar">العربية</a></li>
							</ul>
							<span class="label-lang"><?php _e('Language','cish');?>:</span>
						</div>
					</div>
				</div>
			</div>
		</header>
		
		<div id="section-logo">
			<a href="<?php bloginfo('url');?>"><img class="img-responsive" src="<?php echo $MAIN->getSetting('logo_'.ICL_LANGUAGE_CODE);?>" /></a>
		</div>
		
		<nav>
			<div class="container">
				<div class="row">
					<div class="col-md-9 sf-menu">
						<?php $MAIN->getSiteMenu();?>
					</div>
					<div class="col-md-3" id="col-search">
						<form id="form-search" action="<?php bloginfo("url");?>" method="get">
							<input class="form-field" data-placeholder="" type="text" name="s" value="<?php _e('Search entire site here...','cish');?>"/>
						</form>
					</div><!-- 3-->
				</div>
			</div>
		</nav>
		
<div id="page-<?php echo $MAIN->getParentPageSlug();?>" class="all-content page-<?php echo $MAIN->getChildPageSlug();?>">

<?php if ( function_exists('yoast_breadcrumb') ) {?>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div id="breadcrumbs">
					<?php yoast_breadcrumb("","");?>
				</div>
			</div>
		</div>
	</div><?php
}
?>