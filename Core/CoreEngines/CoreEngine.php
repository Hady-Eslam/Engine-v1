<?php

namespace Core;

use ErrorsHandlers\ErrorsHandlerEngine;

use Configs\AppConfigsEngine;
use Configs\RoutingConfigsEngine;
use Configs\ModelConfigsEngine;

use Core\RoutingEngine;
use Core\RequestsEngine;
use Core\ViewsEngine;
use Core\TemplateEngine;

use CoreModels\ModelsQueriesEngine;
use CoreModels\InvokeQueriesEngine;

use Exceptions\TemplateExceptionsEngine;

class CoreEngine{

	function __construct(){
		$this->TurnEngineOn();
	}

	private function TurnEngineOn(){
		register_shutdown_function('Core\CoreEngine::Register_ShutDown');
		new ErrorsHandlerEngine();
		new DefinesEngine('WebSiteEngine');
		$this->LoadConfigs();
	}

	private function LoadConfigs(){
		$GLOBALS['_Configs_']['_AppConfigs_'] =
				new AppConfigsEngine(_DIR_.'/Configs/AppConfigs.php');
		
		$GLOBALS['_Configs_']['_RoutingConfigs_'] =
				new RoutingConfigsEngine(_DIR_.'/Configs/RoutingConfigs.php');
		
		$GLOBALS['_Configs_']['_ModelConfigs_'] =
				new ModelConfigsEngine(_DIR_.'/Configs/ModelConfigs.php');
	}

	function BeginRouting(){
		$Routing = new RoutingEngine($GLOBALS['_Configs_']['_AppConfigs_']['SCHEMA'],
			explode('?', $_SERVER['REQUEST_URI'], 2) );
		$this->ViewPath = $Routing->BeginRouting();
		$this->Values = $Routing->Values;
	}

	function GetRequest(){
		$Requests = new RequestsEngine();
		$this->Request = $Requests->GetRequest();
	}

	function BeginView(){
		//$GLOBALS['_Queries_'] = new ModelsQueriesEngine();
		//$GLOBALS['QueriesResults_'] = [];
		$Views = new ViewsEngine($GLOBALS['_Configs_']['_AppConfigs_']['VIEWS'],
			$this->ViewPath, $this->Values);
		$this->Render = $Views->TurnViewOn($this->Request);
	}

	function GenerateTemplate(){
		$Template = new TemplateEngine($this->Render);
		$Template->FlushTemplate(
			$Template->BeginParsing()
		);
	}

	static function Register_ShutDown(){
		$Error = error_get_last();
	}
}
