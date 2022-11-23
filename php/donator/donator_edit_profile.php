<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="icon" href="../../images/logo-LZNK.ico">

    <!-- Imports -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link href="../../css/style.css" rel="stylesheet" />
    <link href="../../css/custom-css.css" rel="stylesheet" />

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    /* Start session and validate user */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 3) {
        /* DB Connect and Setting */
        include_once '../dbcon.php';

        /* SELECT Query */
        $query = "SELECT * FROM user WHERE user_id=?"; // SQL with parameters
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result(); // Get the MySQLI result
        $r = $result->fetch_assoc(); // Fetch data  

        /* Session Timeout */
        include '../con_timeout.php';
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
                            <span>Donator</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="donator_edit_profile.php">
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
                <a class="nav-link collapsed" href="donator.php">
                    <i class="bi bi-grid"></i> <span>Donator Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="donator_edit_profile.php">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="donator_donate.php">
                    <i class="bi bi-cash-coin"></i>
                    <span>Donate</span>
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
                        <a href="donator.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Account Details</h5>
                            <form action="donator_edit_profile_save.php" method="POST">
                                <!-- Input -->
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label for="username" class="form-label fw-semibold">Username</label>
                                        <input type="text" id="username" name="username" class="form-control" placeholder="Input username" value="<?php echo $r['user_username'] ?>" required>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="form-group">
                                        <label for="name" class="form-label fw-semibold">Full Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Input name" value="<?php echo $r['user_name'] ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <label for="email" class="form-label fw-semibold">Email</label>
                                            <input type="email" id="email" name="email" class="form-control" placeholder="Input email" value="<?php echo $r['user_email'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Input phone" value="<?php echo $r['user_phone'] ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="form-group">
                                        <label for="address" class="form-label fw-semibold">Address</label>
                                        <textarea id="address" name="address" class="form-control" placeholder="Input address" rows="3" required><?php echo $r['user_address'] ?></textarea>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="Submit" class="btn btn-primary" value="Submit" name="editProfileButton">Save Detail</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Password Settings</h5>
                            <!-- Password Change Form -->
                            <form action="donator_edit_profile_save.php" method="POST">
                                <!-- Input -->
                                <div class="mb-3 col-lg-12">
                                    <div class="form-group">
                                        <label for="currentPassword" class="form-label fw-semibold">Current Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="currentPassword" name="currentPassword" data-toggle="password" required>
                                            <div class="input-group-text">
                                                <i class="bi bi-eye-fill" style="cursor: pointer"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 col-lg-12">
                                    <div class="form-group">
                                        <label for="newPassword" class="form-label fw-semibold">New Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="newPassword" name="newPassword" data-toggle="password" required>
                                            <div class="input-group-text">
                                                <i class="bi bi-eye-fill" style="cursor: pointer"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 col-lg-12">
                                    <div class="form-group">
                                        <label for="confirmNewPassword" class="form-label fw-semibold">Confirm New Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" data-toggle="password" required>
                                            <div class="input-group-text">
                                                <i class="bi bi-eye-fill" style="cursor: pointer"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Message check for same password -->
                                <div class="mb-3">
                                    <span id='checkSamePasswordMessage'></span>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="Submit" class="btn btn-primary" value="Submit" name="editPasswordButton">Save Password</button>
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

    <!-- Imports -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.4.0/echarts.min.js" integrity="sha512-LYmkblt36DJsQPmCK+cK5A6Gp6uT7fLXQXAX0bMa763tf+DgiiH3+AwhcuGDAxM1SvlimjwKbkMPL3ZM1qLbag==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../js/main.js"></script>
</body>

</html>