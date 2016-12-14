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
        <title>Main</title>
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
        <script type="text/javascript" src="main.js"></script>


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
	<li class="active"><a href="http://dsg1.crc.nd.edu/cse30246/viva/main.php">Home<span class="sr-only">(current)</span></a></li>
        <li><a href="http://dsg1.crc.nd.edu/cse30246/viva/lineup.php">Lineup</a></li>
	<li><a href="http://dsg1.crc.nd.edu/cse30246/viva/planWeekend.php">Plan Your Weekend</a></li>
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
        <li><a href="http://dsg1.crc.nd.edu/cse30246/viva" class="signout">Sign Out</a></li>
      </ul>
    </div>
   </div>
</nav>
        <div align="center">
                <h2><font color="#00004d" face="Century Gothic"><p style="font-size: 92pt;"><b>Team Research.</p></font size></h2>
        </div>

<div align="left">
	<h4>Who would you like to add to your team?</h4>
	<form class="form-inline" id="insertForm" action="main.php" method="get">
        <div class="form-group" id="insertdiv">
            <input type="text" class="form-control" placeholder="Player Name" name="playerInsert" id="playerInsert" maxlength="30">
            <input type="submit" name="insertButton" value="Insert" class="btn btn-primary">
        </div>
	</form>
</div>

<div align="left">
    <h4>Who would you like to drop from your team?</h4>
    <form class="form-inline" id="dropForm" action="main.php" method="get">
        <div class="form-group" id="dropdiv">
            <input type="text" class="form-control" placeholder="Player Name" name="playerDrop" id="playerDrop" maxlength="30">
            <input type="submit" name="dropButton" value="Drop" class="btn btn-primary">
        </div>
    </form>
</div>

<div align="left">
	<h2>Your team:</h2>
</div>

<?php
/* session_start(); */
/* if (isset($_SESSION['firstName'])) $fName=$_SESSION['firstName']; */
/* else echo "<script>window.location.href='http://dsg1.crc.nd.edu/cse30246/viva/index.php?logout=true';</script>"; */
/* if (isset($_SESSION['lastName'])) $lName=$_SESSION['lastName']; */
/* else echo "<script>window.location.href='http://dsg1.crc.nd.edu/cse30246/viva/index.php?logout=true';</script>"; */
/* if (isset($_SESSION['teamName'])) $tName=$_SESSION['teamName']; */
/* else echo "<script>window.location.href='http://dsg1.crc.nd.edu/cse30246/viva/index.php?logout=true';</script>"; */
ob_start();
printTeam($tName, $fName, $lName);

//print out current team
function printTeam($tName, $fName, $lName) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        	or die('Could not connect: ' . mysql_error());
	mysqli_select_db($link, 'viva') or die('Could not select database');
	if (!($stmt=$link->prepare("select p1 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
	$stmt->fetch();
        if ($isOccupied!=NULL) {
	//	echo $isOccupied . "<br>";
		echo '<li class="list-group-item list-group-item-info">'.$isOccupied.'</li>';
	}
	$stmt->close();

	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p2 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
	$result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied!=NULL) {
        	echo '<li class="list-group-item list-group-item-info">'.$isOccupied.'</li>';
	}
        $stmt->close();

	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p3 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied) {
		echo '<li class="list-group-item list-group-item-info">'.$isOccupied.'</li>';
        }

	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p4 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied) {
        	echo '<li class="list-group-item list-group-item-info">'.$isOccupied.'</li>';
	}

	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p5 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied) {
        	echo '<li class="list-group-item list-group-item-info">'.$isOccupied.'</li>';
	}

	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p6 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied) {
		echo '<li class="list-group-item list-group-item-info">'.$isOccupied.'</li>';
        }

	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p7 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied) {
        	echo '<li class="list-group-item list-group-item-info">'.$isOccupied.'</li>';
	}

	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p8 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied) {
        	echo '<li class="list-group-item list-group-item-info">'.$isOccupied.'</li>';
	}

	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p9 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied) {
        	echo '<li class="list-group-item list-group-item-info">'.$isOccupied.'</li>';
	}

	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p10 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied) {
        	echo '<li class="list-group-item list-group-item-info">'.$isOccupied.'</li>';
	}

	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p11 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied) {
        	echo '<li class="list-group-item list-group-item-info">'.$isOccupied.'</li>';
	}

	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p12 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied) {
       		echo '<li class="list-group-item list-group-item-info">'.$isOccupied.'</li>';
	 }

	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p13 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied) {
        	echo '<li class="list-group-item list-group-item-info">'.$isOccupied.'</li>';
	}

	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p14 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied) {
        	echo '<li class="list-group-item list-group-item-info">'.$isOccupied.'</li>';
	}

	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p15 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied) {
        	echo '<li class="list-group-item list-group-item-info">'.$isOccupied.'</li>';
	}
	
}

