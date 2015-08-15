<?php
/** 
 * Custom theme page to display the slideshow (both included plugins) if not using the Colorbox mode
 */
if (!defined('WEBPATH')) die();
if (function_exists('printSlideShow')) {
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
			<?php printSlideShow(true, true); ?>
			<?php printZenphotoLink(); ?>
			<?php zp_apply_filter('theme_body_close'); ?>
		</body>
	</html>
<?php
} else {
	include(SERVERPATH . '/' . ZENFOLDER . '/404.php');
}
?>