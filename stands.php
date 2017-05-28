<?php session_start();
include 'header.php';
//require_once('calendar/classes/tc_calendar.php');

?>

<script>
function validateForm() 
{
	 
    var standName= document.forms["standsForm"]["standName"].value;

     
     
    var message="Hello \n";
    if (standName == null || standName == "") 
    {
        message=message+"Enter A valid Stand Name \n ";
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

if (isset($_POST['editing'])) 
	{	    $standId=$_POST['stand_id_to_edit']; 
			$result=mysql_query("SELECT * FROM  stands_table WHERE stand_id=".$standId."");
			$row=mysql_fetch_array($result);
			
			echo '
			<br/>
			<form action="'. $_SERVER['PHP_SELF'].'" name="standsForm" onsubmit="return validateForm()" method="post">
			<table id="addoutlettable" width="50%" align="center">
				<tr>
					<td>
						Stand Name:
					</td>
					<td>
						<input type="text" name="standName" size="30" maxlength="20" value="'. $row[1] .'" />
					</td>
				</tr>
				<tr>
					<td>
						Outlet Id:
					</td>';
?>
					<td>
						
						<select name = "outletId">
						<?php
						$result = mysql_query("SELECT * FROM outlets_table");
						while($row = mysql_fetch_array($result))
						{
							echo '<option  value='.$row[0].'>'.$row[1].'</option>';
						}

						echo '<input Type="hidden" name="stand_id_to_edit" value="'.$standId.'"/>';
						?>
						</select>
						
					</td>
				</tr>
					<td></td>
					<td align="left">
						<input type="hidden" name="editstand"/>
						
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
			</form>
		<?php
	}	
if(isset($_POST['editstand']))
	{
		$standName=$_POST['standName'];
		$outletId=$_POST['outletId'];
		$standId=$_POST['stand_id_to_edit'];
	//	echo '<script type="text/javascript">alert(" '.$standId.' Query: UPDATE stands_table  SET stand_name='.$standName.' , outlet_id='.$outletId.'  WHERE stand_id = '.$standId.'");</script>';
		
		mysql_query("UPDATE stands_table  SET stand_name='".$standName."' , outlet_id='".$outletId."' WHERE stand_id=".$standId."" );
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Stand successfully edited.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}
//---------------------------------------------------------- End Editing ---------------------------------------------------------------	



if(isset($_SESSION['username']))
{
	//-------------------------------------------add new stand  ------------------------------
	echo '<div align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="addstand" value="addstand"/>
				<input type="submit" value="Add Stand"/>
			</form>
		</div>';

		if(isset($_POST['addstand']))
	{
		?>
		<br/>
		<form action="<?php $_SERVER['PHP_SELF']?>"  name="standsForm" onsubmit="return validateForm()" method="post">
			<table  width="50%" align="center">
				<tr>
					<td>
						Stand Name:
					</td>
					<td>
						<input type="text" name="standName" size="30" maxlength="20"/>
						
					</td>
				</tr>
				<tr>
					<td>
						Outlet Id:
					</td>
					<td>
						<!--<input type="text" name="outlet_address" size="60" maxlength="50"/>-->
						<select name = "outlet_id">
						<?php
						$result = mysql_query("SELECT * FROM outlets_table");
						while($row = mysql_fetch_array($result))
						{
							echo '<option  value='.$row[0].'>'.$row[1].'</option>';
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
				<td></td>
				<td>
				<input type="hidden" name="insertstand"/>
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
		</form>
		<?php
	}
	if(isset($_POST['insertstand']))
	{
		$stand_name=$_POST['standName'];
		$outlet_id=$_POST['outlet_id'];
		
		mysql_query("INSERT INTO stands_table VALUES (NULL,'$stand_name','$outlet_id')");
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Stand successfully added.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}

	//------------------------------------add new stand -----xxxxxxxxxxxxxxxx-------

	$result = mysql_query("SELECT * FROM  stands_table");
	



	echo '<table align="center" width="90%">
		<tr>
		<th width="50px">S.No.</th>
		<th>Stand Id</th>
		<th>Stand Name</th>
		<th>Outlet Name</th>
		<th></th>
		</tr>';

$count = 0;

	while ($row = mysql_fetch_array($result))
	{
		$result_for_stand_name = mysql_query("SELECT * FROM  outlets_table");
		$count++;
	echo'
		<tr>
		<td>'.$count.'</td>
		<td> '.$row[0].'</td>
		<td> '.$row[1].'</td>
		';
		while ($row_for_stand_name = mysql_fetch_array($result_for_stand_name)) 

		{
			if ($row[2]==$row_for_stand_name[0]) 
			{
			echo	'<td>'.$row_for_stand_name[1].'</td>';

			}
		}
		echo '<td align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="editing" value="editing"/>
				<input Type="hidden" name="stand_id_to_edit" value="'.$row[0].'"/>
				<input type="submit" value="Edit"/>
			</form>
			</td>
		
		
		</tr>';
		
	}
	echo '</table>';
}
include 'footer.php';
?>