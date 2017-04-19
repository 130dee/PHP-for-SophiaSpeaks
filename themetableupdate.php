<?php
/**
 * @author DeeConway
 * This class is a simple POST request handler
 * to insert data to the theme table by calling a User DAO function
 */
require 'dbconnect.php';

$_dbmanager->openConnection();

if(empty($_POST) === false){
	$_id = $_POST['id'];
	if(empty($_id)===false){
		$_email = $_POST['email'];
		if(empty($_email)===false){
			$_theme =$_POST['theme'];
			if(empty($_theme)===false){
				$_state = $_POST['state'];
				if(empty($_state)===false){
					$_usable_db->insertThemeTable($_id,$_email,$_theme,$_state);
				}else{echo 'state missing';}
			}else{echo 'theme missing';}
		}else{echo 'email missing';}
	}else{echo 'id missing';}
}else{echo 'post missing';}
				


$_dbmanager->closeConnection();
?>