<?php
/* Looks for "spontaneous" quotations in language translateions
 *
 * @package plugins
 * @subpackage development
 *

  $plugin_is_filter = 5 | ADMIN_PLUGIN;
  $plugin_description = gettext('Use to locate programatic quotations that have been injected by translations.');
  $plugin_author = "Stephen Billard (sbillard)";
  $plugin_version = '1.4.6';

  $option_interface = 'findQuotes_options';
 */

class findQuotes_options {

	function __construct() {
		setOptionDefault('findQuotes_target', 'de_DE');
	}

	function getOptionsSupported() {
		$list = generateLanguageList('all');
		$options = array(gettext('Language')	 => array('key'				 => 'findQuotes_target', 'type'			 => OPTION_TYPE_SELECTOR,
										'selections' => $list,
										'desc'			 => gettext('Select the language file to be examined.')),
						gettext('go')				 => array('key'	 => 'findQuotes_execute', 'type' => OPTION_TYPE_CUSTOM,
										'desc' => gettext('Process the “po” file.'))
		);
		return $options;
	}

	function handleOption($option, $currentValue) {
		?>
		<input type="button" name="findQuotes" value="<?php printf(gettext('Process %s'), getOption('findQuotes_target')); ?>" onclick="launchScript('<?php echo WEBPATH . '/' . USER_PLUGIN_FOLDER . '/findQuotes.php'; ?>', [])"></input>
		<?php
	}

}

if (!defined('OFFSET_PATH')) {
	define('OFFSET_PATH', 3);
	require_once(dirname(dirname($_SERVER['SCRIPT_NAME'])) . '/zp-core/admin-globals.php');
	printAdminHeader('overview', 'DB');
	echo "\n</head>";
	echo "\n<body>";

	printLogoAndLinks();
	echo "\n" . '<div id="main">';
	printTabs();

	echo "\n" . '<div id="content">';
	printAdminFooter();
	$lang = getOption('findQuotes_target');
	$filepath = SERVERPATH . '/' . ZENFOLDER . '/locale/' . $lang . '/LC_MESSAGES/zenphoto.po';
	$text = file_get_contents($filepath);
	if ($text) {
		$lines = explode("\n", $text);
		?>
		<h1><?php echo $lang; ?></h1>
		<?php
		while (!empty($lines)) {
			$line = trim(array_shift($lines));
			if (strpos($line, 'msgid') === 0) {
				$msgid = trim(preg_replace('~msgid\s*~', '', $line), '"');
				do {
					$line = trim(array_shift($lines));
					$done = strpos($line, 'msgstr') !== false;
					if (!$done) {
						$msgid .= trim($line, '"');
					}
				} while (!$done);
				$msgstr = trim(preg_replace('~msgstr\s*~', '', $line), '"');
				do {
					$line = trim(array_shift($lines));
					$done = empty($line);
					if (!$done)
						$msgstr .= trim($line, '"');
				} while (!$done);
				if (!empty($msgid)) {
					$double = $single = false;
					if (strpos($msgid, '"') === false) {
						//no English "
						if (strpos($msgstr, '"' !== false)) {
							//one inserted in the translation
							$double = '"';
						}
					}
					if (strpos($msgid, "'") === false) {
						//no English '
						if (strpos($msgstr, "'") !== false) {
							//one inserted in the translation
							$single = "'";
						}
					}
					if ($double || $single) {
						echo '<br/>';
						if ($double && $single) {
							echo gettext('Translation has inserted both single and double quotes.') . '<br/>';
						} else {
							if ($single) {
								echo gettext('Translation has inserted single quotes.') . '<br/>';
							} else {
								echo gettext('Translation has inserted double quotes.') . '<br/>';
							}
						}
						echo '<strong>$msgid:</strong>' . html_encode($msgid) . '<br/>';
						echo '<strong>$msgstr:</strong>' . html_encode($msgstr) . '<br/>';
					}
				}
			}
		}
	}
	echo "\n</body>";
	echo "\n</head>";
}