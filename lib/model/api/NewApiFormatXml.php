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

class NewApiFormatXml extends NewApiFormatBase {

	private $mRootElemName = 'api';
	private $mDoubleQuote = false;

	public function getMimeType() {
		return 'text/xml';
	}

	public function getNeedsRawData() {
		return true;
	}

	public function setRootElement( $rootElemName ) {
		$this->mRootElemName = $rootElemName;
	}

	public function execute( $text, $params = array() ) {
		$this->mDoubleQuote = isset( $params['xmldoublequote'] ) ? $params['xmldoublequote'] : false;
		$this->printText( '<?xml version="1.0"?>' );
		$this->printText( self::recXmlPrint( $this->mRootElemName,
				$text,
				$this->getIsHtml() ? - 2 : null,
				$this->mDoubleQuote ) );
	}

	/**
	* This method takes an array and converts it to XML.
	* There are several noteworthy cases:
	*
	*  If array contains a key '_element', then the code assumes that ALL other keys are not important and replaces them with the value['_element'].
	*	Example:	name='root',  value = array( '_element'=>'page', 'x', 'y', 'z') creates <root>  <page>x</page>  <page>y</page>  <page>z</page> </root>
	*
	*  If any of the array's element key is '*', then the code treats all other key->value pairs as attributes, and the value['*'] as the element's content.
	*	Example:	name='root',  value = array( '*'=>'text', 'lang'=>'en', 'id'=>10)   creates  <root lang='en' id='10'>text</root>
	*
	* If neither key is found, all keys become element names, and values become element content.
	* The method is recursive, so the same rules apply to any sub-arrays.
	*/
	public static function recXmlPrint( $elemName, $elemValue, $indent, $doublequote = false ) {
		$retval = '';
		if ( !is_null( $indent ) ) {
			$indent += 2;
			$indstr = "\n" . str_repeat( " ", $indent );
		} else {
			$indstr = '';
		}
		$elemName = str_replace( ' ', '_', $elemName );

		switch ( gettype( $elemValue ) ) {
			case 'array' :
				if ( isset ( $elemValue['*'] ) ) {
					$subElemContent = $elemValue['*'];
					if ( $doublequote )
						$subElemContent = Sanitizer::encodeAttribute( $subElemContent );
					unset ( $elemValue['*'] );
					
					// Add xml:space="preserve" to the
					// element so XML parsers will leave
					// whitespace in the content alone
					$elemValue['xml:space'] = 'preserve';
				} else {
					$subElemContent = null;
				}

				if ( isset ( $elemValue['_element'] ) ) {
					$subElemIndName = $elemValue['_element'];
					unset ( $elemValue['_element'] );
				} else {
					$subElemIndName = null;
				}

				$indElements = array ();
				$subElements = array ();
				foreach ( $elemValue as $subElemId => & $subElemValue ) {
					if ( is_string( $subElemValue ) && $doublequote )
						$subElemValue = Sanitizer::encodeAttribute( $subElemValue );
					
					if ( gettype( $subElemId ) === 'integer' ) {
						$indElements[] = $subElemValue;
						unset ( $elemValue[$subElemId] );
					} elseif ( is_array( $subElemValue ) ) {
						$subElements[$subElemId] = $subElemValue;
						unset ( $elemValue[$subElemId] );
					}
				}

				if ( is_null( $subElemIndName ) && count( $indElements ) )
					die( __METHOD__ .  ": ($elemName, ...) has integer keys without _element value. Use ApiResult::setIndexedTagName()." );

				if ( count( $subElements ) && count( $indElements ) && !is_null( $subElemContent ) )
					die( __METHOD__ .  ": ($elemName, ...) has content and subelements" );

				if ( !is_null( $subElemContent ) ) {
					$retval .= $indstr . Xml::element( $elemName, $elemValue, $subElemContent );
				} elseif ( !count( $indElements ) && !count( $subElements ) ) {
						$retval .= $indstr . Xml::element( $elemName, $elemValue );
				} else {
					$retval .= $indstr . Xml::element( $elemName, $elemValue, null );

					foreach ( $subElements as $subElemId => & $subElemValue )
						$retval .= self::recXmlPrint( $subElemId, $subElemValue, $indent );

					foreach ( $indElements as $subElemId => & $subElemValue )
						$retval .= self::recXmlPrint( $subElemIndName, $subElemValue, $indent );

					$retval .= $indstr . Xml::closeElement( $elemName );
				}
				break;
			case 'object' :
				// ignore
				break;
			default :
				$retval .= $indstr . Xml::element( $elemName, null, $elemValue );
				break;
		}
		return $retval;
	}
}