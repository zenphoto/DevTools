<?php
 /** 
  * The gallery index (home page) of a theme. Usually prints the top level albums
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
		<?php printGalleryDesc(); // the main gallery description ?>
		<?php while (next_album()): // the loop of the top level albums ?>
			<a href="<?php echo html_encode(getAlbumLinkURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo getAnnotatedAlbumTitle();?>"><?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?></a>
			<a href="<?php echo html_encode(getAlbumLinkURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo getAnnotatedAlbumTitle();?>"><?php printAlbumTitle(); ?></a>
			<?php printAlbumDate(""); ?>
			<?php printAlbumDesc(); ?>
		<?php endwhile; ?>
		<?php printPageListWithNav("« ".gettext("prev"), gettext("next")." »"); ?>
		<?php if (class_exists('RSS')) printRSSLink('Gallery','','RSS', ' | '); ?>
		<?php printZenphotoLink(); ?>
		<?php zp_apply_filter('theme_body_close'); ?>
	</body>
</html>