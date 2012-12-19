<?php
	session_start();
	error_reporting(E_ALL);
	require_once 'constants.php';
	require_once 'runScript_server.php';
	ini_set('display_errors', 1);

	$user = $_SESSION['user'];
	$project = $_SESSION['project'];
	$script = $_POST['script'];
	$constant = $_POST['CSIconstant'];
	$minRange = $_POST['minRange'];
	$maxRange = $_POST['maxRange'];
	$inverse = ($_POST['inverse'] == "true");
	
	if($script == "hyper.pl"){
		$file = "hyper_results.txt";
		$baseName = "hypergeometric";
	}
	if($script == "geo.pl"){
		$file = "geo_results.txt";
		$baseName = "geometric";
	}
	if($script == "pearson.pl"){
		$file = "pear_result.txt";
		$baseName = "pearson";
	}
	if($script == "jaccard.pl"){
		$file = "jac_results.txt";
		$baseName = "jaccard";
	}
	if($script == "mm.pl"){
		$file = "mm_results.txt";
		$baseName = "simpson";
	}
	if($script == "c_index.pl"){
		$file = "c_results.txt";
		$baseName = "cosine";
	}
	
	// If we're using the inverse set that up now by appending _rev onto the baseName
	/*if($inverse){
		$baseName = $baseName."_rev";
	}*/
	if($_POST['forceRerun'] == "true"){
		sendToCorrelationScript($user, $project, $baseName, $script, $minRange, $maxRange, $inverse);
		if($_POST['useCSI'] == "true"){
			sendToCSIScript($user, $project, $baseName, $constant, $minRange, $maxRange, $inverse);
		}
	} else {
		$dir = $GLOBALS['directory']."users/".$user."/projects/".$project."/".$baseName."/";
		if(file_exists($dir.$file)){
			if($_POST['useCSI'] == "true"){
				sendToCSIScript($user, $project, $baseName, $constant, $minRange, $maxRange, $inverse);
			}
			echo false;
		} else {
			sendToCorrelationScript($user, $project, $baseName, $script, $minRange, $maxRange, $inverse);
			if($_POST['useCSI'] == "true"){
				sendToCSIScript($user, $project, $baseName, $constant, $minRange, $maxRange, $inverse);
			}
		}
	}
	
	// Run the clustering script.. no matter what!
	if($_POST['useCSI'] == "true"){
		$runClusterReturnCode = runClusterScript($user, $project, $baseName, $minRange, $maxRange, $inverse, true);
	} else {
		$runClusterReturnCode = runClusterScript($user, $project, $baseName, $minRange, $maxRange, $inverse);
	}
	
	echo "Cluster: ".$runClusterReturnCode."\n";
	
	
	
	function sendToCorrelationScript($user, $project, $baseName, $script, $minRange, $maxRange, $inverse){
		$runCorrelationReturnCode = runCorrelationScript($user, $project, $script, $inverse);
		//$runClusterReturnCode = runClusterScript($user, $project, $baseName, $minRange, $maxRange);
		echo "Correlation: ".$runCorrelationReturnCode."\n";
	}
	
	function sendToCSIScript($user, $project, $baseName, $constant, $minRange, $maxRange, $inverse){
		$runCSIReturnCode = runCSIScript($user, $project, $baseName, $constant, $inverse);
		//$runClusterReturnCode = runClusterScript($user, $project, "csi_".$baseName, $minRange, $maxRange);
		echo "CSI: ".$runCSIReturnCode."\n";
	}
?>
