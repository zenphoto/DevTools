<?php
/**
 * This is an optional (static) custom theme page example to provide a simple contact way using the contact_form plugin
 */
	// force UTF-8
	if (!defined('WEBPATH')) die();
	if (function_exists('printContactForm')) { // To avoid errors if the contact form plugin is not enable and the page is accessed
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
				<?php printContactForm(); // the contact form plugin function ?>
				<?php if (class_exists('RSS')) printRSSLink('Gallery','','RSS', ' | '); ?>
				<?php printZenphotoLink(); ?>
				<?php zp_apply_filter('theme_body_close'); ?>
			</body>
		</html>
	<?php
	} else {
		include(SERVERPATH . '/' . ZENFOLDER . '/404.php');
	}
	?>