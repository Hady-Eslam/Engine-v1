<?php

namespace ErrorsHandlers;

class ErrorsMessageHandlerEngine{
	
	function __construct($Level, $Message, $File, $Line){
		$this->TurnEngineOn($Level, $Message, $File, $Line);
	}

	private function TurnEngineOn($Level, $Message, $File, $Line){
		$this->ErrorHandlerRouting($Level, $Message, $File, $Line);
	}

	private function ErrorHandlerRouting($Level, $Message, $File, $Line){
		?>
	    <!DOCTYPE>
	    <html>
	    <head>
	        <title>Error in Loading</title>
	    </head>
	    <body>
	    	<p>Error Level = <?php echo $Level; ?></p>
	        <p>Error Title = Error in Loading Page</p>
	        <p>Error Discription = Something Goes Wrong</p>
	        <p>Error Line = <?php echo $Line; ?></p>
	        <p>Error Message = <?php echo $Message; ?></p>
		<?php
	        $POS = strrpos($File, "\\");
	        if ( $POS !== false ){
		?>              <p>Error File = <?php echo substr($File, $POS+1); ?></p>
		<?php
	        }

	        var_dump( debug_backtrace() );
		?>
	    </body>
	    </html>
		<?php
	}
}