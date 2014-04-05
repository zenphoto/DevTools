<?php
/** 
 * Standard theme page for 404 errors for not found items
 */
if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php zp_apply_filter('theme_head'); ?>
		<?php printHeadTitle(); ?>
		<meta charset="<?php echo LOCAL_CHARSET; ?>"><!-- HTML5 style -->
		<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" /><!-- Old HTML style - Fallback for older browsers -->
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
		<?php
			zp_apply_filter('theme_body_close');
		?>
	</body>
</html>