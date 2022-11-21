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
    /* Start session and validate donator */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 3) {
        if (isset($_POST['donatorDonateButton'])) {
            /* DB Connect and Setting */
            include_once '../dbcon.php';

            $donate_status = 3; // 3 = Pending
            $admin_id = 1; // 1 = Default admin (which admin verify later in verification)
            $date = date('--Y-m-d--H-i-s');
            $donator_id = $_SESSION["user_id"];

            $donate_date = date("Y-m-d H:i:s");
            /* Get all the posted items */
            $campaign_name = $_POST['campaign_name'];
            $user_username = $_POST['user_username'];
            $donate_amount = $_POST['donate_amount'];
            $campaign_id = $_POST['campaign_id'];

            /* Upload File */
            $fileExt  = strtolower(pathinfo($_FILES["donate_proof"]["name"], PATHINFO_EXTENSION));
            $target_dir = "../../images/donation-proof/";
            $file_name = $user_username . "--campaignID" . $campaign_id . $date . "." . $fileExt; // username--campaignid--date.ext
            $target_file = $target_dir . $file_name;

            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // file type to lowercase

            $uploadOk = 1;
            /* Condition */
            if (file_exists($target_file)) { // Check if file already exists
                $uploadOk = 1;
            }
            if ($_FILES["donate_proof"]["size"] > 10000000) { // Check file size (10000000 = 10MB)
                $uploadOk = 2;
            }
            if ($imageFileType != "pdf" && $imageFileType != "png" && $imageFileType != "jpg" && $imageFileType != "jpeg") { // Allow certain file formats
                $uploadOk = 3;
            }
            /* End Condition */

            // Success Popup (SweetAlert2)
            function successPopup()
            {
    ?>
                <!-- Success Popup -->
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: '<?php echo $GLOBALS['campaign_name']; ?>',
                        text: 'Your total donation of RM<?php echo $GLOBALS['donate_amount'] ?> has been processed. Please wait for it to be verified.',
                        footer: '(Auto close in 10 seconds)',
                        showConfirmButton: true,
                        confirmButtonText: 'Confirm',
                        backdrop: `#2871f9`,
                        confirmButtonColor: '#0d6efd',
                        timer: 10000,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = 'donator.php';
                        }
                    })
                </script>
            <?php
            }

            // Error Popup (SweetAlert2)
            function errorPopup($uploadOk)
            {
                if ($uploadOk == 1) {
                    $text = "Error. File already exists.";
                } else if ($uploadOk == 2) {
                    $text = "Error. Your file is too large.";
                } else if ($uploadOk == 3) {
                    $text = "Error. Only PNG, JPG, JPEG and PDF file formats are allowed.";
                } else {
                    $text = "Error. There was an error uploading your file.";
                }
            ?>
                <!-- Error Popup -->
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '<?php echo $text; ?>',
                        footer: '(Auto close in 5 seconds)',
                        showConfirmButton: true,
                        confirmButtonText: 'Confirm',
                        backdrop: `#2871f9`,
                        confirmButtonColor: '#0d6efd',
                        timer: 5000,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = 'donator_donate.php';
                        }
                    })
                </script>
    <?php
            }
            /* End SweetAlert2 Popup */

            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["donate_proof"]["tmp_name"], $target_file)) {
                    $donate_proof = str_replace("../", "", $target_file); // Remove "../" from the path 

                    /* INSERT Query (donate) */
                    $query = "INSERT INTO donate(donate_amount, donate_date, donate_proof, donate_status, donator_id, admin_id, campaign_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("dssiiii", $donate_amount, $donate_date, $donate_proof, $donate_status, $donator_id, $admin_id, $campaign_id);
                    $stmt->execute();

                    successPopup();

                    /* Close connection */
                    $stmt->close();
                    $con->close();
                } else {
                    errorPopup(100);
                }
            } else {
                errorPopup($uploadOk);
            }
        }
    } else {
        header("Location: ../user_logout.php");
    }
    ?>

</body>

</html>