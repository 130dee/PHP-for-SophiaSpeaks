<?php
/**
 * @author Dee Conway
 * definition of the User DAO (database access object)
 */
class UsersDAO {
	private $dbManager;
	function UsersDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	function getAllMyImages() {
		$sql = "SELECT * ";
		$sql .= "FROM imagestore ";
		
		$result = $this->dbManager->executeQuery ( $sql );
		$arrayOfResults = $this->dbManager->fetchResults ($result);
		
		
		header('Content-Type: application/json');
		echo json_encode($arrayOfResults);
		
	}
	function getNextImage($email) {
		$sql = "SELECT * ";
		$sql .= "FROM imagestore WHERE  `seen` = 'N' AND `email` = '$email' ";
		$sql .= "ORDER BY ID DESC";
		
		$result = $this->dbManager->executeQuery ( $sql );
		$arrayOfResults = $this->dbManager->fetchResults ($result);
		$first[0] = $arrayOfResults[0];
		
		header('Content-Type: application/json');		
		echo json_encode($first);
		
	}
	function getAllImages($email) {
		//$sql = "SELECT * ";
		//$sql .= "FROM imagestore WHERE  `email` = '$email' AND `wordSound` > 0";
		//$sql .= "ORDER BY ID DESC";
		$sql = "SELECT distinct imagestore.id, imagestore.photo, imagedescription.description ";
		$sql .= "FROM imagestore INNER JOIN imagedescription ON imagestore.id = imagedescription.id WHERE `email` = '$email' AND `wordSound` >0 AND `deleted` = 0";
		
		
		$result = $this->dbManager->executeQuery ( $sql );
		$arrayOfResults = $this->dbManager->fetchResults ($result);
		shuffle($arrayOfResults);
		
		
		header('Content-Type: application/json');		
		echo json_encode($arrayOfResults);
		
	}
		function getMyGames($email) {
		$sql = "SELECT * ";
		$sql .= "FROM canyouspy WHERE  `useremail` = '$email'";
		$sql .= "ORDER BY ID DESC";
		
		$result = $this->dbManager->executeQuery ( $sql );
		$arrayOfResults = $this->dbManager->fetchResults ($result);
		
		
		header('Content-Type: application/json');		
	
		echo json_encode($arrayOfResults);
		
	}
	function updateViewed($id) {
		$sql = "UPDATE imagestore ";
		$sql .= "SET `seen` = 'Y' WHERE `id` = '$id'";
		
		$this->dbManager->executeQuery ($sql);
		echo $sql;
		
	}
	function insertUser($username, $password , $fname, $lname, $email, $type ) {
		//create an INSERT INTO sql statement (reads the parametersArray - this contains the fields submitted in the HTML5 form)
		$sql = "INSERT INTO users (`username`, `password`, `fname`, `lname`, `email`, `usertype`) 
		VALUES ('$username', '$password', '$fname', '$lname', '$email','$type');";
		//execute the query
		
		$this->dbManager->executeQuery ( $sql);
		if($this){
			echo "successful";
		}else{echo "unsucessful";}
		
		
	}
    function userExists($username,$password){
        //$username = sanitize_this_data($username);
        $sql="SELECT * FROM `users` WHERE `username` = '$username' AND `password`= '$password'";
        $result = $this->dbManager->executeQuery ( $sql,0 );
		$arrayOfResults = $this->dbManager->fetchResults ($result);
		if(empty($arrayOfResults)===false)
		{
			$first[0] = $arrayOfResults[0];
			header('Content-Type: application/json');	
			echo json_encode($first);
		}
		header('Content-Type: application/json');
        
    }
	 function workerExists($code){
        //$username = sanitize_this_data($username);
        $sql="SELECT email FROM `users` WHERE  `access_code`= '$code'";
        $result = $this->dbManager->executeQuery ( $sql,0 );
		$arrayOfResults = $this->dbManager->fetchResults ($result);
		if(empty($arrayOfResults)===false)
		{
			$first[0] = $arrayOfResults[0];
			header('Content-Type: application/json');	
			echo json_encode($first);
		}
		header('Content-Type: application/json');
        
    }
    function getName($username){
        //$username = sanitize_this_data($username);
        $sql="SELECT (`fname`) FROM `users` WHERE `email` = '$email'";
        $result = $this->dbManager->executeQuery ( $sql,0 );
        $number = $result->fetch_row();
        
        return $number[0];
        
    }
	function checkTaken($username){
		//$username = sanitize_this_data($username);
        $sql="SELECT COUNT(`userid`) FROM `users` WHERE `username` = '$username'";
        $result = $this->dbManager->executeQuery ( $sql,0 );
        $number = $result->fetch_row();
		
		return ($number[0]==1) ? true : false;
	}
    function insertImage($theme, $image,$email,$imagetag,$location,$tstamp){
		//insert image to folder and get pathinfo
		$sql = "SELECT id FROM imagestore ORDER BY id ASC";
		$result = $this->dbManager->executeQuery ($sql);
		$im_id = 0;
		
		while($row = $result->fetch_array()){
			$im_id = $row[id];
		}
		
		$localpath='images/'.$im_id.'.png';
		$path = 'http://52.50.76.1/sophiaFYP/'.$localpath;
		
		//insert details into db
        $sql="INSERT INTO imagestore (`theme`,`photo`,`email`,`tag`,`locate`,`timestamp`) VALUES ('$theme','$path','$email','$imagetag','$location','$tstamp');";
		echo $sql;
		if($this->dbManager->executeQuery ( $sql )){
			if(file_put_contents($localpath,base64_decode($image))){echo "success";}
			
		}
	}
	function insertGame($gameName,$email,$time,$datestring){
		$sql="INSERT INTO canyouspy (`name`,`useremail`,`datetime`,`datestring`) VALUES ('$gameName','$email','$time','$datestring');";
		$this->dbManager->executeQuery ( $sql );
		
		
	}
	
