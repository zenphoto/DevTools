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
 */

function stripEscaped($str) {
	$str = str_replace('\\"', '', $str);
	$str = str_replace("\\'", '', $str);
	return $str;
}

function findQuotes_button($buttons) {
	$buttons[] = array(
					'category'		 => gettext('Development'),
					'enable'			 => true,
					'button_text'	 => gettext('findQuotes'),
					'formname'		 => 'findQuotes',
					'action'			 => WEBPATH . "/" . USER_PLUGIN_FOLDER . '/' . 'findQuotes.php',
					'icon'				 => 'images/burst.png',
					'title'				 => gettext('Find injected quotes'),
					'alt'					 => '',
					'hidden'			 => '',
					'rights'			 => ADMIN_RIGHTS,
	);
	return $buttons;
}

function nextLine() {
	global $handle, $linecounter;
	while (!feof($handle)) {
		$line = trim(fgets($handle));
		$linecounter++;

		if (@$line{0} != '#') {
			return $line;
		}
	}
	return NULL;
}

if (defined('OFFSET_PATH')) {
	zp_register_filter('admin_utilities_buttons', 'findQuotes_button');
} else {
	define('OFFSET_PATH', 3);
	require_once(dirname(dirname($_SERVER['SCRIPT_NAME'])) . '/zp-core/functions.php');
	require_once(SERVERPATH . '/' . ZENFOLDER . '/admin-globals.php');
	zp_register_filter('admin_tabs', 'findQuotes_admin_tab');
	setOptionDefault('findingQuotes_target', 'de_DE');
	printAdminHeader('overview', 'findQuotes');
	echo '</head>';
	$list = generateLanguageList('all');
	$lang = NULL;
	if (isset($_POST['language'])) {
		$selected = $lang = sanitize($_POST['language']);
		setOption('findingQuotes_target', $lang);
	} else {
		$selected = getOption('findingQuotes_target');
	}
	?>
	<body>
		<?php printLogoAndLinks(); ?>
		<div id="main">
			<?php printTabs(); ?>
			<div id="content">
				<h1><?php echo gettext('Find injected quotes in translation files.'); ?></h1>
				<form	action="<?php echo WEBPATH . "/" . USER_PLUGIN_FOLDER . '/' . 'findQuotes.php'; ?>" method="post">
					<select name="language">
						<?php generateListFromArray(array($selected), $list, false, true); ?>
					</select>
					<button type="submit"><?php echo gettext('Go'); ?></button>
				</form>
				<?php
				if ($lang) {
					if ($lang == 'en_US') {
						$filepath = SERVERPATH . '/' . ZENFOLDER . '/locale/de_DE/LC_MESSAGES/zenphoto.po'; // presumed to be up-to-date
					} else {
						$filepath = SERVERPATH . '/' . ZENFOLDER . '/locale/' . $lang . '/LC_MESSAGES/zenphoto.po';
					}

					$handle = fopen($filepath, 'r');
					if ($handle) {
						while (!feof($handle)) {
							@set_time_limit(30);
							$msgids = array();
							$line = nextLine();
							if (strpos($line, 'msgid') === 0) {
								$msgids['msgid'] = trim(preg_replace('~msgid\s*~', '', $line), '"');
								$idln = $linecounter;
								do {
									$line = nextLine();
									$done = strpos($line, 'msgstr') !== false || strpos($line, 'msgid_plural') !== false;
									if (!$done) {
										$msgids['msgid'] .= trim($line, '"');
									}
								} while (!$done);
								if (strpos($line, 'msgid_plural') !== false) {
									$msgids['msgid_plural'] = trim(preg_replace('~msgid_plural\s*~', '', $line), '"');
									do {
										$line = nextLine();
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
									$line = nextLine();
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
										if (strpos(stripEscaped($msgid), '"') === false) {
											//no English "
											foreach ($msgstrs as $str => $msgstr) {
												if (strpos(stripEscaped($msgstr), '"') !== false) {
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
										if (strpos(stripEscaped($msgid), "'") === false) {
											//no English '
											foreach ($msgstrs as $str => $msgstr) {
												if (strpos(stripEscaped($msgstr), "'") !== false) {
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
											echo sprintf(gettext('At line %s translation has inserted both single and double quotes.'), $idln) . '<br/>';
										} else {
											if ($single) {
												echo sprintf(gettext('At line %s translation has inserted single quotes.'), $idln) . '<br/>';
											} else {
												echo sprintf(gettext('At line %s translation has inserted double quotes.'), $idln) . '<br/>';
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
				}
				?>
			</div>
		</div>
		<?php printAdminFooter(); ?>
	</body>
	<?php
}
?>
