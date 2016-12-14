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
	<li><a href="http://dsg1.crc.nd.edu/cse30246/viva/index.php" class="signout">Sign Out</a></li>
    </ul>
    </div>
   </div>
</nav>

        <div align="center">
                <h2><font color="green" face="Century Gothic"><p style="font-size: 92pt;"><b>Success.</p></font size></h2>
        </div>
	<div align="center">
 	<font face="Century Gothic" color="green"> Below you can find all different data regarding the performance of our algorithm. For each week, it shows (in order) how much we were off
on average for the top 150 offensive players that week as an absolute value, the same but done overall, and the standard error of the measurements. I understand that these numbers likely
do not mean much, but they are about to. Our algorithm only takes into account data from the current season, so we consider the first two weeks to be time for getting enough data to make
a reasonable prediction. After that, here are a few places we have shown to be better than for score predicting:<br></br>ESPN (1.3 +/- 0.25)<br></br>FFToday (1.06 +/- 0.26)<br></br>Multiple CBS Sports Columnists (1.74 +/- 0.25) (1.08 +/- 0.24)<br></br>
You can see the bottom of the page for our current accuracy rating.<br></br><br></br>
        </font>



<?php
	if(1){
		// connect and select database
		$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
		or die('Could not connect: ' . mysql_error());

		mysqli_select_db($link, 'viva') or die('Could not select database');

		// insert query
		$query="(SELECT '1' as 'Week', AVG(ABS(error)), AVG(error), ROUND((stddev(error)/sqrt(count(pl))),6) as 'Standard Error', count(pl)
FROM
(
SELECT pl, tm, position, Projection, tru, (Projection - tru) as error
FROM
(
SELECT pl, tm, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier)), 2) as Projection, position, OffensiveStats.standardPts as tru, oppo
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player as pl, tm, pos as position, oppo
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos, opp as oppo
FROM OffensiveStats
WHERE standardPts > 0 and week < 1
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
GROUP BY def
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, 
(
SELECT opp as vs
FROM OffensiveStats
WHERE week = 1
) E, ScoringSystemOffensive, math, schedule, OffensiveStats
WHERE OffensiveStats.player = pl and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and oppo = defense and vs = schedule.1 and math.one = 1 and schedule.team = tm
) ZZ
WHERE tru > 0
LIMIT 150
) QW
) UNION ALL 
(SELECT '2' as 'Week', AVG(ABS(error)), AVG(error), ROUND((stddev(error)/sqrt(count(pl))),6) as 'Standard Error', count(pl)
FROM
(
SELECT pl, tm, position, Projection, tru, (Projection - tru) as error
FROM
(
SELECT pl, tm, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier)), 2) as Projection, position, OffensiveStats.standardPts as tru, oppo
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player as pl, tm, pos as position, oppo
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos, opp as oppo
FROM OffensiveStats
WHERE standardPts > 0 and week < 2
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
GROUP BY def
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, 
(
SELECT opp as vs
FROM OffensiveStats
WHERE week = 2
) E, ScoringSystemOffensive, math, schedule, OffensiveStats
WHERE OffensiveStats.player = pl and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and oppo = defense and vs = schedule.2 and math.one = 1 and schedule.team = tm
) ZZ
WHERE tru > 0
LIMIT 150
) QW
) UNION ALL
(SELECT '3' as 'Week', AVG(ABS(error)), AVG(error), ROUND((stddev(error)/sqrt(count(pl))),6) as 'Standard Error', count(pl)
FROM
(
SELECT pl, tm, position, Projection, tru, (Projection - tru) as error
FROM
(
SELECT pl, tm, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier)), 2) as Projection, position, OffensiveStats.standardPts as tru, oppo
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player as pl, tm, pos as position, oppo
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos, opp as oppo
FROM OffensiveStats
WHERE standardPts > 0 and week < 3
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
GROUP BY def
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, 
(
SELECT opp as vs
FROM OffensiveStats
WHERE week = 3
) E, ScoringSystemOffensive, math, schedule, OffensiveStats
WHERE OffensiveStats.player = pl and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and oppo = defense and vs = schedule.3 and math.one = 1 and schedule.team = tm
) ZZ
WHERE tru > 0
LIMIT 150
) QW
) UNION ALL (
SELECT '4' as 'Week', AVG(ABS(error)), AVG(error), ROUND((stddev(error)/sqrt(count(pl))),6) as 'Standard Error', count(pl)
FROM
(
SELECT pl, tm, position, Projection, tru, (Projection - tru) as error
FROM
(
SELECT pl, tm, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier)), 2) as Projection, position, OffensiveStats.standardPts as tru, oppo
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player as pl, tm, pos as position, oppo
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos, opp as oppo
FROM OffensiveStats
WHERE standardPts > 0 and week < 4
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
GROUP BY def
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, 
(
SELECT opp as vs
FROM OffensiveStats
WHERE week = 4
) E, ScoringSystemOffensive, math, schedule, OffensiveStats
WHERE OffensiveStats.player = pl and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and oppo = defense and vs = schedule.4 and math.one = 1 and schedule.team = tm
) ZZ
WHERE tru > 0
LIMIT 150
) QW
) UNION ALL (
SELECT '5' as 'Week', AVG(ABS(error)), AVG(error), ROUND((stddev(error)/sqrt(count(pl))),6) as 'Standard Error', count(pl)
FROM
(
SELECT pl, tm, position, Projection, tru, (Projection - tru) as error
FROM
(
SELECT pl, tm, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier)), 2) as Projection, position, OffensiveStats.standardPts as tru, oppo
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player as pl, tm, pos as position, oppo
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos, opp as oppo
FROM OffensiveStats
WHERE standardPts > 0 and week < 5
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
GROUP BY def
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, 
(
SELECT opp as vs
FROM OffensiveStats
WHERE week = 5
) E, ScoringSystemOffensive, math, schedule, OffensiveStats
WHERE OffensiveStats.player = pl and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and oppo = defense and vs = schedule.5 and math.one = 1 and schedule.team = tm
) ZZ
WHERE tru > 0
LIMIT 150
) QW
) UNION ALL (
SELECT '6' as 'Week', AVG(ABS(error)), AVG(error), ROUND((stddev(error)/sqrt(count(pl))),6) as 'Standard Error', count(pl)
FROM
(
SELECT pl, tm, position, Projection, tru, (Projection - tru) as error
FROM
(
SELECT pl, tm, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier)), 2) as Projection, position, OffensiveStats.standardPts as tru, oppo
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player as pl, tm, pos as position, oppo
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos, opp as oppo
FROM OffensiveStats
WHERE standardPts > 0 and week < 6
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
GROUP BY def
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, 
(
SELECT opp as vs
FROM OffensiveStats
WHERE week = 6
) E, ScoringSystemOffensive, math, schedule, OffensiveStats
WHERE OffensiveStats.player = pl and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and oppo = defense and vs = schedule.6 and math.one = 1 and schedule.team = tm
) ZZ
WHERE tru > 0
LIMIT 150
) QW
) UNION ALL (
SELECT '7' as 'Week', AVG(ABS(error)), AVG(error), ROUND((stddev(error)/sqrt(count(pl))),7) as 'Standard Error', count(pl)
FROM
(
SELECT pl, tm, position, Projection, tru, (Projection - tru) as error
FROM
(
SELECT pl, tm, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier)), 2) as Projection, position, OffensiveStats.standardPts as tru, oppo
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player as pl, tm, pos as position, oppo
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos, opp as oppo
FROM OffensiveStats
WHERE standardPts > 0 and week < 7
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
GROUP BY def
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, 
(
SELECT opp as vs
FROM OffensiveStats
WHERE week = 7
) E, ScoringSystemOffensive, math, schedule, OffensiveStats
WHERE OffensiveStats.player = pl and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and oppo = defense and vs = schedule.7 and math.one = 1 and schedule.team = tm
) ZZ
WHERE tru > 0
LIMIT 150
) QW
) UNION ALL (
SELECT '8' as 'Week', AVG(ABS(error)), AVG(error), ROUND((stddev(error)/sqrt(count(pl))),8) as 'Standard Error', count(pl)
FROM
(
SELECT pl, tm, position, Projection, tru, (Projection - tru) as error
FROM
(
SELECT pl, tm, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier)), 2) as Projection, position, OffensiveStats.standardPts as tru, oppo
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player as pl, tm, pos as position, oppo
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos, opp as oppo
FROM OffensiveStats
WHERE standardPts > 0 and week < 8
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
GROUP BY def
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, 
(
SELECT opp as vs
FROM OffensiveStats
WHERE week = 8
) E, ScoringSystemOffensive, math, schedule, OffensiveStats
WHERE OffensiveStats.player = pl and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and oppo = defense and vs = schedule.8 and math.one = 1 and schedule.team = tm
) ZZ
WHERE tru > 0
LIMIT 150
) QW
) UNION ALL (
SELECT '9' as 'Week', AVG(ABS(error)), AVG(error), ROUND((stddev(error)/sqrt(count(pl))),9) as 'Standard Error', count(pl)
FROM
(
SELECT pl, tm, position, Projection, tru, (Projection - tru) as error
FROM
(
SELECT pl, tm, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier)), 2) as Projection, position, OffensiveStats.standardPts as tru, oppo
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player as pl, tm, pos as position, oppo
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos, opp as oppo
FROM OffensiveStats
WHERE standardPts > 0 and week < 9
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
GROUP BY def
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, 
(
SELECT opp as vs
FROM OffensiveStats
WHERE week = 9
) E, ScoringSystemOffensive, math, schedule, OffensiveStats
WHERE OffensiveStats.player = pl and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and oppo = defense and vs = schedule.9 and math.one = 1 and schedule.team = tm
) ZZ
WHERE tru > 0
LIMIT 150
) QW
) UNION ALL (
SELECT '10' as 'Week', AVG(ABS(error)), AVG(error), ROUND((stddev(error)/sqrt(count(pl))),10) as 'Standard Error', count(pl)
FROM
(
SELECT pl, tm, position, Projection, tru, (Projection - tru) as error
FROM
(
SELECT pl, tm, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier)), 2) as Projection, position, OffensiveStats.standardPts as tru, oppo
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player as pl, tm, pos as position, oppo
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos, opp as oppo
FROM OffensiveStats
WHERE standardPts > 0 and week < 10
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
GROUP BY def
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, 
(
SELECT opp as vs
FROM OffensiveStats
WHERE week = 10
) E, ScoringSystemOffensive, math, schedule, OffensiveStats
WHERE OffensiveStats.player = pl and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and oppo = defense and vs = schedule.10 and math.one = 1 and schedule.team = tm
) ZZ
WHERE tru > 0
LIMIT 150
) QW
) UNION ALL (
SELECT '11' as 'Week', AVG(ABS(error)), AVG(error), ROUND((stddev(error)/sqrt(count(pl))),10) as 'Standard Error', count(pl)
FROM
(
SELECT pl, tm, position, Projection, tru, (Projection - tru) as error
FROM
(
SELECT pl, tm, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier)), 2) as Projection, position, OffensiveStats.standardPts as tru, oppo
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player as pl, tm, pos as position, oppo
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos, opp as oppo
FROM OffensiveStats
WHERE standardPts > 0 and week < 11
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
GROUP BY def
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, 
(
SELECT opp as vs
FROM OffensiveStats
WHERE week = 11
) E, ScoringSystemOffensive, math, schedule, OffensiveStats
WHERE OffensiveStats.player = pl and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and oppo = defense and vs = schedule.11 and math.one = 1 and schedule.team = tm
) ZZ
WHERE tru > 0
LIMIT 150
) QW
) UNION ALL (
SELECT '12' as 'Week', AVG(ABS(error)), AVG(error), ROUND((stddev(error)/sqrt(count(pl))),10) as 'Standard Error', count(pl)
FROM
(
SELECT pl, tm, position, Projection, tru, (Projection - tru) as error
FROM
(
SELECT pl, tm, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier)), 2) as Projection, position, OffensiveStats.standardPts as tru, oppo
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player as pl, tm, pos as position, oppo
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos, opp as oppo
FROM OffensiveStats
WHERE standardPts > 0 and week < 12
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
GROUP BY def
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, 
(
SELECT opp as vs
FROM OffensiveStats
WHERE week = 12
) E, ScoringSystemOffensive, math, schedule, OffensiveStats
WHERE OffensiveStats.player = pl and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and oppo = defense and vs = schedule.12 and math.one = 1 and schedule.team = tm
) ZZ
WHERE tru > 0
LIMIT 150
) QW
) UNION ALL (
SELECT '13' as 'Week', AVG(ABS(error)), AVG(error), ROUND((stddev(error)/sqrt(count(pl))),10) as 'Standard Error', count(pl)
FROM
(
SELECT pl, tm, position, Projection, tru, (Projection - tru) as error
FROM
(
SELECT pl, tm, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier)), 2) as Projection, position, OffensiveStats.standardPts as tru, oppo
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player as pl, tm, pos as position, oppo
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos, opp as oppo
FROM OffensiveStats
WHERE standardPts > 0 and week < 13
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
GROUP BY def
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, 
(
SELECT opp as vs
FROM OffensiveStats
WHERE week = 13
) E, ScoringSystemOffensive, math, schedule, OffensiveStats
WHERE OffensiveStats.player = pl and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and oppo = defense and vs = schedule.13 and math.one = 1 and schedule.team = tm
) ZZ
WHERE tru > 0
LIMIT 150
) QW
) UNION ALL (
SELECT '14' as 'Week', AVG(ABS(error)), AVG(error), ROUND((stddev(error)/sqrt(count(pl))),10) as 'Standard Error', count(pl)
FROM
(
SELECT pl, tm, position, Projection, tru, (Projection - tru) as error
FROM
(
SELECT pl, tm, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier)), 2) as Projection, position, OffensiveStats.standardPts as tru, oppo
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player as pl, tm, pos as position, oppo
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos, opp as oppo
FROM OffensiveStats
WHERE standardPts > 0 and week < 14
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
GROUP BY def
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, 
(
SELECT opp as vs
FROM OffensiveStats
WHERE week = 14
) E, ScoringSystemOffensive, math, schedule, OffensiveStats
WHERE OffensiveStats.player = pl and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and oppo = defense and vs = schedule.14 and math.one = 1 and schedule.team = tm
) ZZ
WHERE tru > 0
LIMIT 150
) QW
) UNION ALL (
SELECT '15' as 'Week', AVG(ABS(error)), AVG(error), ROUND((stddev(error)/sqrt(count(pl))),10) as 'Standard Error', count(pl)
FROM
(
SELECT pl, tm, position, Projection, tru, (Projection - tru) as error
FROM
(
SELECT pl, tm, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier)), 2) as Projection, position, OffensiveStats.standardPts as tru, oppo
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player as pl, tm, pos as position, oppo
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos, opp as oppo
FROM OffensiveStats
WHERE standardPts > 0 and week < 15
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
GROUP BY def
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, 
(
SELECT opp as vs
FROM OffensiveStats
WHERE week = 15
) E, ScoringSystemOffensive, math, schedule, OffensiveStats
WHERE OffensiveStats.player = pl and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and oppo = defense and vs = schedule.15 and math.one = 1 and schedule.team = tm
) ZZ
WHERE tru > 0
LIMIT 150
) QW
) UNION ALL (
SELECT '16' as 'Week', AVG(ABS(error)), AVG(error), ROUND((stddev(error)/sqrt(count(pl))),10) as 'Standard Error', count(pl)
FROM
(
SELECT pl, tm, position, Projection, tru, (Projection - tru) as error
FROM
(
SELECT pl, tm, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier)), 2) as Projection, position, OffensiveStats.standardPts as tru, oppo
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player as pl, tm, pos as position, oppo
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos, opp as oppo
FROM OffensiveStats
WHERE standardPts > 0 and week < 16
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
GROUP BY def
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, 
(
SELECT opp as vs
FROM OffensiveStats
WHERE week = 16
) E, ScoringSystemOffensive, math, schedule, OffensiveStats
WHERE OffensiveStats.player = pl and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and oppo = defense and vs = schedule.16 and math.one = 1 and schedule.team = tm
) ZZ
WHERE tru > 0
LIMIT 150
) QW
) UNION ALL (
SELECT '17' as 'Week', AVG(ABS(error)), AVG(error), ROUND((stddev(error)/sqrt(count(pl))),10) as 'Standard Error', count(pl)
FROM
(
SELECT pl, tm, position, Projection, tru, (Projection - tru) as error
FROM
(
SELECT pl, tm, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier)), 2) as Projection, position, OffensiveStats.standardPts as tru, oppo
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player as pl, tm, pos as position, oppo
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos, opp as oppo
FROM OffensiveStats
WHERE standardPts > 0 and week < 17
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
GROUP BY def
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, 
(
SELECT opp as vs
FROM OffensiveStats
WHERE week = 17
) E, ScoringSystemOffensive, math, schedule, OffensiveStats
WHERE OffensiveStats.player = pl and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and oppo = defense and vs = schedule.17 and math.one = 1 and schedule.team = tm
) ZZ
WHERE tru > 0
LIMIT 150
) QW
)
;";

if(!($stmt=$link->prepare($query))){
		echo "prepare failed: (" . mysqli_errno($link) . ") " . mysqli_error($link);
} else {
    

	// bind parameters for markers

	// execute query
	$stmt->execute();
    $result=$stmt->get_result();

	// fetch value
    echo "<table class=\"table\">";
    echo "<th class=text-center>Week</th>";
    echo "<th class=text-center>Absolute Error</th>";
    echo "<th class=text-center>Average Error</th>";
    echo "<th class=text-center>Standard Error</th>";
    while($row = $result->fetch_assoc()) {
    	echo "<tr><td class=text-center>";
        echo $row["Week"];
        echo "</td><td class=text-center>";
        echo $row["AVG(ABS(error))"];
        echo "</td><td class=text-center>";
        echo $row["AVG(error)"];
        echo "</td><td class=text-center>";
        echo $row["Standard Error"];
        echo "</td><td class=text-center>";
    }

echo "</table>";
 
	// close statement
	$stmt->close();
}

	// close connection
	mysqli_close($link);		
}

		    
?>
</body>
</html>
