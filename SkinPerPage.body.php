<?php

use MediaWiki\MediaWikiServices;

class SkinPerPage {
	/**
	 * Register our extension tag and parser function
	 *
	 * @param Parser $parser
	 * @return bool
	 */
	public static function onParserFirstCallInit( Parser $parser ) {
		# Old one for backwards compatibility
		$parser->setHook( 'skin', [ __CLASS__, 'parserHook' ] );
		# Function-style one that users should actually use
		$parser->setFunctionHook( 'useskin', [ __CLASS__, 'useskinHook' ] );
		return true;
	}

	/**
	 * Handler for <skin>foo</skin>
	 */
	public static function parserHook( $text, $attribs, Parser $parser ) {
		$parser->mOutput->spp_skin = $text;
		return '';
	}

	/**
	 * Reads the skin key from ParserOutput and sets it as the skin to use for display
	 *
	 * @param OutputPage $out
	 * @param ParserOutput $parserOutput
	 * @return bool
	 */
	public static function onOutputPageParserOutput( OutputPage $out, ParserOutput $parserOutput ) {
		if ( isset( $parserOutput->spp_skin ) ) {
			$key = Skin::normalizeKey( strtolower( trim( $parserOutput->spp_skin ) ) );

			$skin = MediaWikiServices::getInstance()->getSkinFactory()->makeSkin( $key );

			RequestContext::getMain()->setSkin( $skin );
		}
		return true;
	}

	/**
	 * Handler for {{#useskin:foo}}
	 *
	 * @param Parser $parser
	 * @param string $skin
	 */
	public static function useskinHook( Parser $parser, $skin = '' ) {
		self::parserHook( $skin, [], $parser );
	}
}
