<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 1) {
        include_once '../dbcon.php'; // Connect to database 

    } else {
        header("Location: ../user_login.php");
    }
    ?>
    <form action="" method="GET">
        Choose which type of user to edit:
        <button name="type" type="submit" value="Auditor">Auditor</button>
        <button name="type" type="submit" value="Donator">Donator</button>
    </form>

    <?php
    // Check for wrong password
    if (isset($_GET["type"]) && $_GET["type"] == 'Auditor')
        $user_level = 2;
    else if (isset($_GET["type"]) && $_GET["type"] == 'Donator')
        $user_level = 3;

    if (isset($_GET["type"]) && ($_GET["type"] == 'Auditor' || $_GET["type"] == 'Donator')) {
        include_once '../dbcon.php'; // Connect to database 

        $query = "SELECT * FROM user WHERE user_level=?"; // SQL with parameter for level
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $user_level);
        $stmt->execute();
        $result = $stmt->get_result();

    ?>
        <table>
            <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Username
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Phone
                    </th>
                    <th>
                        Address
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
            </thead>

            <tbody>

                <?php while ($r = $result->fetch_assoc()) {
                ?>
                    <form action="edit_user_action.php" method="POST">
                        <tr>
                            <td>
                                <!-- can put hidden input here if want-->
                                <?php echo $r['user_id']; ?>
                            </td>
                            <td>
                                <input type="text" name="username" value="<?php echo $r['user_username']; ?>">
                            </td>
                            <td>
                                <input type="text" name="name" value="<?php echo $r['user_name']; ?>">
                            </td>
                            <td>
                                <input type="text" name="email" value="<?php echo $r['user_email']; ?>">
                            </td>
                            <td>
                                <input type="text" name="phone" value="<?php echo $r['user_phone']; ?>">
                            </td>
                            <td>
                                <textarea type="text" name="address" rows="2" cols="60"><?php echo $r['user_address']; ?></textarea>
                            </td>
                            <td>
                                <button type="submit" name="edit-user-button" value="<?php echo $r['user_id']; ?>">Save</button>
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
    if (isset($_GET["type"]) && $_GET["type"] == 'Auditor')
    ?>
    <a href="admin.php">Admin Dashboard</a>
</body>

</html>