<?php
/**
 * @author DeeConway
 * This class is a simple GET request handler
 * to serve the next current theme game  by calling a User DAO function
 */
require 'dbconnect.php';
$_dbmanager->openConnection();
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
	if(empty($_GET)===false)
	{
		$_data = $_GET['email'];
		$_usable_db->getGameTheme($_data);
		}
}

$_dbmanager->closeConnection();

?>