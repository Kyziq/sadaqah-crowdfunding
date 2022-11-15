<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Donation</title>

    <link rel="icon" href="../../images/logo-LZNK.ico">

    <!-- Imports -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    /* Start session and validate admin */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 1) {
        /* Check if verify donation button is clicked */
        if (isset($_POST['verifyDonationButton'])) {
            /* DB Connect and Setting */
            include_once '../dbcon.php';
            date_default_timezone_set('Asia/Singapore');

            /* Get all the posted items */
            $donateId = $_POST['donateId'];
            $donatorName = $_POST['donatorName'];
            $donateStatus = $_POST['donateStatus'];
            $adminId = $_SESSION['user_id'];
            $campaignName = $_POST['campaignName'];

            $campaignId = $_POST['campaignId'];
            $donateAmount = $_POST['donateAmount'];

            /* UPDATE Query for donate table */
            $query = "UPDATE donate SET donate_status=?, admin_id=? WHERE donate_id=?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("iii", $donateStatus, $adminId, $donateId);
            $stmt->execute();

            /* UPDATE Query for campaign table */
            $query = "UPDATE campaign SET campaign_raised=campaign_raised+? WHERE campaign_id=?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("di", $donateAmount, $campaignId);
            $stmt->execute();

    ?>
            <!-- Success Popup -->
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Donation from <?php echo $donatorName; ?> has been verified!',
                    text: 'A total amount of RM<?php echo $donateAmount; ?> has been successfully added to campaign <?php echo $campaignName; ?>.',
                    footer: '(Auto close in 10 seconds)',
                    showConfirmButton: true,
                    confirmButtonText: 'Confirm',
                    backdrop: `#2871f9`,
                    confirmButtonColor: '#0d6efd',
                    timer: 10000,
                    willClose: () => {
                        window.location.href = 'admin_verify_donation.php';
                    }
                })
            </script>
    <?php
            /* Close connection */
            $stmt->close();
            $con->close();
        }
    } else {
        header("Location: ../user_logout.php");
    }
    ?>
</body>

</html>