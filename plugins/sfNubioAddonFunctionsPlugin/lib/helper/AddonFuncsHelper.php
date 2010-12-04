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

if( !function_exists( 'pretty_backtrace' ) ) {
	
	/**
	 * Generates a "pretty" backtrace.
	 * 
	 * @access public
	 * @param bool $print True to print to STDOUT, false to return the value (default: true)
	 * @return string|void
	 */
	function pretty_backtrace( $print = true ) {
		$debug = debug_backtrace();
		
		$ret = null;
		foreach( $debug as $call ) {
			$ret .= "{$call['function']}() -> " . realpath( $call['file'] ) . ':' . $call['line'] . ";\n";
		}
		
		if( $print ) {
			echo $ret;
		}
		else {
			return $ret;
		}
	}
}

if( !function_exists( 'strpos_arr' ) ) {
	
	/**
	 * Checks if an array of values is in a string
	 *
	 * Example: strpos_arr( 'abcde', array( 'c', 'e' ) ) == 2
	 * 
	 * @access public
	 * @param string $haystack String to search
	 * @param mixed $needle
	 * @param bool $insensitive Case-insensitive. Can also be done using stripos_arr (default: false)
	 * @return int|bool
	 */
	function strpos_arr( $haystack, $needle, $insensitive = false ) {
		
		$func = 'strpos';
		if( $insensitive ) $func = 'stripos';
		
		foreach( (array) $needle as $sub_needle ) {
			$position = $func( $haystack, $sub_needle );
			if( $pos !== FALSE ) return $position;
		}
		
		return false;
	}
}

if( !function_exists( 'stripos_arr' ) ) {
	
	/**
	 * Case-insensitive strpos_arr function.
	 * 
	 * @access public
	 * @param string $haystack 
	 * @param mixed $needle
	 * @return int|bool
	 */
	function stripos_arr( $haystack, $needle ) {
		return strpos_arr( $haystack, $needle, true );
	}
}

if( !function_exists( 'db_ip2long' ) ) {
	
	/**
	 * Converts a 1.2.3.4-formatted IPv4 to an unsigned int for entry into MySQL databases.
	 * 
	 * @access public
	 * @param string $ip
	 * @return string
	 */
	function db_ip2long( $ip ) {
		return sprintf( "%u", ip2long( $ip ) ); 
	}
}

if( !function_exists( 'string_unshift' ) ) {
	
	/**
	 * Adds $character to the beginning of a string to make it $max_length characters
	 *
	 * Example: $str = 'abcd'; $ret = string_unshift( $str, 'e', 9 );
	 * This makes $str equal to 'eeeeeabcd', and $ret equal to 5; 
	 * 
	 * @access public
	 * @param string &$string String to modify
	 * @param string $character Charater to add
	 * @param int $max_length Maximum length of string
	 * @return int Number of characters added
	 */
	function string_unshift( &$string, $character, $max_length ) {
		
		$count = $max_length - strlen( $string );	
		
		for( $i = $count; $i > 0; $i-- ) {
			$string = $character . $string;
		}
		
		return $count;
	}
}

if( !function_exists( 'string_shift' ) ) {
	
	/**
	 * Chops $character off the beginning of a string
	 *
	 * Example: $str = 'aaaaabcde'; $ret = string_shift( $str, 'a' );
	 * This makes $str equal to 'bcde', and $ret equal to 'aaaaa'; 
	 * 
	 * @access public
	 * @param mixed &$string String to chop
	 * @param mixed $character Charater to remove
	 * @return string
	 */
	function string_shift( &$string, $character ) {
		
		$string = str_split( $string, 1 );
		$ret_val = null;
		
		foreach( $string as $val => $strchar ) {
			if( $strchar != $character ) break;
			
			$ret_val .= $string[$val];
			
			unset( $string[$val] );
		}
		
		$string = implode( "", $string );
		
		return $ret_val;
		
	}
}


if( !function_exists( 'string_push' ) ) {
	
	/**
	 * Adds $character to the end of a string to make it $max_length characters
	 *
	 * Example: $str = 'abcd'; $ret = string_push( $str, 'e', 9 );
	 * This makes $str equal to 'abcdeeeee', and $ret equal to 5; 
	 * 
	 * @access public
	 * @param string &$string String to modify
	 * @param string $character Charater to add
	 * @param int $max_length Maximum length of string
	 * @return int Number of characters added
	 */
	function string_push( &$string, $character, $max_length ) {
		
		$count = $max_length - strlen( $string );	
		
		for( $i = $count; $i > 0; $i-- ) {
			$string = $string . $character;
		}
		
		return $count;
	}
}

if( !function_exists( 'string_pop' ) ) {

	/**
	 * Chops $character off the end of a string
	 *
	 * Example: $str = 'abcdeeeee'; $ret = string_pop( $str, 'e' );
	 * This makes $str equal to 'abcd', and $ret equal to 'eeeee'; 
	 * 
	 * @access public
	 * @param mixed &$string String to chop
	 * @param mixed $character Charater to remove
	 * @return string
	 */
	function string_pop( &$string, $character ) {
		
		$string = str_split( $string, 1 );
		$ret_val = null;
		
		foreach( array_reverse( $string, true ) as $val => $strchar ) {
			if( $strchar != $character ) break;
			
			$ret_val .= $string[$val];
			
			unset( $string[$val] );
		}
		
		$string = implode( "", $string );
		
		return strrev( $ret_val );
		
	}
}

