<?php 

if( !empty($_GET['data']) && !empty($_GET['data2'])):
	$data = $_GET['data'];
	$data2 = $_GET['data2'];

	echo 'Holyshit ! It works '.$data.'||'.$data2.'. Oh yeah !';
endif;