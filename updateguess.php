<?php
/**
 * @author DeeConway
 * This class is a simple GET request handler
 * to allow the results of a game guess to be stored by calling a User DAO function
 */
require 'dbconnect.php';

$_dbmanager->openConnection();

if(empty($_POST) === false){
	$_id = $_POST['id'];
	if(empty($_id)===false){
		$_guess = $_POST['guess'];
		if(empty($_guess)===false){
			if($_usable_db->updateGuess($_id,$_guess)){
				}
				if($_guess=='wrong'){
					$_wrongimage = $_POST['wrongimage'];
					if(empty($_wrongimage)===false){
						$_rightimage = $_POST['rightimage'];
						if(empty($_rightimage)===false){
							$_question = $_POST['question'];
							if(empty($_question)===false){
								if($_usable_db->insertWrongResultTable($_id,$_wrongimage,$_rightimage,$_question)){
									echo 'usableDB';
									}else{echo 'mistake';}
								}else{echo 'question missing';}
						}
					}else{echo 'wrong missing';}
				}else{echo 'wrong not == wrong';}
			}else{echo 'empty guess';}
	}else{echo 'empty id';}
}else{echo 'empty POST';}

$_dbmanager->closeConnection();
?>