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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link href="../../css/style.css" rel="stylesheet" />
    <link href="../../css/custom-css.css" rel="stylesheet" />
</head>

<body>
    <?php
    /* Start session and validate admin */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 1) {
        /* DB Connect and Setting */
        include_once '../dbcon.php';
        date_default_timezone_set('Asia/Singapore');

        /* SELECT Query */
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
                        <a href="admin_create_auditor.php">
                            <i class="bi bi-circle"></i><span>Create Auditor</span>
                        </a>
                    </li>
                    <li>
                        <a href=<?php
                                if (isset($_GET["type"]) && $_GET["type"] == 'Auditor') {
                                    echo '"admin_edit_user.php?type=Auditor" class="active"';
                                } else {
                                    echo '"admin_edit_user.php?type=Auditor"';
                                }
                                ?>>
                            <i class=" bi bi-circle"></i><span>Edit Auditor</span>
                        </a>
                    </li>
                    <li>
                        <a href=<?php
                                if (isset($_GET["type"]) && $_GET["type"] == 'Donator') {
                                    echo '"admin_edit_user.php?type=Donator" class="active"';
                                } else {
                                    echo '"admin_edit_user.php?type=Donator"';
                                }
                                ?>>
                            <i class=" bi bi-circle"></i><span>Edit Donator</span>
                        </a>
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
                    <li class="breadcrumb-item">
                        <a href="admin.php">Home</a>
                    </li>
                    <li class="breadcrumb-item">User</li>
                    <?php
                    $type = isset($_GET["type"]) && $_GET["type"] == 'Auditor' ? 'Auditor' : (isset($_GET["type"]) && $_GET["type"] == 'Donator' ? 'Donator' : '');
                    ?>
                    <li class="breadcrumb-item active">Edit <?php echo $type ?></li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <?php
                                    /* Check for type of user to proceed query */
                                    if (isset($_GET["type"]) && $_GET["type"] == 'Auditor') {
                                        $user_level = 2;
                                        echo '<h5 class="card-title">Edit Auditor List</h5>';
                                    } else if (isset($_GET["type"]) && $_GET["type"] == 'Donator') {
                                        $user_level = 3;
                                        echo '<h5 class="card-title">Edit Donator List</h5>';
                                    }

                                    /* Display list of auditors/donators */
                                    if (isset($_GET["type"]) && ($_GET["type"] == 'Auditor' || $_GET["type"] == 'Donator')) {
                                        include_once '../dbcon.php'; // Connect to database 
                                        $query = "SELECT * FROM user WHERE user_level=?"; // SQL with parameter for level
                                        $stmt = $con->prepare($query);
                                        $stmt->bind_param("i", $user_level);
                                        $stmt->execute();
                                        $result = $stmt->get_result(); // Get the MySQLi result

                                        $index = 1;
                                    ?>
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Address</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($r = $result->fetch_assoc()) { ?>
                                                <form action="admin_edit_user_action.php" method="POST">
                                                    <!-- Hidden Input -->
                                                    <input type="hidden" name="level" value="<?php echo $r['user_level']; ?>">
                                                    <tr>
                                                        <th scope="row">
                                                            <?php echo $index; ?>
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
                                                $index++;
                                            }
                                            ?>
                                        </tbody>
                                    <?php
                                    }
                                    ?>
                                </table>

                            </div>
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
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src=".../../js/main.js"></script>

    <?php
    // Close connection
    $stmt->close();
    $con->close();
    ?>
</body>

</html>