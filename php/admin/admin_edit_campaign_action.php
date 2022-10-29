<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edited Campaign</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!-- Sweet Alert 2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 1) {
        /** Check if create campaign button is clicked **/
        if (isset($_POST['edit-campaign-button'])) {
            include_once '../dbcon.php'; // Connect to database

            /* Get all the posted items */
            $campaignCreatedDate = date('Y-m-d', strtotime($_POST['campaignCreatedDate']));
            $campaignId = $_POST['campaignId'];
            $campaignName = $_POST['campaignName'];
            $campaignDesc = $_POST['campaignDesc'];

            $campaignBannerDir = $_POST['campaignBannerDir'];
            $campaignCategory = $_POST['campaignCategory'];
            $campaignRaised = $_POST['campaignRaised'];
            $campaignAmount = $_POST['campaignAmount'];
            $startDate = $_POST['startDate'];
            $endDate  = $_POST['endDate'];
            $campaignAdminId = $_SESSION['user_id'];

            /* Query */
            $query = "UPDATE user SET user_username=?, user_name=?, user_email=?, user_phone=?, user_address=? WHERE user_id=?"; // SQL with parameters
            $stmt = $con->prepare($query);
            $stmt->bind_param("sssssi", $user_username, $user_name, $user_email, $user_phone, $user_address, $user_id);
            $stmt->execute();

            if (file_exists($campaignBannerDir)) {
                $fileExt = pathinfo($campaignBannerDir, PATHINFO_EXTENSION);
                $newFile = $campaignName . "-"  . $campaignCreatedDate . "." . $fileExt;
                rename($campaignBannerDir, "../../images/campaign/" . $newFile);

                $query = "UPDATE campaign SET campaign_name=?, campaign_description=?, campaign_category_id=?, campaign_raised=?, campaign_amount=?, campaign_start=?, campaign_end=?, campaign_admin_id=? WHERE campaign_id=?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("ssiddssii", $campaignName, $campaignDesc, $campaignCategory, $campaignRaised, $campaignAmount, $startDate, $endDate, $campaignAdminId, $campaignId);
                $stmt->execute();
            } else {
                $query = "UPDATE campaign SET campaign_name=?, campaign_description=?, campaign_banner=?, campaign_category_id=?, campaign_raised=?, campaign_amount=?, campaign_start=?, campaign_end=?, campaign_admin_id=? WHERE campaign_id=?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("sssiddssii", $campaignName, $campaignDesc, $campaignBannerDir, $campaignCategory, $campaignRaised, $campaignAmount, $startDate, $endDate, $campaignAdminId, $campaignId);
                $stmt->execute();

                // TODO DELETE FILE, CREATE NEW FILE
            }

    ?>
            <!-- Success Popup -->
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Campaign ID (<?php echo $campaignId; ?>) has been successfully edited.',
                    text: '(Auto close in 5 seconds)',
                    showConfirmButton: true,
                    confirmButtonText: 'Confirm',
                    backdrop: `#192e59`,
                    timer: 5000,
                    willClose: () => {
                        window.location.href = 'admin_edit_campaign.php';
                    }
                })
            </script>
    <?php
            // Close connection
            $stmt->close();
            $con->close();
        }
    } else {
        header("Location: ../user_logout.php");
    }
    ?>
</body>

</html>