//printTeam($tName, $fName, $lName);

if(isset($_GET['insertButton'])) {
ob_end_clean();
// connect and select database
//$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
  //      or die('Could not connect: ' . mysql_error());
//mysqli_select_db($link, 'viva') or die('Could not select database');
$inserted=0;
$queries = array(
    1 => "select p1 from userTeams where teamName=? and firstName=? and lastName=?",
    2 => "select p2 from userTeams where teamName=? and firstName=? and lastName=?",
    3 => "select p3 from userTeams where teamName=? and firstName=? and lastName=?",
    4 => "select p4 from userTeams where teamName=? and firstName=? and lastName=?",
    5 => "select p5 from userTeams where teamName=? and firstName=? and lastName=?",
    6 => "select p6 from userTeams where teamName=? and firstName=? and lastName=?",
    7 => "select p7 from userTeams where teamName=? and firstName=? and lastName=?",
    8 => "select p8 from userTeams where teamName=? and firstName=? and lastName=?",
    9 => "select p9 from userTeams where teamName=? and firstName=? and lastName=?",
    10 => "select p10 from userTeams where teamName=? and firstName=? and lastName=?",
    11 => "select p11 from userTeams where teamName=? and firstName=? and lastName=?",
    12 => "select p12 from userTeams where teamName=? and firstName=? and lastName=?",
    13 => "select p13 from userTeams where teamName=? and firstName=? and lastName=?",
    14 => "select p14 from userTeams where teamName=? and firstName=? and lastName=?",
    15 => "select p15 from userTeams where teamName=? and firstName=? and lastName=?"
);
// go through each spot and see if that player exists
foreach( $queries as $query ) {
    if ($inserted == 1) {
        break;
    }
    $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');
    if(!($stmt=$link->prepare($query))) {
        echo "prepare failed: (" . mysqli_errno($link) . ") " . mysqli_error($link);
    }
	if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
        	echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
	}
    
	$result=$stmt->execute();
	echo $stmt->error;
	$stmt->bind_result($isOccupied);
	$stmt->fetch();
    if ($isOccupied == $_GET["playerInsert"]) {
        echo $_GET["playerInsert"] . " is already on your team.<br>";
        $inserted=1;
    }
} 

