<?php
/**
 * @author DeeConway
 * This class is a simple POST request handler
 * to insert a theme game in to the theme table  by calling a User DAO function
 */
require 'dbconnect.php';

$_dbmanager->openConnection();

	
if(empty($_POST) === false){
	$_data = $_POST['game'];  
	$_email = $_POST['email'];
	$_time = $_POST['time'];
	$_datestring = $_POST['datestring'];
	
    
    if(empty($_data)===true){
        echo 'missing uname';        
    }else if(empty($_email)===true){
        echo 'missing email';
    }else 
	{
		$_usable_db->insertGame($_data,$_email,$_time,$_datestring);
        echo 'succesful';
    }
}else{echo 'no POST';}

$_dbmanager->closeConnection();
?>