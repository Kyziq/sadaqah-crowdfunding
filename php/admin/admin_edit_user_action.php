<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="icon" href="../../images/logo-LZNK.ico">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!-- Sweet Alert 2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    /* Start session and validate admin */
    session_start();
    if (isset($_SESSION['user_id']) &&  $_SESSION['user_level'] == 1) {
        /* Check if edit user button clicked */
        if (isset($_POST["edit-user-button"])) {
            include_once '../dbcon.php'; // Connect to database 
            $id = $_POST["edit-user-button"];
            $username = $_POST["username"];
            $name = $_POST["name"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $address = $_POST["address"];
            $level = $_POST["level"];

            $query = "UPDATE user SET user_username=?, user_name=?, user_email=?, user_phone=?, user_address=? WHERE user_id=?"; // SQL with parameters
            $stmt = $con->prepare($query);
            $stmt->bind_param("sssssi", $username, $name, $email, $phone, $address, $id);
            $stmt->execute();
    ?>
            <!-- Success Popup -->
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '<?php echo $name . " (ID " . $id . ")"; ?>',
                    text: 'New account details has been saved successfully.',
                    footer: '(Auto close in 5 seconds)',
                    showConfirmButton: true,
                    confirmButtonText: 'Confirm',
                    backdrop: `#2871f9`,
                    confirmButtonColor: '#0d6efd',
                    timer: 5000,
                    willClose: () => {
                        <?php
                        $type = $level == 2 ? 'Auditor' : ($level == 3 ? 'Donator' : '');
                        echo "window.location.href = 'admin_edit_user.php?type=" . $type . "';";
                        ?>
                    }
                })
            </script>
    <?php
            // Close connection
            $stmt->close();
            $con->close();
        } else {
            header("Location: admin_edit_user.php");
        }
    } else {
        header("Location: ../user_logout.php");
    }
    ?>
</body>

</html>