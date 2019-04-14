<?php

namespace SiteEngines;
use Core\RenderEngine;

class SiteRenderEngine extends RenderEngine{
	
	function __construct(){
		$this->Register_Static_Data([

			// Head Values
			'PagesCSS' => PagesCSS,
			'AllPagesCSS' => AllPagesCSS,
			'LOGO' => LOGO,

			'JQueryScript' => JQueryScript,
			'DropBoxScript' => DropBoxScript,
			'PagesScripts' => PagesScripts,

			// Header Values
			'Find' => Find,
			'Advertise' => Advertise,
			'NoNotification' => NoNotification,
			'Notifications' => Notifications,
			'OnLineUser' => ( SESSION() ) ? $_SESSION['Picture'] : '',
			'OffLineUser' => OffLineUser,

			'SESSION_NAME' => ( SESSION() ) ? $_SESSION['Name'] : '',
			'SESSION_POSTS_NUMBER' => ( SESSION() ) ? $_SESSION['Posts'] : '',
			'Messages_Inbox' => Messages_Inbox,
			'MyProfile' => MyProfile,
			'PeddingPosts' => PeddingPosts,
			'Settings' => Settings,
			'LogOut' => LogOut,
			'Login' => Login,
			'SignUP' => SignUP,

			'ISSET' => ( SESSION() ) ? True : False,
			'UserStatus' => ( SESSION() ) ? $_SESSION['Status'] : '',

			// Footer
			'Help' => Help,
			'Privacy' => Policy
		]);
	}

	//////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////

	// Register Pages

	function SignUP_Render($Result = '', $Form = ''){
		return $this->Render('Register/SignUP.html', [
			'CheckLenScript' => CheckLenScript,
			'CheckinputLenScript' => CheckinputLenScript,
			'CheckPasswordScript' => CheckPasswordScript,
			'CheckPatternScript' => CheckPatternScript,

			'CheckPhoneScript' => CheckPhoneScript,
			'TriggerMessageScript' => TriggerMessageScript,
			'SetError_FunctionScript' => SetError_FunctionScript,

			// Section
			'Name' => ( $Form != '' ) ? $Form->FILTERED_DATA['Name'] : '',
			'Email' => ( $Form != '' ) ? $Form->FILTERED_DATA['Email'] : '',
			'Phone' => ( $Form != '' ) ? $Form->FILTERED_DATA['Phone'] : '',

			// Script
			'Result' => $Result,
			'CheckPage' => CheckPage,
			'Name_Len' => Name_Len,
			'Email_Len' => Email_Len,
			'Phone_Len' => Phone_Len,
			'Password_Len' => Password_Len
		]);
	}

	function SuccessSignUP_Render(){
		return $this->Render('Register/SuccessSignUP.html', []);
	}

	function ConfirmUser_Render(){
		return $this->Render('Register/ConfirmUser.html', []);
	}

	//////////////////////////////////////////////////////////////////////////////////////////

	function Login_Render($Result = '', $Form = ''){
		return $this->Render('Register/Login.html', [
			'CheckLenScript' => CheckLenScript,
			'CheckPatternScript' => CheckPatternScript,

			// Section
			'Email' => ( $Form != '' ) ? $Form->FILTERED_DATA['Email'] : '',
			'ForgetPassword' => ForgetPassword,

			// Script
			'Result' => $Result,
			'Email_Len' => Email_Len,
			'Password_Len' => Password_Len
		]);
	}

	function ForgetPassword_Render($Result = '', $Form = ''){
		return $this->Render('Register/ForgetPassword.html', [
			'CheckLenScript' => CheckLenScript,
			'CheckPatternScript' => CheckPatternScript,

			// Section
			'Email' => ( $Form != '' ) ? $Form->GetEmail() : '',
			'ForgetPassword' => ForgetPassword,

			// Script
			'Result' => $Result,
			'Email_Len' => Email_Len
		]);
	}

