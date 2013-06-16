<?php
/**
 * ------------------------------------------------------------------------------------------------
 * NOTE: This is a raw functional example of a basic Zenphoto theme plugin.
 * For functional examples take a look at the official plugins
 * This plugin uses examples for a plugin based translation (gettext_pl).
 * ------------------------------------------------------------------------------------------------
 * You plugin should have in any case a comment block like this (phpdoc syntax), that explains what you plugin does and its usage
 *
 * @author author_name
 * @package plugins
 * 		(this should be kept)
 * @subpackage development
 * 		(sub tab/category your plugin should be shown on Zenphoto backend, here: development)
 */

/*
	flags this plugin as a filter type plugin and sets it load priority.
	The filters will be loaded in decending priority order. Normal front-end plugins should
	set this variable to 1. They will be loaded by index.php after the front-end environment has
	been established. Values greater than 1 will cause the plugin to load with the class libraries.
	These will be available to the admin scipts as well as to the front-end, but will load before
	the front-end environment is established. Values less than zero will load normally on the
	front-end but will also be available to the admin scripts.[1.2.6] The absolute value of value
	will be used for the load prioirity.[1.2.7] [1.4] There are three defines used in conjunction
	with this variable which control when in the script load process the plugin will be loaded.

They are:

- CLASS_PLUGIN->the plugin is loaded with the Zenphoto "classes" (album, image, etc.);
- ADMIN_PLUGIN->the plugin is loaded with the "classes", but only on the back-end;
- THEME_PLUGIN->the plugin is loaded once the theme context has been established.

NOTE: you "or" these to the base priority. It is permissable to "or" ADMIN_PLUGIN with THEME_PLUGIN to
get a plugin that operates in both environments. CLASS_PLUGIN stands alone as these plugins
will always be loaded.

NOTE: These variables are parsed from the file since they are used even if the plugin is not activated (=loaded). So you need to remove those you don't want to use, e.g. simply commenting out the $option_interface line will not do it if your plugin has no options. It would still be listed as plugin having options.
*/
$plugin_is_filter = 5|THEME_PLUGIN;

/*
Should be set to the text you wish displayed on the admin plugins tab description of the plugin
*/
$plugin_description = gettext_pl('This is a raw functional example of a basic Zenphoto theme plugin','zenphoto_demoplugin');

/*
The author of the plugin. This is also displayed on the plugins tab.
*/
$plugin_author = 'Author';

/*
Version of the plugin. Official plugins always have the version of the Zenphoto release automatically
*/
$plugin_version = '1.0';

/*
URL to the usage documentation for the plugin. For plugins distributed with Zenphoto this is an URL
to the PHP documentation page of the plugin on zenphoto.org.
*/
$plugin_url = '';

/*
controls setting the checkbox to enable the plugin. If the plugin cannot run, set this to the "reason"
and admin will display the "reason" and will not enable the plugin. The variable should not be present
or be set to empty the plugin may be enabled.
*/
$plugin_disable = '';

/*
If your plugin supports options, this variable should set to the option handler for the plugin.
Note: as from Zenphoto 1.4 the "name" of the class should be stored rather than an instantiation
of it. This is to eliminate unneeded class instantiations in the main-line of Zenphoto. We have
determined these are costly of performance.
*/
$option_interface = 'demoplugin_options';

/*
If your plugin requires something to be loaded, e.g. functions from its own plugin subfolder do this here.
The path resolves to <yourdomain>.com/plugins/<folder belonging to your plugin>/file.php
Note: Official plugins use the constant PLUGIN_FOLDER while 3rd party plugins residing in /plugins
 must to use the constant USER_PLUGIN_FOLDER*/
require_once(SERVERPATH.'/'.USER_PLUGIN_FOLDER.'/zenphoto_demoplugin/file.php');
/*
*/

/*
if you need to set any filters do this here. Here an example to add a specific javascript file to the theme head.
yourplugin_javascript is the name of the function to attach to the filter. See the plugin tutorial for details
on all available filters as some require special setup naturally. */
zp_register_filter('theme_head','demoplugin_javascript');
/*
 * the following filter calls a function in a file that was included by the above require_once statement
 */
zp_register_filter('theme_body_open','included');

/*
This is defined on the $option_interface setting above */
class demoplugin_options {

