<?php
/* php & mysqldb connection file */
$user = "root"; // mysqlusername
$pass = ""; // mysqlpassword
$host = "localhost"; // Server name/IP address
$dbname = "sadaqahcrowdfunding"; // Database name

$con = mysqli_connect($host, $user, $pass, $dbname) or die(mysqli_error($con));
