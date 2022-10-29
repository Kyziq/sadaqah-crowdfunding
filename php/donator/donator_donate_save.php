<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Saving</title>
</head>

<body>
    <?php
    /* Start session and validate donator login */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 3) {
        if (isset($_POST['donate-button'])) {
            include("../dbcon.php");
            /* Get all the posted items */
            $donate_amount = $_POST['donate_amount'];
            $donator_proof;
            $donator_id = $_SESSION["user_id"];
            $donate_status = 3; // 3 = Pending
            $admin_id = 1; // 1 = Default admin (which admin verify later in verification)
            $campaign_id = $_POST['campaign_id'];

            /* Construct and run query to insert donation data */
            $query = "INSERT INTO donate(donate_amount, donate_status, donator_id, admin_id, campaign_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param("diiii", $donate_amount, $donate_status, $donator_id, $admin_id, $campaign_id);
            $stmt->execute();
    ?>
            <script>
                alert('Donation has been added, please wait for it to be verified.');
                window.location.href = 'donator.php';
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