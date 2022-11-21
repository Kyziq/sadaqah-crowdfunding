<?php
/* PHP & MySQL database connection file */
$user = "root"; // mysqlusername
$pass = ""; // mysqlpassword
$host = "localhost"; // server name/IP address
$dbname = "sadaqahcrowdfunding"; // database name

$con = mysqli_connect($host, $user, $pass, $dbname) or die(mysqli_error($con));

/* Timezone Set */
date_default_timezone_set('Asia/Singapore');
