<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';
 
$t = new NubioUnitTest();
 
$t->info('1 - ::slugify()');
$t->is(Nubio::slugify('Sensio'), 'sensio', '::slugify() converts all characters to lower case');
$t->is(Nubio::slugify('sensio labs'), 'sensio-labs', '::slugify() replaces a white space by a -');
$t->is(Nubio::slugify('sensio   labs'), 'sensio-labs', '::slugify() replaces several white spaces by a single -');
$t->is(Nubio::slugify('  sensio'), 'sensio', '::slugify() removes - at the beginning of a string');
$t->is(Nubio::slugify('sensio  '), 'sensio', '::slugify() removes - at the end of a string');
$t->is(Nubio::slugify('paris,france'), 'paris-france', '::slugify() replaces non-ASCII characters by a -');
$t->is(Nubio::slugify(''), 'n-a', '::slugify() converts the empty string to n-a');
$t->is(Nubio::slugify(' - '), 'n-a', '::slugify() converts a string that only contains non-ASCII characters to n-a');

if (function_exists('iconv'))
{
  $t->is(Nubio::slugify('Développeur Web'), 'developpeur-web', '::slugify() removes accents');
}
else
{
  $t->skip('::slugify() removes accents - iconv not installed');
}




$t->info('2 - ::parseText()');
$t->is_ignore_nl(
        Nubio::parseText("Simple paragraph"), 
        'Simple paragraph', 
        "::parseText() converts text-only"
);
$t->is_ignore_nl(
        Nubio::parseText("[[Foobar]]"), 
        '<a href="http://en.wikipedia.org/wiki/Foobar" title="Foobar">Foobar</a>', 
        "::parseText() converts [[links]]"
);
$t->is_ignore_nl(
        Nubio::parseText("* Item 1\n* Item 2"), 
        '<ul>
<li>Item 1</li>
<li>Item 2</li>
</ul>', 
        "::parseText() converts unordered lists"
);
$t->is_ignore_nl(
        Nubio::parseText("* plain
* plain''italic''plain
* plain''italic''plain''italic''plain
* plain'''bold'''plain
* plain'''bold'''plain'''bold'''plain
* plain''italic''plain'''bold'''plain
* plain'''bold'''plain''italic''plain
* plain''italic'''bold-italic'''italic''plain
* plain'''bold''bold-italic''bold'''plain
* plain'''''bold-italic'''italic''plain
* plain'''''bold-italic''bold'''plain
* plain''italic'''bold-italic'''''plain
* plain'''bold''bold-italic'''''plain
* plain l'''italic''plain
* plain l''''bold''' plain"), 
        "<ul>
<li>plain</li>
<li>plain<i>italic</i>plain</li>
<li>plain<i>italic</i>plain<i>italic</i>plain</li>
<li>plain<b>bold</b>plain</li>
<li>plain<b>bold</b>plain<b>bold</b>plain</li>
<li>plain<i>italic</i>plain<b>bold</b>plain</li>
<li>plain<b>bold</b>plain<i>italic</i>plain</li>
<li>plain<i>italic<b>bold-italic</b>italic</i>plain</li>
<li>plain<b>bold<i>bold-italic</i>bold</b>plain</li>
<li>plain<i><b>bold-italic</b>italic</i>plain</li>
<li>plain<b><i>bold-italic</i>bold</b>plain</li>
<li>plain<i>italic<b>bold-italic</b></i>plain</li>
<li>plain<b>bold<i>bold-italic</i></b>plain</li>
<li>plain l'<i>italic</i>plain</li>
<li>plain l'<b>bold</b> plain</li>
</ul>", 
        "::parseText() converts bold and italics"
);
$t->is_ignore_nl(
        Nubio::parseText("<nowiki>* This is not an unordered list item.</nowiki>"), 
        '* This is not an unordered list item.', 
        "::parseText() doesn't converts <nowiki>"
);
$t->is_ignore_nl(
        Nubio::parseText(':There is not nowiki.
:There is <nowiki>nowiki</nowiki>.

#There is not nowiki.
#There is <nowiki>nowiki</nowiki>.

*There is not nowiki.
*There is <nowiki>nowiki</nowiki>.'), 
        '<dl>
<dd>There is not nowiki.</dd>
<dd>There is nowiki.</dd>
</dl>
<ol>
<li>There is not nowiki.</li>
<li>There is nowiki.</li>
</ol>
<ul>
<li>There is not nowiki.</li>
<li>There is nowiki.</li>
</ul>', 
        "::parseText() converts indentation and nowiki"
);
$t->is_ignore_nl(
        Nubio::parseText("<!-- ... However we like to keep things simple and somewhat XML-ish so we eat
everything starting with < followed by !-- until the first -- and > we see,
that wouldn't be valid XML however, since in XML -- has to terminate a comment
-->-->"), 
        '-->', 
        "::parseText() parses non-standard comments"
);
$t->is_ignore_nl(
        Nubio::parseText(" This is some
 Preformatted text
 With ''italic''
 And '''bold'''
 And a [[Main Page|link]]
"), 
        '<pre>
This is some
Preformatted text
With <i>italic</i>
And <b>bold</b>
And a <a href="http://en.wikipedia.org/wiki/Main_Page" title="Main Page">link</a>
</pre>', 
        "::parseText() converts <pre>formatted text"
);
$t->is_ignore_nl(
        Nubio::parseText("[[File:Example.jpg|234px|thumb|link=Foo]]"), 
        '<div class="thumb tright">
<div class="thumbinner" style="width:236px;"><a href="http://en.wikipedia.org/wiki/File:Example.jpg" class="image"><img alt="Example.jpg" src="http://upload.wikimedia.org/wikipedia/en/thumb/a/a9/Example.jpg/234px-Example.jpg" width="234" height="253" class="thumbimage" /></a>
<div class="thumbcaption">
<div class="magnify"><a href="http://en.wikipedia.org/wiki/File:Example.jpg" class="internal" title="Enlarge"><img src="http://bits.wikimedia.org/skins-1.5/common/images/magnify-clip.png" width="15" height="11" alt="" /></a></div>
</div>
</div>
</div>', 
        "::parseText() converts image thumbnails"
);
$t->is_ignore_nl(
        Nubio::parseText("éç†¥©√¨¥˙ˆ∆øµ∆ˆ∫˙©√çƒ∂≈¢"), 
        'éç†¥©√¨¥˙ˆ∆øµ∆ˆ∫˙©√çƒ∂≈¢', 
        "::parseText() converts UTF properly"
);
$t->is_ignore_nl(
        Nubio::parseText("      This is a string     ", true), 
        'This is a string', 
        "::parseText() works without cURL"
);



$t->info( '3 - ::_parsePrettyUsername()' );

$t->is(
	Nubio::_parsePrettyUsername('John', 'Smith', 'jsmith'), 
	'John Smith (jsmith)', 
	'::_parsePrettyUsername() uses all 3 names'
);
$t->is(
	Nubio::_parsePrettyUsername('', 'Smith', 'jsmith'), 
	'Smith (jsmith)', 
	'::_parsePrettyUsername() treats an empty string as null'
);
$t->is(
	Nubio::_parsePrettyUsername('John', null, 'jsmith'), 
	'John (jsmith)', 
	'::_parsePrettyUsername() uses first name only'
);
$t->is(
	Nubio::_parsePrettyUsername(null, null, 'jsmith'), 
	'jsmith', 
	'::_parsePrettyUsername() doesn\'t use parentheses for username only'
);
$t->is(
	Nubio::_parsePrettyUsername(null, 'Smith', 'jsmith'), 
	'Smith (jsmith)', 
	'::_parsePrettyUsername() uses only last name'
);
$t->is(
	Nubio::_parsePrettyUsername('', '', 'jsmith'), 
	'jsmith', 
	'::_parsePrettyUsername() continues to ignore empty strings'
);
$t->is(
	Nubio::_parsePrettyUsername('', '', ''), 
	'', 
	'::_parsePrettyUsername() fails safely'
);


$t->info('4 - ::parseProps()');
$t->is(
	Nubio::parseProps(
		array(
		)
	), 
	'<ul></ul>', 
	'::parseProps() returns an empty ul'
);
$t->is(
	Nubio::parseProps(
		array(
			'oldcategory_id' => 1,
			'newcategory_id' => 2
		)
	), 
	'<ul><li>Category ID changed from 1 to 2</li></ul>', 
	'::parseProps() parses category ids'
);
$t->is(
	Nubio::parseProps(
		array(
			'oldsummary' => 'Foo',
			'newsummary' => 'Bar'
		)
	), 
	'<ul><li>Title changed from \'Foo\' to \'Bar\'</li></ul>', 
	'::parseProps() parses summaries'
);
$t->is(
	Nubio::parseProps(
		array(
			'oldkeywords' => 'foo bar',
			'newkeywords' => 'fuu baz'
		)
	), 
	'<ul><li>Keywords changed from \'foo bar\' to \'fuu baz\'</li></ul>', 
	'::parseProps() parses keywords'
);
$t->is(
	Nubio::parseProps(
		array(
			'oldcategory_id' => 1,
			'newcategory_id' => 2,
			'oldsummary' => 'Foo',
			'newsummary' => 'Bar',
			'oldkeywords' => 'foo bar',
			'newkeywords' => 'fuu baz'
		)
	), 
	'<ul><li>Category ID changed from 1 to 2</li><li>Title changed from \'Foo\' to \'Bar\'</li><li>Keywords changed from \'foo bar\' to \'fuu baz\'</li></ul>', 
	'::parseProps() parses all 3'
);
$t->is(
	Nubio::parseProps(
		array(
			'oldkeywords' => 'foo bar'
		)
	), 
	'<ul><li>Keywords changed from \'foo bar\'</li></ul>', 
	'::parseProps() fails safely without newkeywords'
);
$t->is(
	Nubio::parseProps(
		array(
			'oldsummary' => 'Foo',
		)
	), 
	'<ul><li>Title changed from \'Foo\'</li></ul>', 
	'::parseProps() fails safely without newsummary'
);
$t->is(
	Nubio::parseProps(
		array(
			'oldcategory_id' => 1
		)
	), 
	'<ul><li>Category ID changed from 1</li></ul>', 
	'::parseProps() fails safely without newcategory_id'
);
