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

<body style="background-color:#006600;">
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
    </div>
   </div>
</nav>
<!--
	<div align="left">
		<form action="" method="get">
			<input type="submit" name="backButton" value="Back" class="btn btn-primary">
		</form>
	</div>
-->
        <div align="center">
                <h2><font color="white" face="Century Gothic"><p style="font-size: 85pt;margin-bottom: 30px"><b>Choose.</p></font size></h2>
        </div>

	<div align="center">
		<form action="" method="get">

	<div class="container" align="center">
	<font color="white">
 	 <h3 style="display:inline-block;margin: 10px 10px 10px 10px;">Thursday Night</h3>
 		 <!--<p style="display:inline-block;">What do you want to do?</p>-->

  	 <div class="radio" style="display:inline-block;margin: 10px 10px 10px 10px;">
		 <label><input type="radio" name="thurs" value="0" id="rBars">Hit the Bars</label>
    	</div>

	<div class="radio" style="display:inline-block;margin: 10px 10px 10px 10px;">
      		 <label><input type="radio" name="thurs" value="1" id="rFBall">Watch Football</label>
   	 </div>

	<input type="submit" name="thursdayButton" value="Submit" class="btn btn-primary" style="background:#663300; border:#663300; display:inline-block;margin: 10px 10px 10px 10px;">
	</div>
	</form>
	</div>

<?php
if (isset($_SESSION['weekNumber'])) $weekNum=$_SESSION['weekNumber'];

if(isset($_GET["backButton"])) {
    echo "<script>window.location.href='http://dsg1.crc.nd.edu/cse30246/viva/planWeekend.php'</script>";
}
function printLineup($tName) {
	echo "<h2>Your Lineup:</h2><br>";
	$queries = array(
    1 => "select p1 from weekend where teamName=?",
2 => "select p2 from weekend where teamName=?",
3 => "select p3 from weekend where teamName=?",
4 => "select p4 from weekend where teamName=?",
5 => "select p5 from weekend where teamName=?",
6 => "select p6 from weekend where teamName=?",
7 => "select p7 from weekend where teamName=?",
8 => "select p8 from weekend where teamName=?",
9 => "select p9 from weekend where teamName=?",
);

	foreach( $queries as $query ) {

	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
	
	if(!($stmt=$link->prepare($query))) {
        echo "prepare failed: (" . mysqli_errno($link) . ") " . mysqli_error($link);
    }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }

	$result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
    if ($isOccupied!=NULL) {
		echo '<li class="list-group-item list-group-item-info">'.$isOccupied.'</li>';
	}	
}
}

if(isset($_GET['thursdayButton'])) {
	$val=$_GET['thurs'];
//	$weekNum=$_GET["week"];
	$weekNumVar="gameTimes.wk".$weekNum;
    $sched="schedule.".$weekNum;
    if ($val==1) {
//		if ($weekNum==10) {
		$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        		or die('Could not connect: ' . mysql_error());
		mysqli_select_db($link, 'viva') or die('Could not select database');
	
//		if (!($stmt=$link->prepare("(
$query="(SELECT player, tm as Team, def as opponent, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position, ".$weekNumVar." as 'Game Time'
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player, tm, pos
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos
FROM OffensiveStats
) A
GROUP BY player
) B, 
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemOffensive, math, userTeams, gameTimes, schedule
WHERE ".$weekNumVar." = 10 and gameTimes.team = tm and userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$sched." and schedule.team = tm and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
)
UNION ALL
(
SELECT player, tm as Team, def as opponent, ROUND(((sa * ScoringSystemDST.sack + inter * ScoringSystemDST.interceptions + fm * 
ScoringSystemDST.fumb + saf * ScoringSystemDST.safety + dTD * ScoringSystemDST.defTD + rTD * ScoringSystemDST.retTD + ptsAll))
, 2) as Projection, 'DST', ".$weekNumVar." as 'Game Time'
FROM
( 
SELECT CASE
WHEN pts = 0
THEN ScoringSystemDST.pt0
WHEN pts < 7 and pts > 0
THEN ScoringSystemDST.pt16
WHEN pts < 14 and pts > 6
THEN ScoringSystemDST.pt713
WHEN pts < 21 and pts > 13
THEN ScoringSystemDST.pt1420
WHEN pts < 28 and pts > 20
THEN ScoringSystemDST.pt2127
WHEN pts < 35 and pts > 27
THEN ScoringSystemDST.pt2834
ELSE ScoringSystemDST.pt35
END AS ptsAll, sa, inter, fm, saf, dTD, rTD, pts, player, tm
FROM
(
SELECT (SUM(sacks * week) / SUM(week)) as sa, (SUM(interceptions * week) / SUM(week)) as inter, (SUM(fumRec * week) / SUM(week)) as fm, (SUM(safety * week) / SUM(week)) as saf,
(SUM(defTD * week) / SUM(week)) as dTD, (SUM(returnTD * week) / SUM(week)) as rTD, (SUM(ptsAllowed * week) / SUM(week)) as pts, player, tm
FROM
(
SELECT player, week, team as tm, opp, sacks, interceptions, fumRec, safety, defTD, returnTD, ptsAllowed
FROM DSTStats
) A
GROUP BY player
) B, ScoringSystemDST
WHERE ScoringSystemDST.name = 'Standard'
) Q,
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemDST, math, schedule, userTeams, gameTimes
WHERE ".$weekNumVar." = 10 and gameTimes.team = tm and userTeams.teamName = ? and ScoringSystemDST.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$sched." and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
)

UNION ALL

