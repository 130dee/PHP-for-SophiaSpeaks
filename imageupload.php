<?php
/**
 * @author DeeConway
 * This class is a simple POST request handler
 * to insert an image to the database  by calling a User DAO function
 */
require 'dbconnect.php';

$_dbmanager->openConnection();

if(empty($_POST) === false){
	$_theme = $_POST['theme'];
    $_image = $_POST['image'];
	$_imagetag = $_POST['tag'];
	$_email = $_POST['email'];
	$_location = $_POST['location'];
	$_time = $_POST['tdate'];
    
    if(empty($_email)===true){
        echo 'no email';        
    
    }else if($_usable_db->insertImage($_theme,$_image,$_email,$_imagetag,$_location,$_time)===false){
        echo 'not successful';
    }
}

$_dbmanager->closeConnection();
?>