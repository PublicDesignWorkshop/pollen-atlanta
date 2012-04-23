<?
	$address='localhost';
	$user='publicdesign';
	$password='F4epvo17';

	$connect=mysql_connect($address, $user, $password);
	if(!$connect){
		die('error: could not connect to sql server: '.mysql_error());
		
	}

	$db_select=mysql_select_db('pollensurveys',$connect);
	if(!$db_select){
		die('error: could not get table: '.mysql_error());
	}

?>