(
SELECT pl, tm as Team, def, ROUND(p, 2) as Projection, 'K', ".$weekNumVar." as 'Game Time'
FROM
(
SELECT (SUM(standPts * week) / SUM(week)) as p, pl, tm, oppon, def, t
FROM
(
SELECT KickingStats.player as pl, KickingStats.week, KickingStats.team as tm, KickingStats.opp as oppon, standPts, DSTStats.player as def, DSTStats.team as t
FROM KickingStats, DSTStats
) A
GROUP BY pl
) B, userTeams, schedule, gameTimes, DSTStats
WHERE ".$weekNumVar." = 10 and oppon = t and schedule.team = tm and gameTimes.team = tm and userTeams.teamName = ? and (pl = userTeams.p1 or pl = userTeams.p2 or pl = userTeams.p3 or pl = userTeams.p4 or pl = userTeams.p5 or pl = userTeams.p6 or pl = userTeams.p7 or pl = userTeams.p8 or pl = userTeams.p9 or pl = userTeams.p10 or pl = userTeams.p11 or pl = userTeams.p12 or pl = userTeams.p13 or pl = userTeams.p14 or pl = userTeams.p15)
GROUP BY pl
)
ORDER BY Projection DESC;"; 
if (!($stmt=$link->prepare($query))) {
	echo "prepare failed: (" . mysqli_errno($link) .") " . mysqli_error($link);
}

if (!$stmt->bind_param("sss", $tName, $tName, $tName)) {
	echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
}
	$stmt->execute();
	$result=$stmt->get_result();
	echo $stmt->error;
	if ($result->num_rows==0) {
		echo "<h4 align=center><b>\tNo players on your team play on Thursday night during week ".$weekNum.".</b></h4><br><br>";
	}	
else {
	echo "<form action='' method='post'>";
	echo "<br><br>";
	echo "<table style='color:white;' class=\"table\">";
    echo "<th>Player</th>";
    echo "<th>Position</th>";
    echo "<th>Team</th>";
    echo "<th>Opponent</th>";
    echo "<th>Projected Score</th>";
    echo "<th>Add to Lineup</th>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>";
        echo $row["player"];
        echo "</td><td>";
        echo $row["Position"];
        echo "</td><td>";
        echo $row["Team"];
        echo "</td><td>";
        if($row["Position"] == "K") echo "--";
        else echo $row["opponent"];
        echo "</td><td>";
        echo $row["Projection"];
	echo "</td><td>";
//	echo "<form action='planWeekend.php' method='get'>";
	echo "<input type='checkbox' name='playerBox[]' value='".$row["player"]."'><br>";
//	echo "</form>";
        echo "</td></tr>";
    }
    echo "</table>";
	echo "<input style='color:#006600;' type='submit' name='thursSubmit' value='Add'/>";
	echo "</form>";
}
	if (isset($_POST['thursSubmit'])) {
	if (!empty($_POST['playerBox'])) {
		foreach ($_POST['playerBox'] as $selected) {
			$inserted=0;
$queries = array(
    1 => "select p1 from weekend where teamName=?",
2 => "select p2 from weekend where teamName=?",
3 => "select p3 from weekend where teamName=?",
4 => "select p4 from weekend where teamName=?",
5 => "select p5 from weekend where teamName=?",
6 => "select p6 from weekend where teamName=?",
7 => "select p7 from weekend where teamName=?",
8 => "select p8 from weekend where teamName=?",
9 => "select p9 from weekend where teamName=?",
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
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
    if ($isOccupied == $selected) {
        echo $selected . " is already in your lineup.<br>";
        $inserted=1;
    }
}

if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p1 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p1=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p2 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p2=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p3 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p3=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p4 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p4=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p5 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p5=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p6 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p6=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p7 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p7=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p8 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p8=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p9 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p9=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}



		} 
	}
	else {
		echo "You did not select a player to add.";
	}
	}

	}
	else {
		echo "<div align=center>Have fun at Feve!</div><br>";
	}
//}
//	printLineup($tName);

}

?>

<div align="center">
    <form action="" method="get">
        <div class="container" align="center">
         <h3 style="display:inline-block;margin: 10px 10px 10px 10px;">Sunday 1 PM (EST)</h3>
                 <!--<p>What do you want to do?</p>-->

         <div class="radio" style="display:inline-block;margin: 10px 10px 10px 10px;">
                 <label><input type="radio" name="sunMorn" value="0" id="rBars">Go to Brunch</label>
        </div>

        <div class="radio" style="display:inline-block;margin: 10px 10px 10px 10px;">
                 <label><input type="radio" name="sunMorn" value="1" id="rFBall">Watch Football</label>
         </div>

        <input type="submit" name="sunMornButton" value="Submit" class="btn btn-primary" style="background:#663300; border:#663300;display:inline-block;margin: 10px 10px 10px 10px;">
        </div>
</form>
</div>

<?php

if(isset($_GET['sunMornButton'])) {
        $val=$_GET['sunMorn'];
//	$weekNum=$_GET["week1"];
        $weekNumVar="gameTimes.wk".$weekNum;
	if ($val==1) {
		$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
	
		$query1="(
SELECT player, tm as Team, def as opponent, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position, ".$weekNumVar." as 'Game Time'
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player, tm, pos
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos
FROM OffensiveStats
) A
GROUP BY player
) B, 
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemOffensive, math, userTeams, gameTimes, schedule
WHERE ".$weekNumVar." = 1 and gameTimes.team = tm and userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$sched." and schedule.team = tm and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
)

UNION ALL

(
SELECT player, tm as Team, def as opponent, ROUND(((sa * ScoringSystemDST.sack + inter * ScoringSystemDST.interceptions + fm * 
ScoringSystemDST.fumb + saf * ScoringSystemDST.safety + dTD * ScoringSystemDST.defTD + rTD * ScoringSystemDST.retTD + ptsAll))
, 2) as Projection, 'DST', ".$weekNumVar." as 'Game Time'
FROM
( 
SELECT CASE
WHEN pts = 0
THEN ScoringSystemDST.pt0
WHEN pts < 7 and pts > 0
THEN ScoringSystemDST.pt16
WHEN pts < 14 and pts > 6
THEN ScoringSystemDST.pt713
WHEN pts < 21 and pts > 13
THEN ScoringSystemDST.pt1420
WHEN pts < 28 and pts > 20
THEN ScoringSystemDST.pt2127
WHEN pts < 35 and pts > 27
THEN ScoringSystemDST.pt2834
ELSE ScoringSystemDST.pt35
END AS ptsAll, sa, inter, fm, saf, dTD, rTD, pts, player, tm
FROM
(
SELECT (SUM(sacks * week) / SUM(week)) as sa, (SUM(interceptions * week) / SUM(week)) as inter, (SUM(fumRec * week) / SUM(week)) as fm, (SUM(safety * week) / SUM(week)) as saf,
(SUM(defTD * week) / SUM(week)) as dTD, (SUM(returnTD * week) / SUM(week)) as rTD, (SUM(ptsAllowed * week) / SUM(week)) as pts, player, tm
FROM
(
SELECT player, week, team as tm, opp, sacks, interceptions, fumRec, safety, defTD, returnTD, ptsAllowed
FROM DSTStats
) A
GROUP BY player
) B, ScoringSystemDST
WHERE ScoringSystemDST.name = 'Standard'
) Q,
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemDST, math, schedule, userTeams, gameTimes
WHERE ".$weekNumVar." = 1 and gameTimes.team = tm and userTeams.teamName = ? and ScoringSystemDST.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$sched." and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
)

