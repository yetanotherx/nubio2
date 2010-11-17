<?php

/*
 * Created on Sep 19, 2006
 *
 * API for MediaWiki 1.8+
 *
 * Copyright (C) 2006 Yuri Astrakhan <Firstname><Lastname>@gmail.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * This is the abstract base class for API formatters.
 *
 * @ingroup API
 */
abstract class NewApiFormatBase {

	private $mIsHtml, $mIsTest, $mFormat, $mUnescapeAmps, $mHelp, $mCleared;
	private $mBufferResult = false, $mBuffer;

	/**
	 * Constructor
	 * If $format ends with 'fm', pretty-print the output in HTML.
	 * @param $main ApiMain
	 * @param $format string Format name
	 */
	public function __construct( $format ) {
		if( is_null( $format) ) $format = 'xmlfm';
		
		$this->mIsHtml = ( substr( $format, - 2, 2 ) === 'fm' ); // ends with 'fm'
		if ( $this->mIsHtml )
			$this->mFormat = substr( $format, 0, - 2 ); // remove ending 'fm'
		else
			$this->mFormat = $format;
		$this->mFormat = strtoupper( $this->mFormat );
		$this->mCleared = false;
		
		$this->mIsTest = sfConfig::get( 'sf_environment' ) == 'test';

	}

	/**
	 * Overriding class returns the mime type that should be sent to the client.
	 * This method is not called if getIsHtml() returns true.
	 * @return string
	 */
	public abstract function getMimeType();

	/**
	 * Whether this formatter needs raw data such as _element tags
	 * @return bool
	 */
	public function getNeedsRawData() {
		return false;
	}

	/**
	 * Get the internal format name
	 * @return string
	 */
	public function getFormat() {
		return $this->mFormat;
	}

	/**
	 * Specify whether or not sequences like &amp;quot; should be unescaped
	 * to &quot; . This should only be set to true for the help message
	 * when rendered in the default (xmlfm) format. This is a temporary
	 * special-case fix that should be removed once the help has been
	 * reworked to use a fully HTML interface.
	 *
	 * @param $b bool Whether or not ampersands should be escaped.
	 */
	public function setUnescapeAmps ( $b ) {
		$this->mUnescapeAmps = $b;
	}

	/**
	 * Returns true when the HTML pretty-printer should be used.
	 * The default implementation assumes that formats ending with 'fm'
	 * should be formatted in HTML.
	 * @return bool
	 */
	public function getIsHtml() {
		return $this->mIsHtml;
	}
	
	/**
	 * getIsTest function.
	 * Returns true if in the test environment
	 * 
	 * @access public
	 * @return void
	 */
	public function getIsTest() {
		return $this->mIsTest;
	}

	/**
	 * Whether this formatter can format the help message in a nice way.
	 * By default, this returns the same as getIsHtml().
	 * When action=help is set explicitly, the help will always be shown
	 * @return bool
	 */
	public function getWantsHelp() {
		return $this->getIsHtml();
	}

