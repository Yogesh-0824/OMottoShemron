<?php //session_start();
include("../connection.php");

$variable=$_POST['variableName'];

$result = mysql_query("SELECT * FROM inventory_table,products_table WHERE inventory_table.product_id = products_table.product_id ");

while($row = mysql_fetch_array($result))
{
	if($variable==$row[0])
	echo $row[19];
}

?>