UNION ALL

(
SELECT pl, tm as Team, def, ROUND(p, 2) as Projection, 'K', ".$weekNumVar." as 'Game Time'
FROM
(
SELECT (SUM(standPts * week) / SUM(week)) as p, pl, tm, oppon, def, t
FROM
(
SELECT KickingStats.player as pl, KickingStats.week, KickingStats.team as tm, KickingStats.opp as oppon, standPts, DSTStats.player as def, DSTStats.team as t
FROM KickingStats, DSTStats
) A
GROUP BY pl
) B, userTeams, schedule, gameTimes, DSTStats
WHERE ".$weekNumVar." = 1 and oppon = t and schedule.team = tm and gameTimes.team = tm and userTeams.teamName = ? and (pl = userTeams.p1 or pl = userTeams.p2 or pl = userTeams.p3 or pl = userTeams.p4 or pl = userTeams.p5 or pl = userTeams.p6 or pl = userTeams.p7 or pl = userTeams.p8 or pl = userTeams.p9 or pl = userTeams.p10 or pl = userTeams.p11 or pl = userTeams.p12 or pl = userTeams.p13 or pl = userTeams.p14 or pl = userTeams.p15)
GROUP BY pl
)
ORDER BY Projection DESC
;";	

	if (!($stmt=$link->prepare($query1))) {
        echo "prepare failed: (" . mysqli_errno($link) .") " . mysqli_error($link);
}

if (!$stmt->bind_param("sss", $tName, $tName, $tName)) {
        echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
}
        $stmt->execute();
        $result=$stmt->get_result();
        echo $stmt->error;
if ($result->num_rows==0) {
                echo "<h4 align=center><b>\tNo players on your team play on Sunday morning during week ".$weekNum.".</b></h4><br><br>";
        }  
else {
    echo "<font color='white'>";
    echo "<form action='' method='post'>";
        echo "<br><br>";
        echo "<table style='color:white;' class=\"table\">";
    echo "<th>Player</th>";
    echo "<th>Position</th>";
    echo "<th>Team</th>";
    echo "<th>Opponent</th>";
    echo "<th>Projected Score</th>";
    echo "<th>Add to Lineup</th>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>";
        echo $row["player"];
        echo "</td><td>";
        echo $row["Position"];
        echo "</td><td>";
        echo $row["Team"];
        echo "</td><td>";
        echo $row["opponent"];
        echo "</td><td>";
        echo $row["Projection"];
        echo "</td><td>";
//      echo "<form action='planWeekend.php' method='get'>";
        echo "<input type='checkbox' name='playerBox1[]' value='".$row["player"]."'><br>";
//      echo "</form>";
        echo "</td></tr>";
    }
    echo "</table>";
        echo "<input style='color:#006600;' type='submit' name='sunMornSubmit' value='Add'/>";
        echo "</form>";
}
	if (isset($_POST['sunMornSubmit'])) {
        if (!empty($_POST['playerBox1'])) {
                foreach ($_POST['playerBox1'] as $selected) {
                        $inserted=0;
$queries = array(
    1 => "select p1 from weekend where teamName=?",
2 => "select p2 from weekend where teamName=?",
3 => "select p3 from weekend where teamName=?",
4 => "select p4 from weekend where teamName=?",
5 => "select p5 from weekend where teamName=?",
6 => "select p6 from weekend where teamName=?",
7 => "select p7 from weekend where teamName=?",
8 => "select p8 from weekend where teamName=?",
9 => "select p9 from weekend where teamName=?",
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
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
    if ($isOccupied == $selected) {
        echo $selected . " is already in your lineup.<br>";
        $inserted=1;
    }
}
	
if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p1 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p1=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p2 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p2=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p3 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p3=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p4 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p4=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p5 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p5=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p6 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p6=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p7 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p7=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p8 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p8=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p9 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p9=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
                }
        }
        else {
                echo "You did not select a player to add.";
        }
        }

        }
        else {
                echo "<div align=center>Enjoy brunch!</div><br>";
        }
//}
  //      printLineup($tName);
}	

?>

<div align="center">
        <form action="" method="get">
	<div class="container" align="center">
         <h3 style="display:inline-block;margin: 10px 10px 10px 10px;">Sunday 4 PM (EST)</h3>
                 <!--<p>What do you want to do?</p>-->

         <div class="radio" style="display:inline-block;margin: 10px 10px 10px 10px;">
                 <label><input type="radio" name="sunNoon" value="0" id="rBars">Hang with the fam</label>
        </div>

        <div class="radio" style="display:inline-block;margin: 10px 10px 10px 10px;">
                 <label><input type="radio" name="sunNoon" value="1" id="rFBall">Watch Football</label>
         </div>

        <input type="submit" name="sunNoonButton" value="Submit" class="btn btn-primary" style="background:#663300; border:#663300;display:inline-block;margin: 10px 10px 10px 10px;">
        </div>
        </form>
</div>

<?php

