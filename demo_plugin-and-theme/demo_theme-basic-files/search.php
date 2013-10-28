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
		<?php
			zp_apply_filter('theme_body_open');
			$total = getNumImages() + getNumAlbums();
			if (!$total) {
				$_zp_current_search->clearSearchWords();
			}
		?>
		<?php printHomeLink('', ' | '); ?><a href="<?php echo html_encode(getGalleryIndexURL());?>" title="<?php echo ('Gallery Index'); ?>"><?php echo getGalleryTitle();?></a> | <?php echo gettext("Search");?>
		<?php printSearchForm("","search","",gettext("Search gallery")); ?>
		<?php
			if (($total = getNumImages() + getNumAlbums()) > 0) {
				if (isset($_REQUEST['date'])){
					$searchwords = getSearchDate();
 				} else { $searchwords = getSearchWords(); }
					echo sprintf(gettext('Total matches for <em>%1$s</em>: %2$u'), html_encode($searchwords), $total);
			}
			$c = 0;
		?>
		<?php while (next_album()): $c++;?>
			<a href="<?php echo html_encode(getAlbumLinkURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo getAnnotatedAlbumTitle();?>"><?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?></a>
			<a href="<?php echo html_encode(getAlbumLinkURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo getAnnotatedAlbumTitle();?>"><?php printAlbumTitle(); ?></a>
			<?php printAlbumDate(""); ?>
			<?php printAlbumDesc(); ?>
		<?php endwhile; ?>
		<?php while (next_image()): $c++;?>
			<a href="<?php echo html_encode(getImageLinkURL());?>" title="<?php echo getBareImageTitle();?>"><?php printImageThumb(getAnnotatedImageTitle()); ?></a>
			</div>
		<?php endwhile; ?>
		<?php
			if ($c == 0) {
				echo gettext("Sorry, no image matches found. Try refining your search.");
			}
		?>
		<?php printPageListWithNav("« ".gettext("prev"), gettext("next")." »"); ?>
		<?php printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ''); ?>
		<?php if (class_exists('RSS')) printRSSLink('Gallery','','RSS', ' | '); ?>
		<?php printZenphotoLink(); ?>
		<?php
			zp_apply_filter('theme_body_close');
		?>
	</body>
</html>