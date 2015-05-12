<?php

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'SkinPerPage' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['SkinPerPage'] = __DIR__ . '/i18n';
	$wgExtensionMessagesFiles['SkinPerPageMagic'] = __DIR__ . '/SkinPerPage.i18n.magic.php';
	/* wfWarn(
		'Deprecated PHP entry point used for SkinPerPage extension. Please use wfLoadExtension instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	); */
	return true;
} else {
	die( 'This version of the SkinPerPage extension requires MediaWiki 1.25+' );
}
