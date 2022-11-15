<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Campaign</title>
    <link rel="icon" href="../../images/logo-LZNK.ico">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!-- Sweet Alert 2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    /* Start session and validate auditor */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 2) {
        /* Verify campaign button is clicked */
        if (isset($_POST['verifyCampaignButton'])) {
            /* DB Connect and Setting */
            include_once '../dbcon.php';
            date_default_timezone_set('Asia/Singapore');

            /* Get all the posted items */
            $campaignName = $_POST['campaignName'];
            $campaignId = $_POST['campaignId'];
            $verificationStatus = $_POST['verificationStatus'];
            $verificationComment = $_POST['verificationComment'];
            $auditorId = $_SESSION['user_id'];

            /* INSERT Query (verification) */
            $query = "INSERT INTO verification(verification_status, verification_comment, campaign_id, auditor_id) VALUES (?, ?, ?, ?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param("isii", $verificationStatus, $verificationComment, $campaignId, $auditorId);
            $stmt->execute();

            /* UPDATE Query (campaign) */
            $query = "UPDATE campaign SET campaign_status=? WHERE campaign_id=?"; // SQL with parameters
            $stmt = $con->prepare($query);
            $stmt->bind_param("ii", $verificationStatus, $campaignId);
            $stmt->execute();

            if ($verificationStatus == 1) { // Accepted
    ?>
                <!-- Success Popup -->
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: '<?php echo $campaignName; ?>',
                        html: 'The campaign has been <span style="color:#198754;">accepted</span>.',
                        footer: '(Auto close in 5 seconds)',
                        showConfirmButton: true,
                        confirmButtonText: 'Confirm',
                        backdrop: `#2871f9`,
                        confirmButtonColor: '#0d6efd',
                        timer: 5000,
                        willClose: () => {
                            window.location.href = 'auditor.php';
                        }
                    })
                </script>
            <?php
            } else if ($verificationStatus == 2) { // Declined
            ?>
                <!-- Success Popup -->
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: '<?php echo $campaignName; ?>',
                        html: 'The campaign has been <span style="color:#dc3545;">declined</span>.',
                        footer: '(Auto close in 5 seconds)',
                        showConfirmButton: true,
                        confirmButtonText: 'Confirm',
                        backdrop: `#2871f9`,
                        confirmButtonColor: '#0d6efd',
                        timer: 5000,
                        willClose: () => {
                            window.location.href = 'auditor.php';
                        }
                    })
                </script>
    <?php
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