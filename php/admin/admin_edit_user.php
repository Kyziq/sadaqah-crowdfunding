<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>

    <!-- Imports -->
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../../js/script.js" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    /* Start session and validate admin */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 1) {
        include_once '../dbcon.php'; // Connect to database 
    } else {
        header("Location: ../user_login.php");
    }
    ?>
    <div class="container p-5 my-5">
        <a href="admin.php">Go back to Admin Dashboard</a>
        <div class="mb-3">
            <p>Choose which type of user to edit</p>
            <form action="" method="GET">
                <button class="btn btn-outline-primary" name="type" type="submit" value="Auditor">Auditor</button>
                <button class="btn btn-outline-primary" name="type" type="submit" value="Donator">Donator</button>
            </form>
        </div>
        <?php
        /* Check for wrong password */
        if (isset($_GET["type"]) && $_GET["type"] == 'Auditor') {
            $user_level = 2;
        } else if (isset($_GET["type"]) && $_GET["type"] == 'Donator') {
            $user_level = 3;
        }

        /* Display list of auditors/donators */
        if (isset($_GET["type"]) && ($_GET["type"] == 'Auditor' || $_GET["type"] == 'Donator')) {
            include_once '../dbcon.php'; // Connect to database 
            $query = "SELECT * FROM user WHERE user_level=?"; // SQL with parameter for level
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $user_level);
            $stmt->execute();
            $result = $stmt->get_result(); // Get the MySQLi result
        ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col" class="col-1">Username</th>
                        <th scope="col" class="col-3">Name</th>
                        <th scope="col" class="col-2">Email</th>
                        <th scope="col" class="col-2">Phone</th>
                        <th scope="col" class="col-3">Address</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php while ($r = $result->fetch_assoc()) {
                    ?>
                        <form action="admin_edit_user_action.php" method="POST">
                            <tr>
                                <th>
                                    <!-- can put hidden input here if want-->
                                    <?php echo $r['user_id']; ?>
                                </th>
                                <td>
                                    <input type="text" class="form-control" name="username" value="<?php echo $r['user_username']; ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="name" value="<?php echo $r['user_name']; ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="email" value="<?php echo $r['user_email']; ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="phone" value="<?php echo $r['user_phone']; ?>">
                                </td>
                                <td>
                                    <textarea type="text" class="form-control" name="address" rows="2" cols="60"><?php echo $r['user_address']; ?></textarea>
                                </td>
                                <td>
                                    <button class="btn btn-primary" type="submit" name="edit-user-button" value="<?php echo $r['user_id']; ?>">Save</button>
                                </td>
                            </tr>
                        </form>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            </form>
        <?php
        }
        ?>
    </div>
    <?php
    if (isset($result) && is_resource($result)) {
        mysqli_free_result($result);  // Release returned data
    }
    mysqli_close($con); // Close connection
    ?>
</body>

</html>