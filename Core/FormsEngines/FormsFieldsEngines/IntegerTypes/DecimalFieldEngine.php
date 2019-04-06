<?php

namespace FormsFields\IntegerTypes;
use FormsFields\FieldEngine;

class DecimalFieldEngine extends FieldEngine{

	
	public $FieldName = 'Decimal Field';
	public $ClassType = 'IntegerTypes';
	public $Type = 'Decimal';
	public $Constraints = [
		'Require' => True,
		'Default' => '',
		'Min_Length' => 0,
		'Max_Length' => 30
	];

	function __construct($Constraints){
		foreach ($Constraints as $Key => $Value)
			$this->Constraints[$Key] = $Value;
		$this->Check();
	}

	function SetReturn($Value){
		$Value = filter_var( $Value, FILTER_VALIDATE_FLOAT );
		
		if ( $Value != False && strlen($Value) >= $this->Constraints['Min_Length'] && 
								strlen($Value) <= $this->Constraints['Max_Length'] ){
			$this->Value = $Value;
			return True;
		}
		else if ( $this->Constraints['Default'] == '' )
			return False;
		else{
			$this->Value = $this->Constraints['Default'];
			return True;
		}
	}
}