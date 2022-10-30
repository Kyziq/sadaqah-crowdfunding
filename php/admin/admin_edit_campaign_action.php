<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Campaign</title>
    <link rel="icon" href="../../images/logo-LZNK.ico">

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

            if (($_FILES['campaignFileBanner']['name'] == "")) {
                $fileExt = pathinfo($campaignBannerDir, PATHINFO_EXTENSION);
                $campaignNewBanner = "../../images/campaign/" . $campaignName . "-"  . $campaignCreatedDate . "." . $fileExt;
                rename($campaignBannerDir, $campaignNewBanner);

                $query = "UPDATE campaign SET campaign_name=?, campaign_description=?, campaign_banner=?, campaign_category_id=?, campaign_raised=?, campaign_amount=?, campaign_start=?, campaign_end=?, campaign_admin_id=? WHERE campaign_id=?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("sssiddssii", $campaignName, $campaignDesc, $campaignNewBanner, $campaignCategory, $campaignRaised, $campaignAmount, $startDate, $endDate, $campaignAdminId, $campaignId);
                $stmt->execute();
            } else {
                unlink($campaignBannerDir); // Delete File
                // Upload image (where file name is campaignName-date.extension)
                $fileExt  = pathinfo($_FILES["campaignFileBanner"]["name"], PATHINFO_EXTENSION);
                $target_dir = "../../images/campaign/";
                $campaignNewBanner = $target_dir . $campaignName . "-"  . $campaignCreatedDate . "." . $fileExt;
                $file_name = $campaignName . "-" . $campaignCreatedDate  . "." . $fileExt;
                $target_file = $target_dir . $file_name;
                $source = $_FILES["campaignFileBanner"]["tmp_name"];

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // file type to lowercase

                // Check if image file is a actual image or fake image
                $check = getImageSize($source);
                if ($check !== false) // Check if file is an image
                    $uploadOk = 1;
                else
                    $uploadOk = 0;

                if ($_FILES["campaignFileBanner"]["size"] > 10000000) // Check file size (10000000 = 10MB)
                    $uploadOk = 0;

                if ($imageFileType != "png" && $imageFileType != "jpg" && $imageFileType != "jpeg") // Allow certain file formats
                    $uploadOk = 0;

                if ($uploadOk == 0) {
                    header("Location: admin_edit_campaign.php");
                } else {
                    if (move_uploaded_file($_FILES["campaignFileBanner"]["tmp_name"], $target_file)) {
                        $query = "UPDATE campaign SET campaign_name=?, campaign_description=?, campaign_banner=?, campaign_category_id=?, campaign_raised=?, campaign_amount=?, campaign_start=?, campaign_end=?, campaign_admin_id=? WHERE campaign_id=?";
                        $stmt = $con->prepare($query);
                        $stmt->bind_param("sssiddssii", $campaignName, $campaignDesc, $campaignNewBanner, $campaignCategory, $campaignRaised, $campaignAmount, $startDate, $endDate, $campaignAdminId, $campaignId);
                        $stmt->execute();
                    }
                }
            }
    ?>
            <!-- Success Popup -->
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '<?php echo $campaignName; ?>',
                    text: 'Campaign ID (<?php echo $campaignId; ?>) has been successfully edited.',
                    footer: '(Auto close in 5 seconds)',
                    showConfirmButton: true,
                    confirmButtonText: 'Confirm',
                    backdrop: `#1E976B`,
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