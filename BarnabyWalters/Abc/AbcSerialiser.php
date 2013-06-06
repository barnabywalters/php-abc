<?php

namespace BarnabyWalters\Abc\AbcSerialiser;

use Symfony\Component\EventDispatcher;
use Taproot\Librarian as L;

/**
 * ABC Serialiser
 * 
 * 
 * 
 */
class AbcSerialiser implements EventDispatcher\EventSubscriberInterface {
	public static getSubscribedEvents() {
		return [
			L\LibrarianInterface::GET_EVENT => ['unserialise', 10],
			L\LibrarianInterface::PUT_EVENT => ['serialise', -10]
		];
	}
	
	public function unserialise(L\CrudEvent $event) {
	
	}
	
	public function serialise(L\CrudEvent $event) {
		
	}
}