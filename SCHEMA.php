<?php

return [

	404 => '404.Begin',

	'' => 'About_US.Begin',
	
	'Register' => [

		'SignUP' => 'Register/SignUP.SignUP_Begin',
		'SuccessSignUP' => 'Register/SuccessSignUP.SuccessSignUP_Begin',
		'ConfirmUser' => 'Register/ConfirmUser.ConfirmUser_Begin',

		'Login' => 'Register/Login.Login_Begin',
		'ForgetPassword' => 'Register/ForgetPassword.Begin',
		'ReSetPassword' => 'Register/ReSetPassword.Begin',

		'LogOut' => 'Register/LogOut.Begin'
	],

	'DO' => [
		'Find' => 'DO/Find.Begin',
		'Advertise' => 'DO/Advertise.Begin',
		'Post' => [
			'<int>' => [
				'' => 'DO/Post.Begin',
				'Message' => 'DO/PostMessage.Begin'
			]
		],
		'EditPost' => [
			'<int>' => 'DO/EditPost.begin'
		]
	],

	'Services' => [
		'Help' => 'Services/Help.Begin',
		'Policy' => 'Services/Policy.begin'
	],

	'Profile' => [
		
		'Settings' => [
			'' => 'Profile/Settings.Begin',
			'Name' => 'Profile/Name.Begin',
			'Phone' => 'Profile/Phone.Begin',
			'Password' => 'Profile/Password.Begin',
			'Address' => 'Profile/Address.Begin',
			'DeActivate' => 'Profile/DeActivate.Begin'
		],

		'User' => [
			'<int>' => 'Profile/User.begin'
		],

		'MyProfile' => [
			'' => 'Profile/MyProfile.Begin',
			'PeddingPosts' => 'Profile/PeddingPosts.Begin',
			'RejectedPosts' => 'Profile/RejectedPosts.Begin',
			'ApprovedPosts' => 'Profile/ApprovedPosts.Begin'
		],

		'Messages' => [
			'' => 'Profile/Messages_Inbox.Begin',
			'Inbox' => 'Profile/Messages_Inbox.Begin',
			'Sent' => 'Profile/Messages_Sent.Begin'
		],

		'Message' => [
			'<int>' => 'Profile/Message.Begin'
		],

		'Notifications' => 'Profile/Notifications.Begin'
	],

	'Admin' => [
		
		'PeddingPosts' => 'Admin/PeddingPosts.Begin',

		'DeletePost' => [
			'<int>' => 'Admin/DeletePost.Begin'
		],

		'ApprovePost' => [
			'<int>' => 'Admin/ApprovePost.Begin'
		],

		'RejectPost' => [
			'<int>' => 'Admin/RejectPost.Begin'
		],

		'DeleteAccount' => [
			'<int>' => 'Admin/DeleteAccount.Begin'
		]
	],

	'BackEnd' => [
		'CheckPage' => 'BackEnd/CheckPage.Begin',
		'DeletePost' => 'BackEnd/DeletePost.Begin',
		'DeleteMessage' => 'BackEnd/DeleteMessage.Begin',
		'ShowMorePosts' => 'BackEnd/ShowMoreFindPosts.Begin'
	]
];