	function ReSetPassword_Render($Result = '', $Email = '', $Token = ''){
		return $this->Render('Register/ReSetPassword.html', [
			'CheckLenScript' => CheckLenScript,
			'CheckPasswordScript' => CheckPasswordScript,

			// Section
			'ReSetPassword' => ReSetPassword,
			'Email' => $Email,
			'Token' => $Token,

			// Script
			'Result' => $Result,
			'Password_Len' => Password_Len
		]);
	}

	//////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////

	// DO Pages
	function Advertise_Render(){
		return $this->Render('DO/Advertise.html', [
			// Header
			'CheckLenScript' => CheckLenScript,
			'CheckinputLenScript' => CheckinputLenScript,
			'CheckDataLenAndNumberScript' => CheckDataLenAndNumberScript,
			'isNumberScript' => isNumberScript,
			'CheckinputLenAndNumberScript' => CheckinputLenAndNumberScript,
			'AddPictureScript' => AddPictureScript,
			'TriggerFormScript' => TriggerFormScript,
			'TriggerMessageScript' => TriggerMessageScript,

			// Section
			'Address' => $_SESSION['Address'],
			'Phone' => $_SESSION['Phone'],
			'AddPicture' => AddPicture,

			// Script
			'Advertise_Name_Len' => Advertise_Name_Len,
			'Area_Len' => Area_Len,
			'Discreption_Len' => Discreption_Len,
			'Address_Len' => Address_Len,
			'Name_Len' => Name_Len,
			'Money_Len' => Money_Len,
			'Phone_Len' => Phone_Len
		]);
	}

	function Find_Render($Posts){
		return $this->Render('DO/Find.html', [
			// Header
			'CheckLenScript' => CheckLenScript,
			'CheckMinMaxScript' => CheckMinMaxScript,

			'isNumberScript' => isNumberScript,
			'CheckinputLenAndNumberScript' => CheckinputLenAndNumberScript,

			'CheckDataLenAndNumberScript' => CheckDataLenAndNumberScript,
			'TriggerFormScript' => TriggerFormScript,

			// Section
			'Posts' => $Posts,

			// Script
			'Area_Len' => Area_Len,
			'Rooms_Len' => Rooms_Len,
			'Storey_Len' => Storey_Len,
			'Money_Len' => Money_Len
		]);
	}

	function Post_Render($User_Profile, $User_Picture, $User_Email, $Data, $Post_ID){
		return $this->Render('DO/Post.html', [
			
			// Header
			'Title' => $Data['Add_Name'],
			'CheckLenScript' => CheckLenScript,
			'CheckinputLenScript' => CheckinputLenScript,/*
			'CheckMinMaxScript' => CheckMinMaxScript,
			'isNumberScript' => isNumberScript,*/

			'SetError_FunctionScript' => SetError_FunctionScript,
			'TriggerMessageScript' => TriggerMessageScript,

			'AddPictureScript' => AddPictureScript,
			'TriggerFormScript' => TriggerFormScript,

			// Section
			'SmallType' => $Data['SmallType'],
			'BigType' => $Data['BigType'],
			'Date' => $Data['Date'],
			'POST_ID' => $Data['POST_ID'],

			'Data' => $Data,
			'Rooms' => $Data['Rooms'],
			'PathRooms' => $Data['PathRooms'],
			'Area' => $Data['Area'],
			'Furnished' => $Data['Furnished'],
			'Discreption' => $Data['Discreption'],

			'Money' => $Data['Money'],
			'Phone' => $Data['Phone'],

			'Status' => $Data['Status'],
			'Contact_Status' => $Data['Contact_Status'],

			'AdminAcceptPost' => AdminAcceptPost.$Post_ID,
			'AdminRejectPost' => AdminRejectPost.$Post_ID,
			'AdminDeletePost' => AdminDeletePost.$Post_ID,

			'User_Profile' => $User_Profile,
			'User_Picture' => $User_Picture,
			'User_Name' => $Data['User_Name'],

			'AddPicture' => AddPicture,

			'User_Email' => $User_Email,

			// Script
			'MakeMessage' => MakeMessage,
			'Message_Len' => Message_Len,
			'Email_Len' => Email_Len
		]);
	}

