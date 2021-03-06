<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<?php 
	session_start();
	error_reporting(E_ALL);
	require_once 'php/constants.php';
?>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>Similarity Index</title>
	</head>
	<body>
		<?php require($GLOBALS['directory']."html/loginControls.php");?>
		<?php require($GLOBALS['directory']."html/backToHomeButton.html");?>			
		<hr>
			<?php require($GLOBALS['directory']."html/projectControls.html");?>
		<hr>
		<div id="uploadForm">
			<form action="php/uploadFile_server.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="upload_filenameOnServer" value="<?php echo $GLOBALS['interactionFileName'];?>" />
				<label for="file">Filename:</label>
				<input type="file" name="fileToBeUploaded" id="fileToBeUploaded" />
				<br />
				<input type="submit" name="submit" value="Submit" />
			</form>
		</div>
		<div id="response">
			Upload Response Area
		</div>

		<!--START JAVASCRIPT-->
		<!--START JAVASCRIPT-->
		<!--START JAVASCRIPT-->
		
		<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
		<script type="text/javascript" src="js/jquery.form.js"></script> 
		<script type="text/javascript">
			baseurl = "<?php echo $GLOBALS['url']?>";
		</script>
		<script type="text/javascript">
			$(document).ready(function(){ 
				setupAjaxForm('form');
			})

			function setupAjaxForm(identifier){
				$(identifier).ajaxForm({
					beforeSubmit: function() {},
					success: showResponse
				});
			}

			function showResponse(answer){
				if(answer == "ERROR"){
					alert("There was an error with the file upload.");
				} else if (answer == "ERROR_FILE_MOVE"){
					alert("There was an error with the file upload. The file was unable to move.");
				} else if (answer == "NO_PROJECT"){
					$("#response").html("Please select a project.<br>");
				} else if (answer == "SUCCESS"){
					$("#response").html("Your file has successfully uploaded.<br>");
				}
			}
			
		</script>
	</body>
