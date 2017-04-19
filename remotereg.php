<?php
/**
 * @author DeeConway
 * This class is a simple POST request handler
 * to insert a newly registered user in to the database by calling a User DAO function
 */
require 'dbconnect.php';

$_dbmanager->openConnection();

if(empty($_POST) === false){
	$_username = $_POST['user'];    
    $_password = $_POST['password'];
    $_fname = $_POST['first'];
    $_lname = $_POST['last'];
	$_email = $_POST['email'];
	$_type = $_POST['code'];
    
    if(empty($_username)===true){
        echo 'missing uname';        
    }else if(empty($_password)===true){
        echo 'missing password';
    }else if(empty($_fname)===true){
        echo 'missing fname';
    }else if(empty($_lname)===true){
        echo 'missing lname';
    }else if(empty($_email)===true){
        echo 'missing email';
    }else if(empty($_type)===true){
        echo 'missing usertype';
    }else if($_usable_db->checkTaken($_username)===true){
        echo 'username already reg taken';
    }else {
		$_usable_db->insertUser($_username,$_password,$_fname,$_lname,$_email,$_type);
	}
}

$_dbmanager->closeConnection();
?>

