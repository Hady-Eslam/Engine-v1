<?php

namespace Core;
use Exceptions\RoutingExceptionsEngine;

class RoutingEngine{

	private $Schema;

	function __construct($SCHEMA, $URL){
		$this->URL = explode('/', $URL[0], 2)[1];
		$this->MainErrorPage = $GLOBALS['_Configs_']['_RoutingConfigs_']['404'];
		$this->Schema = include_once $SCHEMA;
		$this->Values = [];
	}

	function BeginRouting(){
		if ( !is_array($this->Schema) )
			throw new RoutingExceptionsEngine(
				'Error in Schema Format : Schema Should Be Key => Value Pair Array');
		
		return $this->GetPath();
	}

	private function GetPath(){
		
		while (True) {

			$URLPart = explode('/', $this->URL, 2);
			$Matched = False;
			$Matched_Value = NULL;
			
			foreach ($this->Schema as $Key => $Value) {
				$Key = strval($Key);
			
				if ( $Key === '404' )
					$GLOBALS['_Configs_']['_RoutingConfigs_']['404'] = $Value;

				else if ( $Key === '<int>' || $Key === '<string>' || $Key === '<double>'){
					if ( $this->CheckRegularExpresion($Key, $URLPart[0]) ){
						$Matched = True;
						$Matched_Value = $Value;
						break;
					}
				}
				
				else if ( $Key == $URLPart[0] ){
					$Matched = True;
					$Matched_Value = $Value;
					break;
				}
			}

			if ( !$Matched )
				$this->NotMatchedRouting($Matched_Value);
			else
				if ( sizeof($URLPart) == 1 ){
					if ( is_string($Matched_Value ) )
						return $Matched_Value;
					$this->NotMatchedRouting($Matched_Value);
				}
				else
					if ( is_string($Matched_Value) )
						$this->NotMatchedRouting($Matched_Value);
			$this->Schema = $Matched_Value;
			$this->URL = $URLPart[1];
		}
	}

	private function NotMatchedRouting($Matched_Value){
		if ( !file_exists($GLOBALS['_Configs_']['_RoutingConfigs_']['404']) )
			include_once $this->MainErrorPage;
		else
			include_once $GLOBALS['_Configs_']['_RoutingConfigs_']['404'];
		exit();
	}

	private function CheckRegularExpresion($Key, $URL){
		if ( $Key == '<int>' )
			$Pattern = '/^(\d+)$/';
		else if ( $Key == '<string>')
			$Pattern = '/^(.*)$/';
		else if ( $Key == '<double>')
			$Pattern = '/^(\d+)(\.(\d+))?$/';
		
		if ( preg_match($Pattern, $URL, $Result) ){
			array_push($this->Values, $Result[0]);
			return True;
		}
		return False;
	}
}