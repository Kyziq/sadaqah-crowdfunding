<?php
    /* Start session and validate donator login */
   
    session_start();
    echo $_SESSION['user_id'];
    if (isset($_POST['donate-button'])) {
    include("../dbcon.php");
    /* Get all the posted items */
    $campaign_id = $_POST['campaign_id'];
    $donate_amount = $_POST['donate_amount'];
    $donate_date = $_POST['donate_date'];
    // $file = 
    $donator_id = $_SESSION["user_id"];
    /* Construct and run query to check if username is taken */
    $q = "INSERT INTO donate(campaign_id,donate_amount,donate_date,donator_id,donate_status)
    VALUES ('$campaign_id','$donate_amount','$donate_date','$donator_id','3')";
    $result = mysqli_query($con, $q);

    if($result){
        echo "<script>
        alert('Donation has been added,please wait for it to be verified.');
        window.location.href='donator.php';
        </script>";
    } else {
        echo "<script>
      alert('user can only make one booking at a time');
      window.location.href='donator.php';
      </script>";
      }
    }else {
        header("Location: ../user_logout.php");
    }
    ?>

