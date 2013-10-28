<?php
	// force UTF-8
	if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php zp_apply_filter('theme_head'); ?>
		<?php printHeadTitle(); ?>
		<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
		<?php if (class_exists('RSS')) printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
  </head>
	<body>
		<?php zp_apply_filter('theme_body_open'); ?>
		<?php printHomeLink('', ' | '); ?><a href="<?php echo html_encode(getGalleryIndexURL());?>" title="<?php echo gettext('Albums Index'); ?>"><?php echo getGalleryTitle();?></a> | <?php printParentBreadcrumb(); ?><?php printAlbumTitle();?>
		<?php
			if (getOption('Allow_search')) {
				printSearchForm("","search","",gettext("Search gallery"));
			}
		?>
		<?php if (hasPrevImage()) { ?>
			<a href="<?php echo html_encode(getPrevImageURL());?>" title="<?php echo gettext("Previous Image"); ?>"><?php echo gettext("prev"); ?></a>
		<?php } if (hasNextImage()) { ?>
			<a href="<?php echo html_encode(getNextImageURL());?>" title="<?php echo gettext("Next Image"); ?>"><?php echo gettext("next"); ?></a>
		<?php } ?>
		<?php printHomeLink('', ' | '); ?><a href="<?php echo html_encode(getGalleryIndexURL());?>" title="<?php gettext('Albums Index'); ?>"><?php echo getGalleryTitle();?></a> | <?php printParentBreadcrumb("", " | ", " | "); printAlbumBreadcrumb("", " | "); ?><?php printImageTitle(true); ?>
		<a href="<?php echo html_encode($fullimage);?>" title="<?php echo getBareImageTitle();?>">
			<?php printDefaultSizedImage(getImageTitle()); ?>
		</a>
		<?php printImageDesc(); ?>
		<?php
			if (getImageMetaData()) {
				printImageMetadata('', false); ;
			}
		?>
		<?php printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ''); ?>
		<?php if (class_exists('RSS')) printRSSLink('Gallery','','RSS', ' | '); ?>
		<?php printZenphotoLink(); ?>
		<?php
			zp_apply_filter('theme_body_close');
		?>
	</body>
</html>