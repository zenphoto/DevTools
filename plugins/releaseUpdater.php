<?php
/**
 * This plugin will update the <i>release number</i> define in <var>version.php</var>
 *
 * This is a <b>Development tools</b> plugin. It is intended to make it easier for
 * developers to keep a running <i>release number</i> when making changes to the Zenphoto application.
 * Of course it is also necessary to commit the changed file to the GitHub repository. This should happen
 * automatically if you commit other changes. If you do not make any (other) changes there is, of course, no need
 * to commit a new release number!
 *
 * The plugin will update the <i>release number</i> once a day so long as you use the installation. (You do remember to test your changes,
 * don't you!)
 *
 * The <i>release number</i> will be set based on the number of days since October 19, 2012. An offset is added so that these
 * numbers are greater than the Zenphoto release prior to the <i>GitHub</i> change-over.
 *
 *
 *
 * <b>NOTE:</b> You <b>MUST</b> change the <var>VERSION_FILE</var> define to point to your
 * clone of the Zenphoto repository. You must also change the <var>TIMEOFFSET</var> define to
 * adjust your local time to GMT. My server returns local time for the <var>time()</var> function
 * so the define is set to add 8 hours to get GMT from Pacific time.
 *
 * @author Stephen Billard (sbillard)
 * @package plugins
 * @subpackage development
 */

$plugin_is_filter = 2|CLASS_PLUGIN;
$plugin_description = gettext('Updates the Zenphoto "release" number.');
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.4.4';
$option_interface = 'releaseUpdater';

class releaseUpdater {

	function __construct() {
		setOptionDefault('releaseUpdater_loc', SERVERPATH.'/'.ZENFOLDER.'/version.php');
	}

	function getOptionsSupported() {
		return array(	gettext('File location') => array('key' => 'releaseUpdater_loc', 'type' => OPTION_TYPE_TEXTBOX,
												'desc' => gettext('Path to the version file to be updated.')));
	}
}

$file = getOption('releaseUpdater_loc');
if (file_exists($file)) {

	list($y,$m,$d) = explode('-',gmdate('Y-m-d'));

	if ($m > 2) {
	    $m = $m - 3;
	} else {
	    $m = $m + 9 ;
	    $yy = $y - 1;
	}

	$c = $y / 100 ; $ya = $y - 100 * $c ;
	$j = (int) floor((146097 * $c) / 4 + (1461 * $ya) / 4 + (153 * $m + 2) / 5 + $d + 1721119);
	$j = $j - 2456220 + 10980;	//October 19, 2012 is the base date, 10980 is the base release #


	$f = file_get_contents($file);

	preg_match('/define\(\'ZENPHOTO_RELEASE\',\s*([0-9]*)\);/', $f, $matches);
	if ($matches[1] != $j) {
		$f = str_replace($matches[0], 'define(\'ZENPHOTO_RELEASE\', '.$j.');', $f);
		file_put_contents($file, $f);
	}

} else {
	zp_register_filter('admin_note', 'patherror');
	function patherror($tab) {
		if ($tab == 'Overview'){
			echo '<p class="errorbox">'.gettext('<code>releaseUpdater</code> says: version.php was not found.').'</p>';
		}
		return $tab;
	}
}
?>