<?php session_start();
include("../connection.php");

$result = mysql_query("SELECT * FROM owners_table WHERE owner_id = '$owner_id'");
$row = mysql_fetch_array($result);
$owner_name = $row[2];

date_default_timezone_set('Asia/Calcutta');
//echo date('Y-m-d h:i:s');
$currdate = date('Y-m-d H:i:s');

mysql_query("INSERT INTO feedback_response_table VALUES(null,$feedback_id,'$owner_name','$currdate','$comments')");
mysql_query("UPDATE main_table SET response_flag = 1 WHERE feedback_id = $feedback_id");

$result = mysql_query("SELECT * FROM feedback_response_table
							ORDER BY response_id DESC
							LIMIT 1");
$row = mysql_fetch_array($result);

		//formating DATE & TIME for display purpose only
			$timestamp = strtotime($row[3]);

			$responded_on = date('j-M-Y', $timestamp);
echo '
		<tr>
			<td width="20px">
				<strong>By:</strong>
			</td>
			<td width="130px">
				'.$row[2].'
			</td>
			<td width="150px" rowspan="2">
				<textarea rows="4" cols="20" id="commentsId'.$row[1].'" onkeypress="activateSave('.$row[1].')">'.$row[4].'</textarea>
			</td>
		</tr>
		<tr>
			<td>
				<strong>On:</strong>
			</td>
			<td>
				'.$responded_on.'
			</td>
		</tr>';
mysql_close($connect);
?>