<?php session_start();
include 'header.php';
//require_once('calendar/classes/tc_calendar.php');
?>

<script>
function validateForm() 
{
	 
    var productName = document.forms["productForm"]["productName"].value;
    var exFactoryPrice = document.forms["productForm"]["exFactoryPrice"].value;
    var freightToShowroom = document.forms["productForm"]["freightToShowroom"].value;
    var margin = document.forms["productForm"]["margin"].value;
    var vat = document.forms["productForm"]["vat_per"].value;
    var exShowroomPrice =  document.forms["productForm"]["exShowroomPrice"].value;
    var registrationCost = document.forms["productForm"]["registrationCost"].value;
    var insuranceCost = document.forms["productForm"]["insuranceCost"].value;
    var onRoadPrice = document.forms["productForm"]["onRoadPrice"].value;
     
    var message="Hello \n";
    if (productName == null || productName == "") 
    {
        message=message+"Enter A valid Product Name \n ";
    }
    if (exFactoryPrice == null || exFactoryPrice == "") 
    {
        message=message+"Enter A valid Ex-Factory Price \n ";
    }
    if (freightToShowroom == null || freightToShowroom == "") 
    {
        message=message+"Enter A valid Freight To Showroom Price \n ";
    }
    
    if (margin == null || margin == "") 
    {
        message=message+"Enter A valid Margin \n ";
    }
    if (vat == null || vat == "") 
    {
        message=message+"Enter A valid Vat \n ";
    }
    if (exShowroomPrice == null || exShowroomPrice == "") 
    {
        message=message+"Enter A valid Ex-Showroom Price \n ";
    }
    if (registrationCost == null || registrationCost == "") 
    {
        message=message+"Enter A valid Registration Cost \n ";
    }
    if (insuranceCost == null || insuranceCost == "") 
    {
        message=message+"Enter A valid Insurance Cost \n ";
    }
    if (onRoadPrice == null || onRoadPrice == "") 
    {
        message=message+"Enter A valid On Road Price \n ";
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
	{	    $productId=$_POST['product_id_to_edit']; 
			$result=mysql_query("SELECT * FROM  products_table WHERE product_id=".$productId."");
			$row=mysql_fetch_array($result);
			
			echo '
			<br/>
			<form action="'. $_SERVER['PHP_SELF'].'"  name="productForm" onsubmit="return validateForm()" method="post">
			<table id="addinsurencetable" width="50%" align="center">
				<tr>
					<td>
						Product Name:
					</td>
					<td>
						<input type="text" name="productName" size="30" maxlength="20" value="'. $row[1] .'" />
					</td>
				</tr>
				<tr>
					<td>
						Ex-Factory Price:
					</td>
					<td>
						<input type="text" name="exFactoryPrice" size="20" maxlength="15" value="'. $row[2] .'" />
					</td>
				</tr>
				<tr>
					<td>
						Freight To Showroom:
					</td>
					<td>
						<input type="text" name="freightToShowroom" size="20" maxlength="15" value="'. $row[3] .'" />
					</td>
				</tr>
				<tr>
					<td>
						Margin:
					</td>
					<td>
						<input type="text" name="margin" size="20" maxlength="15" value="'. $row[4] .'" 
					</td>
				</tr>
				<tr>
					<td>
						Vat:
					</td>
					<td>
						<input type="text" name="vat_per" size="20" maxlength="15" value="'. $row[5] .'" />
					</td>
				</tr>
				
				<tr>
					<td>
						Registration Cost:
					</td>
					<td>
						<input type="text" name="registrationCost" size="20" maxlength="15" value="'. $row[7] .'" />
					</td>
				</tr>
				<tr>
					<td>
						Insurance Cost:
					</td>
					<td>
						<input type="text" name="insuranceCost" size="20" maxlength="15" value="'. $row[8] .'" />
					</td>
				</tr>
				<tr>
					<td>
						Additional Cost:
					</td>
					<td>
						<input type="text" name="additionalCost" size="20" maxlength="15" value="'. $row[9] .'" />
					</td>
				</tr>
				
					';
						
						echo '<input Type="hidden" name="product_id_to_edit" value="'.$productId.'"/>';   //send Id to next page
						
						
						
						?>
					
				</tr>
					<td></td>
					<td align="left">
						<input type="hidden" name="editproduct"/>
						
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
			</form>
		<?php
	}	
if(isset($_POST['editproduct']))
	{  
		$productName=$_POST['productName'];
		$exFactoryPrice=$_POST['exFactoryPrice'];
		$freightToShowroom=$_POST['freightToShowroom'];
		$margin=$_POST['margin'];
		$vat_per=$_POST['vat_per'];
		
		$registrationCost=$_POST['registrationCost'];
		$insuranceCost=$_POST['insuranceCost'];
		$additionalCost=$_POST['additionalCost'];
		
		$productId=$_POST['product_id_to_edit'];
		//echo '<script type="text/javascript">alert("  Query: UPDATE insurers_table  SET insurer_name="'.$insurerName.'" , active_flag='.$activeFlag.'  WHERE insurer_id='.$insurerId.'");</script>';
		$vat= (($ExFactoryPrice + $freightToShowroom + $margin)/100 )*$vat_per;
		$exShowroomPrice= ($ExFactoryPrice + $freightToShowroom + $margin + $vat);
		$onRoadPrice=($exShowroomPrice + $registrationCost +$insuranceCost +$additionalCost);
	
	
		mysql_query("UPDATE products_table  SET product_name='".$productName."' , ex_factory_price='".$exFactoryPrice."' , freight_to_showroom='".$freightToShowroom."' , margin='".$margin."' , vat='".$vat."' , ex_showroom_price='".$exShowroomPrice."' , registration_cost='".$registrationCost."' , insurance_cost='".$insuranceCost."' , additional_cost='".$additionalCost."' , on_road_price='".$onRoadPrice."'  WHERE product_id=".$productId."" );
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Product successfully edited.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}
//---------------------------------------------------------- End Editing ---------------------------------------------------------------	

	//---------------------------------------------------------Add new Product  -------------------------------------------------------
	echo '<div align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="addProduct" value="addProduct"/>
				<input type="submit" value="Add A Product"/>
			</form>
		</div>';

		if(isset($_POST['addProduct']))
	{
		?>
		<br/>
		<form action="<?php $_SERVER['PHP_SELF']?>"  name="productForm" onsubmit="return validateForm()" method="post">
			<table id="addoutlettable" width="50%" align="center">
				<tr>
					<td>
						Product Name:
					</td>
					<td>
						<input type="text" name="productName" size="40" maxlength="30"/>
					</td>
				</tr>
				<tr>
					<td>
						Ex-factory Price:
					</td>
					<td>
						<input type="text" name="exFactoryPrice" size="15" maxlength="10"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Freight To Showroom:
					</td>
					<td>
						<input type="text" name="freightToShowroom" size="15" maxlength="10"/>
					</td>
				</tr>
						
				<tr>
					<td>
						Margin:
					</td>
					<td>
						<input type="text" name="margin" size="15" maxlength="10"/>
					</td>
				</tr>
				<tr>
					<td>
						Vat:
					</td>
					<td>
						<input type="text" name="vat_per" size="15" maxlength="10"  />
					</td>
				</tr>
				
				<tr>
					<td>
						Registration Cost:
					</td>
					<td>
						<input type="text" name="registrationCost" size="15" maxlength="10"/>
					</td>
				</tr>
				<tr>
					<td>
						Insurance Cost:
					</td>
					<td>
						<input type="text" name="insuranceCost" size="15" maxlength="10"/>
					</td>
				</tr>
				<tr>
					<td>
						Additional Cost:
					</td>
					<td>
						<input type="text" name="additionalCost" size="15" maxlength="10"/>
					</td>
				</tr>
				
					<tr>
					<td>
					</td>
					<td>
						<input type="hidden" name="insertproduct"/>
						<input type="submit" value="Submit"/>
					</td>
				</tr>
			</table>
		</form>
		<?php
	}
	if(isset($_POST['insertproduct']))
	{
		$productName=$_POST['productName'];
		$exFactoryPrice=$_POST['exFactoryPrice'];
		$freightToShowroom=$_POST['freightToShowroom'];
		$margin=$_POST['margin'];
		$vat_per=$_POST['vat_per'];
		$registrationCost=$_POST['registrationCost'];
		$insuranceCost=$_POST['insuranceCost'];
		$additionalCost=$_POST['additionalCost'];
		
		$vat= (($exFactoryPrice + $freightToShowroom + $margin)/100 )*$vat_per;
		$exShowroomPrice= ($exFactoryPrice + $freightToShowroom + $margin + $vat);
		$onRoadPrice=($exShowroomPrice + $registrationCost +$insuranceCost +$additionalCost);
		


		mysql_query("INSERT INTO products_table (product_name , ex_factory_price , freight_to_showroom , margin , vat , ex_showroom_price , registration_cost , insurance_cost , additional_cost , on_road_price) VALUES ('".$productName."' , ".$exFactoryPrice." , ".$freightToShowroom." , ".$margin." , ".$vat." , '".$exShowroomPrice."' , ".$registrationCost." , ".$insuranceCost." , ".$additionalCost." , ".$onRoadPrice.")");
		if(mysql_errno()==0)
			echo '<script type="text/javascript">alert("Product successfully added.");</script>';
		else
			echo '<script type="text/javascript">alert("Error occured, Error Code: '.mysql_errno().'.");</script>';
	}

	//-----------------------------------------------------------------add new product -----xxxxxxxxxxxxxxxx-------------------------

	$result = mysql_query("SELECT * FROM products_table");



	echo '<table align="center" width="90%">
		<tr>
		<th width="50px">S.No.</th>
		<th>Product Id</th>
		<th>Product Name</th>  
		<th>Ex-Factory Price </th>
		<th>Freight To Showroom </th>
		<th> Margin </th>
		<th>Vat</th>
		<th>Ex-Showroom Price</th> 
		<th>Registration Cost </th>  
		<th>Insurance Cost</th> 
		<th>Additional Cost</th>
		<th>On Road Price</th>
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
		<td> '.$row[2].'</td>
		<td> '.$row[3].'</td>
		<td> '.$row[4].'</td>
		<td> '.$row[5].'</td>
		<td> '.$row[6].'</td>
		<td> '.$row[7].'</td>
		<td> '.$row[8].'</td>
		<td> '.$row[9].'</td>
		<td> '.$row[10].'</td>
		';
			echo ' <td align = "center">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<input type="hidden" name="editing" value="editing"/>
				<input Type="hidden" name="product_id_to_edit" value="'.$row[0].'"/>
				<input type="submit" value="Edit"/>
			</form>
			</td>
	
		</tr>';
	}

	echo '</table>';
}
include 'footer.php';
?>