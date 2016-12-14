<html>
<head>
	<title>Fantasize</title>

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
<h1 id="title">Fantasize</h1>
<h3> Quarterbacks with more than 3 TDs: </h3>
<?php
if (isset($_GET['submitQbData'])) {
// connecting, selecting database
$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
	or die('Could not connect: ' . mysql_error());
//echo 'Contacted successfully';
mysqli_select_db($link, 'viva') or die('Could not select database');

// performing sql query
$query = 'select player, passTd from OffensiveStats where passTD > 3 group by player';
$result = mysqli_query($link, $query) or die('Query failed: ' . mysql_error());

// printing results in HTML
echo "<table>\n";
while ($tuple = mysqli_fetch_array($result, MYSQL_ASSOC)) {
	echo "\t<tr>\n";
	foreach ($tuple as $col_value) { 
		echo "\t\t<td>$col_value</td>\n";
	}
	echo "\t</tr>\n";
}
echo "</table>\n";

// free resultset
mysqli_free_result($result);

// Closing Connection
mysqli_close($link);
}
?>
<form action="index.php" method="get">
<input type="submit" name="submitQbData" value="QB Data">
</form>
<h3> Scoring System: </h3>
<p>Add New: </p>
<form action="index.php" method="get">
<table>
<tr><td class="addLabel"></td><td class="addTextBox"><label>Name: </label><input type="textbook" name="name"></td></tr>
<tr><td class="addLabel"></td><td class="addTextBox"><label><label>Sacks: </label><input type="textbook" name="sack"></td></tr>
<tr><td class="addLabel"></td><td class="addTextBox"><label>Interceptions: </label><input type="textbook" name="interceptions"></td></tr>
<tr><td class="addLabel"></td><td class="addTextBox"><label>Fumbles: </label><input type="textbook" name="fumb"></td></tr>
<tr><td class="addLabel"></td><td class="addTextBox"><label>Safeties: </label><input type="textbook" name="safety"></td></tr>
<tr><td class="addLabel"></td><td class="addTextBox"><label>Defensive TDs: </label><input type="textbook" name="defTD"></td></tr>
<tr><td class="addLabel"></td><td class="addTextBox"><label>retTD: </label><input type="textbook" name="retTD"></td></tr>
<tr><td class="addLabel"></td><td class="addTextBox"><label>pt0: </label><input type="textbook" name="pt0"></td></tr>
<tr><td class="addLabel"></td><td class="addTextBox"><label>pt16: </label><input type="textbook" name="pt16"></td></tr>
<tr><td class="addLabel"></td><td class="addTextBox"><label>pt713: </label><input type="textbook" name="pt713"></td></tr>
<tr><td class="addLabel"></td><td class="addTextBox"><label>pt1420: </label><input type="textbook" name="pt1420"></td></tr>
<tr><td class="addLabel"></td><td class="addTextBox"><label>pt2127: </label><input type="textbook" name="pt2127"></td></tr>
<tr><td class="addLabel"></td><td class="addTextBox"><label>pt2834: </label><input type="textbook" name="pt2834"></td></tr>
<tr><td class="addlabel"></td><td class="addtextbox"><label>pt35: </label><input type="textbook" name="pt35"></td></tr>
</table>
<input style="text-align:right" type="submit" name="submitAdd" value="Add">
</form>

