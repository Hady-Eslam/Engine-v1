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
		//unset($_COOKIE);
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

	function isPOST(){
		return ( $this->SERVER['REQUEST_METHOD'] === 'POST' ) ? True : False ;
	}

	function isGET(){
		return ( $this->SERVER['REQUEST_METHOD'] === 'GET' ) ? True : False ;
	}

	function REQUEST_METHOD(){
		return $this->SERVER['REQUEST_METHOD'];
	}

	function REFERER_IS_SET(){
		return ( isset($this->SERVER['HTTP_REFERER']) ) ? True : False;
	}

	function GET_REFERER(){
		return ( isset($this->SERVER['HTTP_REFERER']) ) ? $this->SERVER['HTTP_REFERER'] : '';
	}

	function CHECK_REFERER($INCOMING_URL = ''){
		$REFERER = ( !isset($this->SERVER['HTTP_REFERER']) ) ? '' : $this->SERVER['HTTP_REFERER'];
		$REFERER = explode('?', $REFERER)[0];
		return ( $INCOMING_URL === $REFERER ) ? True : False;
	}

	function IN_POST(...$Keys){
		foreach ($Keys as $Key => $Value)
			if ( !isset($this->POST[$Value]) )
				return False;
		return True;
	}

	function IN_GET(...$Keys){
		foreach ($Keys as $Key => $Value)
			if ( !isset($this->GET[$Value]) )
				return False;
		return True;
	}

	function IN_FILES(...$Keys){
		foreach ($Keys as $Key => $Value)
			if ( !isset($this->FILES[$Value]) )
				return False;
		return True;
	}
}