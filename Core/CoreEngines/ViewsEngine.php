<?php

namespace Core;
use Exceptions\ViewsExceptionsEngine;

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
		else if ( !file_exists($this->ViewsPath.$View[0].'.php') )
			throw new ViewsExceptionsEngine("View Not Found in Path ( ".
					$this->ViewsPath.$View[0].'.php'." )");
		else
			include_once $this->ViewsPath.$View[0].'.php';


		if ( !function_exists($View[1]) )
			throw new ViewsExceptionsEngine('View Function Not Found');
		$this->ViewName = $View[1];
	}

	function TurnViewOn($Request){
		array_unshift($this->Values, $Request);
		$Render = call_user_func_array($this->ViewName, $this->Values);
		return $Render;
	}
}