<?php
if (isset($_GET['submitAdd'])) {
// connecting, selecting database
$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

if (!($stmt=$link->prepare("insert into ScoringSystemDST values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
	echo "prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
$sack=(int)$_GET["sack"];
$interceptions=(int)$_GET["interceptions"];
$fumb=(int)$_GET["fumb"];
$safety=(int)$_GET["safety"];
$defTD=(int)$_GET["defTD"];
$retTD=(int)$_GET["retTD"];
$pt0=(int)$_GET["pt0"];
$pt16=(int)$_GET["pt16"];
$pt713=(int)$_GET["pt713"];
$pt1420=(int)$_GET["pt1420"];
$pt2127=(int)$_GET["pt2127"];
$pt2834=(int)$_GET["pt2834"];
$pt35=(int)$_GET["pt35"];

if (!$stmt->bind_param("siiiiiiiiiiiii", $_GET["name"], $sack, $interceptions, $fumb, $safety, $defTD, $retTD, $pt0, $pt16, $pt713, $pt1420, $pt2127, $pt2834, $pt35)) {
	echo "binding failed: (" . $stmt->errno . ")" . $stmt->error;	
}

$stmt->execute();

mysqli_close($link);
}
?>

<h3>Update: </h3>
<form action="index.php" method="get">
Name to update: <input type="textbox" name="nameToUpdate"><br>
Category to update:<br> 
<input type="radio" name="categoryToUpdate" value="sack" checked>sack<br>
<input type="radio" name="categoryToUpdate" value="interceptions">interceptions<br>
<input type="radio" name="categoryToUpdate" value="fumbles">fumbles<br>
<input type="radio" name="categoryToUpdate" value="safeties">safeties<br>
New value for category: <input name="valueToUpdate">
<input type="submit" name="submitUpdate" value="Update">
</form>
<!--
<div class="btn-group">
	<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Category to Update:
	<span class="selection">N/A </span><span class="caret"></span></button>
	<ul class=dropdown-menu role="menu">
		<li><a href="javascript:;">sack </a></li>
		<li><a href="javascript:;">interceptions </a></li>
		<li><a href="javascript:;">fumbles </a></li>
		<li><a href="javascript:;">safeties </a></li>
		<li><a href="javascript:;">defensive TDs </a></li>
		<li><a href="javascript:;">retTDs </a></li>
	</ul>
</div>
-->

<?php

if (isset($_GET['submitUpdate'])) {
// connecting, selecting database
$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
        or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');

$name=$_GET["nameToUpdate"];
$cat=$_GET["categoryToUpdate"];
$value=(int)$_GET["valueToUpdate"];

if ($cat=="sack") {
	if (!($stmt1=$link->prepare("update ScoringSystemDST set sack=? where name=?"))) {
		echo "prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
}
else if ($cat=="interceptions") {
        if (!($stmt1=$link->prepare("update ScoringSystemDST set interceptions=? where name=?"))) {
                echo "prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
}
else if ($cat=="fumb") {
        if (!($stmt1=$link->prepare("update ScoringSystemDST set fumb=? where name=?"))) {
                echo "prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
}
else if ($cat=="safety") {
        if (!($stmt1=$link->prepare("update ScoringSystemDST set safety=? where name=?"))) {
                echo "prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
}
else if ($cat=="defTD") {
        if (!($stmt1=$link->prepare("update ScoringSystemDST set defTD=? where name=?"))) {
                echo "prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
}
else if ($cat=="retTD") {
        if (!($stmt1=$link->prepare("update ScoringSystemDST set retTD=? where name=?"))) {
                echo "prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
}
else if ($cat=="pt0") {
        if (!($stmt1=$link->prepare("update ScoringSystemDST set pt0=? where name=?"))) {
                echo "prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
}
else if ($cat=="pt16") {
        if (!($stmt1=$link->prepare("update ScoringSystemDST set pt16=? where name=?"))) {
                echo "prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
}
else if ($cat=="pt713") {
        if (!($stmt1=$link->prepare("update ScoringSystemDST set pt713=? where name=?"))) {
                echo "prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
}
else if ($cat=="pt1420") {
        if (!($stmt1=$link->prepare("update ScoringSystemDST set pt1420=? where name=?"))) {
                echo "prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
}
else if ($cat=="pt2127") {
        if (!($stmt1=$link->prepare("update ScoringSystemDST set pt2127=? where name=?"))) {
                echo "prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
}
else if ($cat=="pt2834") {
        if (!($stmt1=$link->prepare("update ScoringSystemDST set pt2834=? where name=?"))) {
                echo "prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
}
else if ($cat=="pt35") {
        if (!($stmt1=$link->prepare("update ScoringSystemDST set pt35=? where name=?"))) {
                echo "prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
}

if (!$stmt1->bind_param("is", $value, $name)) {
	echo "binding failed: (" . $stmt1->errno . ")" . $stmt1->error;
}

if (!$stmt1->execute()) {
	echo "execute failed: (" . $stmt1->errno . ") " . $stmt1->error;
}

mysqli_close($link);
}

?>

<h3>Delete: </h3>
<form action="index.php" method="get">
Name to Delete: <input type="textbook" name="nameToDelete">
<input type="submit" name="submitDelete" value="Delete">
</form>

<?php
if (isset($_GET['submitDelete'])) {
// connecting, selecting database
$link = mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
       or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');
if (!($stmt2=$link->prepare("delete from ScoringSystemDST where name=?"))) {
	echo "prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
$name=$_GET["nameToDelete"];
if (!$stmt2->bind_param("s", $name)) {
	echo "binding failed: (" . $stmt2->errno . ")" . $stmt2->error;
}

$stmt2->execute();

mysqli_close($link);
}
?>
</body>
</html>
