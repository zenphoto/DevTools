<?php

/**
 * A plugin to print raw image EXIF and IPTC meta data debug info on a theme image.php as PHP nativeely parses it before our formatting is applied. Attaches to the theme_body_close filter.
 *
 * @author Malte Müller (acrylian) <info@maltem.de>
 * @copyright 2024 Malte Müller
 * @license GPL v3 or later
 * @package plugins
 * @subpackage development
 */
$plugin_is_filter = 9 | THEME_PLUGIN;
$plugin_description = gettext('A plugin to print raw image EXIF and IPTC meta data debug info on a theme image.php as PHP nativeely parses it before our formatting is applied. Attaches to the theme_body_close filter.');
$plugin_author = 'Malte Müller (acrylian)';
$plugin_category = gettext('Development');
$plugin_version = '1.0b';

zp_register_filter('theme_body_close', 'imageMetadataRaw::printMetadataRaw');

class imageMetadataRaw {

	static function printMetadataRaw() {
		global $_zp_current_image, $_zp_graphics;

		if (zp_loggedin(ADMIN_RIGHTS)) {
			echo '<div style="background: white; color: black; font-size: 16px;">';
			$exifraw = read_exif_data_protected($_zp_current_image->localpath);
			if ($exifraw) {
				echo "<p>EXIF</p><pre>";
				print_r($exifraw);
				echo "</pre>";
			} else {
				echo '<p>No EXIF data</p>';
			}
			$iptcdata = $_zp_graphics->imageIPTC($_zp_current_image->localpath);
			$iptc = iptcparse($iptcdata);
			if ($iptc) {
				echo "<p>IPTC</p><pre>";

				print_r($iptc);
				echo "</pre>";
			} else {
				echo '<p>No IPTC data</p>';
			}
			echo '</div>';
		}
	}

}
