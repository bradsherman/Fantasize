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
	<title>BackTest</title>
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
      	   <li><a href="http://dsg1.crc.nd.edu/cse30246/viva/planWeekend.php">Plan Your Weekend</a></li>
        <li><a href="http://dsg1.crc.nd.edu/cse30246/viva/algorithms.php">Algorithm</a></li>
	<li class="active"><a href="http://dsg1.crc.nd.edu/cse30246/viva/backtest.php">Performance<span class="sr-only">(current)</span></a></li>
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
	<li><a href="http://dsg1.crc.nd.edu/cse30246/viva/index.php" clas="signout">Sign Out</a></li>
    </ul>
    </div>
   </div>
</nav>
	<div align="center">
	<div align="center">
                <h2><font color="green" face="Century Gothic"><p style="font-size:92pt;"><b>Performance.</p></fontsize></h2>
        </div>
        <p>We have run our projections against the true scores for each of the top 150 offensive players in a given week. This will take a little bit of time, but the results will show
you why Fantasize should become your new default predictor. <br></br>Patience is a virtue my friend! Bear with us as we gather your data.</p>
		<form action="backtest.php" method="get">
			<input type="submit" id="backtest" name="backtest" value="GO" class="btn btn-success" color="green">
		</form>
        <div id="loadingdiv" style="display:none;">
            <p>Please wait while we load test our predictions for your team.</p>
            <div class="loader"></div>
        </div>
            
<?php
if (isset($_GET['backtest'])) {
	/* session_start(); */
	header('Location: backtest1.php');
}

?>
</body>
</html>
