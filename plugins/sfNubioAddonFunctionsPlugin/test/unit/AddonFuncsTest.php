<?php

require_once( dirname(__FILE__).'/../../../../test/bootstrap/unit.php' );
require_once( sfConfig::get( 'sf_plugins_dir' ) . '/sfNubioAddonFunctionsPlugin/lib/helper/AddonFuncsHelper.php' );

$t = new lime_test(117);

$t->info( '1 - is_ip_address()' );

$t->ok( is_ip_address( '127.0.0.1' ), '127.0.0.1 passes' );
$t->ok( !is_ip_address( '127.0.1' ), '127.0.1 fails' );
$t->ok( !is_ip_address( '256.0.0.1' ), 'Numbers over 255 fail' );
$t->ok( !is_ip_address( '' ), 'Blank string fails' );
$t->ok( !is_ip_address( ' éˆ¶¨ ' ), 'Non-ascii string fails' );



$t->info( '2 - is_valid_email()' );

$t->ok( is_valid_email( 'l3tt3rsAndNumb3rs@domain.com' ), 'l3tt3rsAndNumb3rs@domain.com passes' );
$t->ok( is_valid_email( 'has-dash@domain.com' ), 'has-dash@domain.com passes' );
$t->ok( is_valid_email( "hasApostrophe.o'leary@domain.org" ), "hasApostrophe.o'leary@domain.org passes" );
$t->ok( is_valid_email( 'uncommonTLD@domain.museum' ), 'uncommonTLD@domain.museum passes' );
$t->ok( is_valid_email( 'uncommonTLD@domain.travel' ), 'uncommonTLD@domain.travel passes' );
$t->ok( is_valid_email( 'uncommonTLD@domain.mobi' ), 'uncommonTLD@domain.mobi passes' );
$t->ok( is_valid_email( 'countryCodeTLD@domain.uk' ), 'countryCodeTLD@domain.uk passes' );
$t->ok( is_valid_email( 'countryCodeTLD@domain.rw' ), 'countryCodeTLD@domain.rw passes' );
$t->ok( is_valid_email( 'lettersInDomain@911.com' ), 'lettersInDomain@911.com passes' );
$t->ok( is_valid_email( 'underscore_inLocal@domain.net' ), 'underscore_inLocal@domain.net passes' );
$t->ok( is_valid_email( 'IPInsteadOfDomain@127.0.0.1' ), 'IPInsteadOfDomain@127.0.0.1 passes' );
$t->ok( is_valid_email( 'IPAndPort@127.0.0.1:25' ), 'IPAndPort@127.0.0.1:25 passes' );
$t->ok( is_valid_email( 'subdomain@sub.domain.com' ), 'subdomain@sub.domain.com passes' );
$t->ok( is_valid_email( 'local@dash-inDomain.com' ), 'local@dash-inDomain.com passes' );
$t->ok( is_valid_email( 'dot.inLocal@foo.com' ), 'dot.inLocal@foo.com passes' );
$t->ok( is_valid_email( 'a@singleLetterLocal.org' ), 'a@singleLetterLocal.org passes' );
$t->ok( is_valid_email( 'singleLetterDomain@x.org' ), 'singleLetterDomain@x.org passes' );
$t->ok( is_valid_email( '&*=?^+{}\'~@validCharsInLocal.net' ), '&*=?^+{}\'~@validCharsInLocal.net passes' );
$t->ok( is_valid_email( 'foor@bar.newTLD' ), 'foor@bar.newTLD passes' );

