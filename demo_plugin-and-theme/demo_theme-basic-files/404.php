<?php
/** 
 * If your theme contains this script it will be invoked whenever a page not found condition is raised by Zenphoto. 
 * Creating a script of this name allows you to control the presentaton of the page not found error. 
 */
if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="<?php echo LOCAL_CHARSET; ?>">
		<?php zp_apply_filter('theme_head'); ?>
		<?php printHeadTitle(); ?>
		<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
		<?php if (class_exists('RSS')) printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
	</head>
	<body>
		<?php zp_apply_filter('theme_body_open'); ?>
		<?php printGalleryTitle(); ?>
		<?php
			if (getOption('Allow_search')) {
				printSearchForm("","search","",gettext("Search gallery"));
			}
		?>
		<a href="<?php echo getGalleryIndexURL(); ?>">Index</a> » <?php echo gettext("Object not found"); ?>
	  <?php print404status(isset($album) ? $album : NULL, isset($image) ? $image : NULL, $obj); ?>
		<?php if (class_exists('RSS')) printRSSLink('Gallery','','RSS', ' | '); ?>
		<?php printZenphotoLink(); ?>
		<?php zp_apply_filter('theme_body_close'); ?>
	</body>
</html>