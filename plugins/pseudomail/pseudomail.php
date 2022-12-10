<?php

/**
 * Pseudo mailing handler for localhost testing
 *
 * A "mail" file named by the <i>subject</i> is created in the <var>%DATA_FOLDER%</var> folder. Multiple mailings with the
 * same <i>subject</i> will overwrite.
 *
 * @package plugins
 * @subpackage mail
 */
$plugin_is_filter = 5 | CLASS_PLUGIN;
$plugin_description = gettext("Pseudo mailing handler for localhost testing.");
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.4.3';
$plugin_disable = (zp_has_filter('sendmail') && !extensionEnabled('pseudomail')) ? sprintf(gettext('Only one Email handler plugin may be enabled. <a href="#%1$s"><code>%1$s</code></a> is already enabled.'), stripSuffix(get_filterScript('sendmail'))) : '';

if ($plugin_disable) {
	enableExtension('pseudomail', 0);
} else {
	zp_register_filter('sendmail', 'pseudo_sendmail');
}

function pseudo_sendmail($msg, $email_list, $subject, $message, $from_mail, $from_name, $cc_addresses, $replyTo) {
	$filename = str_replace(array('<', '>', ':', '"' . '/' . '\\', '|', '?', '*'), '_', $subject);
	$path = SERVERPATH . '/' . DATA_FOLDER . '/' . $filename . '.txt';
	$f = fopen($path, 'w');
	fwrite($f, str_pad('*', 49, '-') . "\n");
	$tolist = '';
	foreach ($email_list as $to) {
		$tolist .= ',' . $to;
	}
	fwrite($f, sprintf(gettext('To: %s'), substr($tolist, 1)) . "\n");
	fwrite($f, sprintf('From: %1$s <%2$s>', $from_name, $from_mail) . "\n");
	if ($replyTo) {
		$names = array_keys($replyTo);
		fwrite($f, sprintf('Reply-To: %1$s <%2$s>', array_shift($names), array_shift($replyTo)) . "\n");
	}
	if (count($cc_addresses) > 0) {
		$cclist = '';
		foreach ($cc_addresses as $cc_name => $cc_mail) {
			$cclist .= ',' . $cc_mail;
		}
		fwrite($f, sprintf(gettext('Cc: %s'), substr($cclist, 1)) . "\n");
	}
	fwrite($f, sprintf(gettext('Subject: %s'), $subject) . "\n");
	fwrite($f, str_pad('*', 49, '-') . "\n");
	fwrite($f, $message . "\n");
	fclose($f);
	clearstatcache();
	return $msg;
}

?>