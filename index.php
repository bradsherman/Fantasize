<html>
<head>
	<title>Fantasize</title>
	<link rel="shortcut icon" href="http://dsg1.crc.nd.edu/cse30246/viva/favicon.png"/>
	<!-- Bootstrap Stylesheet CDN -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

	<!-- jQuery CDN -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

	<!-- Angular CDN -->
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>

	<!-- Bootstrap JS CDN -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<!-- Custom CSS -->
	<link rel=stylesheet href="stylesheet.css">

	<!-- My JS -->
	<script src="main.js"></script>
</head>

<body>
<?php
if( isset($logout) && $logout ) {
$_SESSION=array();
session_destroy();
echo "<script>alert('You have been logged out. Please sign in again to use the system.')</script>";
}
?>
	<body background="beckhamBackgrounf.jpg">
	<img src='beckhamBackgrounf.jpg' style='position:fixed;top:0px;left:0px;width:100%;height:100%;z-index:-1;'>
	<div align="left">
		<h2><font color="white" face="Century Gothic"><p style="font-size: 128pt;"><b>Fantasize.</p></font size></h2>
	</div>
	<div align="left">
		<h4><font color="white" size=5 face="Century Gothic"><b>Where we make all of your fantasy football dreams come true.</b></h4>
		<p>Have you used our system before?</p>
	</div>

	<div style="position: absolute; bottom: 20; right: 0; text-align:right;">
    	</b><font size=4>Image courtesy of Al Bello, Getty Images.
  	</div>




	<div align="left">
		<a href="sign-in.php" class="btn btn-success">Yes</a>
		<a href="sign-up.php" class="btn btn-danger">No</a>
	</div>
</body>

</html>