$t->ok( !is_valid_email( 'missingDomain@.com' ), 'missingDomain@.com fails' );
$t->ok( !is_valid_email( '@missingLocal.org' ), '@missingLocal.org fails' );
$t->ok( !is_valid_email( 'missingatSign.net' ), 'missingatSign.net fails' );
$t->ok( !is_valid_email( 'missingDot@com' ), 'missingDot@com fails' );
$t->ok( !is_valid_email( 'two@@signs.com' ), 'two@@signs.com fails' );
$t->ok( !is_valid_email( 'colonButNoPort@127.0.0.1:' ), 'colonButNoPort@127.0.0.1: fails' );
$t->ok( !is_valid_email( '' ), '(blank string) fails' );
$t->ok( !is_valid_email( 'someone-else@127.0.0.1.26' ), 'someone-else@127.0.0.1.26 fails' );
$t->ok( !is_valid_email( '.localStartsWithDot@domain.com' ), '.localStartsWithDot@domain.com fails' );
$t->ok( !is_valid_email( 'localEndsWithDot.@domain.com' ), 'localEndsWithDot.@domain.com fails' );
$t->ok( !is_valid_email( 'two..consecutiveDots@domain.com' ), 'two..consecutiveDots@domain.com fails' );
$t->ok( !is_valid_email( 'domainStartsWithDash@-domain.com' ), 'domainStartsWithDash@-domain.com fails' );
$t->ok( !is_valid_email( 'domainEndsWithDash@domain-.com' ), 'domainEndsWithDash@domain-.com fails' );
$t->ok( !is_valid_email( 'numbersInTLD@domain.c0m' ), 'numbersInTLD@domain.c0m fails' );
$t->ok( !is_valid_email( 'missingTLD@domain.' ), 'missingTLD@domain. fails' );
$t->ok( !is_valid_email( '! "#$%(),/;<>[]`|@invalidCharsInLocal.org' ), '! "#$%(),/;<>[]`|@invalidCharsInLocal.org fails' );
$t->ok( !is_valid_email( 'invalidCharsInDomain@! "#$%(),/;<>_[]`|.org' ), 'invalidCharsInDomain@! "#$%(),/;<>_[]`|.org fails' );
$t->ok( !is_valid_email( 'local@SecondLevelDomainNamesAreInvalidIfTheyAreLongerThan64Charactersss.org' ), 'local@SecondLevelDomainNamesAreInvalidIfTheyAreLongerThan64Charactersss.org fails' );


$t->info( '3 - true_percentage()' );

$tester = function( $arr, $pct ) {
	$true = 0;
	foreach( $arr as $val ) {
		if( $val ) $true++;
	}
	
	$percent_final = ( $true / 500 ) * 100;
	if( $percent_final < ( $pct - 15 ) ) return false;
	return true;
};

$bucket = array();
foreach( array( 10, 25, 50, 75, 100, 65.5 ) as $i => $pct ) {
	$bucket[$i] = array();
	for( $j = 0; $j <= 500; $j++ ) {
		$bucket[$i][] = true_percentage( $pct );
	}
}


$t->ok( $tester( $bucket[0], 10 ), '10% works' );
$t->ok( $tester( $bucket[1], 25 ), '25% works' );
$t->ok( $tester( $bucket[2], 50 ), '50% works' );
$t->ok( $tester( $bucket[3], 75 ), '75% works' );
$t->ok( $tester( $bucket[4], 100 ), '100% works' );
$t->ok( $tester( $bucket[5], 65.5 ), '65.5% works' );

unset( $bucket, $tester );



$t->info( '4 - random_string()' );

$t->ok( !( preg_match( '/[1234567890'.preg_quote( '!@#$%^&*()-_+=[]{]\|:;"\'<>?,./', '/').']/', random_string( 100 ) ) ), 'No numbers or punctuation by default' );
$t->ok( !( preg_match( '/['.preg_quote( '!@#$%^&*()-_+=[]{]\|:;"\'<>?,./', '/').']/', random_string( 100, true ) ) ), 'No punctuation' );
$t->ok( ( preg_match( '/[1234567890]/', random_string( 100, true ) ) ), 'Numbers are found when asked' );
$t->ok( !( preg_match( '/[1234567890]/', random_string( 100, false, true ) ) ), 'No numbers' );
$t->ok( ( preg_match( '/['.preg_quote( '!@#$%^&*()-_+=[]{]\|:;"\'<>?,./', '/').']/', random_string( 100, false, true ) ) ), 'Punctuation is found when asked' );

