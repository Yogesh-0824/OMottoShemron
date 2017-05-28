<?php session_start();
include 'header.php';
//require_once('calendar/classes/tc_calendar.php');

if(isset($_SESSION['username']))
{

//-------------------------------------------------------------Eiting Section----------------------------------------------------------

if (isset($_POST['editing'])) 
	{	    $schemeId=$_POST['scheme_id_to_edit']; 
			$result=mysql_query("SELECT * FROM  schemes_table WHERE scheme_id=".$schemeId."");
			$row=mysql_fetch_array($result);
			
			echo '
			<br/>
			<form method="post" action="'. $_SERVER['PHP_SELF'].'">
			<table id="addinsurencetable" width="50%" align="center">
				<tr>
					<td>
						Scheme Name:
					</td>
					<td>
						<input type="text" name="schemeName" size="30" maxlength="20" value="'. $row[1] .'" />
					</td>
				</tr>
				<tr>
					<td>
						Benefit:
					</td>
					<td>
						<input type="text" name="benefit" size="30" maxlength="20" value="'. $row[2] .'" />
					</td>
				</tr>
				
					';
						
						echo '<input Type="hidden" name="scheme_id_to_edit" value="'.$schemeId.'"/>';   //send Id to next page
						
						echo '</select>
					
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
				</tr>				';
						
						?>
					
				</tr>
					<td></td>
					<td align="left">
						<input type="hidden" name="editScheme"/>
						
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
			</form>
		<?php
	}	
if(isset($_POST['editScheme']))
	{  
		$schemeName=$_POST['schemeName'];
		$benefit=$_POST['benefit'];
		$activeFlag=$_POST['activeFlag'];
		$schemeId=$_POST['scheme_id_to_edit'];

		//echo '<script type="text/javascript">alert("  Query: UPDATE insurers_table  SET insurer_name="'.$insurerName.'" , active_flag='.$activeFlag.'  WHERE insurer_id='.$insurerId.'");</script>';
	
		mysql_query("UPDATE schemes_table  SET scheme_name='".$schemeName."' , active_flag=".$activeFlag." , benefit='".$benefit."'  WHERE scheme_id=".$schemeId."" );
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Scheme successfully edited.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}
//---------------------------------------------------------- End Editing ---------------------------------------------------------------	

	//---------------------------------------------------------Add new scheme  -------------------------------------------------------
	echo '<div align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="addScheme" value="addScheme"/>
				<input type="submit" value="Add Scheme"/>
			</form>
		</div>';

		if(isset($_POST['addScheme']))
	{
		?>
		<br/>
		<form method="post" action="<?php $_SERVER['PHP_SELF']?>">
			<table id="addoutlettable" width="50%" align="center">
				<tr>
					<td>
						Scheme Name:
					</td>
					<td>
						<input type="text" name="schemeName" size="30" maxlength="20"/>
					</td>
				</tr>
				<tr>
					<td>
						Benefit :
					</td>
					<td>
						<input type="text" name="benefit" size="30" maxlength="20"/>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="hidden" name="insertscheme"/>
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
		</form>
		<?php
	}
	if(isset($_POST['insertscheme']))
	{
		$schemeName=$_POST['schemeName'];
		$benefit=$_POST['benefit'];
		
		mysql_query("INSERT INTO schemes_table ( scheme_name , benefit , active_flag) VALUES ('".$schemeName."','".$benefit."' ,1)");
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Scheme successfully added.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}

	//-----------------------------------------------------------------add new insurence -----xxxxxxxxxxxxxxxx-------------------------

	$result = mysql_query("SELECT * FROM  schemes_table");



	echo '<table align="center" width="90%">
		<tr>
		<th width="50px">S.No.</th>
		<th>Scheme Id</th>
		<th>Scheme Name</th>
		<th>Benefit </th>
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
		<td align="center"> '.$row[2].'</td>
		';
			if($row[3]==1)
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
				<input Type="hidden" name="scheme_id_to_edit" value="'.$row[0].'"/>
				<input type="submit" value="Edit"/>
			</form>
			</td>
	
		</tr>';
	}

	echo '</table>';
}
include 'footer.php';
?>