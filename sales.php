<?php session_start();
include 'header.php';
//require_once('calendar/classes/tc_calendar.php');

//---------------------------------------------------AJAX Function Start-------------------------------------------------------------------------
?>
<script>

var xmlhttp, variable;
function loadXMLDoc(url,cfunc)
{
	if(window.XMLHttpRequest)
	{
		//Other browsers
		xmlhttp=new XMLHttpRequest();
	}
	else
	{	//IE 6,5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=cfunc;
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("variableName="+variable); 
}


function Ajax_vehId()
{	
	variable=document.getElementById("vehAid").value;
	
	//alert(variable);

	loadXMLDoc("offeredOnRoad.php", function()
		{
			if(xmlhttp.readyState=4 && xmlhttp.status==200)
			{
				document.getElementById("offeredOnRoad").value=xmlhttp.responseText;
			}
		});
}
function Ajax_Scheme()
{	
	variable=document.getElementById("schemeAid").value;
	
	//alert(variable);

	loadXMLDoc("schemeBenifit.php", function()
		{
			if(xmlhttp.readyState=4 && xmlhttp.status==200)
			{
				document.getElementById("schemeBenifit").value=xmlhttp.responseText;
			}
		});
}



</script>

<script>
function validateForm() 
{
	 
    var veh_id = document.forms["salesForm"]["veh_id"].value;
    var offeredOnRoad = document.forms["salesForm"]["offeredOnRoad"].value;
    var financerName = document.forms["salesForm"]["financerName"].value;
    var financedAmount = document.forms["salesForm"]["financedAmount"].value;
    var userName = document.forms["salesForm"]["userName"].value;
    var refrencerName = document.forms["salesForm"]["refrencerName"].value;
    var dateOfSale = document.forms["salesForm"]["dateOfSale"].value;
    var schemeName = document.forms["salesForm"]["schemeName"].value;
    var scheme_benefit = document.forms["salesForm"]["scheme_benefit"].value;
    var message="Hello \n";
    if (veh_id == null || veh_id == "") 
    {
        message=message+"Enter A valid Vehicle Name \n ";
    }
    if (offeredOnRoad == null || offeredOnRoad == "") 
    {
        message=message+"Enter A valid Offered Price \n ";
    }
      
    
    if (financerName == null || financerName == "") 
    {
        message=message+"Enter A valid Financer Name \n ";
    }
    if (financedAmount == null || financedAmount == "") 
    {
        message=message+"Enter A valid Financed Amount \n ";
    }
    if (userName == null || userName == "") 
    {
        message=message+"Enter A valid Seller\'s Name \n ";
    }
    //if (refrencerName == null || refrencerName == "") 
    {
    //    message=message+"Enter A valid Refrencer Name \n ";
    }
    if (dateOfSale == null || dateOfSale == "") 
    {
        message=message+"Enter A valid Date Of Sale \n ";
    }
    //if (schemeName == null || schemeName == "") 
    {
     //   message=message+"Enter A valid Scheme Name \n ";
    }
    //if (scheme_benefit == null || scheme_benefit == "") 
    {
    //    message=message+"Enter A valid Scheme Benefit \n ";
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
//----------------------------------------------------AJAX Function End--------------------------------------------------------------------------------


if(isset($_SESSION['username']))

{

//-------------------------------------------------------------Eiting Section----------------------------------------------------------

if (isset($_POST['editing'])) 
	{	    $saleId=$_POST['sale_id_to_edit']; 
			$result=mysql_query("SELECT * FROM  sales_table WHERE sale_id=".$saleId."");
			$row=mysql_fetch_array($result);
			
			echo '
			<br/>
			<form  action="'. $_SERVER['PHP_SELF'].'" name="salesForm" onsubmit="return validateForm()"  method="post">
			<table id="addinsurencetable" width="50%" align="center">
			
				<tr>
					<td>Vehicle Details : </td>

					<td>
					<select name = "veh_id" id="vehAid" onchange="Ajax_vehId()">
					<option></option>
						';
						
						$selected=' ';
						$result_vehDetTable = mysql_query("SELECT * FROM inventory_table,products_table WHERE inventory_table.product_id = products_table.product_id");
						while($row_vehDetTable = mysql_fetch_array($result_vehDetTable))
						{	
							if ($row[1]==$row_vehDetTable[0]) 
							{
								$selected='selected';
							}
							if ($row[1]!=$row_vehDetTable[0]) 
							{
								$selected=' ';
							}
							echo '<option '.$selected.'  value='.$row_vehDetTable[0].'>'.$row_vehDetTable[10].' / '.$row_vehDetTable [2].' / '.$row_vehDetTable [3].'</option>';
						  
						}
				
				echo '
					</select>
					</td>
				</tr>
				<tr>
					<td>
					Offered On Road Price 
					</td>
					<td>
					<input type="text" name="offeredOnRoad"  id="offeredOnRoad" value="'.$row[7].'" />
					</td>
				</tr>
				<tr>
					<td>
						Customer Name (Paper Owner):
					</td>
					<td>
						 
						<select name = "customerName">
						<option value="same"></option>';
						
						$result_for_cust_name = mysql_query("SELECT * FROM customers_table,stands_table WHERE customers_table.stand_id=stands_table.stand_id");
						while($row_for_cust_name = mysql_fetch_array($result_for_cust_name))
						{	if($row_for_cust_name[6]==1)
							{
							if ($row[2]==$row_for_cust_name[0]) 
							{
								$selected='selected';
							}
							if ($row[2]!=$row_for_cust_name[0]) 
							{
								$selected=' ';
							}
							echo '<option '.$selected.' value='.$row_for_cust_name[0].'>'.$row_for_cust_name[1].' / '.$row_for_cust_name[2].' / '.$row_for_cust_name[8].'</option>';
							}
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Customer Name (Real Owner):
					</td>
					<td>
						 
						<select name = "customerName_real">
						<option value="same"></option>
						<?php
						
						$result_for_cust_name = mysql_query("SELECT * FROM customers_table,stands_table WHERE customers_table.stand_id=stands_table.stand_id");
						while($row_for_cust_name = mysql_fetch_array($result_for_cust_name))
						{	if($row_for_cust_name[6]==0)
							{
							if ($row[31]==$row_for_cust_name[0]) 
							{
								$selected='selected';
							}
							if ($row[31]!=$row_for_cust_name[0]) 
							{
								$selected=' ';
							}
							echo '<option '.$selected.' value='.$row_for_cust_name[0].'>'.$row_for_cust_name[1].' / '.$row_for_cust_name[2].' / '.$row_for_cust_name[8].'</option>';
							}
						}
						?>
						</select>
					</td>
				</tr>
				<!--
				<tr>
					<td>
						Stand Name:
					</td>
					<td>
						 
						<select name = "standName">
						<?php 
						$result_for_stand_name = mysql_query("SELECT * FROM stands_table");
						while($row_for_stand_name = mysql_fetch_array($result_for_stand_name))
						{
							if ($row[3]==$row_for_stand_name[0]) 
							{
								$selected='selected';
							}
							if ($row[3]!=$row_for_stand_name[0]) 
							{
								$selected=' ';
							}
							echo '<option '.$selected.' value='.$row_for_stand_name[0].'>'.$row_for_stand_name[1].'</option>';
						}
						?>
						</select>
					</td>
				</tr>
				-->
				<tr>
					<td>
						Financer Name:
					</td>
					<td>
						<!--<input type="text" name="outlet_address" size="60" maxlength="50"/>-->
						<select name = "financerName">
						<?php
						$result_for_financer_name = mysql_query("SELECT * FROM financers_table");
						while($row_for_financer_name = mysql_fetch_array($result_for_financer_name))
						{
							if ($row[3]==$row_for_financer_name[0]) 
							{
								$selected='selected';
							}
							if ($row[3]!=$row_for_financer_name[0]) 
							{
								$selected=' ';
							}
							echo '<option '.$selected.' value='.$row_for_financer_name[0].'>'.$row_for_financer_name[1].'</option>';
						}
						echo '
						</select>
					</td>
					<td>
						Financed Amount:
					</td>
					<td>
						<input type="text" name="financedAmount" size="30" maxlength="20" value="'.$row[10].'"/>
					</td>
				</tr>
							';?>
				<tr>
					<td>
						Seller's Name:
					</td>
					<td>
						<!--<input type="text" name="outlet_address" size="60" maxlength="50"/>-->
						<select name = "userName">
						<?php
						$result_for_user_name = mysql_query("SELECT * FROM users_table");
						while($row_for_user_name = mysql_fetch_array($result_for_user_name))
						{
							if ($row[4]==$row_for_user_name[0]) 
							{
								$selected='selected';
							}
							if ($row[4]!=$row_for_user_name[0]) 
							{
								$selected=' ';
							}
							echo '<option '.$selected.' value='.$row_for_user_name[0].'>'.$row_for_user_name[1].'</option>';
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Refrencer Name:
					</td>
					<td>
						<!--<input type="text" name="outlet_address" size="60" maxlength="50"/>-->
						<select name = "refrencerName">
						<option value="1"></option>
						<?php
						$result_for_refrencer_name = mysql_query("SELECT * FROM referencer_table,stands_table WHERE referencer_table.stand_id = stands_table.stand_id");
						while($row_for_refrencer_name = mysql_fetch_array($result_for_refrencer_name))
						{
							if ($row[5]==$row_for_refrencer_name[0]) 
							{
								$selected='selected';
							}
							if ($row[5]!=$row_for_refrencer_name[0]) 
							{
								$selected=' ';
							}
							echo '<option '.$selected.' value='.$row_for_refrencer_name[0].'>'.$row_for_refrencer_name[1].' / '.$row_for_refrencer_name[5].'</option>';
						}
						echo '
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Date Of Sale (yyyy-mm-dd):
					</td>
					<td>
						<input type="text" name="dateOfSale" size="30" maxlength="20" value="'.$row[6].'" />
					</td>
				</tr>
				</tr>
				';?>
				<tr>
					<td>
						Scheme Name:
					</td>
					<td>
						<!--<input type="text" name="outlet_address" size="60" maxlength="50"/>-->
						<select name = "schemeName" id="schemeAid" onchange="Ajax_Scheme()">
						<option></option>
						<?php
						$result_for_scheme_name = mysql_query("SELECT * FROM schemes_table");
						while($row_for_scheme_name = mysql_fetch_array($result_for_scheme_name))
						{
							if ($row[8]==$row_for_scheme_name[0]) 
							{
								$selected='selected';
							}
							if ($row[8]!=$row_for_scheme_name[0]) 
							{
								$selected=' ';
							}
							if($row_for_scheme_name[3]==1)
							echo '<option '.$selected.' value='.$row_for_scheme_name[0].'>'.$row_for_scheme_name[1].'</option>';
						}
						echo '
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Scheme Benefit 
					</td>
					<td >
						<input  type="text" name="scheme_benefit" id="schemeBenifit" value="'.$row[9].'"/>
					</td>
				</tr>
				
				
					';
						
						echo '<input Type="hidden" name="sale_id_to_edit" value="'.$saleId.'"/>';   //send Id to next page
						
					
					
				 			
						
						echo '
					<tr>
						<td>
							Recept Number:
						</td>
						<td>
							<input type="text" name="receptNo" size="35" maxlength="30" value="'.$row[30].'" />
						</td>
					</tr>

					';?>
					
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
		$saleId=$_POST['sale_id_to_edit'];
		$veh_id=$_POST['veh_id'];
		$customerName=$_POST['customerName'];
		$customerName_real=$_POST['customerName_real'];
		$standName=$_POST['standName'];
		$financerName=$_POST['financerName'];
		$userName=$_POST['userName'];
		$refrencerName=$_POST['refrencerName'];
		$dateOfSale=$_POST['dateOfSale'];
		$schemeName=$_POST['schemeName'];
		$financedAmount=$_POST['financedAmount'];
		$offeredOnRoad=$_POST['offeredOnRoad'];
		$receptNo=$_POST['receptNo'];
		$scheme_benefit=$_POST['scheme_benefit'];

		//echo '<script type="text/javascript">alert("  Query: UPDATE insurers_table  SET insurer_name="'.$insurerName.'" , active_flag='.$activeFlag.'  WHERE insurer_id='.$insurerId.'");</script>';
		if ($customerName_real=="same") 
		 {
		 	$customerName_real=$customerName;
		 }
	
		mysql_query("UPDATE sales_table  SET veh_id=".$veh_id." , offered_on_road_price=".$offeredOnRoad.", scheme_benefit=".$scheme_benefit.", customer_id=".$customerName." , financer_id=".$financerName." , user_id=".$userName." , referencer_id=".$refrencerName." , date_of_sale='".$dateOfSale."' , scheme_id=".$schemeName." , financed_amount=".$financedAmount."  , recept_no='".$receptNo."' , customer_id_real=".$customerName_real." WHERE  sale_id=".$saleId."  " );
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Sale successfully edited.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}
//---------------------------------------------------------- End Editing ---------------------------------------------------------------	

	//---------------------------------------------------------Add new Sale -I  -------------------------------------------------------
	echo '<div align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="addsale" value="addsale"/>
				<input type="submit" value="Add Sale"/>
			</form>
		</div>';

		if(isset($_POST['addsale']))
	{
		?>
		<br/>
		<form  action="<?php $_SERVER['PHP_SELF']?>"  name="salesForm" onsubmit="return validateForm()"  method="post">
			<table id="addoutlettable" width="50%" align="center">
			
				
				<tr>
					<td>
						Vehicle Details:
					</td>
					<td>
						<!--<input type="text" name="outlet_address" size="60" maxlength="50"/>-->
						<select name = "veh_id" id="vehAid" onchange="Ajax_vehId()">
						<option></option>
						<?php
						$result = mysql_query("SELECT * FROM inventory_table,products_table WHERE inventory_table.product_id = products_table.product_id");
						while($row = mysql_fetch_array($result))
						{
							if($row[8]==1)
							echo '<option  value='.$row[0].'>'.$row[10].' / '.$row[2].' / '.$row[3].'</option>';
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
				<td> Offered On Road Price
				<td >
				<input type="text" name="offeredOnRoad"  id="offeredOnRoad" />
				</td>
			</tr>
				<tr>
					<td>
						Customer Name (Paper Owner):
					</td>
					<td>
						<!--<input type="text" name="outlet_address" size="60" maxlength="50"/>-->
						<select name = "customerName">
						<option></option>
						<?php
						$result = mysql_query("SELECT * FROM customers_table,stands_table WHERE customers_table.stand_id=stands_table.stand_id");
						while($row = mysql_fetch_array($result))
						{
							if($row[6]==1)
							echo '<option  value='.$row[0].'>'.$row[1].' / '.$row[2].' / '.$row[8].'</option>';
						}
						?>
						</select>
					</td>
				<tr>
					<td>
						Customer Name (Real Owner):
					</td>
					<td>
						<?php
						$result = mysql_query("SELECT * FROM customers_table,stands_table WHERE customers_table.stand_id=stands_table.stand_id");

						//if($row[0]>0)
						{
							echo '
						
						<select name = "customerName_real">
						<option value="same"></option>
						';
						
						while($row = mysql_fetch_array($result))
						{
								
							if($row[6]==0)
							echo '<option  value='.$row[0].'>'.$row[1].' / '.$row[2].' / '.$row[8].'</option>';
							
						}
						?>
						</select>
						<?php
						}  
						/*if ($row[1]==null)
							{
								echo '
								
								<div align = "center">
								<form action="customers.php" method="post">
								<input type="hidden" name="addCustomer" value="addCustomer"/>
								<input type="submit" value="Add Customer"/>
								</form>
								</div>';
							} */

						?>
					</td>
				</tr>
				
				<tr>
					<td>
						Stand Name:
					</td>
					<td>
						
						<select name = "standName">
						<?php
						$result = mysql_query("SELECT * FROM customers_table,stands_table WHERE customers_table.stand_id = stands_table.stand_id");
						while($row = mysql_fetch_array($result))
						{
							echo '<option  value='.$row[5].'>'.$row[8].'</option>';
						}
						?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td>
						Financer Name:
					</td>
					<td>
						<!--<input type="text" name="outlet_address" size="60" maxlength="50"/>-->
						<select name = "financerName">
						<?php
						$result = mysql_query("SELECT * FROM financers_table");
						while($row = mysql_fetch_array($result))
						{
							if($row[2]==1)
							echo '<option  value='.$row[0].'>'.$row[1].'</option>';
						}
						?>
						</select>
					</td>
					<td>
						Financed Amount:
					</td>
					<td>
						<input type="text" name="financedAmount" size="15" maxlength="7"/>
					</td>
				</tr>
				<tr>
					<td>
						Seller's Name:
					</td>
					<td>
						<!--<input type="text" name="outlet_address" size="60" maxlength="50"/>-->
						<select name = "userName">
						<?php
						$result = mysql_query("SELECT * FROM users_table");
						while($row = mysql_fetch_array($result))
						{
							if($row[4]==1)
							echo '<option  value='.$row[0].'>'.$row[1].'</option>';
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Refrencer Name:
					</td>
					<td>
						<!--<input type="text" name="outlet_address" size="60" maxlength="50"/>-->
						<select name = "refrencerName">
						<option value="1"></option>
						<?php
						$result = mysql_query("SELECT * FROM referencer_table,stands_table WHERE referencer_table.stand_id = stands_table.stand_id");
						while($row = mysql_fetch_array($result))
						{
							echo '<option  value='.$row[0].'>'.$row[1].' / '.$row[5].'</option>';
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Date Of Sale (yyyy-mm-dd):
					</td>
					<td>
						<input type="text" name="dateOfSale" size="30" maxlength="20"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Scheme Name:
					</td>
					<td>
						
						<select name = "schemeName" id="schemeAid" onchange="Ajax_Scheme()">
						<option></option>
						<?php
						$result = mysql_query("SELECT * FROM schemes_table");
						while($row = mysql_fetch_array($result))
						{
								if($row[3]==1)
							echo '<option  value='.$row[0].'>'.$row[1].'</option>';
						}
						?>
						</select>
					</td>
				</tr>
				</tr>
				<tr>
					<td>
						Scheme Benefit 
					</td>
					<td >
					<input  type="text" name="scheme_benefit" id="schemeBenifit"/>
					</td>
				</tr>
				<!--<tr>
						<td>
							Recept Number:
						</td>
						<td>
							<input type="text" name="receptNo" size="35" maxlength="30" />
						</td>
					</tr>
				-->
				<tr>
					<td>
					</td>
					<td>
						<input type="hidden" name="insertsale"/>
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>

		</form>

		<?php
	}
	if(isset($_POST['insertsale']))
	{
		 
		$veh_id=$_POST['veh_id'];
		$customerName=$_POST['customerName'];
		$customerName_real=$_POST['customerName_real'];
		$standName=$_POST['standName'];
		$financerName=$_POST['financerName'];
		$userName=$_POST['userName'];
		$refrencerName=$_POST['refrencerName'];
		$dateOfSale=$_POST['dateOfSale'];
		$schemeName=$_POST['schemeName'];
		$financedAmount=$_POST['financedAmount'];
		$offeredOnRoad=$_POST['offeredOnRoad'];
		$receptNo=$_POST['receptNo'];
		$scheme_benefit=$_POST["scheme_benefit"];
		 

		 if ($customerName==null || $customerName=="") 
		 	$customerName=0;
		 
		
		echo '<script type="text/javascript"> alert(" '.$veh_id.',  '.$customerName.','.$standName.','.$financerName.','.$userName.','.$refrencerName.', '.$dateOfSale.' , '.$offeredOnRoad.' , '.$schemeName.' , '.$scheme_benefit.' , '.$financedAmount.'  ");</script>';
		 
		 if ($customerName_real=="same") {
		 	$customerName_real=$customerName;
		 }
		
		mysql_query("UPDATE inventory_table SET status_flag=2 WHERE veh_id=".$veh_id."");
		mysql_query("INSERT INTO sales_table (veh_id , customer_id , financer_id , user_id , referencer_id , date_of_sale , offered_on_road_price , scheme_id , scheme_benefit , financed_amount , recept_no , customer_id_real) VALUES (".$veh_id." ,  ".$customerName." , ".$financerName." , ".$userName." , ".$refrencerName." , '".$dateOfSale."' , ".$offeredOnRoad." , ".$schemeName." , ".$scheme_benefit." , ".$financedAmount." , '".$receptNo."' , ".$customerName_real.")");
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Sale successfully added.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}

	//-----------------------------------------------------------------add new sale -I -----xxxxxxxxxxxxxxxx-------------------------

	$result = mysql_query("SELECT st.sale_id , st.date_of_sale, ct.customer_name, sta.stand_name, st.veh_id, st.offered_on_road_price, ft.financer_name,  st.financed_amount , sch.scheme_name , st.scheme_benefit, ut.username, rt.referencer_name ,  st.recept_no  FROM sales_table as st,customers_table as ct,stands_table as sta,financers_table as ft, users_table as ut, referencer_table as rt, schemes_table as sch WHERE st.customer_id_real=ct.customer_id  AND st.financer_id=ft.financer_id AND st.user_id=ut.user_id AND st.referencer_id=rt.referencer_id AND st.scheme_id=sch.scheme_id AND ct.stand_id=sta.stand_id ORDER BY st.sale_id DESC");




	echo '<table align="center" width="90%">
		<tr>
	
		<th>Sale Id</th>
		<th>Date Of Sale </th>
		
		<th>Customer Name</th>
		<th>Stand Name</th>
		<th> Vehicle Details </th>
		<th>Offered On Road Price</th>
		<th>Financer Name ------ Amount</th>
		<th>Scheme Name ------ Benefit</th>
		<th>Seller\'s Name</th>
		<th>Refrer Name</th>
		<th>Recept NO</th>
		<th>Account Details  Paid -------- Balance</th>

		<th></th>
		</tr>';

 
	while ($row = mysql_fetch_array($result))
	{ 
			$result_acc = mysql_query("SELECT sum(lt.amt) , st.offered_on_road_price - sch.benefit - st.financed_amount - SUM(lt.amt) +5000 FROM sales_table as st , ledger_table as lt , schemes_table as sch WHERE st.sale_id=lt.sale_id AND st.scheme_id=sch.scheme_id AND  lt.sale_id = ".$row[0]." GROUP BY lt.sale_id");
			$row_acc=mysql_fetch_array($result_acc);
		 
		
		
		echo'
		<tr>
		
		<td> '.$row[0].'</td>
		<td> '.$row[1].'</td>
		<td> '.$row[2].'</td>
		<td> '.$row[3].'</td>';
		echo ' <td> 
				<table>';     //Displaying Vehical details
				$result_detailsTable=mysql_query("SELECT * FROM inventory_table,products_table WHERE inventory_table.product_id = products_table.product_id");
				while($row_detailsTable=mysql_fetch_array($result_detailsTable))
					{																// Displaying product name and engine no and chassis no
						if($row_detailsTable[0] == $row[4])
							{
				  				
								echo'
									 <tr>
						  			 <td >'.$row_detailsTable[10].'</td>
						  			 </tr>
						  			 <tr>
					
								 	 <td align=center >'.$row_detailsTable[2].'</td>
									 </tr>
									 <tr>
					
								 	 <td align=center >'.$row_detailsTable[3].'</td>
									 </tr>
					  				 
								 ';
								 break;
							}

					}
		echo '	</table>
				</td>
		<td> '.$row[5].'</td>

		
		
		<td> 
				<table>
					<tr>'.$row[6].' </tr>
					<tr> '.$row[7].'</tr>
				</table>
		</td>
		<td> 
				<table>
					<tr>'.$row[8].' </tr>
					<tr> '.$row[9].'</tr>
				</table>
		</td>
		<td> '.$row[10].'</td>
		<td> '.$row[11].'</td>
		

		
		
		<td> '.$row[12].'</td>
		';
		if($row[12]==0)
		{
			$acc= $row[8]-$row[11]-$row[10]+5000;
			echo '<td> 
				<table>
					<tr> '.$acc.'</tr>
				</table>
		</td>';
		}
		else
		{
			echo '
		<td> 
				<table>
					<tr>'.$row_acc[1].' </tr>
					<tr> '.$row_acc[0].'</tr>
				</table>
		</td>';	
		 }
			 
			 
		
		
			echo ' <td align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="editing" value="editing"/>
				<input Type="hidden" name="sale_id_to_edit" value="'.$row[0].'"/>
				<input type="submit" value="Edit"/>
			</form>
			</td>
	
		</tr>';
	}


	echo '</table>';
}
include 'footer.php';
?>