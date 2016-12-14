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
        <title>About</title>
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
	<li><a href="http://dsg1.crc.nd.edu/cse30246/viva/backtest.php">Performance</a></li>
	<li class="active"><a href="http://dsg1.crc.nd.edu/cse30246/viva/about.php">About<span class="sr-only">(current)</span></a></li>
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
    </div>
   </div>
</nav>
	
        <body background="ch.jpg">
        <img src='ch.jpg' style='position:fixed;top:0px;left:0px;width:100%;height:100%;z-index:-1;'>

	<div align="center">
                <h2><font color="#e6e6e6" face="Century Gothic"><p style="font-size: 92pt;"><b>About.</p></font size></h2>
        </div>

	<div id="textbox" class="boxed" align="center" style="position:absolute; background-color:white; opacity:0.52">
	</div> //new
	<div id="tbox" class="boxed" align="center" style="position:absolute">
		<font face="Century Gothic" color="#B20032">It all started as an idea for a secondary ticket marketplace. After being steered into another direction, Fantasize came into
being. Updates will continue to be made to the site periodically, so keep checking in.<br></br>The development team is made up of four Computer Science majors at the University of Notre
Dame: Rachael Mullin, Sam Mustipher, Noah Sarkey, and Brad Sherman.<br></br>If you have any questions, a bug to report, or just want to learn more about the project as a whole, please feel
free to reach out via email (nsarkey@nd.edu) and we are more than happy to talk about football nonsense for as long as you would like.<br></br><b>CSE 30246 Final Project - Professor 
Tim Weninger<br></br>Data procured via FantasyData.com</b></font>
	</div>
        <script>
                var a = window.innerHeight;
                var b = window.innerWidth;
		var c = 0;
		var d = 0;
                console.log(a);
                console.log(b);
		e = a;
                a = a / 2 - 100;
		d = a / 2;
		d = d + 40;
                b = b / 2;
		c = b / 2;
                console.log(a);
                console.log(b);
                document.getElementById("textbox").style.bottom=0;
                document.getElementById("textbox").style.left=c;
		document.getElementById("textbox").style.width=b;
		document.getElementById("textbox").style.height=(e-245);
	</script>

        <script>
                var a = window.innerHeight;
                var b = window.innerWidth;
                var c = 0;
                var d = 0;
                console.log(a);
                console.log(b);
		e = a;
                a = a / 2 - 100;
                d = a / 2;
                d = d + 40;
                b = b / 2;
                c = b / 2;
                console.log(a);
                console.log(b);
                document.getElementById("tbox").style.bottom=0;
                document.getElementById("tbox").style.left=c;
                document.getElementById("tbox").style.width=b;
                document.getElementById("tbox").style.height=(e-245);
        </script>

        <div style="position: absolute; bottom: 20; right: 0; text-align:right;">
        </b><font size=4>Image courtesy of Rachel Santschi, Kansas City Chiefs.
        </div>


</body>

</html>
