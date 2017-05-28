<?php session_start();
include 'header.php';
//require_once('calendar/classes/tc_calendar.php');
?>

<script>
function validateForm() 
{
	 
    var receptNo = document.forms["ledgerForm"]["receptNo"].value;
    var details = document.forms["ledgerForm"]["details"].value;
    var amount = document.forms["ledgerForm"]["amount"].value;
    var saleId = document.forms["ledgerForm"]["saleId"].value;
    var date = document.forms["ledgerForm"]["date"].value;
   
     
    var message="Hello \n";
    if (receptNo == null || receptNo == "") 
    {
        message=message+"Enter A valid Recept Number \n ";
    }
    if (details == null || details == "") 
    {
        message=message+"Enter A valid Details\n ";
    }
    if (amount == null || amount == "") 
    {
        message=message+"Enter A valid Amount \n ";
    }
    
    if (saleId == null || saleId == "") 
    {
        message=message+"Enter A valid Sale Details \n ";
    }
    if (date == null || date == "") 
    {
        message=message+"Enter A valid Date \n ";
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
	{	    $ledgerId=$_POST['ledger_id_to_edit']; 
			$result=mysql_query("SELECT * FROM  ledger_table WHERE ledger_id=".$ledgerId."");
			$row=mysql_fetch_array($result);
			
			echo '
			<br/>
			<form  id="editingLedger"   action="'. $_SERVER['PHP_SELF'].'" name="ledgerForm" onsubmit="return validateForm()" method="post">
			<table id="addinsurencetable" width="50%" align="center">
				<tr>
					<td></td>
					<td>
					<select name="enteryType">
						';if($row[6]==1)
						echo '<option selected value = 1  >Expense</option> <option value = 0 >Income</option>';
						else
						echo '<option selected value = 0 >Income</option>  <option value = 1  >Expense</option>';
					echo '
					</select>
					</td>
				</tr>	
				<tr>
					<td>
						Recept No:
					</td>
					<td>
						<input type="text" name="receptNo" size="30" maxlength="20" value="'. $row[1] .'"   >
					</td>
				</tr>
				<tr>
					<td>
						Details :
					</td>
					<td>
						<input type="text" name="details" size="40" maxlength="30" value="'. $row[2] .'"/>
					</td>
				</tr>
				<tr>
				<tr>
					<td>
						Amount :
					</td>
					<td>
						<input type="text" name="amount" size="30" maxlength="20" value="'. $row[3] .'" />
					</td>
				</tr>
				<tr>
					<td>
						Account:
					</td>';
?>
					<td>
						
						<select name = "account">
						<?php
						$result_for_acc_name = mysql_query("SELECT * FROM ledger_acc_table");
						while($row_for_acc_name = mysql_fetch_array($result_for_acc_name))
						{
							if ($row[7]==$row_for_acc_name[0]) 
							{
								$selected='selected';
							}
							if ($row[7]!=$row_for_acc_name[0]) 
							{
								$selected=' ';
							}
							echo '<option '.$selected.' value='.$row_for_acc_name[0].'>'.$row_for_acc_name[1].'</option>';
						}

						echo '
						</select>
						
					</td>
				</tr>

				<tr>
					<td>
						Sale Details:
					</td>
					<td>';
					
					$result_saleTable = mysql_query(" SELECT  st.sale_id , ct.customer_name , st.customer_id , ct.customer_father_name , sta.stand_name  FROM sales_table as st , customers_table as ct , stands_table as sta  where st.customer_id=ct.customer_id AND ct.stand_id=sta.stand_id; ");
						echo '
							<SELECT name="saleId">
								<option></option>
													';	
						while ($row_saleTable=mysql_fetch_array($result_saleTable)) 
						{
							if ($row[4]==$row_saleTable[0]) 
							{
								$selected='selected';
							}
							if ($row[4]!=$row_saleTable[0]) 
							{
								$selected=' ';
							}
							echo '<option '.$selected.' value="'.$row_saleTable[0].'">'.$row_saleTable[0].'/'.$row_saleTable[1].'/'.$row_saleTable[3].'/'.$row_saleTable[4].'</option>';
						}
					echo '</td>
				</tr>
				<tr>
					<td>
						Date (yyyy-mm-dd) :
					</td>
					<td>
						<input type="text" name="date" size="15" maxlength="10" value="'. $row[5] .'"/>
					</td>
				</tr>
				';
						
						echo '<input Type="hidden" name="ledger_id_to_edit" value="'.$ledgerId.'"/>						
						
					
							';
						
						?>
					
				</tr>
					<td></td>
					<td align="left">
						<input type="hidden" name="editLedger"/>
						
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
			</form>
	 
		<?php
	}	
if(isset($_POST['editLedger']))
	{  
		$receptNo=$_POST['receptNo'];
		$details=$_POST['details'];
		$amount=$_POST['amount'];
		$date=$_POST['date'];
		$enteryType=$_POST['enteryType'];
		$saleId=$_POST['saleId'];
		$ledgerId=$_POST['ledger_id_to_edit'];

		//echo '<script type="text/javascript">alert("  Query: UPDATE insurers_table  SET insurer_name="'.$insurerName.'" , active_flag='.$activeFlag.'  WHERE insurer_id='.$insurerId.'");</script>';
		mysql_query("UPDATE sales_table SET recept_no ='".$receptNo."' WHERE sale_id=".$saleId." ")	;	
	
		mysql_query("UPDATE ledger_table  SET recept_no='".$receptNo."' , details='".$details."' , entery_type=".$enteryType." , amt='".$amount."' , ledger_date ='".$date."' , sale_id=".$saleId."  WHERE  ledger_id=".$ledgerId."" );
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Ledger successfully edited.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}
//---------------------------------------------------------- End Editing ---------------------------------------------------------------	

	//---------------------------------------------------------Add new Ledger  -------------------------------------------------------
	echo '<div align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="addLedger" value="addLedger"/>
				<input type="submit" value="Add Ledger"/>
			</form>
		</div>';

		if(isset($_POST['addLedger']))
	{
		?>
		<br/>
		<form  action="<?php $_SERVER['PHP_SELF']?>"  name="ledgerForm" onsubmit="return validateForm()" method="post">
			<table id="addoutlettable" width="50%" align="center">
				<tr>
					<td></td>
					<td>
					<select name="enteryType">
						
						<option  value = 1  >Expense</option> <option value = 0 >Income</option>';
						
						 
					</select>
					</td>
				</tr>
				<tr>
					<td>
						Recept No:
					</td>
					<td>
						<input type="text" name="receptNo" size="30" maxlength="20"/>
					</td>
				</tr>
				<tr>
					<td>
						Details :
					</td>
					<td>
						<input type="text" name="details" size="40" maxlength="30"/>
					</td>
				</tr>
				<tr>
					<td>
						Amount :
					</td>
					<td>
						<input type="text" name="amount" size="20" maxlength="10"/>
					</td>
				</tr>
				<tr>
					<td>
						Account:
					</td>
					<td>
						 
						<select name = "account">
						<?php 
						$result = mysql_query("SELECT * FROM ledger_acc_table");
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
						Sale Details:
					</td>
					<td>
					<?php
					$result_saleTable = mysql_query(" SELECT  st.sale_id , ct.customer_name , st.customer_id , ct.customer_father_name , sta.stand_name  FROM sales_table as st , customers_table as ct , stands_table as sta  where st.customer_id=ct.customer_id AND ct.stand_id=sta.stand_id ");
						echo '
							<SELECT name="saleId">
								<option></option>
													';	
						while ($row_saleTable=mysql_fetch_array($result_saleTable)) 
						{
							echo '<option value="'.$row_saleTable[0].'">'.$row_saleTable[0].'/'.$row_saleTable[1].'/'.$row_saleTable[3].'/'.$row_saleTable[4].'</option>';
						}
					?></td>
				</tr>

				<!-- ++++++++++++++++++++++++++++++++++ Sale ID +++++++++++++++++++++++++++++++++++++++++++++++ -->

				<tr>
					<td>
						<td id="saleDetails"></td>
					</td>
				</tr>
				<tr>
					<td>
						Date (yyyy-mm-dd) :
					</td>
					<td>
						<input type="text" name="date" size="15" maxlength="10"/>
					</td>
				</tr>
				
				<tr>
					<td>
					</td>
					<td>
						<input type="hidden" name="insertledger"/>
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
		</form>
		<?php
	}
	if(isset($_POST['insertledger']))
	{
		$receptNo=$_POST['receptNo'];
		$details=$_POST['details'];
		$amount=$_POST['amount'];
		$account=$_POST['account'];
		$date=$_POST['date'];
		$enteryType=$_POST['enteryType'];
		$saleId=$_POST['saleId'];
		 
		mysql_query("UPDATE sales_table SET recept_no ='".$receptNo."' WHERE sale_id=".$saleId."");
		
		mysql_query("INSERT INTO ledger_table (	recept_no , details , amt , ledger_date , entery_type , ledger_acc_no , sale_id) VALUES (".$receptNo.", '".$details."' , ".$amount." , '".$date."' , ".$enteryType."  , ".$account." , ".$saleId.")");
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Ledger successfully added.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}

	//-----------------------------------------------------------------add new ledger -----xxxxxxxxxxxxxxxx-------------------------

	$result = mysql_query("SELECT * FROM  ledger_table");



	echo '<table align="center" width="90%">
		<tr>
		<th width="50px">S.No.</th>
		<th>Ledger Id</th>
		<th>Recept No</th>
		<th>Details </th>
		<th>Amount</th>
		<th>Sale Details</th>
		<th>Date</th>
		<th>Account</th>
		<th>Entery Type</th>
		<th></th>
		</tr>';

$count = 0;
	while ($row = mysql_fetch_array($result))
	{	
		$result_for_acc_name = mysql_query("SELECT * FROM  ledger_acc_table");
		$count++;
	echo'
		<tr>
		<td> '.$count.' </td>
		<td> '.$row[0].'</td>
		<td> '.$row[1].'</td>
		<td> '.$row[2].'</td>
		<td> '.$row[3].'</td>';
		  
		 echo ' <td> ';
					
					$result_saleTable = mysql_query(" SELECT  st.sale_id , ct.customer_name , st.customer_id , ct.customer_father_name , sta.stand_name  FROM sales_table as st , customers_table as ct , stands_table as sta  where st.customer_id=ct.customer_id AND ct.stand_id=sta.stand_id ");
					while ($row_saleTable=mysql_fetch_array($result_saleTable)) 
						{
							if($row[4]==$row_saleTable[0])
							echo ''.$row_saleTable[0].'/'.$row_saleTable[1].'/'.$row_saleTable[3].'/'.$row_saleTable[4].'';
						}
			echo '</td> 
		
		<td> '.$row[5].'</td>';
		while ($row_for_acc_name = mysql_fetch_array($result_for_acc_name)) 

		{
			if ($row[7]==$row_for_acc_name[0]) 
			{
			echo	'<td>'.$row_for_acc_name[1].'</td>';

			}
		}
		

		echo'		
		';if($row[6]==1)
						echo '<td align="center"> Expense </td>';
						else
						echo '<td align="center"> Income </td>';
					echo '
					
		</td>
			
			 <td align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="editing" value="editing"/>
				<input Type="hidden" name="ledger_id_to_edit" value="'.$row[0].'"/>
				<input type="submit" value="Edit"/>
			</form>
			</td>
	
		</tr>';
	}

	echo '</table>';
}
include 'footer.php';
?>