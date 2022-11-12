<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Page</title>
    <link rel="icon" href="../../images/logo-LZNK.ico">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!-- Sweet Alert 2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    /* Start session and validate donator login */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 3) {
        if (isset($_POST['donate-button'])) {
            include("../dbcon.php");
            date_default_timezone_set('Asia/Singapore');

            /* Get all the posted items */
            $campaign_name = $_POST['campaign_name'];
            $user_username = $_POST['user_username'];

            $donate_amount = $_POST['donate_amount'];
            $donator_id = $_SESSION["user_id"];
            $donate_status = 3; // 3 = Pending
            $admin_id = 1; // 1 = Default admin (which admin verify later in verification)
            $campaign_id = $_POST['campaign_id'];

            /* File Upload */
            $date = date('--Y-m-d--H-i-s');

            /* Upload File */
            $extension  = strtolower(pathinfo($_FILES["donate_proof"]["name"], PATHINFO_EXTENSION));
            $target_dir = "../../images/donation-proof/";
            $file_name = $user_username . "-campaignID" . $campaign_id . $date . "." . $extension; // username-campaignid-date.extension
            $target_file = $target_dir . $file_name;
            $source = $_FILES["donate_proof"]["tmp_name"];

            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // file type to lowercase

            if ($_FILES["donate_proof"]["size"] > 10000000) // Check file size (10000000 = 10MB)
                $uploadOk = 0;
            if ($imageFileType != "pdf" && $imageFileType != "png" && $imageFileType != "jpg" && $imageFileType != "jpeg") // Allow certain file formats
                $uploadOk = 0;

            if ($uploadOk == 0) { // Check if $uploadOk is set to 0 by an error
                header("Location: donator_donate.php");
            } else {
                if (move_uploaded_file($_FILES["donate_proof"]["tmp_name"], $target_file)) {
                    $donate_proof = str_replace("../", "", $target_file); // Remove "../" from the path 

                    /* Construct and run query to insert donation data */
                    $query = "INSERT INTO donate(donate_amount, donate_proof, donate_status, donator_id, admin_id, campaign_id) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("dsiiii", $donate_amount, $donate_proof, $donate_status, $donator_id, $admin_id, $campaign_id);
                    $stmt->execute();
    ?>
                    <!-- Success Popup -->
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: '<?php echo $campaign_name; ?>',
                            text: 'Your donation for  has been processed. Please wait for it to be verified.',
                            footer: '(Auto close in 10 seconds)',
                            showConfirmButton: true,
                            confirmButtonText: 'Confirm',
                            backdrop: `#2871f9`,
                            confirmButtonColor: '#0d6efd',
                            timer: 10000,
                            willClose: () => {
                                window.location.href = 'donator.php';
                            }
                        })
                    </script>
    <?php

                    // Close connection
                    $stmt->close();
                    $con->close();
                } else {
                    header("Location: donator_donate.php");
                }
            }
        }
    } else {
        header("Location: ../user_logout.php");
    }
    ?>

</body>

</html>