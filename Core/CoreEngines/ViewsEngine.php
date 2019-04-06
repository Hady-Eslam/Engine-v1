<?php

namespace Core;
use Exceptions\ViewsExceptionsEngine;
use Core\OutPutEngine;

class ViewsEngine{
	
	function __construct($ViewsPath, $ThisViewPath, $Values){
		$this->ViewsPath = $ViewsPath;
		$this->ThisViewPath = $ThisViewPath;
		$this->Values = $Values;
		$this->CheckView();
	}

	private function CheckView(){
		$View = explode('.', $this->ThisViewPath);
		if ( sizeof($View) != 2 )
			throw new ViewsExceptionsEngine('Error in SCHEMA View Syntax : '
					.$this->ThisViewPath);

		if ( $this->ViewsPath == '' )
			$this->ViewsPath = _DIR_.'/Views/';
		include_once $this->ViewsPath.$View[0].'.php';

		if ( !function_exists($View[1]) )
			throw new ViewsExceptionsEngine('View Not Found');
		$this->ViewName = $View[1];
	}

	function TurnViewOn($Request){
		array_unshift($this->Values, $Request);
		$Render = call_user_func_array($this->ViewName, $this->Values);
		//$OutPut->OpenOutPut();
		return $Render;
	}
}