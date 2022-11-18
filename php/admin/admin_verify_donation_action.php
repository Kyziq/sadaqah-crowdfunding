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

            $adminId = $_SESSION['user_id'];
            $donateStatusDate = date("Y-m-d H:i:s");
            /* Get all the posted items */
            $donateId = $_POST['donateId'];
            $donatorName = $_POST['donatorName'];
            $donateStatus = $_POST['donateStatus'];
            $campaignName = $_POST['campaignName'];
            $campaignId = $_POST['campaignId'];
            $donateAmount = $_POST['donateAmount'];

            function popup($type)
            {
                $campaignName = $_POST['campaignName'];
                $donatorName = $_POST['donatorName'];
                $donateAmount = $_POST['donateAmount'];
                if ($type == "accepted") {
                    $icon = "success";
                    $title = "Donation from " . $donatorName . " has been accepted!";
                    $text = "A total amount of RM" . $donateAmount . " has been successfully added to campaign " . $campaignName . ".";
                } else if ($type == "declined") {
                    $icon = "error";
                    $title = "Donation from " . $donatorName . " has been declined!";
                    $text = "A total amount of RM" . $donateAmount . " will not be added to campaign " . $campaignName . ".";
                }
    ?>
                <script>
                    Swal.fire({
                        icon: '<?php echo $icon; ?>',
                        title: '<?php echo $title; ?>',
                        text: '<?php echo $text; ?>',
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
            }
            /* UPDATE Query for donate table */
            $query = "UPDATE donate SET donate_status=?, donate_status_date=?, admin_id=? WHERE donate_id=?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("isii", $donateStatus, $donateStatusDate, $adminId, $donateId);
            $stmt->execute();

            if ($donateStatus == 1) { // Accepted
                /* UPDATE Query for campaign table (increase campaign total raised) */
                $query = "UPDATE campaign SET campaign_raised=campaign_raised+? WHERE campaign_id=?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("di", $donateAmount, $campaignId);
                $stmt->execute();
                popup("accepted");
            } else if ($donateStatus == 2) { // Declined
                popup("declined");
            }

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