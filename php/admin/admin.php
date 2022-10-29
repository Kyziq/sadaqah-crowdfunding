<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Admin Dashboard</title>

    <!-- Imports -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link href="../style.css" rel="stylesheet" />
</head>

<body>
    <?php
    /* Start session and validate admin login */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 1) {
        include_once '../dbcon.php'; // Connect to database 
        $query = "SELECT * FROM user WHERE user_id=?"; // SQL with parameter for user ID
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result(); // Get the MySQLi result
        $r = $result->fetch_assoc(); // Fetch data  
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
                <a class="nav-link" href="admin.php">
                    <i class="bi bi-grid"></i> <span>Admin Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="admin_edit_profile.php">
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
            <h1>Admin Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="admin.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Admin Dashboard</li>
                </ol>
            </nav>
        </div>
        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Total User
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>
                                                <?php
                                                $query = "SELECT COUNT(*) FROM user";
                                                $result = mysqli_query($con, $query);
                                                $count = mysqli_fetch_assoc($result)['COUNT(*)'];
                                                echo $count;
                                                ?>
                                            </h6>
                                            <span class="text-muted small">admins, auditors, donators</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Total Donation Raised
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>
                                                RM?????
                                                <?php
                                                // $query = "SELECT SUM(campaign_amount) FROM campaign";
                                                // $result = mysqli_query($con, $query);
                                                // $count = mysqli_fetch_assoc($result)['COUNT(*)'];
                                                // echo $count;
                                                ?>
                                            </h6>
                                            <span class="text-muted small">from</span>
                                            <span class="text-success small fw-bold">all campaigns</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-12">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Pending Payment Verification
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-wallet"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>
                                                ????????
                                                <?php
                                                // $query = "SELECT COUNT(donate_id) FROM donate WHERE donate_status=3";
                                                // $result = mysqli_query($con, $query);
                                                // $count = mysqli_fetch_assoc($result)['COUNT(*)'];
                                                // echo $count;
                                                ?>
                                            </h6>
                                            <span class="text-muted small">needs to be</span>
                                            <span class="text-danger small fw-bold">verified</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Title <span> | Graph</span></h5>
                                    <div id="reportsChart">(TODO: GRAPH)</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card top-selling overflow-auto">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">Today</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">This Month</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">This Year</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Account Details
                                <span> | Admin
                                </span>
                            </h5>
                            <div class="activity">
                                <div class="activity-item d-flex">
                                    <div class="activity-content">
                                        <span class="fw-bold text-dark">
                                            Username
                                        </span>
                                        <div><?php echo $r['user_username']; ?></div>
                                    </div>
                                </div>
                                <div class="activity-item d-flex">
                                    <div class="activity-content">
                                        <span class="fw-bold text-dark">
                                            Full Name
                                        </span>
                                        <div><?php echo $r['user_name']; ?></div>
                                    </div>
                                </div>
                                <div class="activity-item d-flex">
                                    <div class="activity-content">
                                        <span class="fw-bold text-dark">
                                            Email
                                        </span>
                                        <div><?php echo $r['user_email']; ?></div>
                                    </div>
                                </div>
                                <div class="activity-item d-flex">
                                    <div class="activity-content">
                                        <span class="fw-bold text-dark">
                                            Phone Number
                                        </span>
                                        <div><?php echo $r['user_phone']; ?></div>
                                    </div>
                                </div>
                                <div class="activity-item d-flex">
                                    <div class="activity-content">
                                        <span class="fw-bold text-dark">
                                            Address
                                        </span>
                                        <div><?php echo $r['user_address']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body pb-0">
                            <?php
                            $query = "SELECT COUNT(*) FROM campaign";
                            $result = mysqli_query($con, $query);
                            $totalCamp = mysqli_fetch_assoc($result)['COUNT(*)'];
                            ?>
                            <h5 class="card-title">
                                Total Campaign (<?php echo $totalCamp ?>)<span> | Pie Chart</span>
                            </h5>
                            <div id="trafficChart" style="min-height: 400px" class="echart"></div>
                            <script>
                                document.addEventListener(
                                    "DOMContentLoaded",
                                    () => {
                                        echarts
                                            .init(
                                                document.querySelector(
                                                    "#trafficChart"
                                                )
                                            )
                                            .setOption({
                                                tooltip: {
                                                    trigger: "item",
                                                },
                                                legend: {
                                                    top: "5%",
                                                    left: "center",
                                                },
                                                series: [{
                                                    name: "Access From",
                                                    type: "pie",
                                                    radius: [
                                                        "40%",
                                                        "70%",
                                                    ],
                                                    avoidLabelOverlap: false,
                                                    label: {
                                                        show: false,
                                                        position: "center",
                                                    },
                                                    emphasis: {
                                                        label: {
                                                            show: true,
                                                            fontSize: "18",
                                                            fontWeight: "bold",
                                                        },
                                                    },
                                                    labelLine: {
                                                        show: false,
                                                    },

                                                    data: [
                                                        <?php
                                                        $query = "SELECT COUNT(*) FROM campaign WHERE campaign_category_id=1";
                                                        $result = mysqli_query($con, $query);
                                                        $totalCategoryCash = mysqli_fetch_assoc($result)['COUNT(*)'];
                                                        ?> {
                                                            value: <?php echo $totalCategoryCash ?>,
                                                            name: "Cash",
                                                        },

                                                        <?php
                                                        $query = "SELECT COUNT(*) FROM campaign WHERE campaign_category_id=2";
                                                        $result = mysqli_query($con, $query);
                                                        $totalCategorySchool = mysqli_fetch_assoc($result)['COUNT(*)'];
                                                        ?> {
                                                            value: <?php echo $totalCategorySchool ?>,
                                                            name: "School Necessity",
                                                        },

                                                        <?php
                                                        $query = "SELECT COUNT(*) FROM campaign WHERE campaign_category_id=3";
                                                        $result = mysqli_query($con, $query);
                                                        $totalCategoryFaci = mysqli_fetch_assoc($result)['COUNT(*)'];
                                                        ?> {
                                                            value: <?php echo $totalCategoryFaci ?>,
                                                            name: "Facilitator",
                                                        },

                                                        <?php
                                                        $query = "SELECT COUNT(*) FROM campaign WHERE campaign_category_id=4";
                                                        $result = mysqli_query($con, $query);
                                                        $totalCategoryService = mysqli_fetch_assoc($result)['COUNT(*)'];
                                                        ?> {
                                                            value: <?php echo $totalCategoryService ?>,
                                                            name: "Service",
                                                        },
                                                    ],
                                                }, ],
                                            });
                                    }
                                );
                            </script>
                        </div>
                    </div>
                    <div class="card">
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

    <?php
    // Close connection
    $stmt->close();
    $con->close();
    ?>

    <!-- Imports -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.4.0/echarts.min.js" integrity="sha512-LYmkblt36DJsQPmCK+cK5A6Gp6uT7fLXQXAX0bMa763tf+DgiiH3+AwhcuGDAxM1SvlimjwKbkMPL3ZM1qLbag==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../main.js"></script>

</body>

</html>