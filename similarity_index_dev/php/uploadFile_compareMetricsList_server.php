<?php
	session_start();
	require_once 'constants.php';
	require_once 'convertFileFormat_server.php';
	ini_set('display_errors', 1);

	$returnOnSuccess = "SUCCESS";
	$returnOnFailure = "ERROR";
	// If the user is not logged on, redirect to login page.
	if(!isset($_SESSION['logged_on'])){
		header('Location: '.$GLOBALS['url'].'login.php');
	}
	

	//echo "Success!\n";
	if ($_FILES["fileToBeUploaded"]["error"] > 0){
		echo "ERROR";
	} else {
		$temporaryFileName = $_FILES["fileToBeUploaded"]["tmp_name"];

		$user = $_SESSION['user'];
		$project = $_SESSION['project'];
		
		$listName = $_POST["listName"];
		$filenameOnServer = $_POST["upload_filenameOnServer"];
		
		// OK, Let's move this file!
		if($project == ""){
			echo "NO_PROJECT";
		} else if($listName == ""){
			echo "NO LIST";
		} else {
			// Let's make sure the directory that we require exists, if it doesn't, create it and for now set chmod to permissive
			$workingDirectory = $GLOBALS['directory']."users/".$user."/projects/".$project."/";
			$workingDirectory = $workingDirectory . "lists/";
			if(file_exists($workingDirectory) && is_dir($workingDirectory)){
				// Everything is fine, don't do anything
			} else {
				mkdir($workingDirectory, 0777);
				chmod($workingDirectory, 0777);
			}

			// Ok, now let's make a list folder that will have the list and a downloadable file.
			$workingDirectory = $workingDirectory . $listName . "/";
			if(file_exists($workingDirectory) && is_dir($workingDirectory)){
				// Everything is fine, don't do anything
			} else {
				mkdir($workingDirectory, 0777);
				chmod($workingDirectory, 0777);
			}
			
			// MOVE!
			if(move_uploaded_file($temporaryFileName, $workingDirectory.$filenameOnServer)){
				//Move file was successful
				chmod($workingDirectory.$filenameOnServer, 0777);
				echo $returnOnSuccess;
			} else {
				//Move file was unsuccessful
				echo $returnOnFailure;
			}
		}
  }
?>
