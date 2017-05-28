<?php session_start();
include 'header.php';
//require_once('calendar/classes/tc_calendar.php');

?>

<script>
function validateForm() 
{
	 
    var referencerName= document.forms["userForm"]["userName"].value;
    var referencerPhNo= document.forms["userForm"]["userPassword"].value;
     
     
    var message="Hello \n";
    if (referencerName == null || referencerName == "") 
    {
        message=message+"Enter A valid User Name \n ";
    }
    if (referencerPhNo == null || referencerPhNo == "") 
    {
        message=message+"Enter A valid User Password\n ";
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

//-------------------------------------------------------------Eiting Section----------------------------------------------------------
if(isset($_SESSION['username']))
{
if (isset($_POST['editing'])) 
	{	    $userId=$_POST['user_id_to_edit']; 
			$result=mysql_query("SELECT * FROM  users_table WHERE user_id=".$userId."");
			$row=mysql_fetch_array($result);
			
			echo '
			<br/>
			<form action="'. $_SERVER['PHP_SELF'].'"  name="userForm" onsubmit="return validateForm()" method="post">
			<table id="addoutlettable" width="50%" align="center">
				<tr>
					<td>
						User Name:
					</td>
					<td>
						<input type="text" name="userName" size="30" maxlength="20" value="'. $row[1] .'" />
					</td>
				</tr>
				<tr>
					<td>
						User Password:
					</td>
					<td>
						<input type="password" name="userPassword" size="15" maxlength="10" value="'. $row[2] .'"/>
					</td>
				</tr>
				<tr>
					<td>
						User Type:
					</td>';
?>
					<td>
						
						<select name = "user_type">
						<?php
						$type=1;
						$type_name[1]='Admin';
						$type_name[2]='Manager';
						$type_name[3]='Sales Head';
						$type_name[4]='Team Leader';
						$type_name[5]='Sales Person';
						$type_name[6]='Tele-Caller';
					
						
						while($type<=6)
						{
							if($type==$row[3])
								echo '<option selected value='.$type.'>'.$type_name[$type].'</option>';
							else
								echo '<option  value='.$type.'>'.$type_name[$type].'</option>';
							$type++;
						}

						echo '<input Type="hidden" name="user_id_to_edit" value="'.$userId.'"/>';
						echo '
						</select>
						
					</td>
				</tr>
				<tr>
					<td> Outlet At Which Appointed : </td>
					<td>
					<select name = "outlet_id">
						';
						
							echo "hello";
						$selected=' ';
						$result_outletTable = mysql_query("SELECT * FROM outlets_table");
						while($row_outletTable = mysql_fetch_array($result_outletTable))
						{if($row_outletTable[3]==1)
						  {	
							if ($row[5]==$row_outletTable[0]) 
							{
								$selected='selected';
							}
							if ($row[5]!=$row_outletTable[0]) 
							{
								$selected=' ';
							}
							echo '<option '.$selected.'  value='.$row_outletTable[0].'>'.$row_outletTable[1].'</option>';
						  }
						}
				
				echo '
					</select>
					</td>
				</tr>
				<tr>
					<td>Status :</td>
					<td>
					<select name="activeFlag">
						';if($row[4]==1)
						echo '<option selected value = 1  >Active</option> <option value = 0 >Inactive</option>';
						else
						echo '<option selected value = 0 >Inactive</option>  <option value = 1  >Active</option>';
					echo '
					</select>
					</td>
				</tr>';
				?>
				<tr>
					<td></td>
					<td align="left">
						<input type="hidden" name="edituser"/>
						
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
			</form>
		<?php
	}	
if(isset($_POST['edituser']))
	{
		$user_name=$_POST['userName'];
		$user_password=$_POST['userPassword'];
		$user_type=$_POST['user_type'];
		$userId=$_POST['user_id_to_edit'];
		$activeFlag=$_POST['activeFlag'];
		$OutletId=$_POST['outlet_id'];
//echo '<script type="text/javascript">alert(" '.$userId.' Query: UPDATE users_table  SET username='.$user_name.' , password='.$user_password.' , user_type='.$user_type.' WHERE user_id = '.$userId.'");</script>';
		
		mysql_query("UPDATE users_table  SET username='".$user_name."' , password='".$user_password."' , user_type=".$user_type." , active_flag=".$activeFlag." , outlet_id=".$OutletId." WHERE user_id=".$userId."" );
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("User successfully edited.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}
//---------------------------------------------------------- End Editing ---------------------------------------------------------------	

//---------------------------------------------------------- Add New User------------------------------------------------------------------

	
		echo '<div align = "center">
				<form action="'.$_SERVER['PHP_SELF'].'" method="post">
					<input type="hidden" name="adduser" value="adduser"/>
					<input type="submit" value="Add User"/>
				</form>
			  </div>';

		if(isset($_POST['adduser']))
			{
		?>
				<br/>
				<form action="<?php $_SERVER['PHP_SELF']?>"  name="userForm" onsubmit="return validateForm()" method="post">
				<table id="addoutlettable" width="50%" align="center">
					<tr>
						<td>
							User Name:
						</td>
						<td>
							<input type="text" name="userName" size="30" maxlength="20"/>
						</td>
					</tr>
					<tr>
						<td>
							User Password:
						</td>
						<td>
							<input type="password" name="userPassword" size="15" maxlength="10"/>
						</td>
					</tr>
					<tr>
						<td>
							User Type:
						</td>
						<td>
						
							<select name = "user_type">
						<?php
							$type=1;
							$type_name[1]='Admin';
							$type_name[2]='Manager';
							$type_name[3]='Sales Head';
							$type_name[4]='Team Leader';
							$type_name[5]='Sales Person';
							$type_name[6]='Tele-Caller';
						
						
							while($type<=6)
								{
									echo '<option  value='.$type.'>'.$type_name[$type].'</option>';
									$type++;
								}
						?>
							</select>
						</td>
					</tr>

					<tr>
					<td> Outlet At Which Appointed : </td>
					<td>
					<select name = "outlet_id">
						<?php
						
						$result_outletTable = mysql_query("SELECT * FROM outlets_table");
						while($row_outletTable = mysql_fetch_array($result_outletTable))
						{if($row_outletTable[3]==1)
						  {	
							echo '<option  value='.$row_outletTable[0].' > '.$row_outletTable[1].'</option>';
						  }
						}
				
				echo '
					</select>
					</td>
				</tr>
				';
				?>
						<td align="center">
							<input type="hidden" name="insertuser"/>
							<input type="submit" value="Submit"/>
						</td>
					</tr>
				</table>
				</form>
<?php
			}
	if(isset($_POST['insertuser']))
		{
			$user_name=$_POST['userName'];
			$user_password=$_POST['userPassword'];
			$user_tyep=$_POST['user_type'];
			$outlet_id=$_POST['outlet_id'];
		
			mysql_query("INSERT INTO users_table (username,password,user_type,active_flag, outlet_id) VALUES ('".$user_name."','".$user_password."',".$user_tyep.",1,".$outlet_id.")");
			if(mysql_errno()==0)
				echo '<script type="text/javascript">alert("User successfully added.");</script>';
			else
				echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
		}

//add new outlet -----xxxxxxxxxxxxxxxx-------

	$result = mysql_query("SELECT * FROM  users_table,outlets_table where users_table.outlet_id = outlets_table.outlet_id");

	echo '<table align="center" width="90%">
			<tr>
				<th width="50px">S.No.</th>
				<th>User Id</th>
				<th>Username</th>
				<th>User Type</th>
				<th> Status</th>
				<th> Outlet </th>
				<th> </th>
			</tr>';

	$count = 0;
	$type_name[1]='Admin';
	$type_name[2]='Manager';
	$type_name[3]='Sales Head';
	$type_name[4]='Team Leader';
	$type_name[5]='Sales Person';
	$type_name[6]='Tele-Caller';


	while ($row = mysql_fetch_array($result))
	{
		$count++;
		echo'
		<tr>
			<td>'.$count.'</td>
			<td> '.$row[0].'</td>
			<td>'.$row[1].'</td>
			<td> '.$type_name[$row[3]].'</td>
			';
			if($row[4]==1)
			echo '
				<td> Active </td>';
		
			else
			{
				echo'
			<td> Inactive</td>';
			}
			echo '
					<td>
					'.$row[7]
					.'
					</td>
			';
		echo '<td align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="editing" value="editing"/>
				<input Type="hidden" name="user_id_to_edit" value="'.$row[0].'"/>
				<input type="submit" value="Edit"/>
			</form>
			</td>
		</tr>';
	}
	echo '</table>';




}
		
include 'footer.php';
?>