if(isset($_GET['sunNoonButton'])) {
        $val=$_GET['sunNoon'];
//	$weekNum=$_GET["week2"];
        $weekNumVar="gameTimes.wk".$weekNum;
	if ($val==1) {
		$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
	
		$query2="
(
SELECT player, tm as Team, def as opponent, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position, ".$weekNumVar." as 'Game Time'
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player, tm, pos
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos
FROM OffensiveStats
) A
GROUP BY player
) B, 
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemOffensive, math, userTeams, gameTimes, schedule
WHERE ".$weekNumVar." = 4 and gameTimes.team = tm and userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$sched." and schedule.team = tm and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
)

UNION ALL

(
SELECT player, tm as Team, def as opponent, ROUND(((sa * ScoringSystemDST.sack + inter * ScoringSystemDST.interceptions + fm * 
ScoringSystemDST.fumb + saf * ScoringSystemDST.safety + dTD * ScoringSystemDST.defTD + rTD * ScoringSystemDST.retTD + ptsAll))
, 2) as Projection, 'DST', ".$weekNumVar." as 'Game Time'
FROM
( 
SELECT CASE
WHEN pts = 0
THEN ScoringSystemDST.pt0
WHEN pts < 7 and pts > 0
THEN ScoringSystemDST.pt16
WHEN pts < 14 and pts > 6
THEN ScoringSystemDST.pt713
WHEN pts < 21 and pts > 13
THEN ScoringSystemDST.pt1420
WHEN pts < 28 and pts > 20
THEN ScoringSystemDST.pt2127
WHEN pts < 35 and pts > 27
THEN ScoringSystemDST.pt2834
ELSE ScoringSystemDST.pt35
END AS ptsAll, sa, inter, fm, saf, dTD, rTD, pts, player, tm
FROM
(
SELECT (SUM(sacks * week) / SUM(week)) as sa, (SUM(interceptions * week) / SUM(week)) as inter, (SUM(fumRec * week) / SUM(week)) as fm, (SUM(safety * week) / SUM(week)) as saf,
(SUM(defTD * week) / SUM(week)) as dTD, (SUM(returnTD * week) / SUM(week)) as rTD, (SUM(ptsAllowed * week) / SUM(week)) as pts, player, tm
FROM
(
SELECT player, week, team as tm, opp, sacks, interceptions, fumRec, safety, defTD, returnTD, ptsAllowed
FROM DSTStats
) A
GROUP BY player
) B, ScoringSystemDST
WHERE ScoringSystemDST.name = 'Standard'
) Q,
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemDST, math, schedule, userTeams, gameTimes
WHERE ".$weekNumVar." = 4 and gameTimes.team = tm and userTeams.teamName = ? and ScoringSystemDST.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$sched." and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
)
UNION ALL
(
SELECT pl, tm as Team, def, ROUND(p, 2) as Projection, 'K', ".$weekNumVar." as 'Game Time'
FROM
(
SELECT (SUM(standPts * week) / SUM(week)) as p, pl, tm, oppon, def, t
FROM
(
SELECT KickingStats.player as pl, KickingStats.week, KickingStats.team as tm, KickingStats.opp as oppon, standPts, DSTStats.player as def, DSTStats.team as t
FROM KickingStats, DSTStats
) A
GROUP BY pl
) B, userTeams, schedule, gameTimes, DSTStats
WHERE ".$weekNumVar." = 4 and oppon = t and schedule.team = tm and gameTimes.team = tm and userTeams.teamName = ? and (pl = userTeams.p1 or pl = userTeams.p2 or pl = userTeams.p3 or pl = userTeams.p4 or pl = userTeams.p5 or pl = userTeams.p6 or pl = userTeams.p7 or pl = userTeams.p8 or pl = userTeams.p9 or pl = userTeams.p10 or pl = userTeams.p11 or pl = userTeams.p12 or pl = userTeams.p13 or pl = userTeams.p14 or pl = userTeams.p15)
GROUP BY pl
)
ORDER BY Projection DESC
;";


	if (!($stmt=$link->prepare($query2))) {
        echo "prepare failed: (" . mysqli_errno($link) .") " . mysqli_error($link);
}

if (!$stmt->bind_param("sss", $tName, $tName, $tName)) {
        echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
}
        $stmt->execute();
        $result=$stmt->get_result();
        echo $stmt->error;
if ($result->num_rows==0) {
                echo "<h4 align=center><b>\tNo players on your team play on Sunday afternoon during week ".$weekNum.".</b></h4><br><br>";
        }  
else {
        echo "<form action='' method='post'>";
        echo "<br><br>";
        echo "<table style='color:white;' class=\"table\">";
    echo "<th>Player</th>";
    echo "<th>Position</th>";
    echo "<th>Team</th>";
    echo "<th>Opponent</th>";
    echo "<th>Projected Score</th>";
    echo "<th>Add to Lineup</th>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>";
        echo $row["player"];
        echo "</td><td>";
        echo $row["Position"];
        echo "</td><td>";
        echo $row["Team"];
        echo "</td><td>";
        echo $row["opponent"];
        echo "</td><td>";
        echo $row["Projection"];
        echo "</td><td>";
//      echo "<form action='planWeekend.php' method='get'>";
        echo "<input type='checkbox' name='playerBox2[]' value='".$row["player"]."'><br>";
//      echo "</form>";
        echo "</td></tr>";
    }
    echo "</table>";
        echo "<input style='color:#006600;' type='submit' name='sunNoonSubmit' value='Add'/>";
        echo "</form>";
}
	if (isset($_POST['sunNoonSubmit'])) {
        if (!empty($_POST['playerBox2'])) {
                foreach ($_POST['playerBox2'] as $selected) {
                        $inserted=0;
$queries = array(
    1 => "select p1 from weekend where teamName=?",
2 => "select p2 from weekend where teamName=?",
3 => "select p3 from weekend where teamName=?",
4 => "select p4 from weekend where teamName=?",
5 => "select p5 from weekend where teamName=?",
6 => "select p6 from weekend where teamName=?",
7 => "select p7 from weekend where teamName=?",
8 => "select p8 from weekend where teamName=?",
9 => "select p9 from weekend where teamName=?",
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
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
    if ($isOccupied == $selected) {
        echo $selected . " is already in your lineup.<br>";
        $inserted=1;
    }
}

if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p1 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p1=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p2 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p2=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p3 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p3=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p4 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p4=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p5 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p5=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p6 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p6=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p7 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p7=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p8 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p8=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p9 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p9=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
                }
        }
        else {
        	echo "You did not select a player to add.";
	}
        }

        }
        else {
                echo "<div align=center>Have fun with the fam :)</div><br>";
        }
