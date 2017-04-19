<?php
/**
 * @author DeeConway
 * This class is a simple POST request handler
 * to insert data relating to an image  by calling a User DAO function
 */
require 'dbconnect.php';

$_dbmanager->openConnection();

if(empty($_POST) === false){
	$_id = $_POST['id'];
	if(empty($_id)===false){
		$_job = $_POST['job'];
		if(empty($_job)===false){
			if($_job=='delete'){
				if($_usable_db->deleteThisImage($_id)){
				echo 'deleted';
				}
			}else if($_job=='saveD'){
				$_description = $_POST['description'];
				if(empty($_description)===false){
					if($_usable_db->insertDescription($_id,$_description)){
									//echo 'saved';
						}
				}else{echo 'saved wrong';}
			}else{echo 'empty description';}
		}else{echo 'empty job';}
	}else{echo 'empty ID';}
}else{echo 'empty POST';}
					
					


$_dbmanager->closeConnection();
?>