	function addTag($id,$tag){
		$sql="INSERT INTO tagtable (`imtagid`,`thistag`) VALUES ('$id','$tag');";
		if($this->dbManager->executeQuery ($sql)){
			echo 'TAG INSERTED';
		}
		
		
	}
	
	 function insertSoundBite($sound,$email,$type,$imageid){
		//insert sound to folder and get pathinfo
		
		$localpath='sounbites/'.$imageid.$type.'.3gp';
		$path = 'http://52.50.76.1/sophia/'.$localpath;
		
		//insert details into db
        $sql="UPDATE imagestore SET `$type` = '$path' WHERE `id` = '$imageid'";
		echo $sql;
		
		if($this->dbManager->executeQuery ( $sql )){
			//if(file_put_contents($localpath,base64_decode($sound))){echo "success";}
			
		}else {echo'something went wrong';}
	}
	
	function deleteThisImage($id){
		$sql="UPDATE imagestore SET `deleted` = 1 WHERE `id` = '$id'";
		if($this->dbManager->executeQuery ($sql)){
			echo 'Deleted';
		}
		
		
	}
	function updateImagesWithTags($imageid,$question,$description){
		//insert sound to folder and get pathinfo
		
		
		//insert details into db
        $sql="UPDATE imagestore SET `question` = '$question',`wordSound` = '$description' WHERE `id` = '$imageid'";
		echo $sql;
		
		if($this->dbManager->executeQuery ( $sql )){
			echo "success";
			
		}else {echo'something went wrong';}
	}
	
	function insertQuestion($id,$question){
		//insert sound to folder and get pathinfo
		
		
		//insert details into db
        $sql="INSERT INTO imagequestion (`id`,`question`) VALUES ('$id', '$question'); ";
		$sql2="UPDATE imagestore SET `question` = 1 WHERE `id` = '$id'";
		echo $sql;
		
		if(($this->dbManager->executeQuery ( $sql ))AND ($this->dbManager->executeQuery ( $sql2 ))){
			//if(file_put_contents($localpath,base64_decode($sound))){echo "success";}
			
		}else {echo'something went wrong';}
	}
	function insertDescription($id,$description){
		//insert sound to folder and get pathinfo
		
		
		//insert details into db
        $sql="INSERT INTO imagedescription (`id`,`description`) VALUES ('$id', '$description'); ";
		$sql2="UPDATE imagestore SET `wordSound` = 1 WHERE `id` = '$id'";
		echo $sql;
		
		if(($this->dbManager->executeQuery ( $sql ))AND ($this->dbManager->executeQuery ( $sql2 ))){
			//if(file_put_contents($localpath,base64_decode($sound))){echo "success";}
			
		}else {echo'something went wrong';}
	}
	
	function getGameImages($email) {
		$sql = "SELECT imagestore.id, imagestore.email, imagestore.photo, imagestore.correct, imagedescription.description ";
		$sql .= "FROM imagestore ";
		$sql .= "INNER JOIN imagedescription ON imagestore.id = imagedescription.id WHERE imagestore.email ='$email'";
		$sql .= "ORDER BY imagestore.correct ASC , id DESC LIMIT 20";
		
		$result = $this->dbManager->executeQuery ( $sql );
		$arrayOfResults = $this->dbManager->fetchResults ($result);
		shuffle($arrayOfResults);
		
		
		
		header('Content-Type: application/json');		
		echo json_encode (array_slice($arrayOfResults,1));
		
	}
	
	function updateGuess($id,$guess){
		$sql="UPDATE imagestore SET $guess = $guess + 1 WHERE `id` = '$id'";
		//echo $sql;
		
		if($this->dbManager->executeQuery ( $sql )){
			//if(file_put_contents($localpath,base64_decode($sound))){echo "success";}
			
		}else {echo'something went wrong';}
	}
	function insertWrongResultTable($id,$wrongimage,$rightimage,$question){
		
        $sql="INSERT INTO `game_tracker`( `wrong_image`, `right_image`, `question`) VALUES ('$wrongimage','$rightimage','$question');";
		echo $sql;
		
		if($this->dbManager->executeQuery ( $sql )){
			//if(file_put_contents($localpath,base64_decode($sound))){echo "success";}
			
		}else {echo'something went wrong';}
	}
	
	function getGameTheme($email) {
	$sql = "SELECT name ";
	$sql .= "FROM canyouspy ";
	$sql .= "WHERE useremail = '$email' ";
	$sql .= "ORDER BY id DESC LIMIT 1";
	
	$result = $this->dbManager->executeQuery ( $sql );
	$arrayOfResults = $this->dbManager->fetchResults ($result);
	$single = $arrayOfResults[0];
	
	echo ($single['name']);
		
	}
	
	function insertThemeTable($id,$email,$theme,$state){
		$sql = "INSERT INTO themegame (`image`, `email`, `theme`, `result`) 
		VALUES ('$id','$email','$theme','$state')";
		//execute the query
		echo $sql;
		$this->dbManager->executeQuery ( $sql);
	}
	
	function showImagesThatNeedEditing($_data){
		$sql = "SELECT `id` , `photo` , `wordSound` ";
		$sql .=  "FROM `imagestore` WHERE `wordSound` =0 AND`deleted` = 0";
		$result = $this->dbManager->executeQuery ( $sql);
		$arrayOfResults = $this->dbManager->fetchResults ($result);
		
		//echo $sql;
		
		header('Content-Type: application/json');		
		echo json_encode ($arrayOfResults);
	}
}
		
    

?>