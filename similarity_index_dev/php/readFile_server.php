<?php
	session_start();
	require_once 'constants.php';
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	function readCytoscapeFile($user, $project, $baseName, $cutoff = 0.5, $csi = false){
		if(!isset($_SESSION['logged_on'])){return false;}
		$projectDirectory = $GLOBALS['directory']."users/".$user."/projects/".$project."/".$baseName."/";
		///Make sure the user exists and the interaction file also exists.
		if($csi){ 
			$baseName = "csi".$baseName; 
		}
		$fileName = $baseName."_list.txt";

		if(!file_exists($projectDirectory.$fileName)){return false;}

		/// Set up some arrays for later
		$geneList1 = array();
		$geneList2 = array();
		$interactions = array();
		// Make sure the interaction file exists		
		// Create a file handle
		$inputHandle = fopen($projectDirectory.$fileName, "r");
		// Let's read line by line
		if ($inputHandle) {
			while (($line = fgets($inputHandle)) !== false) {
				$lineArray = explode("\t",trim($line));
				if($lineArray[2] >= $cutoff){
					// Check to make sure there isn't already an edge in this connection, if there is just continue on @ the while loop
					if(isset($interactions[$lineArray[1]])){
						if(in_array($lineArray[0], $interactions[$lineArray[1]])){
							$geneList1[] = $lineArray[0];
							continue;
						}
					}
					if(isset($interactions[$lineArray[0]])){
						if(in_array($lineArray[1], $interactions[$lineArray[0]])){
							$geneList2[] = $lineArray[1];
							continue;
						}
					}
					if($lineArray[0] == $lineArray[1]){
						continue;
					}
					$geneList1[] = $lineArray[0];
					$geneList2[] = $lineArray[1];
					$interactions[$lineArray[0]][] = $lineArray[1];
				}
			}
			if (!feof($inputHandle)) {
				echo "Error: unexpected fgets() fail\n";
			}
			fclose($inputHandle);
		}
	
		return array("geneList1" => array_values(array_unique($geneList1)), "geneList2" => array_values(array_unique($geneList2)), "interactions" => $interactions);
		return false;
	}
	
	function readMatrixFile($user, $project, $fileBase, $headered){
		if(!isset($_SESSION['logged_on'])){return false;}
		$projectDirectory = $GLOBALS['directory']."users/".$user."/projects/".$project."/".$fileBase."/";
		if($headered){$fileName = $fileBase."_headered.txt";} 
			else { $fileName = $fileBase."_bare_matrix.txt";}
		if(!file_exists($projectDirectory.$fileName)){return false;}
		
		$matrix = array();
		$lineNumber = 0;
		
		$inputHandle = fopen($projectDirectory.$fileName, "r");
		
		if ($inputHandle) {
			// Create 2d Array of bare matrix
			while (($line = fgets($inputHandle)) !== false) {
				$lineArray = explode("\t",rtrim($line));
				$matrix[] = array();
				foreach($lineArray as $element){
					$matrix[$lineNumber][] = $element;
				}
				$lineNumber++;
			}
			if (!feof($inputHandle)) {
				echo "Error: unexpected fgets() fail\n";
			}
			fclose($inputHandle);
		}
		
		return $matrix;
		
	}
?>
