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
	<title>Optimal Lineup</title>
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
	<li class="active"><a href="http://dsg1.crc.nd.edu/cse30246/viva/lineup.php">Lineup<span class="sr-only">(current)</span></a></li>
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
        <li><a href="http://dsg1.crc.nd.edu/cse30246/viva/index.php" class="signout">Sign Out</a></li>
    </ul>
    </div>
   </div>
</nav>

	<div align="center">
        <div align="center">
                <h2><font color="#800080" face="Century Gothic"><p style="font-size: 92pt;"><b>Optimal.</p></font size></h2>
        </div>

        <p>Enter the current week and your team name and we will find the best lineup for you!</p>
		<form action="lineup.php" method="get">
			<input type="textbook" placeholder="Week Number" name="weekNum">
			<input type="textbook" placeholder="Team Name" name="teamName" maxlength="30">
			<input type="submit" name="lineup" value="GO" class="btn btn-success">
		</form>
<?php
	if(isset($_GET['lineup'])){
		if(($_GET['weekNum']<1 or $_GET['weekNum']>17) and !$_GET['teamName']){
			echo "Please enter a week number between 1 and 17.";
			//header('Location: lineup.php');
		}
		else{
		// connect and select database
		$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
		or die('Could not connect: ' . mysql_error());

		mysqli_select_db($link, 'viva') or die('Could not select database');
		$week="schedule.".$_GET["weekNum"];
		/* echo "before prepare\n"; */
        /* echo $_GET["teamName"] . "\n"; */
        /* echo $_GET["weekNum"] . "\n"; */
	
		// create a prepared statement
        $query = "
(SELECT player, Team, opponent, ranking, Projection, Position, @cur := @cur + 1 as finalRating
FROM
(
SELECT player, tm as Team, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position
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
) D, ScoringSystemOffensive, math, schedule, userTeams
WHERE userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$week." and pos = 'QB' and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
) L, (SELECT @cur := 0) w
LIMIT 1
) UNION ALL
(
SELECT player, Team, opponent, ranking, Projection, Position, @cur2 := @cur2 + 1 as finalRating
FROM
(
SELECT player, tm as Team, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position
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
) D, ScoringSystemOffensive, math, schedule, userTeams
WHERE userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$week." and pos = 'WR' and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15) and schedule.team = tm
GROUP BY player
ORDER BY Projection DESC
) L, (SELECT @cur2 := 0) w
LIMIT 2
) UNION ALL
(
SELECT player, Team, opponent, ranking, Projection, Position, @cur3 := @cur3 + 1 as finalRating
FROM
(
SELECT player, tm as Team, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position
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
) D, ScoringSystemOffensive, math, schedule, userTeams
WHERE userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$week."  and pos = 'RB' and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15) and schedule.team = tm
GROUP BY player
ORDER BY Projection DESC
) L, (SELECT @cur3 := 0) w
LIMIT 2
) UNION ALL 
(
SELECT player, Team, opponent, ranking, Projection, Position, @cur4 := @cur4 + 1 as finalRating
FROM
(
SELECT player, tm as Team, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position
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
) D, ScoringSystemOffensive, math, schedule, userTeams
WHERE userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$week."  and pos = 'TE' and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
) L, (SELECT @cur4 := 0) w
LIMIT 1
) UNION ALL

