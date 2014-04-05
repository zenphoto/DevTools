<?php
/** 
 * Custom theme page for displaying the yearly and monthly archive of gallery items
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
		<a href="<?php echo getGalleryIndexURL(); ?>" title="<?php gettext('Index'); ?>"><?php echo gettext("Index"); ?></a> » <strong><?php echo gettext("Archive View"); ?>
		<?php
			if (getOption('Allow_search')) {
				printSearchForm("","search","",gettext("Search gallery"));
			}
		?>
		<a href="<?php echo getGalleryIndexURL(); ?>">Index</a> » <?php echo gettext("Object not found"); ?>
		<?php printAllDates(); // prints the gallery archive list by year and month ?>
		<?php printAllTagsAs('cloud', 'tags'); // a tag cloud of all tags ?>
		<?php printZenphotoLink(); ?>
		<?php zp_apply_filter('theme_body_close'); ?>
	</body>
</html>