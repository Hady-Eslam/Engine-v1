<?php

namespace Core;

class RequestsEngine{
	
	function __construct(){
		$this->TurnEngineOn();
	}

	private function TurnEngineOn(){
		$this->Request = new Request($_GET, $_POST, $_FILES, $_COOKIE, $_SERVER,
				getallheaders());
		$this->DELETE_SUPERGLOBALS();
	}

	private function DELETE_SUPERGLOBALS(){
		unset($_GET);
		unset($_POST);
		unset($_COOKIE);
		unset($_FILES);
		unset($_SERVER);
	}
	

	function GetRequest(){
		return $this->Request;
	}
}

class Request{

	function __construct($GET, $POST, $FILES, $COOKIE, $SERVER, $HEADERS){
		$this->GET = $GET;
		$this->POST = $POST;
		$this->COOKIE = $COOKIE;
		$this->FILES = $FILES;
		$this->SERVER = $SERVER;
		$this->HEADERS = $HEADERS;
	}
}