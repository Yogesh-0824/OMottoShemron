<?php error_reporting(0); ?>
<html>
<head>
   <style>
   body
	{
	background-image:url('photos/sky.png');
	background-repeat:repeat-x;
	background-position:right top;
	margin-right:0px;
	}
	 
    table {border-collapse:collapse; table-layout:fixed; border:0px;}
    table td { word-wrap:break-word;}

    th {
	    background-color:#ff9900;
	    border: 1px solid black;
	}
    td {
	    border: 0px solid black;
	}
	.oddrow
	{
		background-color:#60e4fd; 
	}
	.evenrow
	{
		background-color: #58b1fd;
	}
   </style>
</head>
<script language="javascript" src="calendar/calendar.js"></script>
<body>
<!-- background="photos/background.jpg" -->
<!-- 
old color selection (Blue)
0179CA
1B91F7
0FD2F7

old color selection
A46F43
F6B84F
F2E989
//previous colors: browns - - EDEDD4, CCC7BF, EEEDEA
-->
<table align="center" width="100%">
	<tr>
		<td>
			<!-- <img src="http://ratings4.me/advancedfeedbacksystem/restaurantportal/ownerportal/photos/logo.png" height = "150" width="325"/> -->
		</td>
		<td>
			<div  align="center">
				<h1>OMotto Admin</h1>
			</div><br/><br/>
		</td>
		<td>
			<div align="right">
			Hi&nbsp;
			 <?php 
			 	if (!isset($_SESSION['username']))
			 	{
			 		echo 'Guest <br/> Please Login with a valid user account.<br/><br/>';
					echo '<a href="index.php"><small>Try Again</small></a>';
			 	}
		     	else
		     	{
					echo $_SESSION['username'].'&nbsp;&nbsp;&nbsp; ';
					echo '<br/>
			<a href="index.php"><small>LogOut</small></a>&nbsp;&nbsp;&nbsp;';
			//<br/><a href="#.php"><small> Manage Password </small></a>
			?>
		</div>
		</td>
	</tr>
	</table>
<br/>

    
   <?php 
   	 $url = $_SERVER['PHP_SELF'];
   		$url = end(explode('/',$url));
    echo '
<table align="center" width="98%" bgcolor="transparent">
<tr><td>
<table align="center" width="50%">
	<tr>
		
		';
		if($_SESSION['user_type']==1)
		{
			echo'<tr align="center">
			<tr></tr>
					<table align="left">
					<th>ADMIN</th>
					
						<td width="100px"><a href="users.php"> Users  </a></td>
					
					
						<td width="100px"><a href="outlets.php"> Outlets </a></td>


						<td width="100px"><a href="stands.php"> Stands </a></td>

					
						<td width="100px"><a href="product.php"> Product</a></td>
						
						
						<td width="100px"><a href="inventory.php">Inventory </a></td>
					
					
						<td width="100px"><a href="insurer.php">Insurer</a></td>
					

						<td width="100px"><a href="referencers.php">Referencers </a></td>


						<td width="100px"><a href="financers.php">Financers </a></td>


						<td width="100px"><a href="schemes.php">Schemes </a></td>


						<td width="100px"><a href="customers.php">Customers </a></td>
					
					
						<td width="100px"><a href="sales.php"> Sales </a></td>
					
					
						<td width="100px"><a href="ledger_account.php">Ledger Acc</a></td>
					
					
						<td width="100px"><a href="ledger.php">Ledger </a></td>
					
					
					</table>
				</tr>';


		}
		if($_SESSION['user_type']<=2)
		{
			echo'<tr align="center">
			<tr></tr>
					<table  align="left">
					<th>MANAGER</th>
					
						<td width="100px"><a href="inventory.php">Inventory </a></td>
					
					
						<td width="100px"><a href="stands.php"> Stands </a></td>
					
					
						<td width="100px"><a href="referencers.php">Referencers </a></td>
									
					
						<td width="100px"><a href="customers.php">Customers </a></td>
					
					
						<td width="100px"><a href="sales.php"> Sales </a></td>
					
					
						<td width="100px"><a href="ledger.php">Ledger </a></td>
					
					</table>
				</tr>';

		}
		if($_SESSION['user_type']<=6)
		{
			echo'<tr align="center">
					<table  align="left">
					<th>TELE-CALLER</th>
					
						<td width="100px"><a href="ledger.php">Ledger </a></td>
					
					
						<td width="100px"><a href="customers.php">Customers </a></td>
					
					
						<td width="100px"><a href="sales.php"> Sales </a></td>

					
					</table>
				</tr>';

		}

		 echo'
		
		
		
	</tr>
	<td><a href="home.php"> Leads </a></td>
	<td width="50px"><a href="home.php"> Home </a></td>
	<tr>
	</tr>
</table>
<div style="margin-top:20px;"></div>
';
		include("../connection.php");

		}
	?>