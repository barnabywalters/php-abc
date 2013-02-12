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
    public function testParsesKHeader() {
        $test = <<<EOT
K:G
abc|def
EOT;
        $expected = [
            'K' => ['G']
        ];
        
        $result = Parser::getHeaders($test);
        
        $this->assertEquals($result, $expected);
    }
}

// EOF