//}
    //    printLineup($tName);
}	
?>

<div align="center">
        <form action="" method="get">
        <div class="container" align="center">
         <h3 style="display:inline-block;margin: 10px 10px 10px 10px;">Sunday 8 PM (EST)</h3>
                 <!--<p>What do you want to do?</p>-->

         <div class="radio" style="display:inline-block;margin: 10px 10px 10px 10px;">
                 <label><input type="radio" name="sunNight" value="0" id="rBars">Netflix and Chill</label>
        </div>

        <div class="radio" style="display:inline-block;margin: 10px 10px 10px 10px;">
                 <label><input type="radio" name="sunNight" value="1" id="rFBall">Watch Football</label>
         </div>

        <input type="submit" name="sunNightButton" value="Submit" class="btn btn-primary" style="background:#663300; border:#663300;display:inline-block;margin: 10px 10px 10px 10px;">
        </div>
        </form>
</div>

<?php


if(isset($_GET['sunNightButton'])) {
        $val=$_GET['sunNight'];
	//$weekNum=$_GET["week3"];
        $weekNumVar="gameTimes.wk".$weekNum;
	if ($val==1) {
		$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
	
		$query3="
(
SELECT player, tm as Team, def as opponent, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position, ".$weekNumVar." as 'Game Time'
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player, tm, pos
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos
FROM OffensiveStats
) A
GROUP BY player
) B, 
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemOffensive, math, userTeams, gameTimes, schedule
WHERE ".$weekNumVar." = 8 and gameTimes.team = tm and userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$sched." and schedule.team = tm and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
)

UNION ALL

(
SELECT player, tm as Team, def as opponent, ROUND(((sa * ScoringSystemDST.sack + inter * ScoringSystemDST.interceptions + fm * 
ScoringSystemDST.fumb + saf * ScoringSystemDST.safety + dTD * ScoringSystemDST.defTD + rTD * ScoringSystemDST.retTD + ptsAll))
, 2) as Projection, 'DST', ".$weekNumVar." as 'Game Time'
FROM
( 
SELECT CASE
WHEN pts = 0
THEN ScoringSystemDST.pt0
WHEN pts < 7 and pts > 0
THEN ScoringSystemDST.pt16
WHEN pts < 14 and pts > 6
THEN ScoringSystemDST.pt713
WHEN pts < 21 and pts > 13
THEN ScoringSystemDST.pt1420
WHEN pts < 28 and pts > 20
THEN ScoringSystemDST.pt2127
WHEN pts < 35 and pts > 27
THEN ScoringSystemDST.pt2834
ELSE ScoringSystemDST.pt35
END AS ptsAll, sa, inter, fm, saf, dTD, rTD, pts, player, tm
FROM
(
SELECT (SUM(sacks * week) / SUM(week)) as sa, (SUM(interceptions * week) / SUM(week)) as inter, (SUM(fumRec * week) / SUM(week)) as fm, (SUM(safety * week) / SUM(week)) as saf,
(SUM(defTD * week) / SUM(week)) as dTD, (SUM(returnTD * week) / SUM(week)) as rTD, (SUM(ptsAllowed * week) / SUM(week)) as pts, player, tm
FROM
(
SELECT player, week, team as tm, opp, sacks, interceptions, fumRec, safety, defTD, returnTD, ptsAllowed
FROM DSTStats
) A
GROUP BY player
) B, ScoringSystemDST
WHERE ScoringSystemDST.name = 'Standard'
) Q,
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemDST, math, schedule, userTeams, gameTimes
WHERE ".$weekNumVar." = 8 and gameTimes.team = tm and userTeams.teamName = ? and ScoringSystemDST.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$sched." and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
)

UNION ALL

(
SELECT pl, tm as Team, def, ROUND(p, 2) as Projection, 'K', ".$weekNumVar." as 'Game Time'
FROM
(
SELECT (SUM(standPts * week) / SUM(week)) as p, pl, tm, oppon, def, t
FROM
(
SELECT KickingStats.player as pl, KickingStats.week, KickingStats.team as tm, KickingStats.opp as oppon, standPts, DSTStats.player as def, DSTStats.team as t
FROM KickingStats, DSTStats
) A
GROUP BY pl
) B, userTeams, schedule, gameTimes, DSTStats
WHERE ".$weekNumVar." = 8 and oppon = t and schedule.team = tm and gameTimes.team = tm and userTeams.teamName = ? and (pl = userTeams.p1 or pl = userTeams.p2 or pl = userTeams.p3 or pl = userTeams.p4 or pl = userTeams.p5 or pl = userTeams.p6 or pl = userTeams.p7 or pl = userTeams.p8 or pl = userTeams.p9 or pl = userTeams.p10 or pl = userTeams.p11 or pl = userTeams.p12 or pl = userTeams.p13 or pl = userTeams.p14 or pl = userTeams.p15)
GROUP BY pl
)
ORDER BY Projection DESC
;";


	if (!($stmt=$link->prepare($query3))) {
        echo "prepare failed: (" . mysqli_errno($link) .") " . mysqli_error($link);
}

if (!$stmt->bind_param("sss", $tName, $tName, $tName)) {
        echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
}
        $stmt->execute();
        $result=$stmt->get_result();
        echo $stmt->error;
if ($result->num_rows==0) {
                echo "<h4 align=center><b>\tNo players on your team play on Sunday night during week ".$weekNum.".</b></h4><br><br>";
        }  
