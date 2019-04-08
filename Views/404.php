<?php

function Error(){
	//return '<p>Hello From Here</p>';
	return ['404.html', [

		'Title' => 'Not Found',

		'AllPagesCSS' => '/Public/CSS/AllPagesCSS.CSS',

		'LOGO' => '/Public/Pictures/LOGO.jpg'
	]];
}