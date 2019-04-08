<?php

function DownLoad($Request){
	//return '<a href="">I AM HADY</a>';

	return ['DownLoad.html', [

		'Title' => 'DownLoad',

		'AllPagesCSS' => '/Public/CSS/AllPagesCSS.CSS',

		'LOGO' => '/Public/Pictures/LOGO.jpg'
	]];
}