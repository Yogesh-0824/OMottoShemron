<?php session_start();
include 'header.php';
//require_once('calendar/classes/tc_calendar.php');

if(isset($_SESSION['username']))
{

//-------------------------------------------------------------Eiting Section----------------------------------------------------------

if (isset($_POST['editing'])) 
	{	    $financerId=$_POST['financer_id_to_edit']; 
			$result=mysql_query("SELECT * FROM  financers_table WHERE financer_id=".$financerId."");
			$row=mysql_fetch_array($result);
			
			echo '
			<br/>
			<form method="post" action="'. $_SERVER['PHP_SELF'].'">
			<table id="addoutlettable" width="50%" align="center">
				<tr>
					<td>
						Financer Name:
					</td>
					<td>
						<input type="text" name="financerName" size="30" maxlength="20" value="'. $row[1] .'" />
					</td>
				</tr>
				
					';
						
						echo '<input Type="hidden" name="financer_id_to_edit" value="'.$financerId.'"/>';
						
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
						<input type="hidden" name="editfinancer"/>
						
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
			</form>
		<?php
	}	
if(isset($_POST['editfinancer']))
	{  
		$financerName=$_POST['financerName'];
		$activeFlag=$_POST['activeFlag'];
		$financerId=$_POST['financer_id_to_edit'];

	//	echo '<script type="text/javascript">alert(" '.$standId.' Query: UPDATE stands_table  SET stand_name='.$standName.' , outlet_id='.$outletId.'  WHERE stand_id = '.$standId.'");</script>';
	
		mysql_query("UPDATE financers_table  SET financer_name='".$financerName."' , active_flag=".$activeFlag."  WHERE financer_id=".$financerId."" );
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Financer successfully edited.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}
//---------------------------------------------------------- End Editing ---------------------------------------------------------------	

	//---------------------------------------------------------Add new financer  -------------------------------------------------------
	echo '<div align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="addFinancer" value="addFinancer"/>
				<input type="submit" value="Add Financer"/>
			</form>
		</div>';

		if(isset($_POST['addFinancer']))
	{
		?>
		<br/>
		<form method="post" action="<?php $_SERVER['PHP_SELF']?>">
			<table id="addoutlettable" width="50%" align="center">
				<tr>
					<td>
						Financer Name:
					</td>
					<td>
						<input type="text" name="financerName" size="30" maxlength="20"/>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="hidden" name="insertFinancer"/>
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
		</form>
		<?php
	}
	if(isset($_POST['insertFinancer']))
	{
		$financerName=$_POST['financerName'];
		
		
		mysql_query("INSERT INTO financers_table (financer_name , active_flag) VALUES ('$financerName',1)");
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Outlet successfully added.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}

	//-----------------------------------------------------------------add new financer -----xxxxxxxxxxxxxxxx-------------------------

	$result = mysql_query("SELECT * FROM  financers_table");



	echo '<table align="center" width="90%">
		<tr>
		<th width="50px">S.No.</th>
		<th>Financer Id</th>
		<th>Financer Name</th>
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
				<input Type="hidden" name="financer_id_to_edit" value="'.$row[0].'"/>
				<input type="submit" value="Edit"/>
			</form>
			</td>
	
		</tr>';
	}

	echo '</table>';
}
include 'footer.php';
?>