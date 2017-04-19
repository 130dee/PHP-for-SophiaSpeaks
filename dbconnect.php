<?php
/**
 * @author DeeConway
 * This class instantiates the database manager
 */
require 'connect.php';
require 'UserDAO.php';
$_dbmanager = new DBManager();
$_usable_db = new UsersDAO($_dbmanager);
?>