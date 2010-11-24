<?php
/**
 * @author Soxred93
 */

if( !function_exists( 'is_ip_address' ) ) {	
	/**
	 * Checks if $ip is a valid IPv4 address
	 * 
	 * @access public
	 * @param string $ip
	 * @return bool
	 */
	function is_ip_address( $ip ) {
		return (bool) ( long2ip( ip2long( $ip ) ) == $ip );
	}

}
if( !function_exists( 'is_valid_email' ) ) {

	/**
	 * Checks if an email address if formatted properly.
	 * 
	 * @author James Watts and Francisco Jose Martin Moreno
	 * @access public
	 * @param string $email_address
	 * @return bool
	 */
	function is_valid_email( $email_address ) {
		return (bool) preg_match(
			'/^([\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+\.)*[\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+@((((([a-z0-9]{1}[a-z0-9\-]{0,62}[a-z0-9]{1})|[a-z])\.)+[a-z]{2,6})|(\d{1,3}\.){3}\d{1,3}(\:\d{1,5})?)$/i', $email_address );
	}

}
if( !function_exists( 'true_percentage' ) ) {
	
	/**
	 * Returns true $percent_true percent of the time
	 *
	 * Example: true_percentage( 10 ) returns true 10% of the time;
	 * 
	 * @access public
	 * @param int|float $percent_true
	 * @return bool
	 */
	function true_percentage( $percent_true ) {
		$func = 'mt_rand';
		if( !function_exists( 'mt_rand' ) ) $func = 'rand';
		$rand = $func( 0, 100 );
		return (bool) ( $rand <= $percent_true );
	}

}
if( !function_exists( 'random_string' ) ) {
	
	/**
	 * Generate a random string.
	 * 
	 * @access public
	 * @param int $length Length of string. (default: 10)
	 * @param bool $numbers Whether or not to include numbers. (default: false)
	 * @param bool $punctuation Whether or not to include punctuation. (default: false)
	 * @return string
	 */
	function random_string( $length = 10, $numbers = false, $punctuation = false ) {
		$valid_chars = 'QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm';
		if( $punctuation ) $valid_chars .= '!@#$%^&*()-_+=[]{]\|:;"\'<>?,./';
		if( $numbers ) $valid_chars .= '1234567890';
		
		$valid_len = strlen( $valid_chars );
		$res = null;
		for( $i = 1; $i <= $length; $i++ ) {
			$res .= $valid_chars[rand( 0, ( $valid_len - 1 ) )];
		}
		return $res;
		
	}

}
if( !function_exists( 'append_number_suffix' ) ) {
	
	/**
	 * Appends the proper cardinal suffix to a number
	 *
	 * Example: append_number_suffix( 35 ); //string('35th')
	 * 
	 * @access public
	 * @param int $number
	 * @return string
	 */
	function append_number_suffix( $number ) {
		
		if( !is_numeric( $number ) ) return $number;
		
		$last = substr( (string) $number, -1 );
		$penultimate = substr( (string) $number, -2, -1 );
		
		if( $last > 3 || $last == 0 ) {
			$ext = 'th';
		}	
		elseif( $last == 3 ) {
			$ext = 'rd';
		}
		elseif( $last == 2 ) {
			$ext = 'nd';
		}
		else {
			$ext = 'st'; 
		}
	
		if( $last == 1 && $penultimate == 1) $ext = 'th';
		if( $last == 2 && $penultimate == 1) $ext = 'th';
		if( $last == 3 && $penultimate == 1) $ext = 'th'; 
	
		return (string) $number . $ext;
	}
	

}

if( !function_exists( 'in_string' ) ) {
	
	/**
	 * Returns whether or not a string is found in another
	 * Shortcut for strpos()
	 * 
	 * @param string $needle What to search for
	 * @param string $haystack What to search in
	 * @param bool Whether or not to do a case-insensitive search
	 * @return bool True if $needle is found in $haystack
	 * @link http://us3.php.net/strpos
	 */
	function in_string( $needle, $haystack, $insensitive = false ) {
		$fnc = 'strpos';
		if( $insensitive ) $fnc = 'stripos';
		
		return $fnc( $haystack, $needle ) !== false; 
	}


}

if( !function_exists( 'iin_array' ) ) {
	
	
	/**
	 * Case insensitive in_array function
	 * 
	 * @param mixed $needle What to search for
	 * @param array $haystack Array to search in
	 * @return bool True if $needle is found in $haystack, case insensitive
	 * @link http://us3.php.net/in_array
	 */
	function iin_array( $needle, $haystack, $strict = false ) {
		
		$strtoupper_safe = function( $str ) {
			if( is_string( $str ) ) return strtoupper($str);
			if( is_array( $str ) ) $str = array_map( $strtoupper_safe, $str );
			return $str;
		};
		
		return in_array_recursive( $strtoupper_safe( $needle ), array_map( $strtoupper_safe, $haystack ), $strict );
	}

}
if( !function_exists( 'in_array_recursive' ) ) {
	
	/**
	 * Recursive in_array function
	 * 
	 * @param string $needle What to search for
	 * @param string $haystack What to search in
	 * @param bool Whether or not to do a case-insensitive search
	 * @return bool True if $needle is found in $haystack
	 * @link http://us3.php.net/in_array
	 */
	function in_array_recursive( $needle, $haystack, $insensitive = false ) {
		$fnc = 'in_array';
		if( $insensitive ) $fnc = 'iin_array';
		
		if( $fnc( $needle, $haystack ) ) return true;
		foreach( $haystack as $key => $val ) {
			if( is_array( $val ) ) {
				return in_array_recursive( $needle, $val );
			}
		}
		return false;
	}


}

