<?php

namespace Core;
use Exceptions\TemplateExceptionsEngine;

class TemplateEngine{

	function __construct($Render){
		$this->Render = $Render;
		if ( is_string($Render) )
			$this->Type = 'String';
		else{
			$this->Type = 'Another';
			if ( sizeof($Render) != 2 && sizeof($Render) != 3 )
				throw new TemplateExceptionsEngine('Render Should return Only Two Parameters');

			$this->TemplatePath = $Render[0];
			$this->TemplateValues = $Render[1];
			$this->CheckArgs();
		}
	}

	private function CheckArgs(){
		if ( !is_string($this->TemplatePath) )
			throw new TemplateExceptionsEngine('Path Argument Should Be String');

		else if ( !is_array($this->TemplateValues) )
			throw new TemplateExceptionsEngine('Template Args Should Be Array');
		
		if ( sizeof($this->Render) == 3 ){

			if ( file_exists($this->Render[0]) )
				$this->File = file_get_contents($this->Render[0]);
			else
				throw new TemplateExceptionsEngine(
							'Error Page Not Found Check if Path is Correct');
		}
		else if ( file_exists(
				$GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES'].$this->TemplatePath ) )
			$this->File = file_get_contents(
				$GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES'].$this->TemplatePath);
		else
			throw new TemplateExceptionsEngine('Template Not Found Check if Path ('.
					$GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES'].$this->TemplatePath
					.') is Correct');
	}

	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////

	function BeginParsing(){
		if ( $this->Type == 'String' )
			return $this->Render;

		return preg_replace_callback('/\<\< (.*) \>\>/', function ($Text){
			return $this->Filter_Data($Text[1]);
		}, $this->File);
	}

	private function Filter_Data($TextBefore){
		$Text = explode(':', $TextBefore);


		if ( $Text[0] == 'include ' )
			return $this->include($Text);

		else if ( $Text[0] == 'Filter ' )
			return $this->TemplateFilter($Text);

		else if ( $Text[0] == 'Load ')
			return $this->LoadFilter($Text);

		else if ( !empty( ltrim($TextBefore) ) )
			return $this->PrintValue($Text[0]);
		
		else
			throw new TemplateExceptionsEngine("UnDefined Template Command");
	}

	private function PrintValue($Variable){
		if ( !isset($this->TemplateValues[$Variable]) )
			throw new TemplateExceptionsEngine("Variable ( $Variable ) Not Found");
		return $this->TemplateValues[$Variable];
	}

	private function LoadFilter($Text){
		if ( sizeof($Text) != 2 )
			throw new TemplateExceptionsEngine(
				"NOT Valid Template Load Filter Syntax << Load : Filter_Module_Path >>");

		else if ( !file_exists(
				$GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES_FILTERS'].
							ltrim($Text[1]).'.php'))
			throw new TemplateExceptionsEngine(
				"Filter ( $Text[1] ) Not Found in TemplatesFilters Folder");

		include_once $GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES_FILTERS']
					.ltrim($Text[1]).'.php';
	}

	private function TemplateFilter($Text){
		if ( sizeof($Text) != 3 )
			return $this->TemplateFilter_2($Text);
		
		$Text[1] = ltrim(rtrim($Text[1]));

		$Text[2] = explode('-', $Text[2]);
		$Args = [];
		foreach ($Text[2] as $Value) {
			$Value = ltrim(rtrim($Value));
			if ( substr($Value, 0, 1) == '"' && substr($Value, strlen($Value)-2, 1) == '"' )
				array_push($Args, $Value);
			else
				if ( isset($this->TemplateValues[$Value]) )
					array_push($Args, $this->TemplateValues[$Value]);
				else
					throw new TemplateExceptionsEngine("Args ( $Value ) Not Found");
		}
		$Values = call_user_func_array($Text[1], $Args);
		if ( !is_string($Values) )
			throw new TemplateExceptionsEngine(
				"Filters Functions ($Text[1]) Must Return Only String Values");

		return preg_replace_callback('/\<\< (.*) \>\>/', function ($Text){
			return $this->Filter_Data($Text[1]);
		},	$Values );
	}

	private function TemplateFilter_2($Text){
		if ( sizeof($Text) != 2 )
			throw new TemplateExceptionsEngine(
				"NOT Valid Template Filter Syntax << Filter : Filter_Name : "
				."FilterArgs , ... >> <br><br> OR << Filter : Filter_Name >> ");
		
		$Values = call_user_func(ltrim(rtrim($Text[1])));
		if ( !is_string($Values) )
			throw new TemplateExceptionsEngine(
				"Filters Functions ($Text[1]) Must Return Only String Values");

		return preg_replace_callback('/\<\< (.*) \>\>/', function ($Text){
			return $this->Filter_Data($Text[1]);
		},	$Values );	

	}

	private function include($Text){
		if ( sizeof($Text) != 2 )
			throw new Exception(
				"NOT Valid Template include Syntax << include : Template_Name >>");

		else if ( 
			!file_exists($GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES'].ltrim($Text[1])) )
			throw new TemplateExceptionsEngine(
					"Template ( $Text[1] ) Not Found in Template Folder");

		return preg_replace_callback('/\<\< (.*) \>\>/', function ($Text){
			return $this->Filter_Data($Text[1]);
		},	file_get_contents(
				$GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES'].ltrim($Text[1]) ) );
	}

	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////

	function FlushTemplate($Template){
		//print_r($Template);
		echo $Template;
		//var_dump($Template);
	}
}
