<?php

$position=$_GET["pos"];
$name=$_GET["name"];
if( $position == "RB1" || $position == "RB2" ) {
    $position = "RB";
}
if( $position == "WR1" || $position == "WR2" ) {
    $position = "WR";
}
$query="
    SELECT *
    FROM allPlayers
    WHERE position =\"".$position."\" and name=\"".$name."\";"; 
if( $position == "FLEX" ) {
    $position = "(\"TE\", \"RB\", \"WR\")";
    $query="
        SELECT *
        FROM allPlayers
        WHERE position IN ".$position." and name=\"".$name."\";"; 
}
if( fnmatch("BENCH*",$position )) {
    // just search playerlist for a matching name
    $query="
        SELECT *
        FROM allPlayers
        WHERE name=\"".$name."\";"; 
}
/* echo "<script>alert(".$query.");</script>"; */
$link=mysqli_connect('localhost', 'nsarkey', 'Yosemite123@', 'viva')
    or die('Could not connect: ' . mysql_error());
mysqli_select_db($link, 'viva') or die('Could not select database');
$result=mysqli_query($link, $query);
$values=$result->fetch_assoc();
if(mysqli_num_rows($result) == 0) { 
    echo 0;
} else {
    echo 1;
}

?>
