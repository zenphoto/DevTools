<?php
/** 
 * This page is almost identical to index.php. Standard theme page for sub level album list and/or the thumbnail overview of images within an album
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
		<?php if (class_exists('RSS')) printRSSHeaderLink('Album',getAlbumTitle()); ?>
</head>
	<body>
		<?php zp_apply_filter('theme_body_open'); ?>
		<?php printHomeLink('', ' | '); ?><a href="<?php echo html_encode(getGalleryIndexURL());?>" title="<?php echo gettext('Albums Index'); ?>"><?php echo getGalleryTitle();?></a> | <?php printParentBreadcrumb(); ?><?php printAlbumTitle();?>
		<?php
			if (getOption('Allow_search')) {
				printSearchForm("","search","",gettext("Search gallery"));
			}
		?>
		<?php printAlbumDesc(); ?>
		<?php while (next_album()): // the loop of the sub albums within the album ?>
			<a href="<?php echo html_encode(getAlbumLinkURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo getAnnotatedAlbumTitle();?>"><?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?></a>
			<a href="<?php echo html_encode(getAlbumLinkURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo getAnnotatedAlbumTitle();?>"><?php printAlbumTitle(); ?></a>
			<?php printAlbumDate(""); ?>
			<?php printAlbumDesc(); // the album description?>
			<?php
				// Optional support for the favoritse plugin 
				if (function_exists('printAddToFavorites')) {
					printAddToFavorites($_zp_current_album);
				}
			?> 
		<?php endwhile; ?>
		<?php while (next_image()): // the loop of the image within the album ?>
			<a href="<?php echo html_encode(getImageLinkURL());?>" title="<?php echo getBareImageTitle();?>"><?php printImageThumb(getAnnotatedImageTitle()); ?></a>
			<?php
				// Optional support for the favoritse plugin 
				if (function_exists('printAddToFavorites')) {
					printAddToFavorites($_zp_current_image);
				}
			?>
		<?php 
			endwhile; 
			printPageListWithNav("« ".gettext("prev"), gettext("next")." »"); 
			printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ''); 
			if (class_exists('RSS')) printRSSLink('Gallery','','RSS', ' | '); 
			//Support for the comment form plugin
			if (function_exists('printCommentForm')) {
				printCommentForm();  
			} 
			printZenphotoLink(); 
			zp_apply_filter('theme_body_close');
		?>
	</body>
</html>