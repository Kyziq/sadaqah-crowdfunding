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
        if (isset($_POST['edit-campaign-1-button'])) {
            include_once '../dbcon.php'; // Connect to database
            date_default_timezone_set('Asia/Singapore');

            /* Get all the posted items */
            $campaignCreatedDate = date('--Y-m-d--H-i-s', strtotime($_POST['campaignCreatedDate']));
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

            // If no input file, just rename current file
            if (($_FILES['campaignFileBanner']['name'] == "")) {
                $fileExt = strtolower(pathinfo($campaignBannerDir, PATHINFO_EXTENSION));
                $campaignNewBanner = "../../images/campaign/" . $campaignName  . $campaignCreatedDate . "." . $fileExt;

                rename("../../" . $campaignBannerDir, $campaignNewBanner);

                $campaignNewBanner = str_replace("../", "", $campaignNewBanner); // Remove "../" from the path 

                $query = "UPDATE campaign SET campaign_name=?, campaign_description=?, campaign_banner=?, campaign_category_id=?, campaign_raised=?, campaign_amount=?, campaign_start=?, campaign_end=?, campaign_admin_id=? WHERE campaign_id=?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("sssiddssii", $campaignName, $campaignDesc, $campaignNewBanner, $campaignCategory, $campaignRaised, $campaignAmount, $startDate, $endDate, $campaignAdminId, $campaignId);
                $stmt->execute();
            }
            // If input file
            else {
                unlink("../../" . $campaignBannerDir); // Delete file

                $fileExt  = strtolower(pathinfo($_FILES["campaignFileBanner"]["name"], PATHINFO_EXTENSION));
                $target_dir = "../../images/campaign/"; // Target directory

                $campaignNewBanner = $campaignName . $campaignCreatedDate  . "." . $fileExt; // Upload image (where file name is campaignName-date.ext)

                $campaignNewBannerDir = $target_dir . $campaignName  . $campaignCreatedDate . "." . $fileExt;
                $campaignNewBannerDir = str_replace("../", "", $campaignNewBannerDir); // Remove "../" from the path 

                $target_file = $target_dir . $campaignNewBanner;
                $source = $_FILES["campaignFileBanner"]["tmp_name"];

                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                /* File Conditions */
                if (getImageSize($source) !== false) { // Check if image file is a actual image or fake image
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }
                if (file_exists($target_file)) { // Check if file already exists
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }
                if ($_FILES["campaignFileBanner"]["size"] > 10000000) { // Check file size (10000000 = 10MB)
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
                if (
                    $imageFileType != "png" && $imageFileType != "jpg" && $imageFileType != "jpeg"
                ) { // Allow certain file formats
                    echo "Sorry, only PNG, JPG, and JPEG files are allowed.";
                    $uploadOk = 0;
                }
                /* */

                if ($uploadOk == 0) {
                    header("Location: admin_edit_campaign.php");
                } else {
                    if (move_uploaded_file($_FILES["campaignFileBanner"]["tmp_name"], $target_file)) {
                        $query = "UPDATE campaign SET campaign_name=?, campaign_description=?, campaign_banner=?, campaign_category_id=?, campaign_raised=?, campaign_amount=?, campaign_start=?, campaign_end=?, campaign_admin_id=? WHERE campaign_id=?";
                        $stmt = $con->prepare($query);
                        $stmt->bind_param("sssiddssii", $campaignName, $campaignDesc, $campaignNewBannerDir, $campaignCategory, $campaignRaised, $campaignAmount, $startDate, $endDate, $campaignAdminId, $campaignId);
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
                    backdrop: `#2871f9`,
                    confirmButtonColor: '#0d6efd',
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