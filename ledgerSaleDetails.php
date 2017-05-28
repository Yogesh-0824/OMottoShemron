<?php //session_start();
include("../connection.php");

$account=$_POST['variableName'];
if ($account==2) 
{ 
	$result_saleTable = mysql_query("  SELECT ct.customer_name , st.customer_id FROM sales_table as st , customers_table as ct where st.customer_id=ct.customer_id");
	echo '
	<SELECT name="saleId">
	<option></option>
	';	
	while ($row_saleTable=mysql_fetch_array($result_saleTable)) 
	{
		echo '<option value="'.$row_saleTable[1].'">'.$row_saleTable[0].'</option>';
	}
}

 
}

?>