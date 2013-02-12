<?php

namespace BarnabyWalters\Abc;

/**
 * Parser
 * 
 * A partial ABC notation parser.
 * 
 * Example Usage:
 * 
 * $headers = Parser::getHeaders($abcString);
 * 
 * @author Barnaby Walters
 */
class Parser {
    public static function getHeaders($abc) {
        // Split into lines
        $lines = explode("\n", $abc);
        
        // Iterate through, parsing each header as we get to it
        $headers = [];
        
        foreach ($lines as $l) {
            $line = trim($l);
            
            // Ignore blank lines
            if (empty($line))
                continue;
            
            // Ignore non-header lines
            if ($line[1] !== ':')
                continue;
            
            // Split the line into header and value
            $header = explode(':', $line, 2);
            
            // Add the info to the return array
            $headers[$header[0]][] = trim($header[1]);
        }
        
        return $headers;
    }
}

// EOF
