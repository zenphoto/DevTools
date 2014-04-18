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
	$lang = getOption('findQuotes_target');
	if ($lang == 'en_US') {
		$filepath = SERVERPATH . '/' . ZENFOLDER . '/locale/de_DE/LC_MESSAGES/zenphoto.po'; // presumed to be up-to-date
	} else {
		$filepath = SERVERPATH . '/' . ZENFOLDER . '/locale/' . $lang . '/LC_MESSAGES/zenphoto.po';
	}
	echo '</head>';
	?>
	<body>
		<?php printLogoAndLinks(); ?>
		<div id="main">
			<?php printTabs(); ?>
			<div id="content">
				<h1><?php echo $lang; ?></h1>
				<?php
				$text = file_get_contents($filepath);
				if ($text) {
					$lines = explode("\n", $text);
					$c = 0;
					while (!empty($lines)) {
						@set_time_limit(30);
						$line = trim(array_shift($lines));
						$c++;
						$msgids = array();
						if (strpos($line, 'msgid') === 0) {
							$msgids['msgid'] = trim(preg_replace('~msgid\s*~', '', $line), '"');
							$idln = $c;
							do {
								$line = trim(array_shift($lines));
								$c++;
								$done = strpos($line, 'msgstr') !== false || strpos($line, 'msgid_plural') !== false;
								if (!$done) {
									$msgids['msgid'] .= trim($line, '"');
								}
							} while (!$done);
							if (strpos($line, 'msgid_plural') !== false) {
								$msgids['msgid_plural'] = trim(preg_replace('~msgid_plural\s*~', '', $line), '"');
								do {
									$line = trim(array_shift($lines));
									$c++;
									$done = strpos($line, 'msgstr') !== false;
									if (!$done) {
										$msgids['msgid_plural'] .= trim($line, '"');
									}
								} while (!$done);
							}
							$msgstrs = array();
							preg_match('~(msgstr[\[\d+\]]*)~', $line, $matches);
							$msgstrs[$matches[1]] = trim(preg_replace('~msgstr[\[\d+\]]*\s*~', '', $line), '"');
							do {
								$line = trim(array_shift($lines));
								$c++;
								if (strpos($line, 'msgstr') !== false) {
									preg_match('~(msgstr[\[\d+\]]*)~', $line, $matches);
									$msgstrs[$matches[1]] = trim(preg_replace('~msgstr[\[\d+\]]*\s*~', '', $line), '"');
								} else {
									$done = empty($line);
									if (!$done)
										$msgstrs[$matches[1]] .= trim($line, '"');
								}
							} while (!$done);

							if (!empty($msgids)) {
								foreach ($msgids as $id => $msgid) {
									$listed = $double = $single = false;
									if (strpos($msgid, '"') === false) {
										//no English "
										foreach ($msgstrs as $str => $msgstr) {
											if (strpos($msgstr, '"') !== false) {
												//one inserted in the translation
												$double = '"';
											}
										}
									} else {
										if ($lang == 'en_US') {
											echo $idln . ':' . '<strong>' . $id . ':</strong> ' . html_encode($msgid) . '<br/>';
											$listed = true;
										}
									}
								}

								foreach ($msgids as $id => $msgid) {
									if (strpos($msgid, "'") === false) {
										//no English '
										foreach ($msgstrs as $str => $msgstr) {
											if (strpos($msgstr, "'") !== false) {
												//one inserted in the translation
												$single = "'";
											}
										}
									} else {
										if (!$listed && $lang == 'en_US') {
											echo $idln . ':' . '<strong>' . $id . ':</strong> ' . html_encode($msgid) . '<br/>';
										}
									}
								}
								if (($double || $single) && $lang != 'en_US') {

									echo '<br/>';
									if ($double && $single) {
										echo printf(gettext('At line %s translation has inserted both single and double quotes.'), $idln) . '<br/>';
									} else {
										if ($single) {
											echo printf(gettext('At line %s translation has inserted single quotes.'), $idln) . '<br/>';
										} else {
											echo printf(gettext('At line %s translation has inserted double quotes.'), $idln) . '<br/>';
										}
									}
									foreach ($msgids as $id => $msgid) {
										echo '<strong>' . $id . ':</strong> ' . html_encode($msgid) . '<br/>';
									}
									foreach ($msgstrs as $str => $msgstr) {
										echo '<strong>' . $str . ':</strong> ' . html_encode($msgstr) . '<br/>';
									}
								}
							}
						}
					}
				}
				?>
			</div>
		</div>
		<?php printAdminFooter(); ?>
	</body>
	<?php
}
?>
