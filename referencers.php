<?php session_start();
include 'header.php';
//require_once('calendar/classes/tc_calendar.php');

?>

<script>
function validateForm() 
{
	 
    var referencerName= document.forms["referencerForm"]["referencerName"].value;
    var referencerPhNo= document.forms["referencerForm"]["referencerPhNo"].value;
     
     
    var message="Hello \n";
    if (referencerName == null || referencerName == "") 
    {
        message=message+"Enter A valid Referencer Name \n ";
    }
    if (referencerPhNo == null || referencerPhNo == "") 
    {
        message=message+"Enter A valid Referencer PhNo\n ";
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
	{	    $referencerId=$_POST['referencer_id_to_edit']; 
			$result=mysql_query("SELECT * FROM  referencer_table WHERE referencer_id=".$referencerId."");
			$row=mysql_fetch_array($result);
			
			echo '
			<br/>
			<form id="editReferencer" action="'. $_SERVER['PHP_SELF'].'" name="referencerForm" onsubmit="return validateForm()" method="post">
			<table id="addinsurencetable" width="50%" align="center">
				<tr>
					<td>
						Referencer Name:
					</td>
					<td>
						<input type="text" name="referencerName" size="30" maxlength="20" value="'. $row[1] .'" />
					</td>
				</tr>
				<tr>
					<td>
						Referencer PhNo:
					</td>
					<td>
						<input type="text" name="referencerPhNo" size="30" maxlength="20" value="'. $row[2] .'" />
					</td>
				</tr>
					<tr>
					<td>
						Stand Id:
					</td>
						
					<td>
						
						<select name = "standId">
						';
						$selected=' ';
						$result_standsTable = mysql_query("SELECT * FROM stands_table");
						while($row_standsTable = mysql_fetch_array($result_standsTable))
						{
							if($row[3] == $row_standsTable[0])
								$selected='selected';
							else
								$selected=' ';
							echo '<option '.$selected.' value='.$row_standsTable[0].'>'.$row_standsTable[1].'</option>';
						}

						echo'
						</select>
						
					</td>
				</tr>
				
					';
						
						echo '<input Type="hidden" name="referencer_id_to_edit" value="'.$referencerId.'"/>';   //send Id to next page
						
						echo '</select>';
					
					 
						
						?>
					
				</tr>
					<td></td>
					<td align="left">
						<input type="hidden" name="editreferencer"/>
						
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
			</form>
			
		<?php
	}	
if(isset($_POST['editreferencer']))
	{  
		$referencerName=$_POST['referencerName'];
		$referencerPhNo=$_POST['referencerPhNo'];
		$standId=$_POST['standId'];
		$referencerId=$_POST['referencer_id_to_edit'];

		//echo '<script type="text/javascript">alert("  Query: UPDATE insurers_table  SET insurer_name="'.$insurerName.'" , active_flag='.$activeFlag.'  WHERE insurer_id='.$insurerId.'");</script>';
	
		mysql_query("UPDATE referencer_table  SET referencer_name='".$referencerName."' , referencer_phone='".$referencerPhNo."'  ,stand_id=".$standId."  WHERE referencer_id=".$referencerId."" );
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Referencer successfully edited.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}
//---------------------------------------------------------- End Editing ---------------------------------------------------------------	

	//---------------------------------------------------------Add new referencer  -------------------------------------------------------
	echo '<div align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="addReferencer" value="addReferencer"/>
				<input type="submit" value="Add Referencer"/>
			</form>
		</div>';

		if(isset($_POST['addReferencer']))
	{
		?>
		<br/>
		<form id="addReferencer" action="<?php $_SERVER['PHP_SELF']?>" name="referencerForm" onsubmit="return validateForm()" method="post">
			<table id="addoutlettable" width="50%" align="center">
				<tr>
					<td>
						Referencer Name:
					</td>
					<td>
						<input type="text" name="referencerName" size="30" maxlength="20"/>
					</td>
				</tr>
				<tr>
					<td>
						Referencer PhNo:
					</td>
					<td>
						<input type="text" name="referencerPhNo" size="10" maxlength="10"/>
					</td>
				</tr>
				<tr>
					<td>
						Stand Id:
					</td>
					<td>
						<select name = "standId">
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
					</td>
					<td>
						<input type="hidden" name="insertreferencer"/>
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
		</form>
		
		<?php
	}
	if(isset($_POST['insertreferencer']))
	{
		$referencerName=$_POST['referencerName'];
		$referencerPhNo=$_POST['referencerPhNo'];
		$standId=$_POST['standId'];
		
		mysql_query("INSERT INTO referencer_table (referencer_name ,referencer_phone , stand_id) VALUES ('".$referencerName."', '".$referencerPhNo."' , ".$standId.")");
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Referencer successfully added.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}

	//-----------------------------------------------------------------add new referencer -----xxxxxxxxxxxxxxxx-------------------------

	$result = mysql_query("SELECT * FROM  referencer_table");



	echo '<table align="center" width="90%">
		<tr>
		<th width="50px">S.No.</th>
		<th>Referencer Id</th>
		<th>Referencer Name</th>
		<th>Referencer PhoneNo</th>
		<th>Stand Name </th>
		<th></th>
		</tr>';

$count = 0;
	while ($row = mysql_fetch_array($result))
	{
		$count++;
		$result_standsTable = mysql_query("SELECT * FROM  stands_table WHERE  stand_id = ".$row[3]."");
		$row_standsTable = mysql_fetch_array($result_standsTable);
	echo'
		<tr>
		<td>'.$count.'</td>
		<td> '.$row[0].'</td>
		<td> '.$row[1].'</td>
		<td> '.$row[2].'</td>
		<td>'.$row_standsTable[1].'</td>
		 <td align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="editing" value="editing"/>
				<input Type="hidden" name="referencer_id_to_edit" value="'.$row[0].'"/>
				<input type="submit" value="Edit"/>
			</form>
			</td>
	
		</tr>
		';
	}	

	echo '</table>';
}
include 'footer.php';
?>