else {
        echo "<form action='' method='post'>";
        echo "<br><br>";
        echo "<table style='color:white;' class=\"table\">";
    echo "<th>Player</th>";
    echo "<th>Position</th>";
    echo "<th>Team</th>";
    echo "<th>Opponent</th>";
    echo "<th>Projected Score</th>";
    echo "<th>Add to Lineup</th>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>";
        echo $row["player"];
        echo "</td><td>";
        echo $row["Position"];
        echo "</td><td>";
        echo $row["Team"];
        echo "</td><td>";
        echo $row["opponent"];
        echo "</td><td>";
        echo $row["Projection"];
        echo "</td><td>";
//      echo "<form action='planWeekend.php' method='get'>";
        echo "<input type='checkbox' name='playerBox3[]' value='".$row["player"]."'><br>";
//      echo "</form>";
        echo "</td></tr>";
    }
    echo "</table>";
        echo "<input style='color:#006600;' type='submit' name='sunNightSubmit' value='Add'/>";
        echo "</form>";
}
	if (isset($_POST['sunNightSubmit'])) {
        if (!empty($_POST['playerBox3'])) {
                foreach ($_POST['playerBox3'] as $selected) {
                        $inserted=0;
$queries = array(
    1 => "select p1 from weekend where teamName=?",
2 => "select p2 from weekend where teamName=?",
3 => "select p3 from weekend where teamName=?",
4 => "select p4 from weekend where teamName=?",
5 => "select p5 from weekend where teamName=?",
6 => "select p6 from weekend where teamName=?",
7 => "select p7 from weekend where teamName=?",
8 => "select p8 from weekend where teamName=?",
9 => "select p9 from weekend where teamName=?",
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
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
    if ($isOccupied == $selected) {
        echo $selected . " is already in your lineup.<br>";
        $inserted=1;
    }
}

if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p1 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p1=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p2 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p2=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p3 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p3=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p4 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p4=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p5 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p5=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p6 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p6=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p7 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p7=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p8 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p8=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p9 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p9=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
                }
        }
        else {
        	echo "You did not select a player to add.";
	}
        }

        }
        else {
                echo "<div align=center>Don't forget the popcorn!</div><br>";
        }
//}
      //  printLineup($tName);
}	

?>

<div align="center">
	<form action="" method="get">
        <div class="container" align="center">
         <h3 style="display:inline-block;margin: 10px 10px 10px 10px;">Monday Night</h3>
                 <!--<p>What do you want to do?</p>-->

         <div class="radio" style="display:inline-block;margin: 10px 10px 10px 10px;">
                 <label><input type="radio" name="mon" value="0" id="rBars">Be productive with your life</label>
        </div>

        <div class="radio" style="display:inline-block;margin: 10px 10px 10px 10px;">
                 <label><input type="radio" name="mon" value="1" id="rFBall">Watch Football</label>
         </div>

        <input type="submit" name="monButton" value="Submit" class="btn btn-primary" style="background:#663300; border:#663300;display:inline-block;margin: 10px 10px 10px 10px;">
        </div>
        </form>
</div>

<?php


if(isset($_GET['monButton'])) {
        $val=$_GET['mon'];
	//$weekNum=$_GET["week4"];
        $weekNumVar="gameTimes.wk".$weekNum;
	if ($val==1) {
		$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
	
		$query4="
(
SELECT player, tm as Team, def as opponent, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position, ".$weekNumVar." as 'Game Time'
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player, tm, pos
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos
FROM OffensiveStats
) A
GROUP BY player
) B, 
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemOffensive, math, userTeams, gameTimes, schedule
WHERE ".$weekNumVar." = 11 and gameTimes.team = tm and userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$sched." and schedule.team = tm and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
)

UNION ALL

(
SELECT player, tm as Team, def as opponent, ROUND(((sa * ScoringSystemDST.sack + inter * ScoringSystemDST.interceptions + fm * 
ScoringSystemDST.fumb + saf * ScoringSystemDST.safety + dTD * ScoringSystemDST.defTD + rTD * ScoringSystemDST.retTD + ptsAll))
, 2) as Projection, 'DST', ".$weekNumVar." as 'Game Time'
FROM
( 
SELECT CASE
WHEN pts = 0
THEN ScoringSystemDST.pt0
WHEN pts < 7 and pts > 0
THEN ScoringSystemDST.pt16
WHEN pts < 14 and pts > 6
THEN ScoringSystemDST.pt713
WHEN pts < 21 and pts > 13
THEN ScoringSystemDST.pt1420
WHEN pts < 28 and pts > 20
THEN ScoringSystemDST.pt2127
WHEN pts < 35 and pts > 27
THEN ScoringSystemDST.pt2834
ELSE ScoringSystemDST.pt35
END AS ptsAll, sa, inter, fm, saf, dTD, rTD, pts, player, tm
FROM
(
SELECT (SUM(sacks * week) / SUM(week)) as sa, (SUM(interceptions * week) / SUM(week)) as inter, (SUM(fumRec * week) / SUM(week)) as fm, (SUM(safety * week) / SUM(week)) as saf,
(SUM(defTD * week) / SUM(week)) as dTD, (SUM(returnTD * week) / SUM(week)) as rTD, (SUM(ptsAllowed * week) / SUM(week)) as pts, player, tm
FROM
(
SELECT player, week, team as tm, opp, sacks, interceptions, fumRec, safety, defTD, returnTD, ptsAllowed
FROM DSTStats
) A
GROUP BY player
) B, ScoringSystemDST
WHERE ScoringSystemDST.name = 'Standard'
) Q,
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemDST, math, schedule, userTeams, gameTimes
WHERE ".$weekNumVar." = 11 and gameTimes.team = tm and userTeams.teamName = ? and ScoringSystemDST.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$sched." and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
)

UNION ALL

