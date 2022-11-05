<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Campaign</title>
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
        if (isset($_POST['create-campaign-button'])) {
            include_once '../dbcon.php'; // Connect to database

            /* Get all the posted items */
            $campaignName = $_POST['campaignName'];
            $campaignDesc = $_POST['campaignDesc'];
            $campaignCategory = $_POST['campaignCategory'];
            $campaignAmount = $_POST['campaignAmount'];
            $startDate = $_POST['startDate'];
            $endDate  = $_POST['endDate'];
            $campaignRaised = 0;
            $campaignAdminId = $_SESSION['user_id'];
            $campaignStatus = 3; // 3 = Pending

            /* File Upload */
            date_default_timezone_set('Asia/Singapore');
            $date = date('Y-m-d');

            // Upload image (where file name is campaignName-date.extension)
            $extension  = pathinfo($_FILES["campaignFileBanner"]["name"], PATHINFO_EXTENSION);
            $target_dir = "../../images/campaign/";
            $file_name = $campaignName . "-" . $date . "." . $extension;
            $target_file = $target_dir . $file_name;
            $source = $_FILES["campaignFileBanner"]["tmp_name"];

            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // file type to lowercase

            // Check if image file is a actual image or fake image
            $check = getImageSize($source);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size (10000000 = 10MB)
            if ($_FILES["campaignFileBanner"]["size"] > 10000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if (
                $imageFileType != "png" && $imageFileType != "jpg" && $imageFileType != "jpeg"
            ) {
                echo "Sorry, only PNG, JPG, and JPEG files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                header("Location: admin_create_campaign.php");
            } else {
                if (move_uploaded_file($_FILES["campaignFileBanner"]["tmp_name"], $target_file)) {
                    $campaignFileBanner = $target_file;

                    $query = "INSERT INTO campaign(campaign_name, campaign_description, campaign_banner, campaign_category_id, campaign_amount, campaign_start, campaign_end, campaign_raised, campaign_admin_id, campaign_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("sssidssdii", $campaignName, $campaignDesc, $campaignFileBanner, $campaignCategory, $campaignAmount, $startDate, $endDate, $campaignRaised, $campaignAdminId, $campaignStatus);
                    $stmt->execute();
    ?>
                    <!-- Success Popup -->
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: '<?php echo $campaignName; ?>',
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
                    // Close connection
                    $stmt->close();
                    $con->close();
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    } else {
        header("Location: ../user_logout.php");
    }
    ?>
</body>

</html>