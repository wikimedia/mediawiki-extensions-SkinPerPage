<?php
if (!defined('MEDIAWIKI')) die();

/**
 * @file
 * @ingroup Extensions
 */

$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'Skin per page',
	'version'        => '1.1.0',
	'author'         => array( 'Tim Starling', 'Calimonius the Estrange' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:SkinPerPage',
	'descriptionmsg' => 'skinperpage-desc',
);

$wgMessagesDirs['SkinPerPage'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['SkinPerPageMagic'] = __DIR__ . '/SkinPerPage.i18n.magic.php';

$wgHooks['ParserFirstCallInit'][] = 'SkinPerPage::onParserFirstCallInit';
$wgHooks['OutputPageParserOutput'][] = 'SkinPerPage::onOutputPageParserOutput';

$wgAutoloadClasses['SkinPerPage'] = __DIR__ . '/SkinPerPage.body.php';
