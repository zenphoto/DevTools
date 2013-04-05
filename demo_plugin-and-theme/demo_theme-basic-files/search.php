<?php
	// force UTF-8
	if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php zp_apply_filter('theme_head'); ?>
		<title><?php echo getBareGalleryTitle(); ?> | <?php echo gettext("Search"); ?></title>
		<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
		<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
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
		<?php printRSSLink('Gallery','','RSS', ' | '); ?>
		<?php printZenphotoLink(); ?>
		<?php
			zp_apply_filter('theme_body_close');
		?>
	</body>
</html>