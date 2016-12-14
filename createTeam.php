<?php 
session_start(); 
?> 
<html>
<head>
        <title>Pick Your Team</title>
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


<body style="background-color:#00004d;">
        <div align="center">
        <div align="center">
                <h2><font color="white" face="Century Gothic"><p style="font-size: 75pt;"><b>Create Team.</p></h2>
        </div>

    <div align="center">
        <form id="teamCreate" class="form-horizontal" action="createTeam.php" method="get">
            <div class="form-group" id="qbdiv">
                <label class="control-label col-sm-3" for="qbtext">QB: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="qbtext" id="qbtext" maxlength="30">
                </div>
            </div>
            <div class="form-group" id="wr1div">
                <label class="control-label col-sm-3" for="wr1text">WR1: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="wr1text" id="wr1text" maxlength="30">
                </div>
            </div>
            <div class="form-group" id="wr2div">
                <label class="control-label col-sm-3" for="wr2text">WR2: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="wr2text" id="wr2text" maxlength="30">
                </div>
            </div>
            <div class="form-group" id="rb1div">
                <label class="control-label col-sm-3" for="rb1text">RB1: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="rb1text" id="rb1text" maxlength="30">
                </div>
            </div>
            <div class="form-group" id="rb2div">
                <label class="control-label col-sm-3" for="rb1text">RB2: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="rb2text" id="rb2text" maxlength="30">
                </div>
            </div>
            <div class="form-group" id="tediv">
                <label class="control-label col-sm-3" for="tetext">TE: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="tetext" id="tetext" maxlength="30">
                </div>
            </div>
            <div class="form-group" id="flexdiv">
                <label class="control-label col-sm-3" for="flextext">FLEX: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="flextext" id="flextext" maxlength="30">
                </div>
            </div>
            <div class="form-group" id="kdiv">
                <label class="control-label col-sm-3" for="ktext">K: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="ktext" id="ktext" maxlength="30">
                </div>
            </div>
            <div class="form-group" id="dstdiv">
                <label class="control-label col-sm-3" for="dsttext">DST: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="dsttext" id="dsttext" maxlength="30">
                </div>
            </div>
            <div class="form-group" id="bench1div">
                <label class="control-label col-sm-3" for="bench1text">BENCH1: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="bench1text" id="bench1text" maxlength="30">
                </div>
            </div>
            <div class="form-group" id="bench2div">
                <label class="control-label col-sm-3" for="bench2text">BENCH2: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="bench2text" id="bench2text" maxlength="30">
                </div>
            </div>
            <div class="form-group" id="bench3div">
                <label class="control-label col-sm-3" for="bench3text">BENCH3: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="bench3text" id="bench3text" maxlength="30">
                </div>
            </div>
            <div class="form-group" id="bench4div">
                <label class="control-label col-sm-3" for="bench4text">BENCH4: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="bench4text" id="bench4text" maxlength="30">
                </div>
            </div>
            <div class="form-group" id="bench5div">
                <label class="control-label col-sm-3" for="bench5text">BENCH5: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="bench5text" id="bench5text" maxlength="30">
                </div>
            </div>
            <div class="form-group" id="bench6div">
                <label class="control-label col-sm-3" for="bench6text">BENCH6: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="bench6text" id="bench6text" maxlength="30">
                </div>
            </div>
            <button name="createTeam" class="btn btn-primary">Submit</button>
        </form>
    </div>
