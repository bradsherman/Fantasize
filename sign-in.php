<html>
<head>
	<title>Sign In</title>
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

	<!-- My JS -->	<script src="main.js"></script>


</head>
<body style="background-color:#00004d;">
        <div align="center">
        <div align="center">
                <h2><font color="white" face="Century Gothic"><p style="font-size: 75pt;"><b>Welcome Back.</p></h2>
        </div>

		<h4>Please enter your first name, last name, and team name below.</h4>
		<form action="sign-in.php" method="get"><font color="black">
			<input type="textbook" placeholder="First Name" name="fName" maxlength="30">
			<input type="textbook" placeholder="Last Name" name="lName" maxlength="30">
			<input type="textbook" placeholder="Team Name" name="tName" maxlength="30">
			<input type="submit" name="signIn" value="Sign In" class="btn btn-primary">
		</form>
<?php
if(isset($_GET['signIn'])) {
session_start();
$_SESSION['firstName']=$_GET["fName"];
$_SESSION['lastName']=$_GET["lName"]; 
$_SESSION['teamName']=$_GET["tName"];

// connect and select database
$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
	or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

if (!($stmt=$link->prepare("select teamName, firstName, lastName from userTeams where teamName=? and firstName=? and lastName=?"))) {
	echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
}
if (!$stmt->bind_param("sss", $_GET["tName"], $_GET["fName"], $_GET["lName"])) {
	echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
}

$result = $stmt->execute();
echo $stmt->error;
$stmt->bind_result($fname,$lname,$tname);
$stmt->fetch();
if (!$fname) {
	echo "user not found";
}else {
// send user to main.php
	header('Location: main.php');
}

}
?>
		<form action="index.php" method="get">
			<input type="submit" name="goBack" value="Back" class="btn btn-primary">
		</form>
	</div>
	

</body>

</html>
