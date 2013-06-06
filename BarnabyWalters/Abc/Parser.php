<?php

namespace BarnabyWalters\Abc;

/**
 * Parser
 * 
 * A partial ABC notation parser.
 * 
 * Example Usage:
 * 
 * <code>$headers = Parser::getHeaders($abcString);</code>
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
	
	public static function collapseHeader($header, array $headers) {
		if (empty($headers[$header]))
			return null;
		
		if (!is_array($headers[$header]))
			return null;
		
		reset($headers[$header]);
		
		return current($headers[$header]);
	}
	
	public static function getTuneBody($abc) {
		// Is there a K: field? If not we can’t tell so return the whole thing
		if (strstr($abc, 'K:') === false) {
			return $abc;
		} else {
			// If there is return every line after K:
			$lines = preg_split('/$\R?^/m', $abc);
			
			foreach ($lines as $i => $line) {
				if ($line[1] == ':' and $line[0] !== '|')
					continue;
				
				// This one is the first body line, return lines after this joined by \n
				return implode(PHP_EOL, array_slice($lines, $i));
			}
		}
	}
	
	public static function getTuneHead($abc) {
		// Is there a K: field? If not we can’t tell so return the whole thing
		if (strstr($abc, 'K:') === false) {
			return $abc;
		} else {
			// If there is return every line before K:
			$lines = preg_split('/$\R?^/m', $abc);
			
			foreach ($lines as $i => $line) {
				if ($line[1] == ':' and $line[0] !== '|')
					continue;
				
				// This one is the first non-header line, return < this joined by \n
				return implode(PHP_EOL, array_slice($lines, 0, $i));
			}
		}
	}
	
	public static function firstMatching($pattern, array $headerList) {
		if (empty($headerList))
			return null;
		
		foreach ($headerList as $h) {
			if (preg_match($pattern, $h))
				return $h;
		}
	}
}
