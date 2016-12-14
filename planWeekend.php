<?php
session_start();
if (isset($_SESSION['firstName'])) $fName=$_SESSION['firstName'];
else echo "<script>window.location.href='http://dsg1.crc.nd.edu/cse30246/viva/index.php?logout=true';</script>";
if (isset($_SESSION['lastName'])) $lName=$_SESSION['lastName'];
else echo "<script>window.location.href='http://dsg1.crc.nd.edu/cse30246/viva/index.php?logout=true';</script>";
if (isset($_SESSION['teamName'])) $tName=$_SESSION['teamName'];
else echo "<script>window.location.href='http://dsg1.crc.nd.edu/cse30246/viva/index.php?logout=true';</script>";
?>
<html>
<head>
        <title>Plan Your Weekend</title>
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

<body style="background-color:white;">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="http://dsg1.crc.nd.edu/cse30246/viva/main.php">Home</a></li>
        <li><a href="http://dsg1.crc.nd.edu/cse30246/viva/lineup.php">Lineup</a></li>
        <li class="active"><a href="http://dsg1.crc.nd.edu/cse30246/viva/planWeekend.php">Plan Your Weekend<span class="sr-only">(current)</span></a></li>
        <li><a href="http://dsg1.crc.nd.edu/cse30246/viva/algorithms.php">Algorithm</a></li>
        <li><a href="http://dsg1.crc.nd.edu/cse30246/viva/backtest.php">Performance</a></li>
        <li><a href="http://dsg1.crc.nd.edu/cse30246/viva/about.php">About</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
      <li><a href="">
            <?php 
            if(isset($_SESSION['firstName']) && isset($_SESSION['lastName'])) {
                echo "<div>".$_SESSION['firstName']." ".$_SESSION['lastName']."</div>";
            }
            else echo "<div>Unknown</div>";
            ?>
      </a>
      </li>
        <li><a href="http://dsg1.crc.nd.edu/cse30246/viva/index.php" class="signout">Sign Out</a></li>
        </ul>
    </div>
   </div>
</nav>
	<div align="center">
                <h2><font color="#B20032" face="Century Gothic"><p style="font-size: 80pt;"><b>Plan Your Weekend.</p></font size></h2>
        </div>

        <div id="textbox" class="boxed" align="center" style="position:absolute; background-color:white; opacity:0.54">
        </div>

        <div id="tbox" class="boxed" align="center" style="position:absolute">
                <font face="Century Gothic" color="#B20032">Throughout every man or woman's week, there comes a time when they have to ask themselves just how little they want to get done this weekend. If you need help or guidance on this noble endeavor, like planning how much time you will spend on your couch or in a bar, then this is the feature for you: Plan Your Weekend. NFL games are played at five different timeslots and (begrudgingly) two different continents. This app allows for the user to select exactly which times they want to watch football and draft a fantasy football lineup from it.<br></br>
		</font>
	
		<h2><font color="#B20032">Enter week:</font></h2>
		<form action="planWeekend.php" method="get">
			<input type="textbook" placeholder="Week Number" name="week">
			<input type="submit" name="weekSubmit" value="Submit" class="btn btn-primary" style="background:#B20032; border:#B20032;">
		</form>
	</div>

<?php
if (isset($_GET['weekSubmit'])) {
//session_start();
$_SESSION['weekNumber']=$_GET["week"];

if ($_GET["week"]<1 or $_GET["week"]>17) {
	echo "<div><h4><br></br><br></br><br>Invalid week number. Please enter a week number between 1 and 17.</h4></div>";
}
else {
	header('Location: planWeekend1.php');
}

}

?>


</body>
</html>
