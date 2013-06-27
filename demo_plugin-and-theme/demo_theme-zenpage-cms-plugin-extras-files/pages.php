<?php
	// force UTF-8
	if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php zp_apply_filter('theme_head'); ?>
		<title><?php if(!isset($ishomepage)) { echo getBarePageTitle(); } ?> | <?php echo getBareGalleryTitle(); ?></title>
		<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
		<?php printZenpageRSSHeaderLink("Pages","", "Zenpage news", ""); ?>
	</head>
	<body>
		<?php zp_apply_filter('theme_body_open'); ?>
		<?php printHomeLink('', ' | '); ?><a href="<?php echo html_encode(getGalleryIndexURL());?>" title="<?php echo ('Gallery Index'); ?>"><?php echo getGalleryTitle();?></a> | <?php printZenpageItemsBreadcrumb(" &raquo; ",""); ?>
		<?php 	
			if (getOption('Allow_search')) { 
				printSearchForm("","search","",gettext("Search gallery")); 
			} 
		?>
		<?php printPageTitle(); ?>		
		<?php printPageContent(); ?>
		<?php	printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ', ');	?>
		<?php printRSSLink('Gallery','','RSS', ' | '); ?>
		<?php printZenpageRSSLink("News","","",gettext("News"),''); ?>
		<?php 
			printAdminToolbox();
			zp_apply_filter('theme_body_close');
		?>
	</body>
</html>
