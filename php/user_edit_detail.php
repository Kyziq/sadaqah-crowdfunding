<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Detail</title>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION['user_id']) && ($_SESSION['user_level'] == 3 || $_SESSION['user_level'] == 2 || $_SESSION['user_level'] == 1)) {
        include_once 'dbcon.php'; // Connect to database 
        $query = "SELECT * FROM user WHERE user_id=?"; // SQL with parameters
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result(); // Get the MySQLI result
        $r = $result->fetch_assoc(); // Fetch data  
    } else {
        header("Location: user_login.php");
    }
    ?>

    Hello
    <?php
    if ($r['user_level'] == 1)
        echo "Admin ";
    else if ($r['user_level'] == 2)
        echo "Auditor ";
    else if ($r['user_level'] == 3)
        echo "Donator ";

    echo $r['user_name'];
    ?>
    <form action="user_edit_action.php" method="POST">
        <table>
            <tr>
                <td>
                    Username:
                </td>
                <td><input type="text" name="username" value="<?php echo $r['user_username'] ?>"></td>
            </tr>
            <tr>
                <td>
                    Name:
                </td>
                <td><input type="text" name="name" value="<?php echo $r['user_name'] ?>"></td>
            </tr>
            <tr>
                <td>
                    Email:
                </td>
                <td><input type="text" name="email" value="<?php echo $r['user_email'] ?>"></td>
            </tr>
            <tr>
                <td>
                    Phone Number:
                </td>
                <td><input type="text" name="phone" value="<?php echo $r['user_phone'] ?>"></td>
            </tr>
            <tr>
                <td>
                    Address:
                </td>
                <td><input type="text" name="address" value="<?php echo $r['user_address'] ?>"></td>
            </tr>
            <tr>
                <td colspan="2" align="right"><button type="Submit" value="Submit" name="edit-action-button">Save</button></td>
            </tr>
        </table>
    </form>
</body>

</html>