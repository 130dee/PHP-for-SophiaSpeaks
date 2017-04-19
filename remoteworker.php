<?php
/**
 * @author DeeConway
 * This class is a simple GET request handler
 * to handle a login attempt by a worker user by calling a User DAO function
 */
require 'dbconnect.php';



$_dbmanager->openConnection();



if(empty($_GET) === false){
	
    $_code = $_GET['code'];
    
    if(empty($_code)===true){
        echo 'no pword';
    }else if($_usable_db->workerExists($_code)===false){
        
    }
}else if(empty($_GET)===true){
	echo "empty";
	}

$_dbmanager->closeConnection();
?>