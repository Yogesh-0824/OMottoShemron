<?php session_start();
include 'header.php';
//require_once('calendar/classes/tc_calendar.php');
?>

<script>
function validateForm() 
{
	 
    var productId = document.forms["inventoryForm"]["productId"].value;
    var engineNo = document.forms["inventoryForm"]["engineNo"].value;
    var chasisNo = document.forms["inventoryForm"]["chasisNo"].value;
    var manufacturingYear = document.forms["inventoryForm"]["manufacturingYear"].value;
    var productInvoiceNo = document.forms["inventoryForm"]["productInvoiceNo"].value;
     
    var message="Hello \n";
    if (productId == null || productId == "") 
    {
        message=message+"Enter A valid Product Name \n ";
    }
    if (engineNo == null || engineNo == "" || engineNo==" ") 
    {
        message=message+"Enter A valid Engine Number \n ";
    }
    if (chasisNo == null || chasisNo == "") 
    {
        message=message+"Enter A valid chasis Number \n ";
    }
    
    if (manufacturingYear == null || manufacturingYear == "") 
    {
        message=message+"Enter A valid Manufacturing Year \n ";
    }
    if (productInvoiceNo == null || productInvoiceNo == "") 
    {
        message=message+"Enter A valid Invoice Number \n ";
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

//------------------------------------Incomplete-------------------------Eiting Section----------------------------------------------------------

if (isset($_POST['editing'])) 
	{	    $vehId=$_POST['veh_id_to_edit']; 
			$result=mysql_query("SELECT * FROM  inventory_table WHERE veh_id=".$vehId."");
			$row=mysql_fetch_array($result);
			
			echo '
			<br/>
			<form  action="'. $_SERVER['PHP_SELF'].'"  name="inventoryForm" onsubmit="return validateForm()" method="post" >
			<table id="addinsurencetable" width="50%" align="center">
			<tr>
					<td> Product Name : </td>
					<td>
					<select name = "productId">
						';
						
						$selected=' ';
						$result_productsTable = mysql_query("SELECT * FROM products_table");
						while($row_productsTable = mysql_fetch_array($result_productsTable))
						{	
							if ($row[1]==$row_productsTable[0]) 
							{
								$selected='selected';
							}
							if ($row[1]!=$row_productsTable[0]) 
							{
								$selected=' ';
							}
							echo '<option '.$selected.'  value='.$row_productsTable[0].'>'.$row_productsTable[1].'</option>';
						  
						}
				
				echo '
					</select>
					</td>
				</tr>
				<tr>
					<td>
						Engine Number:
					</td>
					<td>
						<input type="text" name="engineNo" size="30" maxlength="20" value="'. $row[2] .'" />
					</td>
				</tr>
				<tr>
					<td>
						Chasis Number:
					</td>
					<td>
						<input type="text" name="chasisNo" size="30" maxlength="20" value="'. $row[3] .'" />
					</td>
				</tr>
				<tr>
					<td>Colour :</td>
					<td>
					<select name="colour">
						';if($row[4]==1)
						echo '<option selected value = 1  >Black/Yellow</option> <option value = 2 >Blue/White</option>';
						else
						echo '<option selected value = 2 >Blue/White</option>  <option value = 1  >Black/Yellow</option>';
					echo '
					</select>
					</td>
				</tr>
				<tr>
					<td>
						 Manufacturing Year:
					</td>
					<td>
						<input type="text" name="manufacturingYear" size="30" maxlength="20" value="'. $row[5] .'" />
					</td>
				</tr>
				<tr>
					<td>Fuel Type :</td>
					<td>
					<select name="fuelType">
						';if($row[6]==1)
						echo '<option selected value = 1  >Diesel</option> <option value = 2 > CNG </option>';
						else
						echo '<option selected value = 2 >CNG</option>  <option value = 1  >Diesel</option>';
					echo '
					</select>
					</td>
				</tr>
				<tr>
					<td>
						 Product Invoice Number:
					</td>
					<td>
						<input type="text" name="productInvoiceNo" size="30" maxlength="20" value="'. $row[7] .'" />
					</td>
				</tr>
					<tr>
					<td>Status :</td>
					<td>
					<select name="statusFlag">
						';if($row[8]==1)
						echo '<option selected value = 1  >In Store</option> <option value = 3 > Returned </option>';

						else
							if($row[8]==3)
								echo '<option  value = 1  >In Store</option>  <option selected value = 3 > Returned </option>';

					echo '
					</select>
					</td>
				</tr>
				
					';
						
						echo '<input Type="hidden" name="veh_id_to_edit" value="'.$vehId.'"/>';   //send Id to next page
						
						echo '</select>
					
								';
						
						?>
					
				</tr>
					<td></td>
					<td align="left">
						<input type="hidden" name="editveh"/>
						
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
			</form>
		<?php
	}	
if(isset($_POST['editveh']))
	{  
		$engineNo=$_POST['engineNo'];
		$productId=$_POST['productId'];
		$chasisNo=$_POST['chasisNo'];
		$colour=$_POST['colour'];
		$manufacturingYear=$_POST['manufacturingYear'];
		$fuelType=$_POST['fuelType'];
		$productInvoiceNo=$_POST['productInvoiceNo'];
		$statusFlag=$_POST['statusFlag'];
		$vehId=$_POST['veh_id_to_edit'];

		//echo '<script type="text/javascript">alert("  Query: UPDATE insurers_table  SET insurer_name="'.$insurerName.'" , active_flag='.$activeFlag.'  WHERE insurer_id='.$insurerId.'");</script>';
	
		mysql_query("UPDATE inventory_table  SET product_id=".$productId." , engine_no='".$engineNo."' , chasis_no='".$chasisNo."' , colour=".$colour." , manufacturing_year='".$manufacturingYear."' , fuel_type=".$fuelType." , purchase_invoice_no='".$productInvoiceNo."' , status_flag=".$statusFlag." WHERE veh_id=".$vehId."" );
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Inventory Updated successfully .");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}
//---------------------------------Incomplete------------------------- End Editing ---------------------------------------------------------------	

	//---------------------------------------------------------Add new inventory  -------------------------------------------------------
	echo '<div align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="addInventory" value="addInventory"/>
				<input type="submit" value="Add To Invetory"/>
			</form>
		</div>';

		if(isset($_POST['addInventory']))
	{
		?>
		<br/>
		<form action="<?php $_SERVER['PHP_SELF']?>"  name="inventoryForm" onsubmit="return validateForm()" method="post">
			<table id="addoutlettable" width="50%" align="center">
				<tr>
					<td>
						Product Name:
					</td>
					<td> <SELECT name="productId">
					<?php
					$result=mysql_query("SELECT * FROM products_table");
					while($row=mysql_fetch_array($result))
					{
						echo '<option value='.$row[0].'>'.$row[1].'</option>';
					}
					?>
						</SELECT>
					</td>
				</tr>
				<tr>
					<td>
						Engine Number:
					</td>
					<td>
						<input type="text" name="engineNo" size="40" maxlength="30"/>
					</td>
				</tr>
				<tr>
					<td>
						Chasis Number:
					</td>
					<td>
						<input type="text" name="chasisNo" size="30" maxlength="20"/>
					</td>
				</tr>
				<tr>
					<td>
						Colour:
					</td>
					<td>
						<select name = "colour">
						<?php
							$type=1;
							$type_name[1]='Black/Yellow';
							$type_name[2]='Blue/White';
											
						
							while($type<=2)
								{
									echo '<option  value='.$type.'>'.$type_name[$type].'</option>';
									$type++;
								}
						?>
							</select>
					</td>
				</tr>
				<tr>
					<td>
						Manufacturing Year:
					</td>
					<td>
						<input type="text" name="manufacturingYear" size="10" maxlength="8"/>
					</td>
				</tr>
				<tr>
					<td>
						Fuel Type:
					</td>
					<td>
						<select name = "fuelType">
						<?php
							$type=1;
							$type_name[1]='Diesel';
							$type_name[2]='CNG';
											
						
							while($type<=2)
								{
									echo '<option  value='.$type.'>'.$type_name[$type].'</option>';
									$type++;
								}
						?>
							</select>
					</td>
				</tr>
					
					<tr>
					<td>
						Product Invoice Number:
					</td>
					<td>
						<input type="text" name="productInvoiceNo" size="20" maxlength="10"/>
					</td>
				</tr>
				<tr>
					<td>
						Status:
					</td>
					<td>
						<select name = "status">
						<?php
							$type=1;
							$type_name[1]='In Store';
							$type_name[2]='Sold';
							$type_name[3]='Returned';
											
						
							while($type<=3)
								{
									echo '<option  value='.$type.'>'.$type_name[$type].'</option>';
									$type++;
								}
						?>
							</select>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="hidden" name="insertinventory"/>
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
		</form>
		<?php
	}
	if(isset($_POST['insertinventory']))
	{
		$engineNo=$_POST['engineNo'];
		$productId=$_POST['productId'];
		$chasisNo=$_POST['chasisNo'];
		$colour=$_POST['colour'];
		$manufacturingYear=$_POST['manufacturingYear'];
		$fuelType=$_POST['fuelType'];
		$productInvoiceNo=$_POST['productInvoiceNo'];
		$status=$_POST['status'];
		//echo '<script type="text/javascript">alert("'.$productId.''.$engineNo.' , '.$chasisNo.' , '.$colour.' , '.$manufacturingYear.' , '.$fuleType.' , '.$productInvoiceNo.' , '.$status.'");</script>';
		mysql_query("INSERT INTO inventory_table (product_id , engine_no , chasis_no , colour , manufacturing_year , fuel_type , purchase_invoice_no , status_flag) VALUES (".$productId." ,'".$engineNo."' , '".$chasisNo."' , ".$colour." , ".$manufacturingYear." , ".$fuelType." , '".$productInvoiceNo."' , ".$status.")");
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Invetory successfully Updated.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}

	//-----------------------------------------------------------------add new to inventory -----xxxxxxxxxxxxxxxx-------------------------

	$result = mysql_query("SELECT * FROM  inventory_table");
	$result_productsTable = mysql_query("SELECT * FROM  products_table");


	echo '<table align="center" width="90%">
		<tr>
		<th width="50px">S.No.</th>
		<th>Vehical Id</th>
		<th>Product Name</th>  
		<th width="100px"> 
			<table>
				<tr><th>Engine No </th></tr>
				<tr><th> Chasis No </th></tr>
			</table>
		</th>
		<th width="30px"></th>
		<th>Manuf Year</th> 
		<th>Fuel Type </th>  
		<th>Purchase Invoice No</th> 
		<th>Status</th>
		<th></th>
		</tr>';

$count = 0;
	while ($row = mysql_fetch_array($result))
	{
		$result_productsTable = mysql_query("SELECT * FROM  products_table WHERE  product_id = ".$row[1]."");
		$row_productsTable = mysql_fetch_array($result_productsTable);
		$count++;
	echo'
		<tr>
		<td>'.$count.'</td>
		<td> '.$row[0].'</td>
		<td> '.$row_productsTable[1].'</td>
		<td>
			<table>
				<tr> <td width="100px" > '.$row[2].'</td></tr>
				<tr> <td width="100px" > '.$row[3].'</td></tr>
			</table>
		</td>
		';
		if($row[4]==1)
			echo '
				<td width="30px" align="center" bgcolor = "Black"></td>';
		
			else
			{ if($row[4]==2)
				echo'
			<td  width="30px" align="center" bgcolor = "Blue"></td>';
			}
			echo '
		<td width="100px" align="center"> '.$row[5].'</td>
		';
			if($row[6]==1)
			echo '
				<td align="center">Diesel</td>';
		
			else
			{ if($row[6]==2)
				echo'
			<td align="center">CNG</td>';
			}
	echo'<td> '.$row[7].'</td>';

		if($row[8]==1)
			echo '
				<td align="center">In Store</td>';
		
		if($row[8]==2)
						{
							echo '<td>';
							$result_custDetails= mysql_query("SELECT ct.customer_name , ct.customer_father_name , st.date_of_sale FROM inventory_table as it, sales_table as st, customers_table as ct WHERE it.veh_id=st.veh_id AND st.customer_id=ct.customer_id AND it.veh_id=".$row[0]."");
							while ($row_cusDetails=mysql_fetch_array($result_custDetails)) 
							{
								echo '
										<table>
										<tr>
											<td>'.$row_cusDetails[0].' /</td>
											<td>'.$row_cusDetails[1].'</td>
										</tr>
										<tr>
											<td>'.$row_cusDetails[2].'</td>
										</tr>
										</table>
									';	
							}
							echo '</td>';
						}
		if($row[8]==3)
			echo'
				<td align="center">Returned</td>';

			echo ' <td align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="editing" value="editing"/>
				<input Type="hidden" name="veh_id_to_edit" value="'.$row[0].'"/>
				<input type="submit" value="Edit"/>
			</form>
			</td>
	
		</tr>';
	}

	echo '</table>';
}
include 'footer.php';
?>