<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>

    <!-- Imports -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link href="../style.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    /* Start session and validate user */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 1) {
        include_once '../dbcon.php'; // Connect to database 
        $query = "SELECT * FROM user WHERE user_id=?"; // SQL with parameters
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result(); // Get the MySQLI result
        $r = $result->fetch_assoc(); // Fetch data  
    } else {
        header("Location: ../user_login_register.php");
    }
    ?>

    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="" class="logo d-flex align-items-center">
                <span class="d-none d-lg-block">Sadaqah Crowdfunding</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle" style="font-size: 36px"></i>
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $r["user_username"]; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo $r["user_username"]; ?></h6>
                            <span>Admin</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="admin_edit_profile.php">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="../user_logout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link collapsed" href="admin.php">
                    <i class="bi bi-grid"></i> <span>Admin Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_edit_profile.php">
                    <i class="bi bi-person"></i> <span>Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>User</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="user-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <!-- To Edit Auditor -->
                    <li>
                        <form action="admin_edit_user.php" method="GET">
                            <input type="hidden" name="type" value="Auditor" />
                            <a onclick="this.parentNode.submit();">
                                <i class="bi bi-circle"></i><span>Edit Auditor</span>
                            </a>
                        </form>
                    </li>
                    <!-- To Edit Donator -->
                    <li>
                        <form action="admin_edit_user.php" method="GET">
                            <input type="hidden" name="type" value="Donator" />
                            <a onclick="this.parentNode.submit();">
                                <i class="bi bi-circle"></i><span>Edit Donator</span>
                            </a>
                        </form>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#campaign-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-clipboard"></i>
                    <span>Campaign</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="campaign-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="admin_create_campaign.php">
                            <i class="bi bi-circle"></i><span>Create Campaign</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin_edit_campaign.php">
                            <i class="bi bi-circle"></i><span>Edit Campaign</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="admin_verify_payment.php">
                    <i class="bi bi-credit-card"></i>
                    <span>Verify Payment</span>
                </a>
            </li>
        </ul>
    </aside>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="admin.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Account Details</h5>
                            <form action="admin_edit_profile_save.php" method="POST" class="row g-2">
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
                            <form action="user_edit_action.php" method="POST">
                                <!-- Input -->
                                <div class="form-group mb-2">
                                    <label for="currentPassword">Current Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" data-toggle="password" required>
                                        <div class="input-group-text">
                                            <i class="bi bi-eye-fill" style="cursor: pointer"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="newPassword">New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="newPassword" name="newPassword" data-toggle="password" required>
                                        <div class="input-group-text">
                                            <i class="bi bi-eye-fill" style="cursor: pointer"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="confirmNewPassword">Confirm New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" data-toggle="password" required>
                                        <div class="input-group-text">
                                            <i class="bi bi-eye-fill" style="cursor: pointer"></i>
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
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Lembaga Zakat Negeri Kedah Darul Aman</span></strong>. All Rights Reserved
        </div>
        <div class="credits"></div>
    </footer>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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
            //eyeOpenClass: 'bi-eye-fill',
            //eyeCloseClass: 'bi-eye-slash-fill',
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
                                .find(".bi")
                                .removeClass("bi-eye-fill")
                                .addClass("bi-eye-slash-fill");
                            input.attr("type", "text");
                        } else {
                            eye_btn
                                .removeClass("input-password-show")
                                .addClass("input-password-hide");
                            eye_btn
                                .find(".bi")
                                .removeClass("bi-eye-slash-fill")
                                .addClass("bi-eye-fill");
                            input.attr("type", "password");
                        }
                    });
                });
            });
        })(window.jQuery);
    </script>

    <!-- Imports -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.4.0/echarts.min.js" integrity="sha512-LYmkblt36DJsQPmCK+cK5A6Gp6uT7fLXQXAX0bMa763tf+DgiiH3+AwhcuGDAxM1SvlimjwKbkMPL3ZM1qLbag==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../main.js"></script>

    <?php
    // Close connection
    $stmt->close();
    $con->close();
    ?>
</body>

</html>