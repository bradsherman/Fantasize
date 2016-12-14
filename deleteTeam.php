<html>
<head>
        <title>Main</title>

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

<div align="center">
	<h2>Are you sure you want to delete your team? :(</h2>
	<form action="deleteTeam.php" method="get">
		<input type="submit" name="yesDelete" value="Yes" class="btn btn-primary">
		<input type="submit" name="noDelete" value="No" class="btn btn-primary">
	</form>
</div>

<?php
session_start();
if (isset($_SESSION['firstName'])) $fName=$_SESSION['firstName'];
else echo "<script>window.location.href='http://dsg1.crc.nd.edu/cse30246/viva/index.php';alert('Your session has expired. Please sign in again.')</script>";
if (isset($_SESSION['lastName'])) $lName=$_SESSION['lastName'];
else echo "<script>window.location.href='http://dsg1.crc.nd.edu/cse30246/viva/index.php';alert('Your session has expired. Please sign in again.')</script>";
if (isset($_SESSION['teamName'])) $tName=$_SESSION['teamName'];
else echo "<script>window.location.href='http://dsg1.crc.nd.edu/cse30246/viva/index.php';alert('Your session has expired. Please sign in again.')</script>";

if(isset($_GET['yesDelete'])) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
	mysqli_select_db($link, 'viva') or die('Could not select database');

	if (!($stmt=$link->prepare("delete from userTeams where teamName=? and firstName=? and lastName=?"))) {
		echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
	}
	if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
	        echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
}
	$result = $stmt->execute();
	echo $stmt->error;

	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("delete from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
}
        $result = $stmt->execute();
        echo $stmt->error;

	header('Location: index.php');
}

if(isset($_GET['noDelete'])) {
	header('Location: main.php');
}

?>

</body>

</html>
