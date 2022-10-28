<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Created Campaign</title>

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
            $campaignType = $_POST['campaignType'];
            $campaignAmount = $_POST['campaignAmount'];
            $startDate = $_POST['startDate'];
            $endDate  = $_POST['endDate'];
            $campaignRaised = 0;

            $query = "INSERT INTO campaign(campaign_name, campaign_description, campaign_category_id, campaign_amount, campaign_start, campaign_end, campaign_raised) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param("ssidssd", $campaignName, $campaignDesc, $campaignType, $campaignAmount, $startDate, $endDate, $campaignRaised);
            $stmt->execute();

    ?>
            <!-- Success Popup -->
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'A new campaign has been successfully created.',
                    text: '(Auto close in 5 seconds)',
                    showConfirmButton: true,
                    confirmButtonText: 'Confirm',
                    backdrop: `#192e59`,
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
        }
    } else {
        header("Location: ../user_logout.php");
    }
    ?>
</body>

</html>