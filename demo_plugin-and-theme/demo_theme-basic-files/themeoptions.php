<?php

// force UTF-8 Ø

/* Plug-in for theme option handling
 * The Admin Options page tests for the presence of this file in a theme folder
 * If it is present it is linked to with a require_once call.
 * If it is not present, no theme options are displayed.
 *
 */
/*
	This is optional and here required because of the usage of the function generateListFromArray() within handleOption() below
*/
require_once(dirname(__FILE__).'/functions.php');

class ThemeOptions {

	/*
		Here you set default values of your options.
		The options here an an example of the default theme
	*/
	function ThemeOptions() {
		setThemeOptionDefault('Allow_search', true);
		setThemeOptionDefault('demoTheme_colors', 'none');
		setThemeOptionDefault('albums_per_page', 6);
		setThemeOptionDefault('albums_per_row', 2);
		setThemeOptionDefault('images_per_page', 20);
		setThemeOptionDefault('images_per_row', 5);
		setThemeOptionDefault('image_size', 595);
		setThemeOptionDefault('image_use_side', 'longest');
		setThemeOptionDefault('thumb_size', 100);
		setThemeOptionDefault('thumb_crop_width', 100);
		setThemeOptionDefault('thumb_crop_height', 100);
		setThemeOptionDefault('thumb_crop', 1);
		setThemeOptionDefault('thumb_transition', 1);

		/*
			You can of course also set other options if your theme requires this.
			This example enables the colorbox plugin if it is used for the theme pages noted.
		*/
		setOptionDefault('colorbox_default_album', 1);
		setOptionDefault('colorbox_default_image', 1);
		setOptionDefault('colorbox_default_search', 1);

		/*
			This is adds support for the cache manager so you can pre-cache your thumbs and other sized images as defined.
			Zenphoto generally does this on the fly when needed but on very slow servers or if you have really a lot of images that also are quite big
			it might be necessary to do this.
		*/
		if (class_exists('cacheManager')) {
			cacheManager::deleteThemeCacheSizes('default');
			cacheManager::addThemeCacheSize('default', getThemeOption('image_size'), NULL, NULL, NULL, NULL, NULL, NULL, false, getOption('fullimage_watermark'), NULL, NULL);
			cacheManager::addThemeCacheSize('default', getThemeOption('thumb_size'), NULL, NULL, getThemeOption('thumb_crop_width'), getThemeOption('thumb_crop_height'), NULL, NULL, true, getOption('Image_watermark'), NULL, NULL);
		}
	}
	/**
	 * Reports the supported options
	 *
	 * @return array
	 */
	function getOptionsSupported() {
		/*
			The option definitions are stored in a multidimensional array. There are several predefine option types.
			Options types are the same for plugins and themes.
		*/
		$options = array(

			/* Radio buttons */
			gettext('Radio buttons option') => array( // The Title of your option that can be translated
				'key' => 'demo_theme_radiobuttons', // the real name of the option that is stored in the database.
																						// Good practice is to name these like yourdemoplugin_optionname
				'type' => OPTION_TYPE_RADIO, // this is generates an option interface for radio buttons
				'order' => 7, // the order position the option should have on the plugin option
				'buttons' => array( // The definition of the radio buttons to choose from and their values.
														//You can of course have more than three.
					gettext('Suboption 1-a')=>'suboption1-a',
					gettext('Suboption 1-b')=>'suboption1-b',
					gettext('Suboption 1-c')=>'suboption1-c'
				),
				'desc' => gettext('Description')
			), // The description of the option

			/* Checkbox list as an array */
			gettext('Checkbox array list option') => array(
				'key' => 'demo_theme_checkbox_array',
				'type' => OPTION_TYPE_CHECKBOX_ARRAY,
				'order' => 0,
				'checkboxes' => array( // The definition of the checkboxes
					gettext('Suboption 2-a')=>'suboption2-a',
					gettext('Suboption 2-b')=>'suboption2-b',
					gettext('Suboption 2-c')=>'suboption2-c'
				),
				'desc' => gettext('Description')),

			/* Checkbox list as an unordered html list */
			gettext('Checkbox list') => array(
				'key' => 'demo_theme_checkbox_list',
				'type' => OPTION_TYPE_CHECKBOX_UL,
				'order' => 0,
				'checkboxes' => array( // The definition of the checkboxes
					gettext('Suboption 3-a')=>'suboption3-a',
					gettext('Suboption 3-b')=>'suboption3-b',
					gettext('Suboption 3-c')=>'suboption3-c'
				),
				'desc' => gettext('Description')),

			/* One checkbox only option - This example is a general theme option */
			gettext('Allow search') => array(
				'key' => 'Allow_search',
				'type' => OPTION_TYPE_CHECKBOX,
				'order' => 2,
				'desc' => gettext('Check to enable search form.')),

			/* Input text field option */
			gettext('Input text field option') => array(
				'key' => 'demo_theme_textbox',
				'type' => OPTION_TYPE_TEXTBOX,
				'multilingual' => 1,	// optional if the field should be multilingual if Zenphoto is run in that mode.
															//Then there will be one input field per enabled language.
				'order' => 9,
				'desc' => gettext('Description')),

			/* Password input field option */
			gettext('Password input field option') => array(
				'key' => 'demo_theme_input_password',
				'type' => OPTION_TYPE_PASSWORD,
				'order' => 9,
				'desc' => gettext('Description')),

			/* Cleartext option */
			gettext('Cleartext input field option') => array(
				'key' => 'demo_theme_input_cleartext',
				'type' => OPTION_TYPE_CLEARTEXT,
				'order' => 9,
				'desc' => gettext('Description')),

			/* Textareafield option */
			gettext('Textarea field option') => array(
				'key' => 'demo_theme_textarea',
				'type' => OPTION_TYPE_TEXTAREA,
				'texteditor' => 1,		// optional to enable the visual editor TinyMCE on this field
				'multilingual' => 1,	// optional if the field should be multilingual if Zenphoto is run
															//in that mode. Then there will be one textarea per enabled language.
				'order' => 9,
				'desc' => gettext('Description')),

			/* Dropdown selector option */
			gettext('Dropdown selector option') => array(
				'key' => 'demo_theme_selector',
				'type' => OPTION_TYPE_SELECTOR,
				'order'=>1,
				'selections' => array( // The definition of the selector values. You can of course have more than three.
					gettext('Suboption1')=>'suboption1',
					gettext('Suboption2')=>'suboption2',
					gettext('Suboption3')=>'suboption3'
				),
				'null_selection' => gettext('Disabled'), // Provides a NULL value to select to the above selections
				'desc' => gettext('Description.')),

			/* jQuery color picker option */
			gettext('jQuery color picker option') => array(
				'key' => 'demo_theme_colorpicker',
				'type' => OPTION_TYPE_COLOR_PICKER,
				'desc' => gettext('Description')),

		 	/* Custom option if none of the above standard ones fit your purpose. You define what to do and show within the method handleOption() below */
			gettext('Theme colors') => array(
				'key' => 'demoTheme_colors',
				'type' => OPTION_TYPE_CUSTOM,
				'desc' => gettext('Select the colors of the theme'))
			);

			/*
			Sometimes you might want to put out notes for example if someone tries to run the plugin but its server lacks support.
			Then there is an option type for notes only. You can add them like this: */
			if(!getOption('zp_theme_demo_theme')) { // whatever you need to check (in this case that the plugin is enabled)
				$options['note'] = array(
					'key' => 'demotheme_note',
					'type' => OPTION_TYPE_NOTE,
					'order' => 25,
					'desc' => gettext('<p class="notebox">Sometimes you might want to put out notes for example this version of the demo theme expects that the <strong>adminToolbox</strong> is inserted via the <code>theme_body_close</code> <em>filter</em>.
																Then there is an option type for notes only</p>') // the class 'notebox' is a standard class for styling notes on the backend, there is also 'errorbox' for errors. Of cours
				);
			}
		return $options;
	}
	// If your theme for example uses specific image sizes for layout reasons you can disable the standard image size options here
  function getOptionsDisabled() {
  	return array('custom_index_page','image_size');
  }

	function handleOption($option, $currentValue) {
		$themecolors = array('red', 'white','blue', 'none');
		if ($option == 'demoTheme_colors') {
			echo '<select id="demoTheme_themeselect_colors" name="' . $option . '"' . ">\n";
			generateListFromArray(array($currentValue), $themecolors, false, false);
			echo "</select>\n";
		}
	}
}
?>