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
		<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
		<script type="text/javascript" src="js/jquery.form.js"></script> 
		<script type="text/javascript">
			baseurl = "<?php echo $GLOBALS['url']?>";
		</script>
	</head>
	<body>
		<div id="loginControls">
			<p>
				<?php if(isset($_SESSION['logged_on'])){echo "user: ".$_SESSION['user']."<br>";}?>
			
				<!-- If user is logged in, show logout button, otherwise, show the login button so we can get the user logged in-->
				<button type="button" onclick="window.location.href='<?php if(isset($_SESSION['logged_on'])){echo "php/logout_server.php";}else{echo "login.php";}?>'"><?php if(isset($_SESSION['logged_on'])){echo "Logout";}else{echo "Login";}?></button>
				<button type="button" onclick="window.location.href='index.php'">Back to Home</button>
			</p>
		</div>
		<hr>
			<?php require($GLOBALS['directory']."html/projectControls.html");?>
		<hr>
	</body>
	
