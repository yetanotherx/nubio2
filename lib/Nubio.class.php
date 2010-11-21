<?php

class Nubio
{
  static public function slugify($text)
  {

	// replace non letter or digits by -
	$text = preg_replace('#[^\\pL\d]+#u', '-', $text);
	
	// trim
	$text = trim($text, '-');
	
	// transliterate
	if (function_exists('iconv'))
	{
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	}
	
	// lowercase
	$text = strtolower($text);
	
	// remove unwanted characters
	$text = preg_replace('#[^-\w]+#', '', $text);
	
	if (empty($text))
	{
	return 'n-a';
	}
	
	return $text;

  }
  
	static public function parseText( $text, $debug = false ) {
		if (sfConfig::get('sf_debug') && sfConfig::get('sf_logging_enabled')) $timer = sfTimerManager::getTimer("Nubio::parseText"); //Add the timer for this to the frontend_dev toolbar
		
		$url = 'http://en.wikipedia.org/w/api.php';
		
		$params = array(
			'action' => 'parse',
			'format' => 'php',
			'text' => $text
		);
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_HTTPHEADER, array('Expect:'));
		curl_setopt($ch,CURLOPT_ENCODING, 'gzip');
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_TIMEOUT,5);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
		curl_setopt($ch,CURLOPT_USERAGENT, 'Nubio Help Database - PHP ' . phpversion() );
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,0);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch,CURLOPT_URL,$url);
		$x = @unserialize( curl_exec( $ch ) );
		curl_close($ch);
		
		if( !$x || !is_array($x) || !isset( $x['parse']['text']['*']) || $debug ) {
			$text = trim($text);
		}
		else {
			$text = html_entity_decode( str_replace( '<a href="/', '<a href="http://en.wikipedia.org/', $x['parse']['text']['*'] ) );
			$text = trim( preg_replace('/<!--(.|\s)*?-->/', '', $text ) );
			if( substr( $text, 0, 3 ) == '<p>' ) $text = substr( $text, 3, -4 ); //get rid of <p> tags
		}
		
		if (sfConfig::get('sf_debug') && sfConfig::get('sf_logging_enabled')) $timer->addTime();
		return $text;
	}
	
	//Only public so the tests can use this
	static public function _parsePrettyUsername( $first, $last, $username ) {
		if( empty( $first ) ) $first = null;
		if( empty( $last ) ) $last = null;
		if( empty( $username ) ) $username = null;
		
		if( !is_null( $first ) && !is_null( $last ) ) {
			$pretty_username = sprintf( '%s %s (%s)', $first, $last, $username );
		}
		elseif( !is_null( $first ) ) {
			$pretty_username = sprintf( '%s (%s)', $first, $username );
			
		}
		elseif( !is_null( $last ) ) {
			$pretty_username = sprintf( '%s (%s)', $last, $username );
		}
		else {
			$pretty_username = $username;
		}
		return $pretty_username;
	}
	
	static public function parsePrettyUsername( $nubio_helper, $nubio_guard ) {
		return self::_parsePrettyUsername( $nubio_guard->getFirstName(), $nubio_guard->getLastName(), $nubio_guard->getUsername() );
	}
	
	public static function getRandTopicID() {
		$q = Doctrine_Core::getTable('NubioTopic')->createQuery('q')->fetchArray();
		
	  	return array_rand(array_keys($q)) + 1;
	}
  	
  	public static function getVerificationEmail( $params, $helper ) {
  		return sfContext::getInstance()->getMailer()->compose(
      		array('nubio@toolserver.org' => 'Nubio'),
      		$params['email_address'],
      		'Nubio account confirmation',
      		<<<EOF
Thank you for registering with Nubio!

To confirm your email address, please use the following link:

http://{$_SERVER['SERVER_NAME']}{$_SERVER['SCRIPT_NAME']}/userreg/confirm/{$helper->token}

Thank you!
-Nubio
EOF
    	);
  	}
  	
  public static function parseProps( $props ) {
  	$ret = "<ul>";
  	
  	if( isset( $props['oldcategory_id'] ) ) {
  		$ret .= "<li>Category ID changed from {$props['oldcategory_id']}";
  		
  		if( isset( $props['newcategory_id'] ) ) {
  			$ret .= " to {$props['newcategory_id']}</li>";
  		}
  		else {
  			$ret .= "</li>";
  		}
  	}
  	
  	if( isset( $props['oldsummary'] ) ) {
  		$ret .= "<li>Title changed from '{$props['oldsummary']}'";
  		
  		if( isset( $props['newsummary'] ) ) {
  			$ret .= " to '{$props['newsummary']}'</li>";
  		}
  		else {
  			$ret .= "</li>";
  		}
  	}
  	
  	if( isset( $props['oldkeywords'] ) ) {
  		$ret .= "<li>Keywords changed from '{$props['oldkeywords']}'";
  		
  		if( isset( $props['newkeywords'] ) ) {
  			$ret .= " to '{$props['newkeywords']}'</li>";
  		}
  		else {
  			$ret .= "</li>";
  		}
  	}
  	
  	$ret .= "</ul>";
  	
  	return $ret;
  }
  
  static public function getTokenType($validate)
  {
    $t = substr($validate, 0, 1);  
    if ($t == 'n')
    {
      return 'New';
    } 
    elseif ($t == 'r')
    {
      return 'Reset';
    }
    else
    {
      return sfView::NONE;
    }
  }
  
}