	/**
	 * Initialize the printer function and prepare the output headers, etc.
	 * This method must be the first outputing method during execution.
	 * A help screen's header is printed for the HTML-based output
	 * @param $isError bool Whether an error message is printed
	 */
	function initPrinter( $isError ) {
		$isHtml = $this->getIsHtml();
		$mime = $isHtml ? 'text/html' : $this->getMimeType();
		$script = sfConfig::get( 'sf_web_dir' ) . '/api.php' ;

		// Some printers (ex. Feed) do their own header settings,
		// in which case $mime will be set to null
		if ( is_null( $mime ) )
			return; // skip any initialization

		if( !$this->getIsTest() ) header( "Content-Type: $mime; charset=utf-8" );

		if ( $isHtml ) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<?php if ( $this->mUnescapeAmps ) {
?>	<title>Nubio API</title>
<?php } else {
?>	<title>Nubio API Result</title>
<?php } ?>
</head>
<body>
<?php


			if ( !$isError ) {
?>
<br />
<small>
You are looking at the HTML representation of the <?php echo( $this->mFormat ); ?> format.<br />
HTML is good for debugging, but probably is not suitable for your application.<br />
See <a href='http://www.mediawiki.org/wiki/API'>complete documentation</a>, or
<a href='<?php echo( $script ); ?>'>API help</a> for more information.
</small>
<?php


			}
?>
<pre>
<?php


		}
	}

	/**
	 * Finish printing. Closes HTML tags.
	 */
	public function closePrinter() {
		if ( $this->getIsHtml() ) {
?>

</pre>
</body>
</html>
<?php


		}
	}

	/**
	 * The main format printing function. Call it to output the result
	 * string to the user. This function will automatically output HTML
	 * when format name ends in 'fm'.
	 * @param $text string
	 */
	public function printText( $text ) {
		if ( $this->mBufferResult ) {
			$this->mBuffer = $text;
		} elseif ( $this->getIsHtml() ) {
			echo $this->formatHTML( $text );
		} else {
			// For non-HTML output, clear all errors that might have been
			// displayed if display_errors=On
			// Do this only once, of course
			if ( !$this->mCleared )
			{
				ob_clean();
				$this->mCleared = true;
			}
			echo $text;
		}
	}

	/**
	 * Get the contents of the buffer.
	 */
	public function getBuffer() {
		return $this->mBuffer;
	}
	/**
	 * Set the flag to buffer the result instead of printing it.
	 */
	public function setBufferResult( $value ) {
		$this->mBufferResult = $value;
	}

	/**
	 * Sets whether the pretty-printer should format *bold* and $italics$
	 * @param $help bool
	 */
	public function setHelp( $help = true ) {
		$this->mHelp = true;
	}

	/**
	* Prety-print various elements in HTML format, such as xml tags and
	* URLs. This method also escapes characters like <
	* @param $text string
	* @return string
	*/
	protected function formatHTML( $text ) {
		global $wgUrlProtocols;

		// Escape everything first for full coverage
		$text = htmlspecialchars( $text );

		// encode all comments or tags as safe blue strings
		$text = preg_replace( '/\&lt;(!--.*?--|.*?)\&gt;/', '<span style="color:blue;">&lt;\1&gt;</span>', $text );
		// identify URLs
		$protos = implode( "|", $wgUrlProtocols );
		// This regex hacks around bug 13218 (&quot; included in the URL)
		$text = preg_replace( "#(($protos).*?)(&quot;)?([ \\'\"<>\n]|&lt;|&gt;|&quot;)#", '<a href="\\1">\\1</a>\\3\\4', $text );
		// identify requests to api.php
		$text = preg_replace( "#api\\.php\\?[^ \\()<\n\t]+#", '<a href="\\0">\\0</a>', $text );
		if ( $this->mHelp ) {
			// make strings inside * bold
			$text = preg_replace( "#\\*[^<>\n]+\\*#", '<b>\\0</b>', $text );
			// make strings inside $ italic
			$text = preg_replace( "#\\$[^<>\n]+\\$#", '<b><i>\\0</i></b>', $text );
		}

		/* Temporary fix for bad links in help messages. As a special case,
		 * XML-escaped metachars are de-escaped one level in the help message
		 * for legibility. Should be removed once we have completed a fully-html
		 * version of the help message. */
		if ( $this->mUnescapeAmps )
			$text = preg_replace( '/&amp;(amp|quot|lt|gt);/', '&\1;', $text );

		return $text;
	}

	protected function getExamples() {
		return 'api.php?format=' . $this->getModuleName();
	}

	public function getDescription() {
		return $this->getIsHtml() ? ' (pretty-print in HTML)' : '';
	}

	public static function getBaseVersion() {
		return __CLASS__ . ': $Id: ApiFormatBase.php 62367 2010-02-12 14:09:42Z siebrand $';
	}
}
