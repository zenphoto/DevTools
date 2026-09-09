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
$plugin_disable = (filter::hasFilter('sendmail') && !extensionEnabled('pseudomail')) ? sprintf(gettext('Only one Email handler plugin may be enabled. <a href="#%1$s"><code>%1$s</code></a> is already enabled.'), stripSuffix(get_filterScript('sendmail'))) : '';

if ($plugin_disable) {
	enableExtension('pseudomail', 0);
} else {
	filter::registerFilter('sendmail', 'pseudo_sendmail');
}

function pseudo_sendmail($msg, $email_list, $subject, $message, $from_mail, $from_name, $cc_addresses, $replyTo) {
	$tolist = '';
	foreach ($email_list as $to) {
		$tolist .= ',' . $to;
	}
	
	$content = sprintf(gettext('To: %s'), substr($tolist, 1)) . "\n";
	if (empty($from_name)) {
		$from_name = getGalleryTitle();
	}
	if (empty($from_mail)) {
		$from_mail = getOption('site_email');
	}
	$content .= sprintf('From: %1$s <%2$s>', $from_name, $from_mail) . "\n";
	if ($replyTo) {
		$names = array_keys($replyTo);
		$content .= sprintf('Reply-To: %1$s <%2$s>', array_shift($names), array_shift($replyTo)) . "\n";
	}
	if (count($cc_addresses) > 0) {
		$cclist = '';
		foreach ($cc_addresses as $cc_name => $cc_mail) {
			$cclist .= ',' . $cc_mail;
		}
		$content .= sprintf(gettext('Cc: %s'), substr($cclist, 1)) . "\n";
	}
	$content .= sprintf(gettext('Subject: %s'), $subject) . "\n";
	$content .= $message . "\n";
	$content .= str_pad('*', 49, '-') . "\n";
	debuglog(trim($content), false, 'pseudomail');
	return $msg;
}
