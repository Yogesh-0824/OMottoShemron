<?php session_start();
include 'header.php';
//require_once('calendar/classes/tc_calendar.php');
?>

<script>
function validateForm() 
{
	 
    var accountName= document.forms["ledgerAccForm"]["accountName"].value;

     
     
    var message="Hello \n";
    if (accountName == null || accountName == "") 
    {
        message=message+"Enter A valid Account Name \n ";
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
	{	    $ledgerID=$_POST['ledger_acc_id_to_edit']; 
			$result=mysql_query("SELECT * FROM  ledger_acc_table WHERE ledger_acc_no=".$ledgerID."");
			$row=mysql_fetch_array($result);
			
			echo '
			<br/>
			<form action="'. $_SERVER['PHP_SELF'].'" name="ledgerAccForm" onsubmit="return validateForm()" method="post">
			<table id="addinsurencetable" width="50%" align="center">
				<tr>
					<td>
						Account Name:
					</td>
					<td>
						<input type="text" name="accountName" size="30" maxlength="20" value="'. $row[1] .'" />
					</td>
				</tr>
				
					';
						
						echo '<input Type="hidden" name="ledger_acc_id_to_edit" value="'.$ledgerID.'"/>';   //send Id to next page
						
						echo '</select>
					
				<tr>
					<td></td>
					<td>
					<select name="activeFlag">
						';if($row[2]==1)
						echo '<option selected value = 1  >Active</option> <option value = 0 >Inactive</option>';
						else
						echo '<option selected value = 0 >Inactive</option>  <option value = 1  >Active</option>';
					echo '
					</select>
					</td>
				</tr>				';
						
						?>
					
				</tr>
					<td></td>
					<td align="left">
						<input type="hidden" name="editLedgerAccount"/>
						
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
			</form>
		<?php
	}	
if(isset($_POST['editLedgerAccount']))
	{  
		$accountName=$_POST['accountName'];
		$activeFlag=$_POST['activeFlag'];
		$ledgerID=$_POST['ledger_acc_id_to_edit'];

	//	echo '<script type="text/javascript">alert("  Query: UPDATE insurers_table  SET insurer_name="'.$insurerName.'" , active_flag='.$activeFlag.'  WHERE insurer_id='.$insurerId.'");</script>';
	
		mysql_query("UPDATE ledger_acc_table  SET acc_name='".$accountName."' , active_flag=".$activeFlag."  WHERE ledger_acc_no=".$ledgerID."" );
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Insurer successfully edited.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}
//---------------------------------------------------------- End Editing ---------------------------------------------------------------	

	//---------------------------------------------------------Add new ledger account  -------------------------------------------------------
	echo '<div align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="addLedgerAccount" value="addLedgerAccount"/>
				<input type="submit" value="Add Ledger Account"/>
			</form>
		</div>';

		if(isset($_POST['addLedgerAccount']))
	{
		?>
		<br/>
		<form  action="<?php $_SERVER['PHP_SELF']?>"  name="ledgerAccForm" onsubmit="return validateForm()" method="post">
			<table id="addoutlettable" width="50%" align="center" >
				<tr>
					<td>
						Account Name:
					</td>
					<td>
						<input type="text" name="accountName" size="30" maxlength="20"/>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="hidden" name="insertaccount"/>
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
		</form>
		<?php
	}
	if(isset($_POST['insertaccount']))
	{
		$accountName=$_POST['accountName'];
		
		
		mysql_query("INSERT INTO ledger_acc_table (acc_name , active_flag) VALUES ('$accountName',1)");
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Ledger Account successfully added.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}

	//-----------------------------------------------------------------add new ledger account -----xxxxxxxxxxxxxxxx-------------------------

	$result = mysql_query("SELECT * FROM  ledger_acc_table");



	echo '<table align="center" width="90%">
		<tr>
		<th width="50px">S.No.</th>
		<th>Ledger Account No</th>
		<th>Accountou Name</th>
		<th>Status</th>
		<th></th>
		</tr>';

$count = 0;
	while ($row = mysql_fetch_array($result))
	{
		$count++;
	echo'
		<tr>
		<td>'.$count.'</td>
		<td> '.$row[0].'</td>
		<td> '.$row[1].'</td>
		';
			if($row[2]==1)
			echo '
				<td align="center"> Active </td>';
		
			else
			{
				echo'
			<td align="center"> Inactive</td>';
			}
			
			echo ' <td align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="editing" value="editing"/>
				<input Type="hidden" name="ledger_acc_id_to_edit" value="'.$row[0].'"/>
				<input type="submit" value="Edit"/>
			</form>
			</td>
	
		</tr>';
	}

	echo '</table>';
}
include 'footer.php';
?>