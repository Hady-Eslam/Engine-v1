<?php

namespace Configs;
use Exceptions\ConfigsExceptionsEngine;

class ConfigsCheckerEngine{

	protected function CheckConfigsValues($WantedConfigs, $Configs){
		
		foreach ($WantedConfigs as $Value)
			if ( !array_key_exists($Value, $Configs) )
				throw new ConfigsExceptionsEngine("Configs Not Found $Value");
	}
}