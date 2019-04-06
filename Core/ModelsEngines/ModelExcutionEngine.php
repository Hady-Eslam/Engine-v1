<?php

namespace CoreModels;
use Exceptions\ModelExceptionsEngine;
use \PDO;

class ModelExcutionEngine{
	
	function __construct(){
		try{
			$this->pdo = new PDO($GLOBALS['_Configs_']['_ModelConfigs_']['DB_LANGUAGE']
								.":host=".$GLOBALS['_Configs_']['_ModelConfigs_']['DB_HOST']
								.";dbname=".$GLOBALS['_Configs_']['_ModelConfigs_']['DB_NAME'], 
								$GLOBALS['_Configs_']['_ModelConfigs_']['DB_USER'],
								$GLOBALS['_Configs_']['_ModelConfigs_']['DB_PASSWORD'],
								array(PDO::MYSQL_ATTR_FOUND_ROWS => true));

			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e){
			throw new ModelExceptionsEngine('Can not Access DataBase');
	    }
	}

    public function excute($Query, array $Array){
		try{
			$this->SQL = $this->pdo->prepare($Query);
			$this->SQL->execute($Array);
	    }
	    catch(PDOException $e){
	    	throw new ModelExceptionsEngine('MY SQL Error : '.$e->getMessage());
	    }
	}

	public function GetAll($Query, array $Array = array()){
		return $this->SQL->fetchAll(PDO::FETCH_ASSOC);
	}

	public function Get($Query, array $Array = array()){
		return $this->SQL->fetch(PDO::FETCH_ASSOC);
	}

	public function GetInsertedID(){
		return $this->pdo->query($Query)->fetchColumn();
	}

	public function AffectedRows(){
		return $this->SQL->rowCount();
	}
}