<?php

function wikiLink( $text, $page ) {
	return link_to( $text, 'http://en.wikipedia.org/wiki/' . rawurlencode( $page ) );
}

function popNamespace( &$text, $ns = null ) {
	$text = explode( ':', $text );
	if( !is_null( $ns ) ) {
		if( $ns == $text[0] ) {
			$ret = $text[0];
			unset($text[0]);
			$text = implode( ':', $text );
			return $ret;
		}
		else {
			return implode( ':', $text );
		}
	}
	$ret = $text[0];
	unset($text[0]);
	$text = implode( ':', $text );
	return $ret;
}
