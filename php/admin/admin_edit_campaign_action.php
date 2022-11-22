<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Campaign</title>
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
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 1) {
        /* Check if create campaign button is clicked */
        if (isset($_POST['editCampaignOneButton'])) {
            /* DB Connect and Setting */
            include_once '../dbcon.php';

            $target_dir = "../../images/campaign/"; // Target directory
            $campaignCreatedDate = date('--Y-m-d--H-i-s', strtotime($_POST['campaignCreatedDate']));
            $campaignAdminId = $_SESSION['user_id'];
            /* Get all the posted items */
            $campaignId = $_POST['campaignId'];
            $campaignName = $_POST['campaignName'];
            $campaignDesc = $_POST['campaignDesc'];
            $campaignBannerDir = $_POST['campaignBannerDir'];
            $campaignCategory = $_POST['campaignCategory'];
            $campaignRaised = $_POST['campaignRaised'];
            $campaignAmount = $_POST['campaignAmount'];
            $startDate = $_POST['startDate'];
            $endDate  = $_POST['endDate'];

            /* SweetAlert2 */
            // Success Popup
            function successPopup()
            {
    ?>
                <!-- Success Popup -->
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: '<?php echo $GLOBALS['campaignName']; ?>',
                        text: 'Campaign ID (<?php echo $GLOBALS['campaignId']; ?>) has been successfully edited.',
                        footer: '(Auto close in 5 seconds)',
                        showConfirmButton: true,
                        confirmButtonText: 'Confirm',
                        backdrop: `#2871f9`,
                        confirmButtonColor: '#0d6efd',
                        timer: 5000,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = 'admin_edit_campaign.php';
                        }
                    })
                </script>
            <?php
            }
            // Error Popup
            $uploadOk = 1; // Valid Condition
            function errorPopup($uploadOk)
            {
                if ($uploadOk == 2) {
                    $text = "Error. Image file is a actual image or fake image.";
                } else if ($uploadOk == 3) {
                    $text = "Error. File already exists.";
                } else if ($uploadOk == 4) {
                    $text = "Error. Your file is too large.";
                } else if ($uploadOk == 5) {
                    $text = "Error. Only PNG, JPG, and JPEG files are allowed.";
                } else if ($uploadOk == 6) {
                    $text = "Error. Start date of the campaign cannot be later than the finish date.";
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
                            window.location.href = 'admin_edit_campaign.php';
                        }
                    })
                </script>
    <?php
            }
            /* End SweetAlert2 */

            // No file inputted (Rename existing file)
            if (($_FILES['campaignFileBanner']['name'] == "")) {
                $fileExt = strtolower(pathinfo($campaignBannerDir, PATHINFO_EXTENSION));
                $campaignNewBanner = $target_dir . $campaignName  . $campaignCreatedDate . "." . $fileExt;

                rename("../../" . $campaignBannerDir, $campaignNewBanner); // Rename

                /* UPDATE Query */
                $campaignNewBanner = str_replace("../", "", $campaignNewBanner); // Remove "../" from the path 

                $query = "UPDATE campaign SET campaign_name=?, campaign_description=?, campaign_banner=?, campaign_category_id=?, campaign_raised=?, campaign_amount=?, campaign_start=?, campaign_end=?, campaign_admin_id=? WHERE campaign_id=?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("sssiddssii", $campaignName, $campaignDesc, $campaignNewBanner, $campaignCategory, $campaignRaised, $campaignAmount, $startDate, $endDate, $campaignAdminId, $campaignId);
                $stmt->execute();

                successPopup();
            }
            // File inputted (Delete file and upload new file)
            else {
                unlink("../../" . $campaignBannerDir); // Delete

                $fileExt  = strtolower(pathinfo($_FILES["campaignFileBanner"]["name"], PATHINFO_EXTENSION));
                $campaignNewBanner = $target_dir . $campaignName  . $campaignCreatedDate . "." . $fileExt; // Upload image (where file name is campaignName--date.ext)
                $campaignNewBannerDir = str_replace("../", "", $campaignNewBanner); // Remove "../" from the path 

                /* Condition */
                $source = $_FILES["campaignFileBanner"]["tmp_name"];
                if (getImageSize($source) !== false) { // Check if image file is a actual image or fake image
                    $uploadOk = 1; // Valid condition
                } else {
                    $uploadOk = 2;
                }
                if (file_exists($campaignNewBanner)) { // Check if file already exists
                    $uploadOk = 3;
                }
                if ($_FILES["campaignFileBanner"]["size"] > 10000000) { // Check file size (10000000 = 10MB)
                    $uploadOk = 4;
                }
                if ($fileExt != "png" && $fileExt != "jpg" && $fileExt != "jpeg") { // Allow certain file formats
                    $uploadOk = 5;
                }
                if ($startDate > $endDate) { // Start date cannot exceed end date
                    $uploadOk = 6;
                }
                /* End Condition */

                /* If valid condition */
                if ($uploadOk == 1) {
                    if (move_uploaded_file($_FILES["campaignFileBanner"]["tmp_name"], $campaignNewBanner)) {
                        /* UPDATE Query */
                        $query = "UPDATE campaign SET campaign_name=?, campaign_description=?, campaign_banner=?, campaign_category_id=?, campaign_raised=?, campaign_amount=?, campaign_start=?, campaign_end=?, campaign_admin_id=? WHERE campaign_id=?";
                        $stmt = $con->prepare($query);
                        $stmt->bind_param("sssiddssii", $campaignName, $campaignDesc, $campaignNewBannerDir, $campaignCategory, $campaignRaised, $campaignAmount, $startDate, $endDate, $campaignAdminId, $campaignId);
                        $stmt->execute();

                        successPopup();
                    } else {
                        errorPopup(100);
                    }
                } else {
                    errorPopup($uploadOk);
                }
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