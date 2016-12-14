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
        <title>Algorithms</title>
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
	<li class="active"><a href="http://dsg1.crc.nd.edu/cse30246/viva/algorithms.php">Algorithm<span class="sr-only">(current)</span></a></li>
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
	
        <body background="jerryWorld.jpg">
        <img src='jerryWorld.jpg' style='position:fixed;top:0px;left:0px;width:100%;height:100%;z-index:-1;'>

        <div align="center">
                <h2><font color="#151B8D" face="Century Gothic"><p style="font-size: 92pt;"><b>Algorithm.</p></font size></h2>
        </div>



	<div id="textbox" class="boxed" align="center" style="position:absolute; background-color:white; opacity:0.83">
	</div> //new
	<div id="tbox" class="boxed" align="center" style="position:absolute">

		<font face="Century Gothic" color="#151B8D">Welcome to Fantasize, the future of Fantasy Football prediction software. We hope you enjoy the website and bring you closer to a 
championship in the process.<br></br> Our algorithms take a very different approach to modeling how athletes will perform on a given week: we think they will keep going. You often hear
sports pundits talking about whether or not a guy can keep up his production or if he is a flash in the pan. We believe that each week is more important than the last and ask the now famous
question:<br></br> "What have you done for me lately?"<br></br> Our algorithm takes into account what a player has done, when it happened, and who he is playing this week. The ranking of defenses
also relies on momentum, following the same style of algorithm as all other players. Depending on the defense, our algorithm allows an offensive player's projected score can fluctuate
up to 45%. <br></br> You are probably wondering why kickers don't have all the information about defenses in their output. Let me be clear, kickers are people too; we have found through trial and 
error that kickers are affected much less by the defense they are playing than by their own performance, so we run a momentum algorithm to get their scores but do not take into account defense.</font>
	</div>
        <script>
                var a = window.innerHeight;
                var b = window.innerWidth;
		var c = 0;
		var d = 0;
                console.log(a);
                console.log(b);
                e = a;
		a = (a / 2) + 5;
		d = a / 2;
		d = d - 60;
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
                a = a / 2 + 5;
                d = a / 2;
                d = d - 60;
                b = b / 2;
                c = b / 2;
                console.log(a);
                console.log(b);
                document.getElementById("tbox").style.bottom=0;
                document.getElementById("tbox").style.left=c;
                document.getElementById("tbox").style.width=b;
                document.getElementById("tbox").style.height=(e - 245);
         </script>

        <div style="position: absolute; bottom: 20; right: 0; text-align:right;">
        </b><font size=4>Image courtesy of Dan Huntley, Flickr.
        </div>


</body>

</html>