(
SELECT pl, tm as Team, def, ROUND(p, 2) as Projection, 'K', ".$weekNumVar." as 'Game Time'
FROM
(
SELECT (SUM(standPts * week) / SUM(week)) as p, pl, tm, oppon, def, t
FROM
(
SELECT KickingStats.player as pl, KickingStats.week, KickingStats.team as tm, KickingStats.opp as oppon, standPts, DSTStats.player as def, DSTStats.team as t
FROM KickingStats, DSTStats
) A
GROUP BY pl
) B, userTeams, schedule, gameTimes, DSTStats
WHERE ".$weekNumVar." = 11 and oppon = t and schedule.team = tm and gameTimes.team = tm and userTeams.teamName = ? and (pl = userTeams.p1 or pl = userTeams.p2 or pl = userTeams.p3 or pl = userTeams.p4 or pl = userTeams.p5 or pl = userTeams.p6 or pl = userTeams.p7 or pl = userTeams.p8 or pl = userTeams.p9 or pl = userTeams.p10 or pl = userTeams.p11 or pl = userTeams.p12 or pl = userTeams.p13 or pl = userTeams.p14 or pl = userTeams.p15)
GROUP BY pl
)
ORDER BY Projection DESC
;";

	if (!($stmt=$link->prepare($query4))) {
        echo "prepare failed: (" . mysqli_errno($link) .") " . mysqli_error($link);
}

if (!$stmt->bind_param("sss", $tName, $tName, $tName)) {
        echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
}
        $stmt->execute();
        $result=$stmt->get_result();
        echo $stmt->error;
if ($result->num_rows==0) {
                echo "<h4 align=center><b>\tNo players on your team play on Monday night during week ".$weekNum.".</b></h4><br><br>";
        }  
else {
        echo "<form action='' method='post'>";
        echo "<br><br>";
        echo "<table style='color:white;' class=\"table\">";
    echo "<th>Player</th>";
    echo "<th>Position</th>";
    echo "<th>Team</th>";
    echo "<th>Opponent</th>";
    echo "<th>Projected Score</th>";
    echo "<th>Add to Lineup</th>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>";
        echo $row["player"];
        echo "</td><td>";
        echo $row["Position"];
        echo "</td><td>";
        echo $row["Team"];
        echo "</td><td>";
        echo $row["opponent"];
        echo "</td><td>";
        echo $row["Projection"];
        echo "</td><td>";
//      echo "<form action='planWeekend.php' method='get'>";
        echo "<input type='checkbox' name='playerBox4[]' value='".$row["player"]."'><br>";
//      echo "</form>";
        echo "</td></tr>";
    }
    echo "</table>";
        echo "<input style='color:#006600;' type='submit' name='monSubmit' value='Add'/>";
        echo "</form>";
}
	if (isset($_POST['monSubmit'])) {
        if (!empty($_POST['playerBox4'])) {
                foreach ($_POST['playerBox4'] as $selected) {
                        $inserted=0;
$queries = array(
    1 => "select p1 from weekend where teamName=?",
2 => "select p2 from weekend where teamName=?",
3 => "select p3 from weekend where teamName=?",
4 => "select p4 from weekend where teamName=?",
5 => "select p5 from weekend where teamName=?",
6 => "select p6 from weekend where teamName=?",
7 => "select p7 from weekend where teamName=?",
8 => "select p8 from weekend where teamName=?",
9 => "select p9 from weekend where teamName=?",
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
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
    if ($isOccupied == $selected) {
        echo $selected . " is already in your lineup.<br>";
        $inserted=1;
    }
}

if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p1 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p1=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p2 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p2=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p3 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p3=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p4 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p4=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p5 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p5=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p6 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p6=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p7 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p7=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p8 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p8=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p9 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p9=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
                }
        }
        else {
                echo "You did not select a player to add.";
        }
        }

        }
        else {
                echo "<div align=center>Good luck man.</div><br>";
        }
//}
       // printLineup($tName);
}	

?>

<div align="center">
<form action="" method="get">
        <div class="container" align="center">
         <h3 style="display:inline-block;margin: 10px 10px 10px 10px;">NFL International Series</h3>
                 <!--<p>What do you want to do?</p>-->

         <div class="radio" style="display:inline-block;margin: 10px 10px 10px 10px;">
                 <label><input type="radio" name="international" value="0" id="rBars">Football? I thought you said f&#250tbol.</label>
        </div>

        <div class="radio" style="display:inline-block;margin: 10px 10px 10px 10px;">
                 <label><input type="radio" name="international" value="1" id="rFBall">Watch Football</label>
         </div>

        <input type="submit" name="internationalSubmit" value="Submit" class="btn btn-primary" style="background:#663300; border:#663300;display:inline-block;margin: 10px 10px 10px 10px;">
        </div>
        </form>
</div>
<?php

if(isset($_GET['internationalSubmit'])) {
        $val=$_GET['international'];
	//$weekNum=$_GET["week5"];
        $weekNumVar="gameTimes.wk".$weekNum;
	if ($val==1) {
		$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
                        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
	
		$query5="
(
SELECT player, tm as Team, def as opponent, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position, ".$weekNumVar." as 'Game Time'
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player, tm, pos
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos
FROM OffensiveStats
) A
GROUP BY player
) B, 
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemOffensive, math, userTeams, gameTimes, schedule
WHERE ".$weekNumVar." = 12 and gameTimes.team = tm and userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$sched." and schedule.team = tm and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
)

UNION ALL

