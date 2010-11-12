<?php

class NubioApi
{
	
	public static function apiPrint( $arr, sfWebRequest $request ) {
		$formats = array(
	  		'xml' => 'NewApiFormatXml',
	  		'xmlfm' => 'NewApiFormatXml',
	  		'json' => 'NewApiFormatJson',
	  		'jsonfm' => 'NewApiFormatJson',
	  		'php' => 'NewApiFormatPhp',
	  		'phpfm' => 'NewApiFormatPhp',
	  		'txt' => 'NewApiFormatTxt',
	  		'txtfm' => 'NewApiFormatTxt',
	  		'yaml' => 'NewApiFormatYaml',
	  		'yamlfm' => 'NewApiFormatYaml',
	  	);
	  	if( !isset( $formats[$request->getParameter( 'format', 'xmlfm' )] ) ) $formats[$request->getParameter( 'format', 'xmlfm' )] = $formats['xmlfm'];
	  	
	  	
	  	//unset _element values on non XML formats
	  	$func = function( $val ) use ( $formats, $request ) {
	  		if( $formats[$request->getParameter( 'format', 'xmlfm' )] == 'NewApiFormatXml' ) return $val;
	  		foreach( $val as $key => $value ) {
	  			if( $key = '_element' ) {
	  				unset( $val[$key] );
	  			}
	  			elseif( is_array( $value ) ) {
	  				$val[$key] = $func($value);
	  			}
	  		}
	  		return $val;
	  	};
	  	
	  	$printer = new $formats[$request->getParameter( 'format', 'xmlfm' )]( $request->getParameter( 'format' ) );
		$printer->setUnescapeAmps ( /*$this->mAction == 'help' &&*/ $printer->getFormat() == 'XML' && $printer->getIsHtml() );
		
		$printer->initPrinter( false );
		$printer->execute( array( 'query' => array( 'result' => $func($arr) ) ), $request->getRequestParameters() );
		$printer->closePrinter();
		die();
	}
	
	public static function revisionList( $arr ) {
		foreach( $arr as $key => $val ) {
	    	$arr[$key] = array(
	    		'id' => $val['id'],
	    		'user' => array(
	    			'id' => $val['helper_id'],
	    			'name' => $val['NubioHelper']['sfGuardUser']['username'],
	    			'first_name' => $val['NubioHelper']['sfGuardUser']['first_name'],
	    			'last_name' => $val['NubioHelper']['sfGuardUser']['last_name'],
	    			'is_admin' => ( $val['NubioHelper']['sfGuardUser']['is_super_admin'] ) ? 'yes' : 'no',
	    			'registration' => $val['NubioHelper']['sfGuardUser']['created_at'],
	    			'blocked' => ( $val['NubioHelper']['is_blocked'] ) ? 'yes' : 'no',
	    		),
	    		'topic_id' => $val['topic_id'],
	    		'*' => $val['text'],
	    		'comment' => $val['comment'],
	    		'props_change' => unserialize( $val['props'] ),
	    		'timestamp' => date( 'YmdHis', strtotime( $val['created_at'] ) )
	    	);
	    }
	    $arr['_element'] = 'rev';
	    return $arr;
	}
	
	public static function topicList( $arr ) {
		foreach( $arr as $key => $val ) {
	    	$arr[$key] = array(
	    		'id' => $val['id'],
	    		'summary' => $val['summary'],
	    		'*' => $val['NubioRevision']['text'],
	    		'keywords' => $val['keywords'],
	    		'category_id' => $val['category_id'],
	    		'category_name' => $val['NubioCategory']['name'],
	    		'created_at' => $val['created_at'],
	    		'updated_at' => $val['updated_at'],
	    	);
	    }
	    $arr['_element'] = 'topic';
	    return $arr;
	}
	
	public static function categoryList( $arr ) {
		foreach( $arr as $key => $val ) {
	    	$arr[$key] = array(
	    		'id' => $val['id'],
	    		'name' => $val['name'],
	    	);
	    }
	    $arr['_element'] = 'category';
	    return $arr;
	}
	
	public static function helperList( $arr ) {
		foreach( $arr as $key => $val ) {
	    	$arr[$key] = array(
	    		'id' => $val['id'],
	    		'username' => $val['sfGuardUser']['username'],
	    		'wikiname' => $val['wikiname'],
	    		'first_name' => $val['sfGuardUser']['first_name'],
	    		'last_name' => $val['sfGuardUser']['last_name'],
	    		'is_admin' => ( $val['sfGuardUser']['is_super_admin'] ) ? 'yes' : 'no',
	    		'registration' => $val['sfGuardUser']['created_at'],
	    		'blocked' => ( $val['is_blocked'] ) ? 'yes' : 'no',
	    	);
	    }
	    $arr['_element'] = 'user';
	    return $arr;
	}
  
}