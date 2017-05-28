<?php session_start();
include 'header.php';
//require_once('calendar/classes/tc_calendar.php');

?>
<script>
function validateForm() 
{
	 
    var customerName = document.forms["customerForm"]["customerName"].value;
    var customerFatherName = document.forms["customerForm"]["customerFatherName"].value;
    var customerPhoneNo = document.forms["customerForm"]["customerPhoneNo"].value;
    var customerAddress = document.forms["customerForm"]["customerAddress"].value;
   
     
    var message="Hello \n";
    if (customerName == null || customerName == "") 
    {
        message=message+"Enter A valid Customer Name \n ";
    }
    if (customerFatherName == null || customerFatherName == "") 
    {
        message=message+"Enter A valid Customer Father Name \n ";
    }
    if (customerPhoneNo == null || customerPhoneNo == "") 
    {
        message=message+"Enter A valid Customer Phone Number \n ";
    }
    
    if (customerAddress == null || customerAddress == "") 
    {
        message=message+"Enter A valid Customer Address \n ";
    }
    
    if (message !="Hello \n") 
    {
        alert(message);
        return false;
    }
    else 
    	return true;
}
</script>

<?php

if(isset($_SESSION['username']))
{

//-------------------------------------------------------------Eiting Section----------------------------------------------------------

if (isset($_POST['editing'])) 
	{	    $customerId=$_POST['customer_id_to_edit']; 
			$result=mysql_query("SELECT * FROM  customers_table WHERE customer_id=".$customerId."");
			$row=mysql_fetch_array($result);
			
			echo '
			<br/>
			<form action="'. $_SERVER['PHP_SELF'].'" name="customerForm" onsubmit="return validateForm()" method="post">
			<table id="addinsurencetable" width="50%" align="center">
				<tr>
					<td>
						Customer Name:
					</td>
					<td>
						<input type="text" name="customerName" size="30" maxlength="20" value="'.$row[1].'"/>
					</td>
				</tr>
				<tr>
					<td>
						Customer\'s Father Name:
					</td>
					<td>
						<input type="text" name="customerFatherName" size="30" maxlength="20"  value="'.$row[2].'"/>
					</td>
				</tr>
				<tr>
					<td>
						Customer\'s Phone Number:
					</td>
					<td>
						<input type="text" name="customerPhoneNo" size="15" maxlength="12"  value="'.$row[3].'"/>
					</td>
				</tr>
				<tr>
					<td>
						Customer\'s Address:
					</td>
					<td>
						<input type="text" name="customerAddress" size="30" maxlength="20"  value="'.$row[4].'"/>
					</td>
				</tr>
				<tr>
					<td> Stand Name : </td>
					<td>
					<select name = "stand_id">
						';
						
						$selected=' ';
						$result_customersTable = mysql_query("SELECT * FROM stands_table");
						while($row_customersTable = mysql_fetch_array($result_customersTable))
						{	
							if ($row[5]==$row_customersTable[0]) 
							{
								$selected='selected';
							}
							if ($row[5]!=$row_customersTable[0]) 
							{
								$selected=' ';
							}
							echo '<option '.$selected.'  value='.$row_customersTable[0].'>'.$row_customersTable[1].'</option>';
						  
						}
				
				echo '
					</select>
					</td>
				</tr>
				
					';
						
						echo '<input Type="hidden" name="customer_id_to_edit" value="'.$customerId.'"/>';   //send Id to next page
						
						echo '</select>
					
				<tr>
					<td></td>
					<td>
					<select name="cust_type">
						';if($row[6]==1)
						echo '<option selected value = 1  >Paper Owner</option> <option value = 0 >Real Owner</option>';
						else
						echo '<option selected value = 0 >Real Owner</option>  <option value = 1  >Paper Owner</option>';
					echo '
					</select>
					</td>
				</tr>				';
						
						?>
					
				</tr>
					<td></td>
					<td align="left">
						<input type="hidden" name="editCustomer"/>
						
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
			</form>
		<?php
	}	
if(isset($_POST['editCustomer']))
	{  
		$customerName=$_POST['customerName'];
		$customerFatherName=$_POST['customerFatherName'];
		$customerPhoneNo=$_POST['customerPhoneNo'];
		$customerAddress=$_POST['customerAddress'];
		$stand_id=$_POST['stand_id'];
		$cust_type=$_POST['cust_type'];
		$customerId=$_POST['customer_id_to_edit'];

		//echo '<script type="text/javascript">alert("  Query: UPDATE insurers_table  SET insurer_name="'.$insurerName.'" , active_flag='.$activeFlag.'  WHERE insurer_id='.$insurerId.'");</script>';
	
		mysql_query("UPDATE customers_table  SET customer_name='".$customerName."' , customer_type=".$cust_type." , customer_father_name='".$customerFatherName."' , customer_phone='".$customerPhoneNo."' , customer_address='".$customerAddress."'  , stand_id='".$stand_id."'   WHERE customer_id=".$customerId."" );
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Customer successfully edited.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}
//---------------------------------------------------------- End Editing ---------------------------------------------------------------	

	//---------------------------------------------------------Add new Insurer  -------------------------------------------------------
	echo '<div align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="addCustomer" value="addCustomer"/>
				<input type="submit" value="Add Customer"/>
			</form>
		</div>';

		if(isset($_POST['addCustomer']))
	{
		?>
		<br/>
		<form action="<?php $_SERVER['PHP_SELF']?>"  name="customerForm" onsubmit="return validateForm()" method="post">
			<table id="addoutlettable" width="50%" align="center">
				<tr>
					<td>
						Customer Name:
					</td>
					<td>
						<input type="text" name="customerName" size="30" maxlength="20"/>
					</td>
				</tr>
				<tr>
					<td>
						Customer's Father Name:
					</td>
					<td>
						<input type="text" name="customerFatherName" size="30" maxlength="20"/>
					</td>
				</tr>
				<tr>
					<td>
						Customer's Phone Number:
					</td>
					<td>
						<input type="text" name="customerPhoneNo" size="15" maxlength="12"/>
					</td>
				</tr>
				<tr>
					<td>
						Customer's Address:
					</td>
					<td>
						<input type="text" name="customerAddress" size="30" maxlength="20"/>
					</td>
				</tr>
				<tr>
					<td>
						Stand Name:
					</td>
					<td>
						<!--<input type="text" name="outlet_address" size="60" maxlength="50"/>-->
						<select name = "stand_id">
						<?php
						$result = mysql_query("SELECT * FROM stands_table");
						while($row = mysql_fetch_array($result))
						{
							echo '<option  value='.$row[0].'>'.$row[1].'</option>';
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
					Customer Type:
					</td>
					<td>
					<select name="cust_type">
						<option value="0">Real Type</option>
						<option value="1">Paper Owner</option>
					</select>

				<tr>
					<td>
					</td>
					<td>
						<input type="hidden" name="insertcustomer"/>
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
		</form>
		<?php
	}
	if(isset($_POST['insertcustomer']))
	{
		$customerName=$_POST['customerName'];
		$customerFatherName=$_POST['customerFatherName'];
		$customerPhoneNo=$_POST['customerPhoneNo'];
		$customerAddress=$_POST['customerAddress'];
		$stand_id=$_POST['stand_id'];
		$cust_type=$_POST['cust_type'];
		
		
		mysql_query("INSERT INTO customers_table (customer_name , customer_phone , customer_father_name , customer_address , stand_id ,  customer_type) VALUES ('".$customerName."', '".$customerPhoneNo."' , '".$customerFatherName."' , '".$customerAddress."'  ,  '".$stand_id."'  , '".$cust_type."')");
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Customer successfully added.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}

//-----------------------------------------------------------------add new customer -----xxxxxxxxxxxxxxxx-----------------------------------------

	$result = mysql_query("SELECT * FROM  customers_table");



	echo '<table align="center" width="90%">
		<tr>
		<th width="50px">S.No.</th>
		<th>Customer Id</th>
		<th>Customer Name</th>
		<th> Customer\'s Father\'s Name </th>
		<th>Customer\'s Phone Number </th>
		<th> Customer\'s Address</th>
		<th> Customer\'s Stand Name </th>
		<th>Customer Type</th>
		<th></th>
		</tr>';

$count = 0;
	while ($row = mysql_fetch_array($result))
	{
		$count++;
		$result_for_stand_name=mysql_query("SELECT * FROM stands_table");
	echo'
		<tr>
		<td> '.$count .'</td>
		<td> '.$row[0].'</td>
		<td> '.$row[1].'</td>
		<td> '.$row[2].'</td>
		<td> '.$row[3].'</td>
		<td> '.$row[4].'</td>';
		while ($row_for_stand_name = mysql_fetch_array($result_for_stand_name)) 

		{
			if ($row[5]==$row_for_stand_name[0]) 
			{
			echo	'<td>'.$row_for_stand_name[1].'</td>';

			}
		}
		
			if($row[6]== 1 )
			echo '
				<td align="center"> Paper Owner </td>';
		
			else
			{
				echo'
			<td align="center"> Real Owner</td>';
			}
			
			echo ' <td align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="editing" value="editing"/>
				<input Type="hidden" name="customer_id_to_edit" value="'.$row[0].'"/>
				<input type="submit" value="Edit"/>
			</form>
			</td>
	
		</tr>';
	}

	echo '</table>';
}
include 'footer.php';
?>