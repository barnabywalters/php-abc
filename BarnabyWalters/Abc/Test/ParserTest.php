<?php

namespace BarnabyWalters\Abc\Test;

use BarnabyWalters\Abc\Parser;

require __DIR__ . '/../Parser.php';

/**
 * ParserTest
 *
 * @author Barnaby Walters
 */
class ParserTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @dataProvider parseTests
	 * @param array $expected
	 * @param string $abc
	 */
	public function testHeaderParsing(array $expected, $abc) {
		$result = Parser::getHeaders($abc);
		
		$this->assertEquals($result, $expected);
	}
	
	public function parseTests() {
		return [
			// Test Parses Single Header
			[
				['K' => ['G']],
				<<<EOT
K:G
abc|def
EOT
			],
			// Test Ignores Blank Lines
			[
				[
					'T' => ['Title'],
					'K' => ['A']
				],
				<<<EOT
T:Title

K:A
EOT
			],
			// Test Handles Headers within a tune body
			[
				[
					'T' => ['Title'],
					'K' => ['G']
				],
				<<<EOT
T:Title
abc|def
K:G
EOT
			],
			// Test Trims whitespace from values
			[
				[
					'T' => ['Title']
				],
				<<<EOT
T:	Title		 
EOT
			],
			// Test handles multiple header values
			[
				[
					'T' => ['Title'],
					'K' => ['C', 'G']
				],
				<<<EOT
T:Title
K:C
abc|def|gab
K:G
GAB|cde
EOT
			]
		];
	}
	
	public function testGetTuneBodyReturnsWholeStringIfNoKSet() {
		$test = <<<EOT
some random multiline
text and stuff
EOT;
		$result = Parser::getTuneBody($test);
		$this->assertEquals($result, $test);
	}
	
	public function testGetTuneBodyReturnsLinesAfterK() {
		$test = <<<EOT
T:The Title
K:G
this is the text
which should be returned
EOT;
		$result = Parser::getTuneBody($test);
		$this->assertEquals("this is the text\nwhich should be returned", $result);
	}
	
	public function testGetTuneHeadReturnsLinesBeforeK() {
		$test = <<<EOT
T:The Title
K:G
this text
which should not be returned
EOT;
		$result = Parser::getTuneHead($test);
		$this->assertEquals("T:The Title\nK:G", $result);
	}
}

// EOF
