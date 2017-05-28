<?php session_start();
include 'header.php';
//require_once('calendar/classes/tc_calendar.php');

if(isset($_SESSION['username']))
{

//-------------------------------------------------------------Eiting Section----------------------------------------------------------

if (isset($_POST['editing'])) 
	{	    $insurerId=$_POST['insurer_id_to_edit']; 
			$result=mysql_query("SELECT * FROM  insurers_table WHERE insurer_id=".$insurerId."");
			$row=mysql_fetch_array($result);
			
			echo '
			<br/>
			<form method="post" action="'. $_SERVER['PHP_SELF'].'">
			<table id="addinsurencetable" width="50%" align="center">
				<tr>
					<td>
						Insurer Name:
					</td>
					<td>
						<input type="text" name="insurerName" size="30" maxlength="20" value="'. $row[1] .'" />
					</td>
				</tr>
				
					';
						
						echo '<input Type="hidden" name="insurer_id_to_edit" value="'.$insurerId.'"/>';   //send Id to next page
						
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
						<input type="hidden" name="editinsurer"/>
						
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
			</form>
		<?php
	}	
if(isset($_POST['editinsurer']))
	{  
		$insurerName=$_POST['insurerName'];
		$activeFlag=$_POST['activeFlag'];
		$insurerId=$_POST['insurer_id_to_edit'];

		echo '<script type="text/javascript">alert("  Query: UPDATE insurers_table  SET insurer_name="'.$insurerName.'" , active_flag='.$activeFlag.'  WHERE insurer_id='.$insurerId.'");</script>';
	
		mysql_query("UPDATE insurers_table  SET insurer_name='".$insurerName."' , active_flag=".$activeFlag."  WHERE insurer_id=".$insurerId."" );
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Insurer successfully edited.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}
//---------------------------------------------------------- End Editing ---------------------------------------------------------------	

	//---------------------------------------------------------Add new Insurer  -------------------------------------------------------
	echo '<div align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="addInsurer" value="addInsurer"/>
				<input type="submit" value="Add Insurer"/>
			</form>
		</div>';

		if(isset($_POST['addInsurer']))
	{
		?>
		<br/>
		<form method="post" action="<?php $_SERVER['PHP_SELF']?>">
			<table id="addoutlettable" width="50%" align="center">
				<tr>
					<td>
						Insurer Name:
					</td>
					<td>
						<input type="text" name="insurerName" size="30" maxlength="20"/>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="hidden" name="insertinsurer"/>
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
		</form>
		<?php
	}
	if(isset($_POST['insertinsurer']))
	{
		$insurerName=$_POST['insurerName'];
		
		
		mysql_query("INSERT INTO insurers_table (insurer_name , active_flag) VALUES ('$insurerName',1)");
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Insurer successfully added.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}

	//-----------------------------------------------------------------add new insurer -----xxxxxxxxxxxxxxxx-------------------------

	$result = mysql_query("SELECT * FROM  insurers_table");



	echo '<table align="center" width="90%">
		<tr>
		<th width="50px">S.No.</th>
		<th>Insurer Id</th>
		<th>Insurer Name</th>
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
				<input Type="hidden" name="insurer_id_to_edit" value="'.$row[0].'"/>
				<input type="submit" value="Edit"/>
			</form>
			</td>
	
		</tr>';
	}

	echo '</table>';
}
include 'footer.php';
?>