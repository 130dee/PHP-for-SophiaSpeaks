<?php
/**
 * @author DeeConway
 * This class is a simple GET request handler
 * to handle a login attempt by calling a User DAO function
 */
require 'dbconnect.php';

$_dbmanager->openConnection();



if(empty($_GET) === false){
	
    $_password = $_GET['password'];
	$_unme = $_GET['username'];
    
    if(empty($_password)===true){
        echo 'no pword';
    }else if($_usable_db->userExists($_unme,$_password)===false){
        
    }
}else if(empty($_GET)===true){
	echo "empty";
	}

$_dbmanager->closeConnection();
?>