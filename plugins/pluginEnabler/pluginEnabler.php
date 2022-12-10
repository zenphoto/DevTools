<?php

/**
 *
 * Provides buttons to:
 * <ul>
 * 		<li>Remember the currently set plugins</li>
 * 		<li>Disable all plugins</li>
 * 		<li>Enable all plugins</li>
 * 		<li>Enable all <em>Zenphoto</em> plugins</li>
 * 		<li>Enable the above <i>remembered</i> set of plugins</li>
 * </ul>
 *
 * @package plugins
 * @subpackage development
 */
$plugin_is_filter = 5 | ADMIN_PLUGIN;
$plugin_description = gettext("Mass enable/disable for plugins.");
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.4.4';

zp_register_filter('admin_utilities_buttons', 'pluginEnabler::buttons');

class pluginEnabler {

	static function buttons($buttons) {
		$buttons[] = array(
				'category' => gettext('Development'),
				'enable' => true,
				'button_text' => gettext('Plugins » Zenphoto'),
				'formname' => 'enablebutton',
				'action' => FULLWEBPATH . '/' . USER_PLUGIN_FOLDER . '/pluginEnabler/handler.php',
				'icon' => FULLWEBPATH . '/' . ZENFOLDER . '/images/zp.png',
				'title' => gettext('Enables all Zenphoto plugins (except <em>show_not_logged-in</em>!) Third party plugins are disabled.'),
				'alt' => '',
				'hidden' => '<input type="hidden" name="pluginsEnable" value="1" />',
				'rights' => ADMIN_RIGHTS,
				'XSRFTag' => 'pluginEnabler'
		);
		$buttons[] = array(
				'category' => gettext('Development'),
				'enable' => true,
				'button_text' => gettext('Plugins » all'),
				'formname' => 'enablebutton',
				'action' => FULLWEBPATH . '/' . USER_PLUGIN_FOLDER . '/pluginEnabler/handler.php',
				'icon' => FULLWEBPATH . '/' . ZENFOLDER . '/images/pass.png',
				'title' => gettext('Enables all plugins.'),
				'alt' => '',
				'hidden' => '<input type="hidden" name="pluginsEnable" value="3" />',
				'rights' => ADMIN_RIGHTS,
				'XSRFTag' => 'pluginEnabler'
		);
		$buttons[] = array(
				'category' => gettext('Development'),
				'enable' => true,
				'button_text' => gettext('Plugins » remembered'),
				'formname' => 'enablebutton',
				'action' => FULLWEBPATH . '/' . USER_PLUGIN_FOLDER . '/pluginEnabler/handler.php',
				'icon' => FULLWEBPATH . '/' . ZENFOLDER . '/images/redo.png',
				'title' => gettext('Restores the plugin states to what was remembered.'),
				'alt' => '',
				'hidden' => '<input type="hidden" name="pluginsEnable" value="2" />',
				'rights' => ADMIN_RIGHTS,
				'XSRFTag' => 'pluginEnabler'
		);
		$buttons[] = array(
				'category' => gettext('Development'),
				'enable' => true,
				'button_text' => gettext('Plugins ¤ current'),
				'formname' => 'enablebutton',
				'action' => FULLWEBPATH . '/' . USER_PLUGIN_FOLDER . '/pluginEnabler/handler.php',
				'icon' => FULLWEBPATH . '/' . ZENFOLDER . '/images/arrow_down.png',
				'title' => gettext('Remembers current plugin states.'),
				'alt' => '',
				'hidden' => '<input type="hidden" name="pluginsRemember" value="1" />',
				'rights' => ADMIN_RIGHTS,
				'XSRFTag' => 'pluginEnabler'
		);
		$buttons[] = array(
				'category' => gettext('Development'),
				'enable' => true,
				'button_text' => gettext('Plugins × all'),
				'formname' => 'disablebutton',
				'action' => FULLWEBPATH . '/' . USER_PLUGIN_FOLDER . '/pluginEnabler/handler.php',
				'icon' => FULLWEBPATH . '/' . ZENFOLDER . '/images/reset.png',
				'title' => gettext('Disables all plugins except pluginEnabler.'),
				'alt' => '',
				'hidden' => '<input type="hidden" name="pluginsEnable" value="0" />',
				'rights' => ADMIN_RIGHTS,
				'XSRFTag' => 'pluginEnabler'
		);
		return $buttons;
	}

}

if (is_null(getOption('pluginEnabler_currentset'))) { // remember what things look like when we first arrive
	setOption('pluginEnabler_currentset', serialize(array_keys(getEnabledPlugins())));
}
?>