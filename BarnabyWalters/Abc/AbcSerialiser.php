<?php

namespace BarnabyWalters\Abc;

use Symfony\Component\EventDispatcher;
use Taproot\Librarian as L;

/**
 * ABC Serialiser
 * 
 * A serialiser class for Taproot\Librarian which enables plain ABC files to be
 * stored, read and indexed just like a YAML or JSON file.
 * 
 * This does not actually currently work. Do not use it.
 */
class AbcSerialiser implements EventDispatcher\EventSubscriberInterface {
	public static getSubscribedEvents() {
		return [
			L\LibrarianInterface::GET_EVENT => ['unserialise', 10],
			L\LibrarianInterface::PUT_EVENT => ['serialise', -10]
		];
	}
	
	public static getExtension() {
		return 'abc';
	}
	
	public function unserialise(L\CrudEvent $event) {
		$abc = $event->getData();
		
		$headers = Parser::getHeaders($abc);
		
		$published = Parser::firstMatching('/^Published:/i', $headers['N']);
		
		$data = [
			'_id' => Parser::collapseHeader('X', $headers),
			'_name' => Parser::collapseHeader('T', $headers),
			'_key' => Parser::collapseHeader('K', $headers),
			'_metre' => Parser::collapseHeader('M', $headers),
			'_composer' => Parser::collapseHeader('C', $headers),
			'_tags' => $headers['G'],
			'_published' => $published,
			'_headers' => $headers,
			'abc' => $abc
		];
		
		$event->setData($data);
	}
	
	public function serialise(L\CrudEvent $event) {
		$abc = $event->getData()['abc'];
		$event->setData($abc);
	}
}