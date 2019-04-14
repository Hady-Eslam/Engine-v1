<?php

namespace Core;

class RenderEngine{

	protected $Data = [];
	
	function Register_Static_Data(array $Array = []){
		$this->Data = $Array;
	}

	function Render($TemplatePath, array $Array = []){
		$this->Data += $Array;
		return [ $TemplatePath, $this->Data ];
	}
}