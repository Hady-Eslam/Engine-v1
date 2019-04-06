<?php

namespace Configs;
use Configs\ConfigsCheckerEngine;
use Exceptions\ConfigsExceptionsEngine;
use ArrayAccess;

class RoutingConfigsEngine extends ConfigsCheckerEngine implements ArrayAccess{
	
	function __construct($ConfigsPath){
		$this->Configs = include_once $ConfigsPath;
		$this->CheckConfigsValues(['404'], $this->Configs);
	}

	public function offsetSet($OffSet, $Value){
		$this->Configs[$OffSet] = $Value;
	}

	public function offsetExists($OffSet){
		return (isset($this->Configs[$OffSet])) ? True : False;
	}

	public function offsetUnset($OffSet){
		unset($this->$Configs[$OffSet]);
	}

	public function offsetGet($OffSet){
		if ( isset($this->Configs[$OffSet]) )
			return $this->Configs[$OffSet];
		throw new ConfigsExceptionsEngine('Key Not Found');
	}
}