<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="icon" href="../../images/logo-LZNK.ico">

    <!-- Imports -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    /* Start session and validate admin */
    session_start();
    if (isset($_SESSION['user_id']) &&  $_SESSION['user_level'] == 1) {
        /* Check if edit user button clicked */
        if (isset($_POST["editUserButton"])) {
            /* DB Connect and Setting */
            include_once '../dbcon.php';

            /* Get all the posted items */
            $id = $_POST["editUserButton"];
            $username = $_POST["username"];
            $name = $_POST["name"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $address = $_POST["address"];
            $level = $_POST["level"];

            /* UPDATE Query */
            $query = "UPDATE user SET user_username=?, user_name=?, user_email=?, user_phone=?, user_address=? WHERE user_id=?"; // SQL with parameters
            $stmt = $con->prepare($query);
            $stmt->bind_param("sssssi", $username, $name, $email, $phone, $address, $id);
            $stmt->execute();

    ?>
            <!-- Success Popup -->
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'New account details for <?php echo $name; ?> has been saved successfully.',
                    footer: '(Auto close in 5 seconds)',
                    showConfirmButton: true,
                    confirmButtonText: 'Confirm',
                    backdrop: `#2871f9`,
                    confirmButtonColor: '#0d6efd',
                    timer: 5000,
                    timerProgressBar: true,
                    willClose: () => {
                        <?php
                        $type = $level == 2 ? 'Auditor' : ($level == 3 ? 'Donator' : '');
                        echo "window.location.href = 'admin_edit_user.php?type=" . $type . "';";
                        ?>
                    }
                })
            </script>
    <?php
            /* Close connection */
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