(

SELECT ZZ.player, ZZ.Team, ZZ.opponent, ZZ.ranking, ZZ.Projection, ZZ.Position, ZZ.finalRating
FROM 

(

(	
SELECT player, Team, opponent, ranking, Projection, Position, finalRating
FROM
(
SELECT player, Team, opponent, ranking, Projection, Position, @cur6 := @cur6 + 1 as finalRating
FROM
(
SELECT player, tm as Team, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position
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
) D, ScoringSystemOffensive, math, schedule, userTeams
WHERE userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$week."  and (pos = 'TE') and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
) L, (SELECT @cur6 := 0) w
) Z
WHERE finalRating = 2
) UNION ALL
(
SELECT player, Team, opponent, ranking, Projection, Position, finalRating
FROM
(
SELECT player, Team, opponent, ranking, Projection, Position, @cur7 := @cur7 + 1 as finalRating
FROM
(
SELECT player, tm as Team, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position
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
) D, ScoringSystemOffensive, math, schedule, userTeams
WHERE userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$week."  and (pos = 'WR') and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
) L, (SELECT @cur7 := 0) w
) a
WHERE finalRating = 3
) UNION ALL 
(
SELECT player, Team, opponent, ranking, Projection, Position, finalRating
FROM
(
SELECT player, Team, opponent, ranking, Projection, Position, @cur8 := @cur8 + 1 as finalRating
FROM
(
SELECT player, tm as Team, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position
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
) D, ScoringSystemOffensive, math, schedule, userTeams
WHERE userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$week."  and (pos = 'RB') and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
) L, (SELECT @cur8 := 0) w
) i
WHERE finalRating  = 3
)
ORDER BY Projection DESC
) ZZ LIMIT 1
)
UNION ALL
(
SELECT player, tm as Team, '--', '--', ROUND(p, 2) as Projection, 'K', '--'
FROM
(
SELECT (SUM(standPts * week) / SUM(week)) as p, player, tm
FROM
(
SELECT player, week, team as tm, opp, standPts
FROM KickingStats
) A
GROUP BY player
) B, schedule, userTeams
WHERE userTeams.teamName = ? and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
LIMIT 1
)
UNION ALL
(
SELECT player, tm as Team, def as opponent, ranking, ROUND(((sa * ScoringSystemDST.sack + inter * ScoringSystemDST.interceptions + fm * 
ScoringSystemDST.fumb + saf * ScoringSystemDST.safety + dTD * ScoringSystemDST.defTD + rTD * ScoringSystemDST.retTD + ptsAll
))
, 2) as Projection, 'DST', '--'
FROM
( 
SELECT CASE
WHEN pts = 0
THEN ScoringSystemDST.pt0
WHEN pts > 0 and pts < 7
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
) D, ScoringSystemDST, math, schedule, userTeams
WHERE userTeams.teamName = ? and ScoringSystemDST.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ".$week." and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
LIMIT 1
)
;";

if(!($stmt=$link->prepare($query))){
		echo "prepare failed: (" . mysqli_errno($link) . ") " . mysqli_error($link);
} else {
    

	// bind parameters for markers
	$stmt->bind_param("sssssssss",$_GET["teamName"],$_GET["teamName"],$_GET["teamName"],$_GET["teamName"],$_GET["teamName"],$_GET["teamName"],$_GET["teamName"],$_GET["teamName"],$_GET["teamName"]);

	// execute query
	$stmt->execute();
    /* $stmt->store_result(); */
    /* $stmt->free_result(); */
    $result=$stmt->get_result();
    /* while($row = $result->fetch_array(MYSQLI_NUM)) { */
    /*     foreach($row as $r) { */
    /*         print "$r "; */
    /*     } */
    /*     print "\n"; */
    /* } */

	// bind results variable
	/* $stmt->bind_result($player, $team, $opp, $ranking, $proj, $pos, $finalRanking); */

	if (!($stmt->fetch())) echo "<h4><b>".$_GET["teamName"]." not found</b></h4>";
	else {
	$tot = 0;
	// fetch value
    echo "<table class=\"table\">";
    echo "<th>Position</th>";
    echo "<th>Player</th>";
    echo "<th>Team</th>";
    echo "<th>Projected Score</th>";
    echo "<th>Opponent</th>";
    echo "<th>Defensive Quality</th>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>";
        echo $row["Position"];
        echo "</td><td>";
        echo $row["player"];
        echo "</td><td>";
        echo $row["Team"];
        echo "</td><td>";
        echo $row["Projection"];
        echo "</td><td>";
        $tot += $row["Projection"];
        echo $row["opponent"];
        echo "</td><td>";
        echo $row["ranking"];
        echo "</td></tr>";
    }
    echo "</table>";
    //echo "Projection: ".$tot;
    echo "<div style ='font:18px/18px Arial,tahoma,sans-serif;color:#008000'>Total Projected Score: </div>";
    echo "<div style ='font:48px/48px Arial,tahoma,sans-serif;color:#008000'>".$tot."</div>";
	}
	// close statement
	$stmt->close();
}

	// close connection
	mysqli_close($link);		
}
}
?>
</body>

</html
