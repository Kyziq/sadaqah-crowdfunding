<?php
session_start();
/* Check if login button is clicked */
if (isset($_POST['login-button'])) {
    /* DB Connect and Setting */
    include_once 'dbcon.php';

    /* Get all the posted items */
    $user_username = $_POST['user_username'];
    $user_password = $_POST['user_password'];

    /* Construct and run query to check for correct credentials (prepared statements) */
    $query = "SELECT * FROM user WHERE user_username=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $user_username);
    $stmt->execute();
    $result = $stmt->get_result();
    $r = $result->fetch_assoc();

    if ($r) {
        /* Check if password is correct with hashed password (DB) */
        if (password_verify($user_password, $r['user_password'])) {
            $_SESSION['last_logged_in'] = date('d M Y H:i:s', time());
            setcookie('expire_time', 'time', time() + 30 * 60); // 30 minutes timeout

            $_SESSION['user_id'] = $r['user_id'];
            $_SESSION['user_level'] = $r['user_level'];

            if ($r['user_level'] == 1) {
                header("Location: admin/admin.php");
            } else if ($r['user_level'] == 2) {
                header("Location: auditor/auditor.php");
            } else if ($r['user_level'] == 3) {
                header("Location: donator/donator.php");
            }
        } else {
            header("Location:../index.php?error=password"); // Fail password
        }
    } else {
        header("Location:../index.php?error=username"); // Fail username
    }

    // Close connection
    $stmt->close();
    $con->close();
} else {
    header("Location: ../index.php");
}