if( !function_exists( 'string_map' ) ) {

	/**
	 * Similar to array_map, applies a function to all the characters in a string
	 * 
	 * @access public
	 * @param callback $callback
	 * @param string $string
	 * @return string
	 */
	function string_map( $callback, $string ) {
		
		$string = str_split( $string, 1 );
		
		$string = array_map( $callback, $string );
		
		$string = implode( "", $string );
		
		return $string;
		
	}
}

if( !function_exists( 'calc_cidr' ) ) {
	
	/**
	 * Calculate starting and ending IPs in a CIDR IP
	 * 
	 * @access public
	 * @param string $start_ip IP in the first part of the cidr (for example, 1.2.3.4 in 1.2.3.4/5)
	 * @param int $cidr CIDR in the second part of the cidr (for example, 5 in 1.2.3.4/5)
	 * @return array
	 */
	function calc_cidr( $start_ip, $cidr ) {
		
		if( !is_between( $cidr, 0, 32 ) ) return false;
		if( !is_ip_address( $start_ip ) ) return false;
		$cidr_base_bin = explode( '.', $start_ip );
		
		foreach( $cidr_base_bin as &$val ) {
			$val = decbin( $val );
			string_unshift( $val, '0', 8 );
		}
		
		$cidr_shortened = substr( implode( '', $cidr_base_bin ), 0, $cidr );
		$cidr_difference = 32 - $cidr;
	
		$cidr_begin = $cidr_shortened . str_repeat( '0', $cidr_difference );
		$cidr_end = $cidr_shortened . str_repeat( '1', $cidr_difference );
		
		string_shift( $cidr_begin, '0' );
		string_shift( $cidr_end, '0' );
		
		$ip_begin = long2ip( bindec( $cidr_begin ) );
		$ip_end = long2ip( bindec( $cidr_end ) );
		$ip_count = bindec( $cidr_end ) - bindec( $cidr_begin ) + 1;
		
		return array( 'begin' => $ip_begin, 'end' => $ip_end, 'count' => $ip_count );

	}
}

if( !function_exists( 'is_between' ) ) {	
	
	/**
	 * Returns true if a value is between 2 other values
	 * 
	 * @access public
	 * @param mixed $needle Value to check
	 * @param mixed $haystack1 Minimum value
	 * @param mixed $haystack2 Maximum value
	 * @param bool $include Whether or not to use <= and >=, instead of just < and > (default: true)
	 * @return bool
	 */
	function is_between( $needle, $haystack1, $haystack2, $include = true ) {
		$operator1 = '>';
		$operator2 = '<';
		
		if( $include ) {
			$operator1 .= '=';
			$operator2 .= '=';
		}
		
		$php1 = sprintf("\$result1 = \$needle $operator1 \$haystack1;");
		$php2 = sprintf("\$result2 = \$needle $operator2 \$haystack2;");
    	eval($php1);
		eval($php2);
		
		return (bool) ( $result1 && $result2 );
	}

}


if( !function_exists( 'is_odd' ) ) {
	
	/**
	 * Returns true if a number is odd.
	 * 
	 * @access public
	 * @param int|float $val
	 * @return bool
	 */
	 function is_odd( $val ) {
		if( !is_numeric( $val ) ) return false; 
		return ( $val % 2 ); 
	}
}

if( !function_exists( 'is_even' ) ) {
	
	/**
	 * Returns true if a number is even.
	 * 
	 * @access public
	 * @param int|float $val
	 * @return bool
	 */
	function is_even( $val ) {
		return !is_odd( $val ); 
	}
}

if( !function_exists( 'trim_extra_spaces' ) ) {
	
	/**
	 * Replaces 2 or more spaces in a string with a single space
	 * 
	 * @access public
	 * @param string $string
	 * @return string
	 */
	function trim_extra_spaces( $string ) {
		return preg_replace( '/\s{2,}/', ' ', $string ); 
	}
}

if( !function_exists( 'add_include_path' ) ) {

	function add_include_path( $path ) {
		set_include_path( $path . PATH_SEPARATOR . get_include_path() );
	}
	
}

if( !function_exists( 'svn_info' ) ) {
	
	/**
	 * Get info about a SVN repo
	 * 
	 * @access public
	 * @param mixed $path Path to svn directory, e.g. /path/to/.svn
	 * @return array
	 */
	function svn_info( $path ) {
		
		// http://svnbook.red-bean.com/nightly/en/svn.developer.insidewc.html
		$entries = $path . '/entries';

		if( !file_exists( $entries ) ) {
			return false;
		}

		$lines = file( $entries );
		if ( !count( $lines ) ) {
			return false;
		}

		// check if file is xml (subversion release <= 1.3) or not (subversion release = 1.4)
		if( preg_match( '/^<\?xml/', $lines[0] ) ) {			
			return false;
		}

		// Subversion is release 1.4 or above.
		if ( count( $lines ) < 11 ) {
			return false;
		}
		
		$info = array(
			'checkout-rev' => intval( trim( $lines[3] ) ),
			'url' => trim( $lines[4] ),
			'repo-url' => trim( $lines[5] ),
			'directory-rev' => intval( trim( $lines[10] ) )
		);
		
		return $info;
	}
}
