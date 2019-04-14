<?php

namespace CoreModels;
use \PDO;

class ModelExcutionEngine{
	
	private $SQL;
	private $pdo;
	private $Found_Error = false;
	private $Error_Message = '';

	function __construct(){
		try{
			$UserName = 'root';
			$Password = '';
			$this->pdo = new PDO(DBLanguage.":host=".Host.";dbname=".DBName, 
				$UserName, $Password,array(PDO::MYSQL_ATTR_FOUND_ROWS => true));
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(Exception $e){
			$this->Found_Error = true;
			$this->Error_Message = $e->getMessage();
	    }
	}

	public function excute($Query, $Array){
		if ( $this->Found_Error )
			return Returns(-1, '', Error('My SQL Error', '2',
				"Access Denied Or Because : ".$this->Error_Message) );
		try{
			$this->SQL = $this->pdo->prepare($Query);
			$this->SQL->execute($Array);
	        return Returns(1);
	    }
	    catch(Exception $e){
	    	return Returns(-1, '', Error('My SQL Error', '3',
	    		"Error in excuting Query Because : ".$e->getMessage()) );
	    }
	}

	private function FetchData($Query, $Array, $Operation){
		try{
			if ( ($Result = $this->excute($Query, $Array))->Result == -1 ) 
				return $Result;

			$Data = '';
			if ( $Operation == 2 )
				$Data = $this->SQL->fetchAll(PDO::FETCH_ASSOC);
			else if ( $Operation == 4 )
				return Returns(1, $this->pdo->query($Query)->fetchColumn());
			else 
				$Data = $this->SQL->fetch(PDO::FETCH_ASSOC);

			if ( empty($Data) )
				return Returns(0, 'Empty');
			return Returns(1, $Data);
		}
		catch(Exception $e){
			if ( $Operation == 1 )
				return Returns(-1, '', Error('My SQL Error', '5',
						"Error in Fetching One Row Or Because : ".$e->getMessage()) );
			else if ( $Operation == 2 )
				return Returns(-1, '', Error('My SQL Error', '6',
						"Error in Fetching All Rows Or Because : ".$e->getMessage()));
			else if ( $Operation == 3 )
				return Returns(-1, '', Error('My SQL Error', '7',
						'Error in Searching For Column Or Because : '.$e->getMessage()));
			return Returns(-1, '', Error('My SQL Error', '4',
						"Error in Counting Query Or Because : ".$e->getMessage()));
		}
	}

	public function FetchOneRow($Query, $Array){
		return $this->FetchData($Query, $Array, 1);
	}

	public function FetchAllRows($Query, $Array){
		return $this->FetchData($Query, $Array, 2);
	}

	public function isFound($Query, $Array){
		return $this->FetchData($Query, $Array, 3);
	}
	
	public function GetRowCount($Query){
		return $this->FetchData($Query, array(), 4);
	}

	public function GetInsertedID(){
		return $this->pdo->lastInsertId();
	}

	public function GetAffectedRowsNumber(){
		return $this->SQL->rowCount();
	}
}