<?php
if (isset($_SESSION['firstName'])) $fName=$_SESSION['firstName'];
else echo "<script>window.location.href='http://dsg1.crc.nd.edu/cse30246/viva/index.php';alert('Your session has expired. Please sign in again.')</script>";
if (isset($_SESSION['lastName'])) $lName=$_SESSION['lastName'];
else echo "<script>window.location.href='http://dsg1.crc.nd.edu/cse30246/viva/index.php';alert('Your session has expired. Please sign in again.')</script>";
if (isset($_SESSION['teamName'])) $tName=$_SESSION['teamName'];
else echo "<script>window.location.href='http://dsg1.crc.nd.edu/cse30246/viva/index.php';alert('Your session has expired. Please sign in again.')</script>";
if (isset($_GET['createTeam'])) {
    $valid=1;
    $qb=$_GET['qbtext'];
    /* str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($qb)))); */
    $wr1=$_GET['wr1text'];
    /* str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($wr1)))); */
    $wr2=$_GET['wr2text'];
    /* str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($wr2)))); */
    $rb1=$_GET['rb1text'];
    /* str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($rb1)))); */
    $rb2=$_GET['rb2text'];
    /* str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($rb2)))); */
    $te=$_GET['tetext'];
    /* str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($te)))); */
    $k=$_GET['ktext'];
    /* str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($k)))); */
    $flex=$_GET['flextext'];
    /* str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($flex)))); */
    $dst=$_GET['dsttext'];
    /* str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($dst)))); */
    $bench1=$_GET['bench1text'];
    /* str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($bench1)))); */
    $bench2=$_GET['bench2text'];
    /* str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($bench2)))); */
    $bench3=$_GET['bench3text'];
    /* str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($bench3)))); */
    $bench4=$_GET['bench4text'];
    /* str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($bench4)))); */
    $bench5=$_GET['bench5text'];
    /* str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($bench5)))); */
    $bench6=$_GET['bench6text'];
    /* str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($bench6)))); */
    // check to see if qb is valid
    if($valid) {
        $link=mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
            or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        $query="
            SELECT *
            FROM allPlayers
            WHERE position=\"QB\" and name=\"".$qb."\";"; 
        $result=mysqli_query($link, $query);
        $values=$result->fetch_assoc();
        if(mysqli_num_rows($result) == 0) { 
            $valid=0;
        }
    } else echo "QB choice is not valid<br>";

    if($valid) {
        $link=mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
            or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        $query="
            SELECT *
            FROM allPlayers
            WHERE position=\"WR\" and name=\"".$wr1."\";"; 
        $result=mysqli_query($link, $query);
        $values=$result->fetch_assoc();
        if(mysqli_num_rows($result) == 0) { 
            $valid=0;
        }
    } else echo "QB choice is not valid<br>";

    if($valid) {
        $link=mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
            or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        $query="
            SELECT *
            FROM allPlayers
            WHERE position=\"WR\" and name=\"".$wr2."\";"; 
        $result=mysqli_query($link, $query);
        $values=$result->fetch_assoc();
        if(mysqli_num_rows($result) == 0) { 
            $valid=0;
        }
    } else echo "WR1 choice is not valid<br>";

    if($valid) {
        $link=mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
            or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        $query="
            SELECT *
            FROM allPlayers
            WHERE position=\"RB\" and name=\"".$rb1."\";"; 
        $result=mysqli_query($link, $query);
        $values=$result->fetch_assoc();
        if(mysqli_num_rows($result) == 0) { 
            $valid=0;
        }
    } else echo "WR2 choice is not valid<br>";

    if($valid) {
        $link=mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
            or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        $query="
            SELECT *
            FROM allPlayers
            WHERE position=\"RB\" and name=\"".$rb2."\";"; 
        $result=mysqli_query($link, $query);
        $values=$result->fetch_assoc();
        if(mysqli_num_rows($result) == 0) { 
            $valid=0;
        }
    } else echo "RB1 choice is not valid<br>";

    if($valid) {
        $link=mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
            or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        $query="
            SELECT *
            FROM allPlayers
            WHERE position=\"TE\" and name=\"".$te."\";"; 
        $result=mysqli_query($link, $query);
        $values=$result->fetch_assoc();
        if(mysqli_num_rows($result) == 0) { 
            $valid=0;
        }
    } else echo "RB2 choice is not valid<br>";

    if($valid) {
        $link=mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
            or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        $query="
            SELECT *
            FROM allPlayers
            WHERE position=\"K\" and name=\"".$k."\";"; 
        $result=mysqli_query($link, $query);
        $values=$result->fetch_assoc();
        if(mysqli_num_rows($result) == 0) { 
            $valid=0;
        }
    } else echo "TE choice is not valid<br>";

    if($valid) {
        $link=mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
            or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        $query="
            SELECT *
            FROM allPlayers
            WHERE name=\"".$flex."\" and position IN (\"TE\",\"RB\",\"WR\");"; 
        $result=mysqli_query($link, $query);
        $values=$result->fetch_assoc();
        if(mysqli_num_rows($result) == 0) { 
            $valid=0;
        }
    } else echo "K choice is not valid<br>";

    if($valid) {
        $link=mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
            or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        $query="
            SELECT *
            FROM allPlayers
            WHERE position=\"DST\" and name=\"".$dst."\";"; 
        $result=mysqli_query($link, $query);
        $values=$result->fetch_assoc();
        if(mysqli_num_rows($result) == 0) { 
            $valid=0;
        }
    } else echo "FLEX choice is not valid<br>";

    if($valid) {
        $link=mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
            or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        $query="
            SELECT *
            FROM allPlayers
            WHERE name=\"".$bench1."\";"; 
        $result=mysqli_query($link, $query);
        $values=$result->fetch_assoc();
        if(mysqli_num_rows($result) == 0) { 
            $valid=0;
        }
    } else echo "DST choice is not valid<br>";

    if($valid) {
        $link=mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
            or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        $query="
            SELECT *
            FROM allPlayers
            WHERE name=\"".$bench2."\";"; 
        $result=mysqli_query($link, $query);
        $values=$result->fetch_assoc();
        if(mysqli_num_rows($result) == 0) { 
            $valid=0;
        }
    } else echo "bench1 choice is not valid<br>";

    if($valid) {
        $link=mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
            or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        $query="
            SELECT *
            FROM allPlayers
            WHERE name=\"".$bench3."\";"; 
        $result=mysqli_query($link, $query);
        $values=$result->fetch_assoc();
        if(mysqli_num_rows($result) == 0) { 
            $valid=0;
        }
    } else echo "bench2 choice is not valid<br>";

    if($valid) {
        $link=mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
            or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        $query="
            SELECT *
            FROM allPlayers
            WHERE name=\"".$bench4."\";"; 
        $result=mysqli_query($link, $query);
        $values=$result->fetch_assoc();
        if(mysqli_num_rows($result) == 0) { 
            $valid=0;
        }
    } else echo "bench3 choice is not valid<br>";

    if($valid) {
        $link=mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
            or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        $query="
            SELECT *
            FROM allPlayers
            WHERE name=\"".$bench5."\";"; 
        $result=mysqli_query($link, $query);
        $values=$result->fetch_assoc();
        if(mysqli_num_rows($result) == 0) { 
            $valid=0;
        }
    } else echo "bench4 choice is not valid<br>";

    if($valid) {
        $link=mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
            or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        $query="
            SELECT *
            FROM allPlayers
            WHERE name=\"".$bench6."\";"; 
        $result=mysqli_query($link, $query);
        $values=$result->fetch_assoc();
        if(mysqli_num_rows($result) == 0) { 
            $valid=0;
        }
    } else echo "bench5 choice is not valid<br>";

    // we have a valid team
    if($valid) {
        // insert into db and send to main.php
        $link=mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
            or die('Could not connect: ' . mysql_error());
        mysqli_select_db($link, 'viva') or die('Could not select database');
        $query="
            INSERT INTO userTeams
            VALUES ('".$tName."','".$fName."','".$lName."','".$qb."','".$wr1."','".$wr2."','".$rb1."','".$rb2."','".$te."','".$flex."','".$k."','".$dst."','".$bench1."','".$bench2."','".$bench3."','".$bench4."','".$bench5."','".$bench6."');";
        echo $query;
        $result=mysqli_query($link,$query);
        echo $result;
        if($result) {
            echo "team created successfully";
            echo "<script>document.location='http://dsg1.crc.nd.edu/cse30246/viva/main.php'</script>";
        } else {
            echo "something went wrong. Try again";
        }

    } else echo "bench6 choice is not valid<br>";

}
?>


</html>