	/**
	 * class instantiation function
	 *
	 * @return admin_login
	 */
	function __construct() {
		// set like this all plugin option default values
		setOptionDefault('demoplugin_radiobuttons', 'suboption3');
		setOptionDefault('demoplugin_checkbox', 1); // use 0/1 or false/true for checkbox options
		setOptionDefault('demoplugin_customoption','default text');
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
			gettext_pl('Radio buttons option','zenphoto_demoplugin') => array( // The Title of your option that can be translated
				'key' => 'demoplugin_radiobuttons', // the real name of the option that is stored in the database.
																						// Good practice is to name these like yourdemoplugin_optionname
				'type' => OPTION_TYPE_RADIO, // this is generates an option interface for radio buttons
				'order' => 7, // the order position the option should have on the plugin option
				'buttons' => array( // The definition of the radio buttons to choose from and their values.
														//You can of course have more than three.
					gettext_pl('Suboption 1-a','zenphoto_demoplugin')=>'suboption1-a',
					gettext_pl('Suboption 1-b','zenphoto_demoplugin')=>'suboption1-b',
					gettext_pl('Suboption 1-c','zenphoto_demoplugin')=>'suboption1-c'
				),
				'desc' => gettext_pl('Description','zenphoto_demoplugin')
			), // The description of the option

			/* Checkbox list as an array */
			gettext_pl('Checkbox array list option','zenphoto_demoplugin') => array(
				'key' => 'demoplugin_checkbox_array',
				'type' => OPTION_TYPE_CHECKBOX_ARRAY,
				'order' => 0,
				'checkboxes' => array( // The definition of the checkboxes
					gettext_pl('Suboption 2-a','zenphoto_demoplugin')=>'suboption2-a',
					gettext_pl('Suboption 2-b','zenphoto_demoplugin')=>'suboption2-b',
					gettext_pl('Suboption 2-c','zenphoto_demoplugin')=>'suboption2-c'
				),
				'desc' => gettext_pl('Description','zenphoto_demoplugin')),

			/* Checkbox list as an unordered html list */
			gettext_pl('Checkbox list','zenphoto_demoplugin') => array(
				'key' => 'demoplugin_checkbox_list',
				'type' => OPTION_TYPE_CHECKBOX_UL,
				'order' => 0,
				'checkboxes' => array( // The definition of the checkboxes
					gettext_pl('Suboption 3-a','zenphoto_demoplugin')=>'suboption3-a',
					gettext_pl('Suboption 3-b','zenphoto_demoplugin')=>'suboption3-b',
					gettext_pl('Suboption 3-c','zenphoto_demoplugin')=>'suboption3-c'
				),
				'desc' => gettext_pl('Description','zenphoto_demoplugin')),

			/* One checkbox only option */
			 gettext_pl('One Checkbox option only','zenphoto_demoplugin') => array(
			 	'key' => 'demoplugin_checkbox',
			 	'type' => OPTION_TYPE_CHECKBOX,
				'order' => 2,
				'desc' => gettext_pl('Description','zenphoto_demoplugin')),

			/* Input text field option */
			gettext_pl('Input text field option','zenphoto_demoplugin') => array(
				'key' => 'demoplugin_textbox',
				'type' => OPTION_TYPE_TEXTBOX,
				'multilingual' => 1,	// optional if the field should be multilingual if Zenphoto is run in that mode.
															//Then there will be one input field per enabled language.
				'order' => 9,
				'desc' => gettext_pl('Description','zenphoto_demoplugin')),

			/* Password input field option */
			gettext_pl('Password input field option','zenphoto_demoplugin') => array(
				'key' => 'demoplugin_input_password',
				'type' => OPTION_TYPE_PASSWORD,
				'order' => 9,
				'desc' => gettext_pl('Description','zenphoto_demoplugin')),

			/* Cleartext option */
			gettext_pl('Cleartext input field option','zenphoto_demoplugin') => array(
				'key' => 'demoplugin_input_cleartext',
				'type' => OPTION_TYPE_CLEARTEXT,
				'order' => 9,
				'desc' => gettext_pl('Description','zenphoto_demoplugin')),

			/* Textareafield option */
			gettext_pl('Textarea field option','zenphoto_demoplugin') => array(
				'key' => 'demoplugin_textarea',
				'type' => OPTION_TYPE_TEXTAREA,
				'texteditor' => 1,		// optional to enable the visual editor TinyMCE on this field
				'multilingual' => 1,	// optional if the field should be multilingual if Zenphoto is run
															//in that mode. Then there will be one textarea per enabled language.
				'order' => 9,
				'desc' => gettext_pl('Description','zenphoto_demoplugin')),

			/* Dropdown selector option */
			gettext_pl('Dropdown selector option','zenphoto_demoplugin') => array(
				'key' => 'demoplugin_selector',
				'type' => OPTION_TYPE_SELECTOR,
				'order'=>1,
				'selections' => array( // The definition of the selector values. You can of course have more than three.
					gettext_pl('Suboption1','zenphoto_demoplugin')=>'suboption1',
					gettext_pl('Suboption2','zenphoto_demoplugin')=>'suboption2',
					gettext_pl('Suboption3','zenphoto_demoplugin')=>'suboption3'
				),
				'null_selection' => gettext_pl('Disabled','zenphoto_demoplugin'), // Provides a NULL value to select to the above selections
				'desc' => gettext_pl('Description.','zenphoto_demoplugin')),

			/* jQuery color picker option */
			gettext_pl('jQuery color picker option','zenphoto_demoplugin') => array(
				'key' => 'demoplugin_colorpicker',
				'type' => OPTION_TYPE_COLOR_PICKER,
				'desc' => gettext_pl('Description','zenphoto_demoplugin')),

		 	/* Custom option if none of the above standard ones fit your purpose. You define what to do and show within the method handleOption() below */
			gettext_pl('Custom option','zenphoto_demoplugin') => array(
				'key' => 'demoplugin_customoption', // note that this name is referenced in handleOption() below!
				'type' => OPTION_TYPE_CUSTOM,
				'desc' => gettext_pl('Custom option if none of the above standard ones fit your purpose. You define what to do and show within the method handleOption(). In this case we mask the input which in actuality is shown in the field below.','zenphoto_demoplugin'),getOption('demoplugin_customoption'))
			);