if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

	if (!($stmt=$link->prepare("select p1 from userTeams where teamName=? and firstName=? and lastName=?"))) {
		echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
	if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
        	echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$result=$stmt->execute();
	echo $stmt->error;
	$stmt->bind_result($isOccupied);
	$stmt->fetch();
	if (!$isOccupied && $isOccupied != $_GET["playerInsert"]) {
		$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
		mysqli_select_db($link, 'viva') or die('Could not select database');
		if (!($stmt1=$link->prepare("update userTeams set p1=? where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
		if (!$stmt1->bind_param("ssss", $_GET["playerInsert"], $tName, $fName, $lName)) {
        		echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
		}
		$result1=$stmt1->execute();
		echo $stmt1->error;
		$inserted=1;
	}
    if ($isOccupied == $_GET["playerInsert"]) {
        echo $_GET["playerInsert"] . " is already on your team.<br>";
    }
}
if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
	mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p2 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $_GET["playerInsert"]) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p2=? where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ssss", $_GET["playerInsert"], $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
        if ($isOccupied == $_GET["playerInsert"]) {
            echo $_GET["playerInsert"] . " is already on your team.<br>";
        }
}
if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
	mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p3 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $_GET["playerInsert"]) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p3=? where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ssss", $_GET["playerInsert"], $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
        if ($isOccupied == $_GET["playerInsert"]) {
            echo $_GET["playerInsert"] . " is already on your team.";
        }
}
if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
	mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p4 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $_GET["playerInsert"]) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p4=? where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ssss", $_GET["playerInsert"], $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
        if ($isOccupied == $_GET["playerInsert"]) {
            echo $_GET["playerInsert"] . " is already on your team.<br>";
        }
}
if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
	mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p5 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $_GET["playerInsert"]) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p5=? where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ssss", $_GET["playerInsert"], $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
        if ($isOccupied == $_GET["playerInsert"]) {
            echo $_GET["playerInsert"] . " is already on your team.";
        }
}
if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
	mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p6 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $_GET["playerInsert"]) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p6=? where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ssss", $_GET["playerInsert"], $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
        if ($isOccupied == $_GET["playerInsert"]) {
            echo $_GET["playerInsert"] . " is already on your team.<br>";
        }
}
if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
	mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p7 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $_GET["playerInsert"]) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p7=? where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ssss", $_GET["playerInsert"], $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
        if ($isOccupied == $_GET["playerInsert"]) {
            echo $_GET["playerInsert"] . " is already on your team.";
        }
}
if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
	mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p8 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $_GET["playerInsert"]) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p8=? where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ssss", $_GET["playerInsert"], $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
        if ($isOccupied == $_GET["playerInsert"]) {
            echo $_GET["playerInsert"] . " is already on your team.<br>";
        }
}
if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
	mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p9 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $_GET["playerInsert"]) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p9=? where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ssss", $_GET["playerInsert"], $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
        if ($isOccupied == $_GET["playerInsert"]) {
            echo $_GET["playerInsert"] . " is already on your team.";
        }
}
if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
	mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p10 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $_GET["playerInsert"]) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p10=? where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ssss", $_GET["playerInsert"], $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
        if ($isOccupied == $_GET["playerInsert"]) {
            echo $_GET["playerInsert"] . " is already on your team.<br>";
        }
}
if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
	mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p11 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $_GET["playerInsert"]) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p11=? where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ssss", $_GET["playerInsert"], $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
        if ($isOccupied == $_GET["playerInsert"]) {
            echo $_GET["playerInsert"] . " is already on your team.";
        }
}
if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
	mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p12 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $_GET["playerInsert"]) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p12=? where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ssss", $_GET["playerInsert"], $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
        if ($isOccupied == $_GET["playerInsert"]) {
            echo $_GET["playerInsert"] . " is already on your team.<br>";
        }
}
if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
	mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p13 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $_GET["playerInsert"]) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p13=? where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ssss", $_GET["playerInsert"], $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
        if ($isOccupied == $_GET["playerInsert"]) {
            echo $_GET["playerInsert"] . " is already on your team.";
        }
}
if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
	mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p14 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $_GET["playerInsert"]) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p14=? where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ssss", $_GET["playerInsert"], $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
        if ($isOccupied == $_GET["playerInsert"]) {
            echo $_GET["playerInsert"] . " is already on your team.<br>";
        }
}
if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
	mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p15 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $_GET["playerInsert"]) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p15=? where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ssss", $_GET["playerInsert"], $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
        if ($isOccupied == $_GET["playerInsert"]) {
            echo $_GET["playerInsert"] . " is already on your team.<br>";
        }
}
if ($inserted==0) {
	print("<br><b>Your team is full. You must first drop a player before inserting a new player.</b><br>");
}
//ob_end_clean();
printTeam($tName, $fName, $lName);
	
}

?>

