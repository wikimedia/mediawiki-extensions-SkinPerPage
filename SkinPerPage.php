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
$wgExtensionMessagesFiles['SkinPerPage'] = dirname( __FILE__ ) . "/SkinPerPage.i18n.php";
$wgExtensionMessagesFiles['SkinPerPageMagic'] = dirname( __FILE__ ) . '/SkinPerPage.i18n.magic.php';

$wgHooks['ParserFirstCallInit'][] = 'SkinPerPage::setup';
$wgHooks['OutputPageParserOutput'][] = 'SkinPerPage::outputHook';

class SkinPerPage {
	static function setup( $parser ) {
		# Old one for backwards compatibility
		$parser->setHook( 'skin', array( __CLASS__, 'parserHook' ) );
		# Function-style one that users should actually use
		$parser->setFunctionHook( 'useskin', array( __CLASS__, 'outputHook2' ) );
		return true;
	}

	static function parserHook( $text, $attribs, $parser ) {
		$parser->mOutput->spp_skin = $text;
		return '';
	}
	static function outputHook( $out, $parserOutput ) {
		if ( isset( $parserOutput->spp_skin ) ) {
			SkinPerPage::renderHook( $parserOutput->spp_skin );
		}
		return true;
	}

	static function outputHook2( $parser, $skin = '' ) {
		SkinPerPage::renderHook( $skin );
	}

	static function renderHook( $skin ) {
		$skin = trim( strtolower( $skin ) );
		RequestContext::getMain()->setSkin( Skin::newFromKey( $skin ) );
	}
}
