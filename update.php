<?php
/**
 * @author DeeConway
 * This class is a simple GET request handler
 * to enable an edit to be completed on the image table by calling a User DAO function
 */
require 'dbconnect.php';
$_dbmanager->openConnection();

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
	if(empty($_GET)===false)
	{
		echo'GET: ';
		
		$_job = $_GET['job'];
		if(empty($_job)===false)
		{
			echo'job == ';
			echo $_job;
			if($_job=='game')
			{
				echo'  GAME ==';
				echo $_job;
				$_game = $_GET['data']; 								
				if(empty($_game)===false)
				{
					echo ' data: ';
					echo $_game;
					$_usable_db->insertGame($_game);
				}
			}else
			{//get id
				$_id = $_GET['id'];			
				if(empty($_id)===false)
				{
					echo' id: ';
					echo $_id;
					if($_job=='viewed')
					{
						echo ' viewed == ';
						echo $_job;
						$_usable_db->updateViewed($_id);
					}else if($_job=='word')
					{
						echo ' word == ';
						echo $_job;
						$_word=$_GET['attach'];
						if(empty($_word)===false)
						{
							echo ' attach: ';
							echo $_word;
							$_usable_db->addTag($_id,$_word);
						}else
						{
							echo ': SOMETHING WENT WRONG';
						}
					}
				}
			}
							
		}
	}
}
$_dbmanager->closeConnection();


?>