<?php
if(isset($_GET['dropButton'])) {
$deleted=0;

if ($deleted==0) {
	// connect and select database
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
    		or die('Could not connect: ' . mysql_error());
	mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p1 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied==$_GET['playerDrop']) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p1=NULL where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("sss", $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $deleted=1;
        }
}
if ($deleted==0) {
        // connect and select database
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p2 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied==$_GET['playerDrop']) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p2=NULL where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("sss", $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $deleted=1;
        }
}
if ($deleted==0) {
        // connect and select database
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p3 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied==$_GET['playerDrop']) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p3=NULL where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("sss", $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $deleted=1;
        }
}
if ($deleted==0) {
        // connect and select database
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p4 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied==$_GET['playerDrop']) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p4=NULL where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("sss", $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $deleted=1;
        }
}
if ($deleted==0) {
        // connect and select database
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p5 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied==$_GET['playerDrop']) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p5=NULL where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("sss", $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $deleted=1;
        }
}
if ($deleted==0) {
        // connect and select database
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p6 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied==$_GET['playerDrop']) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p6=NULL where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("sss", $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $deleted=1;
        }
}
if ($deleted==0) {
        // connect and select database
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p7 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied==$_GET['playerDrop']) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p7=NULL where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("sss", $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $deleted=1;
        }
}
if ($deleted==0) {
        // connect and select database
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p8 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied==$_GET['playerDrop']) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p8=NULL where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("sss", $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $deleted=1;
        }
}
if ($deleted==0) {
        // connect and select database
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p9 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied==$_GET['playerDrop']) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p9=NULL where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("sss", $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $deleted=1;
        }
}
if ($deleted==0) {
        // connect and select database
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p10 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied==$_GET['playerDrop']) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p10=NULL where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("sss", $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $deleted=1;
        }
}
if ($deleted==0) {
        // connect and select database
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p11 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied==$_GET['playerDrop']) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p11=NULL where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("sss", $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $deleted=1;
        }
}
if ($deleted==0) {
        // connect and select database
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p12 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied==$_GET['playerDrop']) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p12=NULL where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("sss", $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $deleted=1;
        }
}
if ($deleted==0) {
        // connect and select database
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p13 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied==$_GET['playerDrop']) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p13=NULL where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("sss", $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $deleted=1;
        }
}
if ($deleted==0) {
        // connect and select database
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p14 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied==$_GET['playerDrop']) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p14=NULL where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("sss", $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $deleted=1;
        }
}
if ($deleted==0) {
        // connect and select database
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        if (!($stmt=$link->prepare("select p15 from userTeams where teamName=? and firstName=? and lastName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("sss", $tName, $fName, $lName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if ($isOccupied==$_GET['playerDrop']) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update userTeams set p15=NULL where teamName=? and firstName=? and lastName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("sss", $tName, $fName, $lName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $deleted=1;
        }
}
if ($deleted==0) {
	echo "This player is not currently on your team.";
}	
ob_end_clean();
printTeam($tName, $fName, $lName);

}
?>

<div align="left">
	<h3>Player Search</h3>
    <h4>Who would you like to search for?</h4>
    <form class="form-inline" id="searchForm" action="main.php" method="get">
        <div class="form-group" id="searchdiv">
            <input type="text" class="form-control" placeholder="Player Name" name="playerSearch" id="playerSearch" maxlength="30">
            <input type="submit" name="searchButton" value="Search" class="btn btn-primary">
        </div>
    </form>
</div>

<?php
if(isset($_GET['searchButton'])) {
// connect and select database
$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');
	$name=$_GET['playerSearch'];
	if (!($stmt=$link->prepare("select * from OffensiveStats where player=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $name)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;

        $stmt->bind_result($rk, $player, $pos, $week, $team, $opp, $passYds, $passTD, $interception, $rushYds, $rushTD, $rec, $recYds, $recTD, $fumLost, $standardPts);
   /*     echo "<br><h4><b>".$name."</b></h4><br>";
    echo "<table class=\"table\">";
    echo "<th> Pos </th><th> Week </th><th> Rank </th><th> Team </th><th> Opp </th><th> PassYds </th><th> PassTD </th><th> Interception </th><th> RushYds </th><th> rushTD </th><th> Rec </th><th> RecYds </th><th> RecTD </th><th> FumLost </th><th> StandardPts </th>";
*/
	if (!($stmt->fetch())) echo "<h4><b>".$name." not found</b></h4>";
//	while ($stmt->fetch()) {
	else {  
	echo "<br><h4><b>".$name."</b></h4><br>";
    echo "<table class=\"table\">";
    echo "<th> Position </th><th> Week </th><th> Weekly Offensive Rank </th><th> Team </th><th> Opponent </th><th> Pass Yds </th><th> Pass TD </th><th> Interceptions </th><th> Rush Yds </th><th> Rush TD </th><th> Receptions </th><th> Receiving Yds </th><th> Receiving TD </th><th> Fumbles Lost </th><th> Standard Pts </th>";
        while ($stmt->fetch()) {
	echo "<tr>";
		echo "<td class=text-center> ".$pos." </td><td class=text-center> ".$week." </td><td class=text-center> ".$rk." </td><td class=text-center> ".$team." </td><td class=text-center> ".$opp." </td><td class=text-center> ".$passYds." </td><td class=text-center> ".$passTD." </td><td class=text-center> ".$interception." </td><td class=text-center> ".$rushYds." </td><td class=text-center> ".$rushTD." </td><td class=text-center> ".$rec." </td><td class=text-center> ".$recYds." </td><td class=text-center> ".$recTD." </td><td class=text-center> ".$fumLost." </td><td class=text-center> ".$standardPts." </td>";
        echo "</tr>";
	}
	echo "</table>";
	}
  //  echo "</table>";
	
}

?>
</div>

<div align="left">
        <h5>Would you like to delete your team?</h5>
	<form action="deleteTeam.php" method="get">
		<input type="submit" name="goToDelete" value="Click Here" class="btn btn-primary">
	</form>
</div>


</body>

</html>
