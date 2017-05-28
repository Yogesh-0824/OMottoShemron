<?php session_start();
include 'header.php';
//require_once('calendar/classes/tc_calendar.php');
?>
<script>
function validateForm() 
{
	 
    var outletName = document.forms["outletForm"]["outletName"].value;
    var outletLocation = document.forms["outletForm"]["outletLocation"].value;
 
     
    var message="Hello \n";
    if (outletName == null || outletName == "") 
    {
        message=message+"Enter A valid Outlet Name \n ";
    }
    if (outletLocation == null || outletLocation == "" || outletLocation==" ") 
    {
        message=message+"Enter A valid Outlet Location \n ";
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
	{	    $outletId=$_POST['outlet_id_to_edit']; 
			$result=mysql_query("SELECT * FROM  outlets_table WHERE outlet_id=".$outletId."");
			$row=mysql_fetch_array($result);
			
			echo '
			<br/>
			<form  action="'. $_SERVER['PHP_SELF'].'"  name="outletForm" onsubmit="return validateForm()" method="post" >
			<table id="addoutlettable" width="50%" align="center">
				<tr>
					<td>
						Outlet Name:
					</td>
					<td>
						<input type="text" name="outletName" size="30" maxlength="20" value="'. $row[1] .'" />
					</td>
				</tr>
				<tr>
					<td>
						Outlet Location:
						<td>
						<input type="text" name="outletLocation" size="60" maxlength="50" value="'. $row[2] .'" />
						</td>	';
						
						echo '<input Type="hidden" name="outlet_id_to_edit" value="'.$outletId.'"/>';
						
						echo '</select>
					</td>
				<tr>
					<td></td>
					<td>
					<select name="activeFlag">
						';if($row[3]==1)
						echo '<option selected value = 1  >Active</option> <option value = 0 >Inactive</option>';
						else
						echo '<option selected value = 0 >Inactive</option>  <option value = 1  >Active</option>';
					echo '
					</select>
					</td>
				</tr>';
				$result_usersTable=mysql_query("SELECT * FROM users_table");
				$checked=' ';
				
				 echo '

				<tr>
				<td></td>
				<td>
					<table>
						<tr>';
						while($row_usersTable=mysql_fetch_array($result_usersTable))
							{if($row_usersTable[4]==1)						//checking flag Acitve/Inactive
								{
							echo '
							<td> ';
							if($outletId==$row_usersTable[5])
							 $checked="checked";
							if($outletId!=$row_usersTable[5])
							 $checked=" ";
							echo'
								<input  type="checkbox" '.$checked.' name="userOutletAppointment[]" value="'.$row_usersTable[0].'">'.$row_usersTable[1].'<br>
							</td>';
							}
								}
						echo '
						</tr>
					</table>
				</td>				';
						
						?>
					
				</tr>
					<td></td>
					<td align="left">
						<input type="hidden" name="editoutlet"/>
						
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
			</form>
		<?php
	}	
if(isset($_POST['editoutlet']))
	{  
		$outletName=$_POST['outletName'];
		$outletLocation=$_POST['outletLocation'];
		$outletId=$_POST['outlet_id_to_edit'];
		$activeFlag=$_POST['activeFlag'];
		$userOutletAppointment=$_POST['userOutletAppointment'];
		 
	//	echo '<script type="text/javascript">alert(" '.$standId.' Query: UPDATE stands_table  SET stand_name='.$standName.' , outlet_id='.$outletId.'  WHERE stand_id = '.$standId.'");</script>';
		$i=0;
		while ($userOutletAppointment[$i])
		 {
		 	if($activeFlag==1)
		mysql_query("UPDATE users_table SET outlet_id = ".$outletId." WHERE user_id= ".$userOutletAppointment[$i]."");
		$i++;
		if (mysql_errno()!=0) {
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
			break;
		}
		 }
		
		mysql_query("UPDATE outlets_table  SET outlet_name='".$outletName."' , outlet_location='".$outletLocation."' , active_flag=".$activeFlag."  WHERE outlet_id=".$outletId."" );
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Outlet successfully edited.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}
//---------------------------------------------------------- End Editing ---------------------------------------------------------------	

	//add new outlet  ------------------------------
	echo '<div align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="addoutlet" value="addoutlet"/>
				<input type="submit" value="Add Outlet"/>
			</form>
		</div>';

		if(isset($_POST['addoutlet']))
	{
		?>
		<br/>
		<form action="<?php $_SERVER['PHP_SELF']?>" name="outletForm" onsubmit="return validateForm()" method="post">
			<table id="addoutlettable" width="50%" align="center">
				<tr>
					<td>
						Outlet Name:
					</td>
					<td>
						<input type="text" name="outletName" size="30" maxlength="20"/>
					</td>
				</tr>
				<tr>
					<td>
						Outlet Location:
					</td>
					<td>
						<input type="text" name="outletLocation" size="60" maxlength="50"/>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="hidden" name="insertoutlet"/>
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
		</form>
		<?php
	}
	if(isset($_POST['insertoutlet']))
	{
		$outlet_name=$_POST['outletName'];
		$outlet_address=$_POST['outletLocation'];
		
		mysql_query("INSERT INTO outlets_table VALUES (NULL,'$outlet_name','$outlet_address',1)");
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Outlet successfully added.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}

	//add new outlet -----xxxxxxxxxxxxxxxx-------

	$result = mysql_query("SELECT * FROM  outlets_table");



	echo '<table align="center" width="90%">
		<tr>
		<th width="50px">S.No.</th>
		<th>Outlet Id</th>
		<th>Outlet Name</th>
		<th>Outlet Location</th>
		<th>Status</th>
		<th>Users</th>
		<th></th>
		</tr>';

$count = 0;
$type=1;
$typeName[1]='Admin';
$typeName[2]='Manager';
$typeName[3]='Sales Head';
$typeName[4]='Team Leader';
$typeName[5]='Sales Person';
$typeName[6]='Tele-Caller';

	while ($row = mysql_fetch_array($result))
	{
		$count++;
	echo'
		<tr>
		<td>'.$count.'</td>
		<td> '.$row[0].'</td>
		<td> '.$row[1].'</td>
		<td> '.$row[2].'</td>
		';
			if($row[3]==1)
			echo '
				<td align="center"> Active </td>';
		
			else
			{
				echo'
			<td align="center"> Inactive</td>';
			}
			echo ' <td> <table>';     //Displaying Users On that outlet
				$result_usersTable=mysql_query("SELECT * FROM users_table");
				while($row_usersTable=mysql_fetch_array($result_usersTable))
					{if($row_usersTable[4]==1)											//checking flag Acitve/Inactive
						if($row_usersTable[5] == $row[0])
							{
				  				$type=$row_usersTable[3];
								echo'
									 <tr>
						  			 <td width="50%">'.$row_usersTable[1].'</td>
					
								 	 <td align=center width="50%">'.$typeName[$type].'</td>
									 </tr>
					  				 
								 ';
							}

					}	
			echo ' </table></td>
		<td align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="editing" value="editing"/>
				<input Type="hidden" name="outlet_id_to_edit" value="'.$row[0].'"/>
				<input type="submit" value="Edit"/>
			</form>
			</td>
	
		</tr>';
	}

	echo '</table>';
}
include 'footer.php';
?>