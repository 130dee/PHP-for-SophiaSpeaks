<?php
/**
 * @author DeeConway
 * This class is a simple GET request handler
 * to serve the list of theme games
 */
require 'dbconnect.php';
$_dbmanager->openConnection();
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
	if(empty($_GET)===false)
	{
		$_data = $_GET['email'];
		$_usable_db->getMyGames($_data);
		}
}

$_dbmanager->closeConnection();

?>