	function PostMessage_Render(){
		return $this->Render('DO/PostMessage.html', []);
	}

	function EditPost_Render($Data){
		return $this->Render('DO/EditPost.html', [

			// Header
			'Title' => $Data['Add_Name'],
			'CheckLenScript' => CheckLenScript,
			'CheckinputLenScript' => CheckinputLenScript,
			'CheckDataLenAndNumberScript' => CheckDataLenAndNumberScript,
			'isNumberScript' => isNumberScript,
			'CheckinputLenAndNumberScript' => CheckinputLenAndNumberScript,
			'AddPictureScript' => AddPictureScript,
			'TriggerFormScript' => TriggerFormScript,
			'TriggerMessageScript' => TriggerMessageScript,

			// Section
			'BigType' => $Data['BigType'],
			'SmallType' => $Data['SmallType'],
			'Money' => $Data['Money'],
			'Rooms' => $Data['Rooms'],
			'PathRooms' => $Data['PathRooms'],
			'Area' => $Data['Area'],
			'Furnished' => $Data['Furnished'],
			'Discreption' => $Data['Discreption'],

			'Picture1' => $Data['Picture1'],
			'Picture2' => $Data['Picture2'],
			'Picture3' => $Data['Picture3'],
			'Picture4' => $Data['Picture4'],

			'Address' => $Data['Address'],
			'User_Name' => $Data['User_Name'],
			'Phone' => $Data['Phone'],
			'ContactMe' => $Data['ContactMe'],

			// Scripts
			'Advertise_Name_Len' => Advertise_Name_Len,
			'Area_Len' => Area_Len,
			'Discreption_Len' => Discreption_Len,
			'Address_Len' => Address_Len,
			'Name_Len' => Name_Len,
			'Money_Len' => Money_Len,
			'Phone_Len' => Phone_Len
		]);
	}

	//////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////

	// Profile
	function User_Render($Data, $User_ID, $Posts_Number, $Posts){
		return $this->Render('Profile/User.html', [
			
			// Header
			'Title' => $Data['Base_User_Name'],
			'TriggerMessageScript' => TriggerMessageScript,
			'SetError_FunctionScript' => SetError_FunctionScript,

			// Section
			'User_ID' => $User_ID,
			'User_Name' => $Data['Base_User_Name'],
			'Posts_Number' => $Posts_Number,

			'AdminDeleteAccount' => AdminDeleteAccount.$User_ID,
			'User_Picture' => $Data['User_Picture'],

			'Posts' => $Posts
		]);
	}

	function MyProfile_Render(){
		return $this->Render('Profile/MyProfile.html', [

			// Header
			'TriggerMessageScript' => TriggerMessageScript,
			'SetError_FunctionScript' => SetError_FunctionScript,
			
			// Section
			'User_Profile' => User.$_SESSION['ID'],
			'User_Picture' => $_SESSION['Picture'],
			'User_ID' => $_SESSION['ID'],
			'User_Name' => $_SESSION['Name'],
			'User_Email' => $_SESSION['Email'],
			'User_Phone' => $_SESSION['Phone'],
			'User_SignUP_Date' => $_SESSION['Sign_UP_Date'],
			'User_Posts' => $_SESSION['Posts'],

			'MyProfile' => MyProfile,
			'ProfilePeddingPosts' => MyProfile.'/PeddingPosts',
			'ProfileRejectedPosts' => MyProfile.'/RejectedPosts',
			'ProfileApprovedPosts' => MyProfile.'/ApprovedPosts',

			'Posts' => $GLOBALS['Result'],

			// Scripts
			'DeletePostPage' => DeletePostPage,
			'EditPost' => EditPost
		]);
	}

