<?php session_start();
include 'header.php';
//require_once('calendar/classes/tc_calendar.php');

if(isset($_SESSION['username']))
{

	echo '<table align="center" width="90%">
		<tr>
		<th width="50px">S.No.</th>
		<th>Salesman</th>
		<th>Hot Leads</th>
		<th>Warm Leads</th>
		<th>Cold Leads</th>
		<th>Lost Leads</th>
		<th>New Leads</th>
		<th>Contacted Leads</th>
		<th>Action</th>
		</tr>
	</table>';
}
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


function testAJAX()
{	
	variable=document.getElementById("textField").value;
	
	//alert(variable);

	loadXMLDoc("offeredOnRoad.php", function()
		{
			if(xmlhttp.readyState=4 && xmlhttp.status==200)
			{
				document.getElementById("table").innerHTML=xmlhttp.responseText;
			}
		});
}


function testMethod()
{
	document.getElementById("table").innerHTML="<tr><td>bruua</td><tr>";
	document.getElementById("textField").value="haha";
}
</script>
<?php 
echo'
<table id="table">
	<tr>
		<td>Test</td>
	</tr>
</table>
<select id="textField" onChange="testAJAX()">
<option value="test">test</option>
<option value="test 2">test 2</option>
</select>
<input type="submit" value="button" onClick="testAJAX()"/>';
?>



<?php
include 'footer.php';
?>