<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;

use CoreModels\ModelExcutionEngine;
use Forms\RegisterForms\LoginForm;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Login_Begin($Request){
	$_SESSION['Page Name'] = 'Log in';
	if ( SESSION() )
		return (new SiteRenderEngine())->Log_Out_Page('Log in');

	else if ( $Request->isPOST() && $Request->CHECK_REFERER(Login) &&
			$Request->IN_POST('Email', 'Password') )
		return Login_CheckData($Request->POST);

	return (new SiteRenderEngine())->Login_Render();
}

function Login_CheckData($POST){
	include_once CheckUser;

	$Form = new LoginForm($POST);
	if ( !$Form->isValid() )
		return (new SiteRenderEngine())->Login_Render();

    // Check Email Found Or Not
    if ( ($Result = CheckUserEmail( $Form->GetEmail() ))->Result == -1 )
    	return (new SiteRenderEngine())->Error_Page('Log in');

    else if ( $Result->Data == 'email Not Found' )
    	return (new SiteRenderEngine())->Login_Render('Email Not Found', $Form);


    // Check if Password is Correct Or Not
    $Hashing = new HashingEngine();
    $Table = ($Result->Data == 'Found email in Users')?'users':'waiting_users';
    $Email = ($Table == 'users')?
    			$Hashing->Hash_Users($Form->GetEmail()):
    			$Hashing->Hash_WaitingUsers($Form->GetEmail());
    $Password = ($Table == 'users')?
    			$Hashing->Hash_Users($Form->GetPassword()):
    			$Hashing->Hash_WaitingUsers($Form->GetPassword());

    if ( ($Result = (new ModelExcutionEngine())->FetchOneRow(
    		"SELECT * FROM $Table WHERE email = ?",
				array( $Email )))->Result == -1 )
    	return (new SiteRenderEngine())->Error_Page('Log in');
    else
    	return Login_CheckData_CheckAccount($Result->Data, $Table, $Form);
}

function Login_CheckData_CheckAccount($Data, $Table, $Form){
	if ( $Table == 'waiting_users'){
		if ( $Data['password'] != $Form->GetPassword() )
			return (new SiteRenderEngine())->Login_Render('Wrong Password', $Form);
		Redirect(SuccessSignUP);
	}

    $Hashing = new HashingEngine();
	if ( $Data['deleted'] == '1' )
		return (new SiteRenderEngine())->Login_Render('Email Not Found', $Form);

	else if ( $Data['password'] != $Hashing->Hash_Users($Form->GetPassword()) )
		return (new SiteRenderEngine())->Login_Render('Wrong Password', $Form);

	else if ( $Data['activate'] == '0' ){
		if ( ($Result = (new ModelExcutionEngine())->
				excute('UPDATE users SET activate = ? WHERE email = ?',
						array(
							'1',
							$Hashing->Hash_Users($Form->GetEmail())
						)))->Result == -1 )
			return (new SiteRenderEngine())->Error_Page('Log in');
	}

	// Open Session
	include_once OpenSession;
	if ( ($Result = OpenSession( $Form->GetEmail() ))->Result == -1 ||
		 $Result->Result == 0 && $Result->Data == 'User Not Found')
		return (new SiteRenderEngine())->Error_Page('Log in');

	Redirect(Find);
}