	function Messages_Render($Title){
		return $this->Render('Profile/Messages.html', [

			// Header
			'Title' => $Title,
			'TriggerMessageScript' => TriggerMessageScript,
			'SetError_FunctionScript' => SetError_FunctionScript,
			

			// Section
			'Messages_Inbox' => Messages_Inbox,
			'Messages_Sent' => Messages_Sent,

			// Scripts
			'DeleteMessage' => DeleteMessage
		]);
	}

	function Message_Render(){
		return $this->Render('Profile/Message.html', [

			// Header
			'From' => $GLOBALS['Message']['Message_Email'],

			// Section
			'To' => $GLOBALS['Message']['User_Email'],
			'Message_Date' => $GLOBALS['Message']['Message_Date'],
			'Add_Name' => $GLOBALS['Message']['Add_Name'],

			'Message_Body' => $GLOBALS['Message']['Message_Body'],
		]);
	}

	function Notifications_Render(){
		return $this->Render('Profile/Notifications.html', []);
	}

	function Settings_Render($Title){
		return $this->Render('Profile/Settings.html', [

			// Header
			'Title' => $Title,
			'TriggerMessageScript' => TriggerMessageScript,
			'SetError_FunctionScript' => SetError_FunctionScript,
			'TriggerFormScript' => TriggerFormScript,

			'AddPictureScript' => AddPictureScript,
			'CheckLenScript' => CheckLenScript,
			'CheckinputLenScript' => CheckinputLenScript,
			'CheckPhoneScript' => CheckPhoneScript,
			'CheckPasswordScript' => CheckPasswordScript,

			// Section
			'Settings_Name' => Settings.'/Name',
			'Settings_Address' => Settings.'/Address',
			'Settings_Password' => Settings.'/Password',
			'Settings_Phone' => Settings.'/Phone',
			'Settings_DeActivate' => Settings.'/DeActivate',

			// Scripts
			'Name_Len' => Name_Len,
			'Phone_Len' => Phone_Len,
			'Password_Len' => Password_Len,
			'Address_Len' => Address_Len,

			'CheckPage' => CheckPage
		]);
	}

	//////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////

	// Admin
	function PeddingPosts_Render(){
		return $this->Render('Admin/PeddingPosts.html', []);
	}

	function DeleteUserPost_Render(){
		return $this->Render('Admin/AdminOperations.html', [ 'Title' => 'Delete User Post' ]);
	}

	function RejectUserPost_Render(){
		return $this->Render('Admin/AdminOperations.html', [ 'Title' => 'Reject User Post' ]);
	}

	function ApproveUserPost_Render(){
		return $this->Render('Admin/AdminOperations.html', [ 'Title' => 'Approve User Post' ]);
	}

	function DeleteUserAccount_Render(){
		return $this->Render('Admin/AdminOperations.html', [ 'Title' => 'Delete User Account' ]);
	}

	//////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////

	// Services Pages
	function Help_Render(){
		return $this->Render('Services/Help.html', []);
	}

	function Policy_Render(){
		return $this->Render('Services/Policy.html', []);
	}

	//////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////

	function About_US_Render(){
		return $this->Render('about.html', [
			'Title' => 'Look And See',
			'File_Style' => 'http://lookandsee.com/Public/style.css'
		]);
	}

	//////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////

	// Status Pages

	function Not_Authurithed_User($PageName){
		return $this->Render('StatusPages/Not_Authurithed_User.html', [ 'Title' => $PageName ]);
	}

	function Error_Page($PageName){
		return $this->Render('StatusPages/Error_Page.html', [ 'Title' => $PageName ]);
	}

	function Log_Out_Page($PageName){
		return $this->Render('StatusPages/Log_Out_Page.html', [ 'Title' => $PageName ]);
	}

	function Not_Found_Page(){
		return $this->Render('StatusPages/Not_Found_Page.html', []);
	}
}