			/*
			Sometimes you might want to put out notes for example if someone tries to run the plugin but its server lacks support.
			Then there is an option type for notes only. You can add them like this: */
			if(!getOption('zp_plugin_zenphoto_demoplugin')) { // whatever you need to check (in this case that the plugin is enabled)
				$options['note'] = array(
					'key' => 'demoplugin_note',
					'type' => OPTION_TYPE_NOTE,
					'order' => 25,
					'desc' => gettext_pl('<p class="notebox">Sometimes you might want to put out notes for example if someone tries to run the plugin but its server lacks support.
																Then there is an option type for notes only</p>','zenphoto_demoplugin') // the class 'notebox' is a standard class for styling notes on the backend, there is also 'errorbox' for errors. Of cours
				);
			}
		return $options;
	}

	function handleOption($option, $currentValue) {
		/* Example to setup and call a custom option. In this case just a custom input field.
		 * Generally you can do anything you want with custom options.
		 *
		 * Here we have made a crude keystroke hider--the keys entered into the input field are recorded in a
		 * disabled (could have been hidden) input field and replaced in the "displayed" input field by asterisks.
		 */
		if($option == 'demoplugin_customoption') {
			?>
			<p>This is a custom option printing a custom "protected" input field. Custom option can be used if none of the above standard ones fit your purpose.</p>
			<input type="textbox" id="zenphoto_demoplugin_mask_input_show" size="40"  style="width: 338px" value="<?php echo html_encode($currentValue); ?>" />
			<input type="textbox" id="zenphoto_demoplugin_mask_input" size="40" name="demoplugin_customoption" value="<?php echo html_encode($currentValue); ?>" disabled="disabled" />
			<script type="text/javascript">
			<!--
			function zenphoto_demoplugin_mask_input() {
				var text_input = $('#zenphoto_demoplugin_mask_input_show').val();
				var text_actual = $('#zenphoto_demoplugin_mask_input').val();
				var text_save = '';
				var text_show = '';
				var l_actual = text_actual.length;
				var l_input = text_input.length;
				var c;
				for (i=0;i<l_input;i++) {
					c = text_input.substr(i,1);
					if (c == '*') {
						text_save = text_save + text_actual.substr(i,1);
					} else {
						text_save = text_save + c;
					}
					text_show = text_show+'*';
				}
				$('#zenphoto_demoplugin_mask_input').val(text_save);
				$('#zenphoto_demoplugin_mask_input_show').val(text_show);
			}

			// monitor the input field for changes
			$('#zenphoto_demoplugin_mask_input_show').bind('input', function() {
				zenphoto_demoplugin_mask_input();
			});

			$('#zenphoto_demoplugin_mask_input').val($('#zenphoto_demoplugin_mask_input_show').val())
			$('#zenphoto_demoplugin_mask_input_show').val('');	//	start with a clean slate.

			//-->
			</script>
			<?php
		}

		/**
		 * handleOptionSave() will be called if it has been defined. Its job is to process the
		 * posting of cusotm options.
		 * @param string $themename
		 * @param string $themealbum
		 */
		function handleOptionSave($themename, $themealbum) {
			if (isset($_POST['demoplugin_customoption'])) {
				setOption('demoplugin_customoption', sanitize($_POST['demoplugin_customoption']));
			}
		}

	}

	/*
	You can put your extra methods here as part of this class or use separate ones below. */

} // End of the option interface class of your plugin

/* Here your plugin functions or extra classes can go. If your plugin is more complex a class or the incorporation into the above one can be good practice */

/* We use a function here as an example for loading javascript on the theme using a filter (see above) */
	function demoplugin_javascript() {
		?>
		<script type="text/javascript" src="<?php echo WEBPATH.'/'.USER_PLUGIN_FOLDER.'/'.stripSuffix(basename(__FILE__)); ?>/javascript.js"></script>
		<?php
	}
	/* It is also good pratice to prefix or suffix function names according to the plugin so you easily spot them if used on a theme */
	function demoplugin_printHelloworld() {
		echo gettext_pl('Hello World!');
	}

?>