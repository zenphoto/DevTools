<?php
	// force UTF-8 
	if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo gettext("News"); ?> <?php echo getBareNewsTitle(""); ?><?php printCurrentNewsCategory(" | "); printCurrentNewsArchive(); ?> | <?php echo getBareGalleryTitle(); ?></title>
		<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
		<?php printZenpageRSSHeaderLink("News","", "Zenpage news", ""); ?>
		<?php zp_apply_filter('theme_head'); ?>
	</head>
	<body>
		<?php zp_apply_filter('theme_body_open'); ?>
		<?php printHomeLink('', ' | '); ?><a href="<?php echo getGalleryIndexURL(false); ?>"><?php echo gettext("Index"); ?></a> <?php printNewsIndexURL(gettext('News'),' &raquo; '); ?><strong><?php printZenpageItemsBreadcrumb(' &raquo; ',''); printCurrentNewsCategory(" &raquo; "); ?><?php printNewsTitle(" &raquo; "); printCurrentNewsArchive(" &raquo; "); ?>
		<?php 	
			if (getOption('Allow_search')) { 
				printSearchForm("","search","",gettext("Search gallery")); 
			} 
		?>
		<?php 
		if(is_NewsArticle()) { // single news article
  		if(getPrevNewsURL()) { 
  			printPrevNewsLink(); 
  		} 
  		if(getNextNewsURL()) { 
  			printNextNewsLink(); 
  		} 
  		printNewsTitle(); 
  		printNewsDate();
  		printNewsCategories(", ",gettext("Categories: "),"newscategories"); ?>
			printNewsContent(); 
			printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ', '); 		
		} else { // news article loop
			while (next_news()): ;?>
 				printNewsTitleLink(); 
 				printNewsDate();
				if(is_GalleryNewsType()) { //required for Zenpage's CombiNews mode
					if(!is_NewsType("album")) {
						echo " | ".gettext("Album:")."<a href='".getNewsAlbumURL()."' title='".getBareNewsAlbumTitle()."'> ".getNewsAlbumTitle()."</a>";
					} 
				} else {
					echo ' | '; printNewsCategories(", ",gettext("Categories: "),"newscategories");
				}
				printNewsContent();
   			printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ', '); 
 			endwhile;
 			printNewsPageListWithNav(gettext('next &raquo;'), gettext('&laquo; prev'),true,'pagelist',true);
		} 
		?>
		<?php printRSSLink('Gallery','','RSS', ' | '); ?>
		<?php printZenpageRSSLink("News","","",gettext("News"),''); ?>
		<?php 
			printAdminToolbox();
			zp_apply_filter('theme_body_close');
		?>
	</body>
</html>