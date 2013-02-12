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
    public function testParsing(array $expected, $abc) {
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
            ]
        ];
    }
}

// EOF
