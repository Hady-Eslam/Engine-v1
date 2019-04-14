<?php

namespace Configs;
use Configs\ConfigsCheckerEngine;
use Exceptions\ConfigsExceptionsEngine;
use ArrayAccess;

class SiteConfigsEngine extends ConfigsCheckerEngine implements ArrayAccess{
	
	function __construct($ConfigsPath){
		$this->Configs = include_once $ConfigsPath;
	}

	public function offsetSet($OffSet, $Value){
		throw new ConfigsExceptionsEngine("Can't Write in Configs Classes");
	}

	public function offsetExists($OffSet){
		return ( isset($this->Configs[$OffSet]) ) ? True : False;
	}

	public function offsetUnset($OffSet){
		unset($this->$Configs[$OffSet]);
	}

	public function offsetGet($OffSet){
		if ( isset($this->Configs[$OffSet]) )
			return $this->Configs[$OffSet];
		throw new ConfigsExceptionsEngine("Key Not Found $OffSet");
	}
}