$t->is( strlen( random_string( 100 ) ), 100, 'Strlen returns 100 characters' );




$t->info( '5 - append_number_suffix()' );

$t->is( append_number_suffix( 1 ), '1st', '1 -> 1st' );
$t->is( append_number_suffix( 2 ), '2nd', '2 -> 2st' );
$t->is( append_number_suffix( 3 ), '3rd', '3 -> 3st' );
$t->is( append_number_suffix( 4 ), '4th', '4 -> 4st' );
$t->is( append_number_suffix( 5 ), '5th', '5 -> 5st' );
$t->is( append_number_suffix( 11 ), '11th', '11 -> 11th' );
$t->is( append_number_suffix( 12 ), '12th', '12 -> 12th' );
$t->is( append_number_suffix( 13 ), '13th', '13 -> 13th' );
$t->is( append_number_suffix( 14 ), '14th', '14 -> 14th' );
$t->is( append_number_suffix( 15 ), '15th', '15 -> 15th' );
$t->is( append_number_suffix( 20 ), '20th', '20 -> 20th' );
$t->is( append_number_suffix( 21 ), '21st', '21 -> 21st' );
$t->is( append_number_suffix( 32 ), '32nd', '32 -> 32nd' );
$t->is( append_number_suffix( 0 ), '0th', '0 -> 0th' );

$t->is( append_number_suffix( null ), null, 'null -> null' );




$t->info( '6 - in_string()' );

$t->ok( in_string( 'foo', 'foobar' ), 'foo is in foobar' );
$t->ok( !in_string( 'Bar', 'foobar' ), 'Case-sensitive by default' );
$t->ok( in_string( 'Foo', 'foobar', true ), 'Case-insensitive when asked' );

	
$t->info( '7 - swap_vars()' );

$var1 = 1;
$var2 = 2;

$t->is( $var1, 1, 'var1 is set originally' );
$t->is( $var2, 2, 'var1 is set originally' );

swap_vars( $var1, $var2 );

$t->is( $var1, 2, 'var1 is swapped' );
$t->is( $var2, 1, 'var2 is swapped' );



$t->info( '8 - full_http_url()' );

$t->is( full_http_url(), null, 'Does not work when used in the CLI' );

$_SERVER['HTTP_HOST'] = 'example.com';
$t->is( full_http_url(), 'http://example.com', 'Works with just HTTP_HOST' );

$_SERVER['HTTPS'] = 'true';
$t->is( full_http_url(), 'https://example.com', 'Works with SSL' );


$t->info( '9 - parse_seconds()' );

$t->is( parse_seconds( 0 ), array( 'second' => '0' ), '0 seconds' );

$t->comment( '  Negative values' );
$t->is( parse_seconds( -1 ), array( 'second' => '-1' ), '-1 seconds' );
$t->is( parse_seconds( -61 ), array( 'minute' => '-1', 'second' => '-1' ), '-61 seconds' );
$t->is( parse_seconds( -12345 ), array( 'hour' => -3, 'minute' => -25, 'second' => -45 ), '-12345 seconds' );
$t->is( parse_seconds( -123456789 ), array (
  'year' => -3,
  'week' => -37,
  'day' => -4,
  'hour' => -21,
  'minute' => -33,
  'second' => -9,
), '-123456789 seconds' );

$t->comment( '  Positive values' );
$t->is( parse_seconds( 1 ), array( 'second' => '1' ), '1 seconds' );
$t->is( parse_seconds( 61 ), array( 'minute' => '1', 'second' => '1' ), '61 seconds' );
$t->is( parse_seconds( 12345 ), array( 'hour' => 3, 'minute' => 25, 'second' => 45 ), '12345 seconds' );
$t->is( parse_seconds( 123456789 ), array (
  'year' => 3,
  'week' => 37,
  'day' => 4,
  'hour' => 21,
  'minute' => 33,
  'second' => 9,
), '123456789 seconds' );

