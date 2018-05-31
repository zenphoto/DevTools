<?php
/* Creates the zenphoto.package file
 *
 * @author Stephen Billard (sbillard)
 * @package plugins
 * @subpackage development
 */
$plugin_is_filter = 5|ADMIN_PLUGIN;
$plugin_description = gettext('Generates the <em>zenphoto.package</em> file.');
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.4.3';
$option_interface = 'zenphoto_package';

zp_register_filter('admin_utilities_buttons', 'zenphoto_package_button');

class zenphoto_package {
	function __construct() {
		setOptionDefault('zenphoto_package_path', ZENFOLDER);
	}

	function getOptionsSupported() {
		return array(gettext('Folder') => array('key' => 'zenphoto_package_path', 'type' => OPTION_TYPE_SELECTOR,
										'selections' => array(DATA_FOLDER=>DATA_FOLDER,ZENFOLDER=>ZENFOLDER,UPLOAD_FOLDER=>UPLOAD_FOLDER),
										'desc' => gettext('Place the package file in this folder.')));
	}
}

function zenphoto_package_button($buttons) {
	$buttons[] = array(
								'category'=>gettext('Development'),
								'enable'=>true,
								'button_text'=>gettext('Create package'),
								'formname'=>'zenphoto_package_button',
								'action'=>WEBPATH.'/plugins/zenphoto_package/zenphoto_package_generator.php',
								'icon'=>'images/arrow_down.png',
								'title'=>gettext('Download new Zenphoto package file'),
								'alt'=>'',
								'hidden'=>'',
								'rights'=>ADMIN_RIGHTS,
								);
	return $buttons;
}
?>