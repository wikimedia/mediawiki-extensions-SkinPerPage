<?php

class SkinPerPage {
	/**
	 * Register our extension tag and parser function
	 *
	 * @param Parser $parser
	 * @return bool
	 */
	public static function onParserFirstCallInit( Parser $parser ) {
		# Old one for backwards compatibility
		$parser->setHook( 'skin', array( __CLASS__, 'parserHook' ) );
		# Function-style one that users should actually use
		$parser->setFunctionHook( 'useskin', array( __CLASS__, 'useskinHook' ) );
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
			$key = Skin::normalizeKey( trim( strtolower( $parserOutput->spp_skin ) ) );
			if ( class_exists( 'SkinFactory' ) ) {
				$skin = SkinFactory::getDefaultInstance()->makeSkin( $key );
			} else {
				$skin = Skin::newFromKey( $key );
			}
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
		SkinPerPage::parserHook( $skin, array(), $parser );
	}
}