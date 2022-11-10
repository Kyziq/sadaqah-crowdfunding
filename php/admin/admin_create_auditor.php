<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="icon" href="../../images/logo-LZNK.ico">

    <!-- Imports -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link href="../../css/style.css" rel="stylesheet" />
    <link href="../../css/custom-css.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    /* Start session and validate admin */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 1) {
        include_once '../dbcon.php';
        $query = "SELECT * FROM user WHERE user_id=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $r = $result->fetch_assoc();
    } else {
        header("Location: ../user_logout.php");
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
                <a class="nav-link collapsed" href="admin_edit_profile.php">
                    <i class="bi bi-person"></i> <span>Profile</span>
                </a>
            </li>

            <!-- User Management -->
            <li class="nav-item">
                <a class="nav-link" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-people"></i></i><span>User</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="user-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="admin_create_auditor.php" class="active">
                            <i class="bi bi-circle"></i><span>Create Auditor</span>
                        </a>
                    </li>

                    <li>
                        <form action="admin_edit_user.php" method="GET">
                            <input type="hidden" name="type" value="Auditor" />
                            <a onclick="this.parentNode.submit();">
                                <i class="bi bi-circle"></i><span>Edit Auditor</span>
                            </a>
                        </form>
                    </li>
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

            <!-- Campaign Management -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#campaign-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-calendar-event"></i>
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

            <!-- Donation Management -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="admin_verify_donation.php">
                    <i class="bi bi-credit-card"></i>
                    <span>Verify Donation</span>
                </a>
            </li>
        </ul>
    </aside>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>User</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                    <li class="breadcrumb-item">User</li>
                    <li class="breadcrumb-item active">Create Auditor</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Create Auditor Form</h5>

                            <form action="admin_create_auditor_action.php" method="POST">
                                <div class="row g-3">
                                    <!-- Input -->
                                    <div class="col-lg-6">
                                        <label for="username" class="form-label fw-semibold">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" required />
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="password" class="form-label fw-semibold">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" data-toggle="password" required>
                                            <div class="input-group-text">
                                                <i class="bi bi-eye-fill" style="cursor: pointer"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <label for="name" class="form-label fw-semibold">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required />
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required />
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                        <input type="number" step=1 class="form-control" id="phone" name="phone" required />
                                    </div>

                                    <div class="col-lg-12">
                                        <label for="address" class="form-label fw-semibold">Address</label>
                                        <textarea type="text" class="form-control" id="address" name="address" rows="3" required></textarea>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary" name="create-auditor-button">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                /* Toggle password visibility */ !(function($) {
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
        </section>

    </main>
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Lembaga Zakat Negeri Kedah Darul Aman</span></strong>. All Rights Reserved
        </div>
        <div class="credits"></div>
    </footer>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Imports -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.4.0/echarts.min.js" integrity="sha512-LYmkblt36DJsQPmCK+cK5A6Gp6uT7fLXQXAX0bMa763tf+DgiiH3+AwhcuGDAxM1SvlimjwKbkMPL3ZM1qLbag==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../js/main.js"></script>

    <?php
    // Close connection
    $stmt->close();
    $con->close();
    ?>
</body>

</html>