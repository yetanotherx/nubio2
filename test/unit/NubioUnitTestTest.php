<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';
 
$t = new lime_test();
$t2 = new NubioUnitTest(null, array('output' => new NubioLimeOutput()));

$t->comment('::is_ignore_nl()');

$t->ok($t2->is_ignore_nl("Foo\nBar",'FooBar','::is_ignore_nl() removes newlines'), '::is_ignore_nl() removes newlines' );
