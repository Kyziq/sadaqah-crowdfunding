<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Campaign</title>
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
        /* Check if create campaign button is clicked */
        if (isset($_POST['createCampaignButton'])) {
            /* DB Connect and Setting */
            include_once '../dbcon.php';
            date_default_timezone_set('Asia/Singapore');
            $date = date('--Y-m-d--H-i-s');

            $campaignRaised = 0; // Default value
            $campaignStatus = 3; // 3 = Pending
            $campaignAdminId = $_SESSION['user_id'];
            /* Get all the posted items */
            global $campaignName;
            $campaignName = $_POST['campaignName'];
            $campaignDesc = $_POST['campaignDesc'];
            $campaignCategory = $_POST['campaignCategory'];
            $campaignAmount = $_POST['campaignAmount'];
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];

            /* Upload file (file name = campaignName--currentDate.ext) */
            $extension  = pathinfo($_FILES["campaignFileBanner"]["name"], PATHINFO_EXTENSION);
            $target_dir = "../../images/campaign/";
            $file_name = $campaignName . $date . "." . $extension;
            $target_file = $target_dir . $file_name;

            $uploadOk = 1; // Valid condition
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // file type to lowercase

            /* Condition */
            $source = $_FILES["campaignFileBanner"]["tmp_name"];
            if (getImageSize($source) !== false) { // Check if image file is a actual image or fake image
                $uploadOk = 1; // Valid condition
            } else {
                $uploadOk = 2;
            }
            if (file_exists($target_file)) { // Check if file already exists
                $uploadOk = 3;
            }
            if ($_FILES["campaignFileBanner"]["size"] > 10000000) { // Check file size (10000000 = 10MB)
                $uploadOk = 4;
            }
            if ($imageFileType != "png" && $imageFileType != "jpg" && $imageFileType != "jpeg") { // Allow certain file formats
                $uploadOk = 5;
            }
            if ($startDate > $endDate) { // Start date cannot exceed end date
                $uploadOk = 6;
            }
            /* End Condition */

            /* SweetAlert2 Popup */
            function resultPopup($uploadOk, $type)
            {
                if ($type == "success") {
    ?>
                    <!-- Success Popup -->
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: '<?php echo $GLOBALS['campaignName']; ?>',
                            text: 'A new campaign has been successfully created.',
                            footer: '(Auto close in 5 seconds)',
                            showConfirmButton: true,
                            confirmButtonText: 'Confirm',
                            backdrop: `#2871f9`,
                            confirmButtonColor: '#0d6efd',
                            timer: 5000,
                            willClose: () => {
                                window.location.href = 'admin.php';
                            }
                        })
                    </script>
                <?php
                } else if ($type == "error") {
                    if ($uploadOk == 3) {
                        $text = "Sorry, file already exists.";
                    } else if ($uploadOk == 4) {
                        $text = "Sorry, your file is too large.";
                    } else if ($uploadOk == 5) {
                        $text = "Sorry, only PNG, JPG, and JPEG files are allowed.";
                    } else if ($uploadOk == 6) {
                        $text = "Start date of the campaign cannot be later than the finish date.";
                    } else {
                        $text = "Sorry, there was an error uploading your file.";
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
                            willClose: () => {
                                window.location.href = 'admin_create_campaign.php';
                            }
                        })
                    </script>
    <?php
                }
            }
            /* End SweetAlert2 Popup */

            /* If valid condition */
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["campaignFileBanner"]["tmp_name"], $target_file)) {
                    $campaignFileBanner = str_replace("../", "", $target_file); // Remove "../" from the path 

                    /* INSERT Query */
                    $query = "INSERT INTO campaign(campaign_name, campaign_description, campaign_banner, campaign_category_id, campaign_amount, campaign_start, campaign_end, campaign_raised, campaign_admin_id, campaign_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("sssidssdii", $campaignName, $campaignDesc, $campaignFileBanner, $campaignCategory, $campaignAmount, $startDate, $endDate, $campaignRaised, $campaignAdminId, $campaignStatus);
                    $stmt->execute();

                    resultPopup($uploadOk, "success");

                    /* Close connection */
                    $stmt->close();
                    $con->close();
                } else {
                    resultPopup(2, "error");
                }
            } else {
                resultPopup($uploadOk, "error");
            }
        }
    } else {
        header("Location: ../user_logout.php");
    }
    ?>
</body>

</html>