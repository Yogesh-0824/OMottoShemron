<?php //session_start();
include("../connection.php");

$variable=$_POST['variableName'];

$result = mysql_query("SELECT * FROM schemes_table WHERE scheme_id=".$variable."");

while($row = mysql_fetch_array($result))
{
	
	echo $row[2];
}

?>