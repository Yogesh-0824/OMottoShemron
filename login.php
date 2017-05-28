<?php session_start();

include("../connection.php");


$result = mysql_query("SELECT portal_status FROM control_table");
$row = mysql_fetch_array($result);

if ($row[0] == 1) {
      # code...


    $username = $_POST["username"];
    $password = $_POST["password"];
    $result = mysql_query("SELECT * FROM users_table  where username like '".$username."' and password like '".$password."' AND active_flag = 1 ");
    
    $count = mysql_num_rows($result);

    if ($count == 1)
    {
    while($row = mysql_fetch_array($result))
      {
      $_SESSION['username'] = $row['username'];
      $_SESSION['user_type'] = $row['user_type'];
      header("Location:home.php");
      }
    }

    else if($count == 0)

      echo '
            <html>
            <head>

            <style>
            body
            {
            background-image:url("photos/sky.png");
            background-repeat:repeat-x;
            background-position:right top;
            margin-right:0px;
            }
            </style>
    
            </head>
            <body>
              <div>
                <div align="left">
                  <!--<img src="photos/logo.png" width="500" height = "200" />-->
                </div>
                <br/><div align="center">
                  Invalid Owner ID or password. Please <a href="index.php"><small>Try Again</small></a>...
                </div><br/><br/>
              </div>
              </body>
              </html>';

    else
      echo 'Some error happened, please contact the administrator.';
}
else{

echo '
<html>
<head>

<style>
body
{
background-image:url("photos/sky.png");
background-repeat:repeat-x;
background-position:right top;
margin-right:0px;
}
</style>

</head>
<body>
  <div>
    <div align="left">
      <img src="photos/logo.png" width="500" height = "200" />
    </div>
    <br/><div align="center">
      Sorry for inconveience, but the portal is under maintenance.
      <br/><a href="index.php"><small>Try Again</small></a>...
    </div><br/><br/>
  </div>
  </body>
  </html>';


}

mysql_close($connect);
?>