if( !function_exists( 'rglob' ) ) {
	
	/**
	 * Recursive glob() function.
	 * 
	 * @access public
	 * @param string $pattern. (default: '*')
	 * @param int $flags. (default: 0)
	 * @param string $path. (default: '')
	 * @return void
	 */
	function rglob( $pattern = '*', $flags = 0, $path = '' ) {
	    $paths = glob( $path . '*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT );
	    $files = glob( $path . $pattern, $flags );
	    
	    foreach ($paths as $path) $files = array_merge( $files, rglob( $pattern, $flags, $path ) );
	    
	    return $files;
	}

}

if( !function_exists( 'swap_vars' ) ) {
	
	/**
	 * Replaces the names of 2 variables
	 * 
	 * @access public
	 * @param mixed &$var1
	 * @param mixed &$var2
	 * @return void
	 */
	function swap_vars( &$var1, &$var2 ) {
		$var3 = $var1;
		$var1 = $var2;
		$var2 = $var3;
	}

}

if( !function_exists( 'full_http_url' ) ) {

	/**
	 * Returns the complete URL of the HTTP request
	 * 
	 * @access public
	 * @return string|null
	 */
	function full_http_url() {
		$prefix = 'http';
		if( isset( $_SERVER['HTTPS'] ) ) $prefix = 'https';
		if( isset( $_SERVER['HTTP_HOST'] ) ) return $prefix . '://' . $_SERVER['HTTP_HOST'] . @$_SERVER['REQUEST_URI'];
		return null;
	}

}

if( !function_exists( 'parse_seconds' ) ) {
	
	/**
	 * Converts a number of seconds into an array of month, week, day, hour, minute, and second values
	 * 
	 * @access public
	 * @param int $secs Seconds to convert (default: 0)
	 * @return array
	 */
	function parse_seconds( $secs = 0 ) {
		if( !$secs ) return array( 'second' => 0 );

		$second = 1;
		$minute = $second * 60;
		$hour = $minute * 60;
		$day = $hour * 24;
		$week = $day * 7;
		$month = $day * ( 365 / 12 );
		$year = $day * 365;
		
		$negative = false;
		if( $secs < 0 ) $negative = true;
		
		$r = array();
		if( abs($secs) > $year) {
			$count = 0;
			for( $i = $year; $i <= abs($secs); $i += $year ) {
				$count++;
			}
			
			if( $negative ) {
				$r['year'] = 0 - $count;
				$secs += $year * $count;
			}
			else {
				$r['year'] = $count;
				$secs -= $year * $count;
			}
			
		}
		
		if( abs($secs) > $month) {
			$count = 0;
			for( $i = $month; $i <= abs($secs); $i += $month ) {
				$count++;
			}
			
			if( $negative ) {
				$r['week'] = 0 - $count;
				$secs += $week * $count;
			}
			else {
				$r['week'] = $count;
				$secs -= $week * $count;
			}
			
		}
		
		if( abs($secs) > $week) {
			$count = 0;
			for( $i = $week; $i <= abs($secs); $i += $week ) {
				$count++;
			}
			
			if( $negative ) {
				$r['week'] = 0 - $count;
				$secs += $week * $count;
			}
			else {
				$r['week'] = $count;
				$secs -= $week * $count;
			}
			
		}
		
		if( abs($secs) > $day) {
			$count = 0;
			for( $i = $day; $i <= abs($secs); $i += $day ) {
				$count++;
			}
			
			if( $negative ) {
				$r['day'] = 0 - $count;
				$secs += $day * $count;
			}
			else {
				$r['day'] = $count;
				$secs -= $day * $count;
			}
			
		}
		
		if( abs($secs) > $hour) {
			$count = 0;
			for( $i = $hour; $i <= abs($secs); $i += $hour ) {
				$count++;
			}
			
			if( $negative ) {
				$r['hour'] = 0 - $count;
				$secs += $hour * $count;
			}
			else {
				$r['hour'] = $count;
				$secs -= $hour * $count;
			}
			
		}
		
		if( abs($secs) > $minute) {
			$count = 0;
			for( $i = $minute; $i <= abs($secs); $i += $minute ) {
				$count++;
			}
			
			if( $negative ) {
				$r['minute'] = 0 - $count;
				$secs += $minute * $count;
			}
			else {
				$r['minute'] = $count;
				$secs -= $minute * $count;
			}
			
		}
		
		if( $secs ) {
			$r['second'] = $secs;
		}
		
		return $r;
	}
	
}