$t->info( '10 - pretty_backtrace()' );

$t->comment( '  No tests available, no way to test this' );



$t->info( '11 - strpos_arr()' );

$t->is( strpos_arr( 'this has the first letter of the letter system we use in it', array( 'a', 'b' ) ), 6, 'uses the first character\'s position' );
$t->is( strpos_arr( 'but this has the second letter of the letter system we use first', array( 'a', 'b' ) ), 10, 'still uses the first character\'s position' );
$t->is( strpos_arr( 'this doesn\'t include either letter', array( 'a', 'b' ) ), false, 'detects no matches' );
$t->is( @strpos_arr( 'this should fail', array( array( 'a' ), 'b' ) ), false, 'fails on subarrays as it should' );

$t->info( '12 - stripos_arr()' );

$t->is( stripos_arr( 'this has the first letter of the letter system we use in it', array( 'A', 'b' ) ), 6, 'uses the first character\'s position' );


$t->info( '13 - db_ip2long()' );

$t->is( db_ip2long( '255.255.255.210' ), '4294967250', 'is actually unsigned' );


$t->info( '14 - string_[un]shift()' );

$string = 'Foobar';
$t->is( string_unshift( $string, 't', 25 ), 19, 'unshift() returns the number of added characters' );
$t->is( strlen($string), 25, 'unshift() correctly prepends characters to the string reference #1' );
$t->is( $string, 'tttttttttttttttttttFoobar', 'unshift() correctly prepends characters to the string reference #2' );
$t->is( string_shift( $string, 't', 25 ), 'ttttttttttttttttttt', 'shift() returns the removed string' );
$t->is( strlen($string), 6, 'shift() correctly removes characters from the string reference #1' );
$t->is( $string, 'Foobar', 'shift() correctly removes characters from the string reference #2' );

$t->info( '15 - string_[pop|push]()' );

$string = 'Foobar';
$t->is( string_push( $string, 't', 25 ), 19, 'push() returns the number of added characters' );
$t->is( strlen($string), 25, 'push() correctly appends characters to the string reference #1' );
$t->is( $string, 'Foobarttttttttttttttttttt', 'push() correctly appends characters to the string reference #2' );
$t->is( string_pop( $string, 't', 25 ), 'ttttttttttttttttttt', 'pop() returns the removed string' );
$t->is( strlen($string), 6, 'pop() correctly removes characters from the string reference #1' );
$t->is( $string, 'Foobar', 'pop() correctly removes characters from the string reference #2' );



$t->info( '16 - string_map()' );

$t->is( string_map( 'strtoupper', $string ), 'FOOBAR', 'string_map works with built-in functions' );


$t->info( '17 - calc_cidr()' );

$t->is( calc_cidr( '127.0.0.1', '16' ), array( 'begin' => '127.0.0.0', 'end' => '127.0.255.255', 'count' => 65536 ), 'calc_cidr() works normally' );
$t->ok( !calc_cidr( '127.0.0.1', '33' ), 'calc_cidr() fails with a bad CIDR' );
$t->ok( !calc_cidr( '127.', '16' ), 'calc_cidr() fails with a bad IP' );

$t->info( '18 - is_between()' );

$t->ok( is_between( 5, 3, 7 ), '5 is between 3 and 7' );
$t->ok( !is_between( 5, 5, 7, false ), '5 is not greater than 5' );
$t->ok( is_between( 5, 5, 7 ), 'But 5 IS greater than 5 when using <=' );


$t->info( '19 - is_[odd|even]()' );

$t->ok( is_odd( 15 ), '15 is odd' );
$t->ok( !is_even( 15 ), '15 is not even' );
$t->ok( is_odd( 15.2 ), '15.2 is odd' );
$t->ok( !is_odd( 'Foobar' ), 'Foobar is not even a number' );