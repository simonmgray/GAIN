<?php
	session_start();
	require_once 'constants.php';
	require_once 'readFile_server.php';
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	if(isset($_POST['project'])){
		$project = $_POST['project'];
	} else {
		$project = $_SESSION['project'];
	}
	
	$csi = ($_POST['csi'] == "true")?true:false;
		
	echo json_encode(readCytoscapeFile($_SESSION['user'], $project, $_POST['fileBase'], $_POST['cutoff'], $csi));
?>
