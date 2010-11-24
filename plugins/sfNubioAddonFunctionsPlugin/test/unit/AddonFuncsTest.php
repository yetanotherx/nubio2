<?php

require_once( dirname(__FILE__).'/../../../../test/bootstrap/unit.php' );
require_once( sfConfig::get( 'sf_plugins_dir' ) . '/sfNubioAddonFunctionsPlugin/lib/helper/AddonFuncsHelper.php' );

$t = new lime_test();

$t->info( '1 - is_ip_address()' );

$t->ok( is_ip_address( '127.0.0.1' ), '127.0.0.1 passes' );
$t->ok( !is_ip_address( '127.0.1' ), '127.0.1 fails' );
$t->ok( !is_ip_address( '256.0.0.1' ), 'Numbers over 255 fail' );
$t->ok( !is_ip_address( '' ), 'Blank string fails' );
$t->ok( !is_ip_address( ' éˆ¶¨ ' ), 'Non-ascii string fails' );



$t->info( '2 - is_valid_email()' );

$t->ok( is_valid_email( 'l3tt3rsAndNumb3rs@domain.com' ), 'l3tt3rsAndNumb3rs@domain.com passes' );
$t->ok( is_valid_email( 'has-dash@domain.com' ), 'has-dash@domain.com passes' );
$t->ok( is_valid_email( "hasApostrophe.o'leary@domain.org" ), "hasApostrophe.o'leary@domain.org passes" );
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