(
SELECT player, tm as Team, def as opponent, ROUND(((sa * ScoringSystemDST.sack + inter * ScoringSystemDST.interceptions + fm * 
ScoringSystemDST.fumb + saf * ScoringSystemDST.safety + dTD * ScoringSystemDST.defTD + rTD * ScoringSystemDST.retTD + ptsAll))
, 2) as Projection, 'DST', ".$weekNumVar." as 'Game Time'
FROM
( 
SELECT CASE
WHEN pts = 0
THEN ScoringSystemDST.pt0
WHEN pts < 7 and pts > 0
THEN ScoringSystemDST.pt16
WHEN pts < 14 and pts > 6
THEN ScoringSystemDST.pt713
WHEN pts < 21 and pts > 13
THEN ScoringSystemDST.pt1420
WHEN pts < 28 and pts > 20
THEN ScoringSystemDST.pt2127
WHEN pts < 35 and pts > 27
THEN ScoringSystemDST.pt2834
ELSE ScoringSystemDST.pt35
END AS ptsAll, sa, inter, fm, saf, dTD, rTD, pts, player, tm
FROM
(
SELECT (SUM(sacks * week) / SUM(week)) as sa, (SUM(interceptions * week) / SUM(week)) as inter, (SUM(fumRec * week) / SUM(week)) as fm, (SUM(safety * week) / SUM(week)) as saf,
(SUM(defTD * week) / SUM(week)) as dTD, (SUM(returnTD * week) / SUM(week)) as rTD, (SUM(ptsAllowed * week) / SUM(week)) as pts, player, tm
FROM
(
SELECT player, week, team as tm, opp, sacks, interceptions, fumRec, safety, defTD, returnTD, ptsAllowed
FROM DSTStats
) A
GROUP BY player
) B, ScoringSystemDST
WHERE ScoringSystemDST.name = 'Standard'
) Q,
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemDST, math, schedule, userTeams, gameTimes
WHERE ".$weekNumVar." = 12 and gameTimes.team = tm and userTeams.teamName = ? and ScoringSystemDST.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$sched." and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
)

UNION ALL

(
SELECT pl, tm as Team, def, ROUND(p, 2) as Projection, 'K', ".$weekNumVar." as 'Game Time'
FROM
(
SELECT (SUM(standPts * week) / SUM(week)) as p, pl, tm, oppon, def, t
FROM
(
SELECT KickingStats.player as pl, KickingStats.week, KickingStats.team as tm, KickingStats.opp as oppon, standPts, DSTStats.player as def, DSTStats.team as t
FROM KickingStats, DSTStats
) A
GROUP BY pl
) B, userTeams, schedule, gameTimes, DSTStats
WHERE ".$weekNumVar." = 12 and oppon = t and schedule.team = tm and gameTimes.team = tm and userTeams.teamName = ? and (pl = userTeams.p1 or pl = userTeams.p2 or pl = userTeams.p3 or pl = userTeams.p4 or pl = userTeams.p5 or pl = userTeams.p6 or pl = userTeams.p7 or pl = userTeams.p8 or pl = userTeams.p9 or pl = userTeams.p10 or pl = userTeams.p11 or pl = userTeams.p12 or pl = userTeams.p13 or pl = userTeams.p14 or pl = userTeams.p15)
GROUP BY pl
)
ORDER BY Projection DESC
;";


	if (!($stmt=$link->prepare($query5))) {
        echo "prepare failed: (" . mysqli_errno($link) .") " . mysqli_error($link);
}

if (!$stmt->bind_param("sss", $tName, $tName, $tName)) {
        echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
}
        $stmt->execute();
        $result=$stmt->get_result();
        echo $stmt->error;
if ($result->num_rows==0) {
                echo "<h4 align=center><b>\tNo players on your team play internationally during week ".$weekNum.".</b></h4><br><br>";
        }  
else {
        echo "<form action='' method='post'>";
        echo "<br><br>";
        echo "<table style='color:white;' class=\"table\">";
    echo "<th>Player</th>";
    echo "<th>Position</th>";
    echo "<th>Team</th>";
    echo "<th>Opponent</th>";
    echo "<th>Projected Score</th>";
    echo "<th>Add to Lineup</th>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>";
        echo $row["player"];
        echo "</td><td>";
        echo $row["Position"];
        echo "</td><td>";
        echo $row["Team"];
        echo "</td><td>";
        echo $row["opponent"];
        echo "</td><td>";
        echo $row["Projection"];
        echo "</td><td>";
//      echo "<form action='planWeekend.php' method='get'>";
        echo "<input type='checkbox' name='playerBox5[]' value='".$row["player"]."'><br>";
//      echo "</form>";
        echo "</td></tr>";
    }
    echo "</table>";
        echo "<input style='color:#006600;' type='submit' name='internationalSubmit' value='Add'/>";
        echo "</form>";
}
	if (isset($_POST['internationalSubmit'])) {
        if (!empty($_POST['playerBox5'])) {
                foreach ($_POST['playerBox5'] as $selected) {
                        $inserted=0;
$queries = array(
    1 => "select p1 from weekend where teamName=?",
2 => "select p2 from weekend where teamName=?",
3 => "select p3 from weekend where teamName=?",
4 => "select p4 from weekend where teamName=?",
5 => "select p5 from weekend where teamName=?",
6 => "select p6 from weekend where teamName=?",
7 => "select p7 from weekend where teamName=?",
8 => "select p8 from weekend where teamName=?",
9 => "select p9 from weekend where teamName=?",
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
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
    if ($isOccupied == $selected) {
        echo $selected . " is already in your lineup.<br>";
        $inserted=1;
    }
}

if ($inserted==0) {
	$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p1 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p1=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p2 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p2=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p3 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p3=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p4 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p4=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p5 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p5=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p6 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p6=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p7 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p7=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p8 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p8=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
if ($inserted==0) {
        $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

        if (!($stmt=$link->prepare("select p9 from weekend where teamName=?"))) {
                echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $tName)) {
                echo "binding failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $result=$stmt->execute();
        echo $stmt->error;
        $stmt->bind_result($isOccupied);
        $stmt->fetch();
        if (!$isOccupied && $isOccupied != $selected) {
                $link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
                mysqli_select_db($link, 'viva') or die('Could not select database');
                if (!($stmt1=$link->prepare("update weekend set p9=? where teamName=?"))) {
                        echo "prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
                }
                if (!$stmt1->bind_param("ss", $selected, $tName)) {
                        echo "binding failed: (" . $stmt1->errno . ") " . $stmt1->error;
                }
                $result1=$stmt1->execute();
                echo $stmt1->error;
                $inserted=1;
        }
    if ($isOccupied == $selected) {
        echo $selected . " is already in the lineup.<br>";
    }
}
                }
        }
        else {
                echo "You did not select a player to add.";
        }
        }

        }
        else {
                echo "<div align=center>Adios amigo!</div><br>";
        }
//}
      //  printLineup($tName);
}	

?>

<?php
	printLineup($tName);	
?>

</body>
</html>
