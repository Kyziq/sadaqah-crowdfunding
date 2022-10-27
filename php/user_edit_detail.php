<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>

    <!-- ***** Imports ***** -->
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="../js/script.js" />
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
    /* Start session and validate user */
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
        header("Location: user_login_register.php");
    }
    ?>

    <!-- User Account Settings Form -->
    <div class="container my-3">
        <?php
        if ($r['user_level'] == 1) {
            echo '<a href="admin/admin.php" class="link-primary">Back to Admin Dashboard</a>';
        } else if ($r['user_level'] == 2) {
            echo '<a href="auditor/auditor.php" class="link-primary">Back to Auditor Dashboard</a>';
        } else if ($r['user_level'] == 3) {
            echo '<a href="donator/donator.php" class="link-primary">Back to User Dashboard</a>';
        }

        ?>
        <p class=" h5"><?php echo $r["user_name"]; ?>'s Account Details</p>
        <form action="user_edit_action.php" method="POST" class="row g-2">
            <!-- Input -->
            <div class="form-group mb-2">
                <div class="form-floating">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Input username" value="<?php echo $r['user_username'] ?>">
                    <label for="username" class="form-label">Username</label>
                </div>
            </div>

            <div class="form-group mb-2">
                <div class="form-floating">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Input name" value="<?php echo $r['user_name'] ?>">
                    <label for="name" class="form-label">Full name</label>
                </div>
            </div>

            <div class="form-group mb-2">
                <div class="form-floating">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Input email" value="<?php echo $r['user_email'] ?>">
                    <label for="email" class="form-label">Email</label>
                </div>
            </div>

            <div class="form-group mb-2">
                <div class="form-floating">
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Input phone" value="<?php echo $r['user_phone'] ?>">
                    <label for="phone" class="form-label">Phone</label>
                </div>
            </div>

            <div class="form-group mb-2">
                <div class="form-floating">
                    <textarea id="address" name="address" class="form-control" placeholder="Input address" rows="2"><?php echo $r['user_address'] ?></textarea>
                    <label for="address" class="form-label">Address</label>
                </div>
            </div>

            <div class="form-group mb-4">
                <button type="Submit" class="btn btn-primary" value="Submit" name="edit-action-button">Save</button>
            </div>
        </form>

        <!-- Password Change Form -->
        <p class="h5">Password Settings</p>
        <form action="user_edit_action.php" method="POST" class="row g-2">
            <!-- Input -->
            <div class="form-group mb-2">
                <label for="currentPassword">Current Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" data-toggle="password" required>
                    <div class="input-group-text">
                        <i class="fa fa-eye" style="cursor: pointer"></i>
                    </div>
                </div>
            </div>

            <div class="form-group mb-2">
                <label for="newPassword">New Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="newPassword" name="newPassword" data-toggle="password" required>
                    <div class="input-group-text">
                        <i class="fa fa-eye" style="cursor: pointer"></i>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="confirmNewPassword">Confirm New Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" data-toggle="password" required>
                    <div class="input-group-text">
                        <i class="fa fa-eye" style="cursor: pointer"></i>
                    </div>
                </div>
            </div>
            <div class="form-group mb-2">
                <span id='passwordCheckMessage'></span>
            </div>

            <div class="form-group mb-2">
                <button type="Submit" class="btn btn-primary" value="Submit" name="edit-password-button">Change Password</button>
            </div>
        </form>
    </div>

    <script>
        // Check if new password and confirm new password are the same
        $('#newPassword, #confirmNewPassword').on('keyup', function() {
            if ($('#newPassword').val() != '' && $('#confirmNewPassword').val() != '') {
                if ($('#newPassword').val() == $('#confirmNewPassword').val()) {
                    $('#passwordCheckMessage').html('New password matching').css('color', 'green');
                } else {
                    $('#passwordCheckMessage').html('New password not matching').css('color', 'red');
                }
            } else {
                $('#passwordCheckMessage').html('');
            }
        });
        // Toggle password visibility
        !(function($) {
            //eyeOpenClass: 'fa-eye',
            //eyeCloseClass: 'fa-eye-slash',
            "use strict";

            $(function() {
                $('[data-toggle="password"]').each(function() {
                    var input = $(this);
                    var eye_btn = $(this).parent().find(".input-group-text");
                    eye_btn.css("cursor", "pointer").addClass("input-password-hide");
                    eye_btn.on("click", function() {
                        if (eye_btn.hasClass("input-password-hide")) {
                            eye_btn
                                .removeClass("input-password-hide")
                                .addClass("input-password-show");
                            eye_btn
                                .find(".fa")
                                .removeClass("fa-eye")
                                .addClass("fa-eye-slash");
                            input.attr("type", "text");
                        } else {
                            eye_btn
                                .removeClass("input-password-show")
                                .addClass("input-password-hide");
                            eye_btn
                                .find(".fa")
                                .removeClass("fa-eye-slash")
                                .addClass("fa-eye");
                            input.attr("type", "password");
                        }
                    });
                });
            });
        })(window.jQuery);
    </script>

    <?php
    // Close connection
    $stmt->close();
    $con->close();
    ?>
</body>

</html>