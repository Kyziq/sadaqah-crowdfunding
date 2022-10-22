<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donator Dashboard</title>
</head>

<body>
    <?php
    /* Start session and validate donator */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 3) {
        include_once '../dbcon.php'; // Connect to database 
        $query = "SELECT * FROM user WHERE user_id=?"; // SQL with parameter for user ID
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result(); // Get the MySQLi result
        $r = $result->fetch_assoc(); // Fetch data  
    } else {
        header("Location: ../user_login.php");
    }
    ?>
    Welcome to donator dashboard, <?php echo $r['user_name']; ?>
    <br><a href="../user_edit_detail.php">Edit My Detail</a>
    <br><a href="../../index.php">Donate</a>
    <br><a href="../user_logout.php">Log Out</a>

    <?php
    if (isset($result) && is_resource($result)) {
        mysqli_free_result($result);  // Release returned data
    }
    mysqli_close($con); // Close connection
    ?>
</body>

</html>