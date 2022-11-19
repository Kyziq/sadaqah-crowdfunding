<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Admin Dashboard</title>
    <link rel="icon" href="../../images/logo-LZNK.ico">

    <!-- Imports -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link href="../../css/style.css" rel="stylesheet" />
    <link href="../../css/custom-css.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
        Chart.defaults.global.plugins.datalabels.anchor = 'end';
        Chart.defaults.global.plugins.datalabels.align = 'end';
    </script>

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
        $user = $result->fetch_assoc();
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
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $user["user_username"]; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo $user["user_username"]; ?></h6>
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

            <!-- User Management -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-people"></i></i><span>User</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="user-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="admin_create_auditor.php">
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
                                                $stmt = $con->prepare($query);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
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
                                                <?php
                                                $query = "SELECT SUM(campaign_raised) FROM campaign";
                                                $stmt = $con->prepare($query);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                $count = mysqli_fetch_assoc($result)['SUM(campaign_raised)'];
                                                echo "RM" . $count;
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
                                        Pending Donation Verification
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-exclamation-lg"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>
                                                <?php
                                                $donate_status = 3;
                                                $query = "SELECT COUNT(donate_id) FROM donate WHERE donate_status=?";
                                                $stmt = $con->prepare($query);
                                                $stmt->bind_param("i", $donate_status);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                $count = mysqli_fetch_assoc($result)['COUNT(donate_id)'];
                                                echo $count;
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
                                    <h5 class="card-title">Ongoing Campaign Information <span> | Info + Chart</span></h5>
                                    <div id="reportsChart">
                                        <form action="admin_campaign_chart.php" method="POST">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <select class="form-select" name="campaignId" required>
                                                        <option value="" disabled selected>Choose Campaign</option>
                                                        <?php
                                                        /* SELECT Query (Only display accepted campaign after current date AND ongoing campaign) */
                                                        $campaign_status = 1; // Accepted
                                                        $query = "SELECT * FROM campaign WHERE campaign_status = ? AND campaign_start <= CURDATE() AND campaign_end >= CURDATE()";
                                                        $stmt = $con->prepare($query);
                                                        $stmt->bind_param("i", $campaign_status);
                                                        $stmt->execute();
                                                        $result = $stmt->get_result();
                                                        while ($r = $result->fetch_assoc()) {
                                                        ?>
                                                            <option value="<?php echo $r['campaign_id']; ?>"><?php echo $r['campaign_name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <button class="btn btn-primary" type="submit" name="ongoingCampaignInfoBtn">Check</button>
                                                </div>
                                            </div>
                                        </form>
                                        <?php
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($r = $result->fetch_assoc()) {
                                            if (isset($_GET['ongoingCampaignId']) && $_GET['ongoingCampaignId'] == $r['campaign_id']) {
                                        ?>
                                                <div class="my-3">
                                                    <h5 class="fw-semibold">Campaign Information (ID <?php echo $r['campaign_id'] ?>)</h5>
                                                    <div class="alert alert-primary" role="alert">
                                                        <div class="row">
                                                            <div class="col-lg-3 fw-bold">Name </div>
                                                            :
                                                            <div class="col"><?php echo $r['campaign_name']; ?> </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 fw-bold">Description</div>
                                                            :
                                                            <div class="col"><?php echo $r['campaign_description']; ?> </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 fw-bold">Date created</div>
                                                            :
                                                            <div class="col">
                                                                <?php
                                                                $dateCreated = date("d M Y", strtotime($r['campaign_created_date']));
                                                                echo $dateCreated;
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 fw-bold">Duration</div>
                                                            :
                                                            <div class="col">
                                                                <?php
                                                                $startDate = date("d M Y", strtotime($r['campaign_start']));
                                                                $endDate = date("d M Y", strtotime($r['campaign_end']));
                                                                $daysLeft = date_diff(date_create($r['campaign_end']), date_create(date("Y-m-d")))->format("%a");
                                                                echo $startDate ?> - <?php echo $endDate . " (" . $daysLeft . " days left)" ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 fw-bold">Total needed (RM)</div>
                                                            :
                                                            <div class="col">
                                                                <?php
                                                                echo $r['campaign_raised'];
                                                                ?>
                                                                /
                                                                <?php echo $r['campaign_amount'];
                                                                if ($r['campaign_raised'] > $r['campaign_amount']) {
                                                                    echo " (Met the target)";
                                                                } else if ($r['campaign_raised'] == 0) {
                                                                    echo " (No donation made yet)";
                                                                } else {
                                                                    echo " (Not completed yet)";
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <?php if (isset($_GET['ongoingCampaignId']) && $_GET['ongoingCampaignId']) { ?>
                                            <div class="chart-container">
                                                <canvas id="ongoingCampaignChart"></canvas>
                                            </div>
                                        <?php
                                            $campaign_status = 1; // Accepted
                                            $campaignId = $_GET['ongoingCampaignId'];

                                            $query = "SELECT * FROM campaign WHERE campaign_status = ? AND campaign_start <= CURDATE() AND campaign_end >= CURDATE() AND campaign_id=?";
                                            $stmt = $con->prepare($query);
                                            $stmt->bind_param("ii", $campaign_status, $campaignId);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            $r = $result->fetch_assoc();

                                            $startDate = date("Y-m-d", strtotime($r['campaign_start']));
                                            $endDate = date("Y-m-d", strtotime($r['campaign_end']));

                                            $remainingDays = date_diff(date_create($endDate), date_create($startDate))->format("%a");
                                            $remainingMonths = date_diff(date_create($endDate), date_create($startDate))->format("%m");
                                        }

                                        ?>
                                        <script>
                                            const ctx = document.getElementById('ongoingCampaignChart');

                                            new Chart(ctx, {
                                                plugins: [ChartDataLabels],
                                                data: {
                                                    labels: [
                                                        <?php
                                                        if ($remainingDays <= 90) {
                                                            for ($i = 0; $i <= $remainingDays; $i++) {
                                                                $newDate = date("d/m", strtotime($startDate . " + $i days"));
                                                                echo '"' . $newDate . '",';
                                                            }
                                                        } else {
                                                            for ($i = 0; $i <= $remainingMonths; $i++) {
                                                                $newDate = date("M", strtotime($startDate . " + $i months"));
                                                                echo '"' . $newDate . '",';
                                                            }
                                                        }
                                                        ?>
                                                    ],
                                                    datasets: [{
                                                        label: 'A',
                                                        yAxisID: 'A',
                                                        type: 'bar',
                                                        label: 'Total Donation, RM',
                                                        data: [1200, 800, 1450, 4073, 600, 2760, 3230, 1800, 900, 4200, 2790],
                                                        borderWidth: 1
                                                    }, {
                                                        label: 'B',
                                                        yAxisID: 'B',
                                                        type: 'line',
                                                        label: 'Completion Percentage, %',
                                                        data: [5, 8, 14, 23, 38, 41, 44, 65, 74, 82, 84],
                                                        borderWidth: 1
                                                    }]
                                                },
                                                options: {
                                                    plugins: {
                                                        title: {
                                                            text: '<?php echo $r['campaign_name'] ?> Progress Chart',
                                                            display: true
                                                        }
                                                    },
                                                    scales: {
                                                        x: {
                                                            title: {
                                                                display: true,
                                                                text: <?php if ($remainingDays <= 90) {
                                                                            echo "'Date'";
                                                                        } else {
                                                                            echo "'Month'";
                                                                        } ?>
                                                            }
                                                        },
                                                        A: {
                                                            type: 'linear',
                                                            position: 'left',
                                                            grid: {
                                                                display: true
                                                            },
                                                            title: {
                                                                display: 'auto',
                                                                text: 'Total Donation, RM'
                                                            },
                                                            ticks: {
                                                                min: 0
                                                            }
                                                        },
                                                        B: {
                                                            type: 'linear',
                                                            position: 'right',
                                                            grid: {
                                                                display: false
                                                            },
                                                            title: {
                                                                display: 'auto',
                                                                text: 'Completion Percentage, %'
                                                            },
                                                            ticks: {
                                                                max: 100,
                                                                min: 0
                                                            }
                                                        }

                                                        // y: {
                                                        //     beginAtZero: true,
                                                        //     title: {
                                                        //         display: true,
                                                        //         text: 'Total Donation'
                                                        //     },
                                                        //     ticks: {
                                                        //         // stepSize: 5,
                                                        //         min: 0, // minimum value
                                                        //         max: 10000 // maximum value
                                                        //     }
                                                        // },
                                                    }
                                                }
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Completed Campaign Information <span> | Info + Chart</span></h5>
                                    <div id="reportsChart">
                                        <form action="admin_campaign_chart.php" method="POST">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <select class="form-select" name="campaignId" required>
                                                        <option value="" disabled selected>Choose Campaign</option>
                                                        <?php
                                                        /* SELECT Query (Only display accepted campaign for ended campaign) */
                                                        $campaign_status = 1; // Accepted
                                                        $query = "SELECT * FROM campaign WHERE campaign_status = ? AND campaign_end < CURDATE()";
                                                        $stmt = $con->prepare($query);
                                                        $stmt->bind_param("i", $campaign_status);
                                                        $stmt->execute();
                                                        $result = $stmt->get_result();
                                                        while ($r = $result->fetch_assoc()) {
                                                        ?>
                                                            <option value="<?php echo $r['campaign_id']; ?>"><?php echo $r['campaign_name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <button class="btn btn-primary" type="submit" name="completedCampaignInfoBtn">Check</button>
                                                </div>
                                            </div>
                                        </form>
                                        <?php
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($r = $result->fetch_assoc()) {
                                            if (isset($_GET['completedCampaignId']) && $_GET['completedCampaignId'] == $r['campaign_id']) {
                                        ?>
                                                <div class="my-3">
                                                    <h5 class="fw-semibold">Campaign Information (ID <?php echo $r['campaign_id'] ?>)</h5>
                                                    <div class="alert alert-primary" role="alert">
                                                        <div class="row">
                                                            <div class="col-lg-3 fw-bold">Name </div>
                                                            :
                                                            <div class="col"><?php echo $r['campaign_name']; ?> </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 fw-bold">Description</div>
                                                            :
                                                            <div class="col"><?php echo $r['campaign_description']; ?> </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 fw-bold">Date created</div>
                                                            :
                                                            <div class="col">
                                                                <?php
                                                                $dateCreated = date("d M Y", strtotime($r['campaign_created_date']));
                                                                echo $dateCreated;
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 fw-bold">Duration</div>
                                                            :
                                                            <div class="col">
                                                                <?php
                                                                $startDate = date("d M Y", strtotime($r['campaign_start']));
                                                                $endDate = date("d M Y", strtotime($r['campaign_end']));
                                                                $daysAgo = date_diff(date_create($r['campaign_end']), date_create(date("Y-m-d")))->format("%a");
                                                                echo $startDate ?> - <?php echo $endDate . " (" . $daysAgo . " days ago)" ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 fw-bold">Total needed (RM)</div>
                                                            :
                                                            <div class="col">
                                                                <?php
                                                                echo $r['campaign_raised'];
                                                                ?>
                                                                /
                                                                <?php echo $r['campaign_amount'];
                                                                if ($r['campaign_raised'] > $r['campaign_amount']) {
                                                                    echo " (Met the target)";
                                                                } else if ($r['campaign_raised'] == 0) {
                                                                    echo " (No donation has been made)";
                                                                } else {
                                                                    echo " (Not completed)";
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    TODO: Chart
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
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
                                        <div><?php echo $user['user_username']; ?></div>
                                    </div>
                                </div>
                                <div class="activity-item d-flex">
                                    <div class="activity-content">
                                        <span class="fw-bold text-dark">
                                            Full Name
                                        </span>
                                        <div><?php echo $user['user_name']; ?></div>
                                    </div>
                                </div>
                                <div class="activity-item d-flex">
                                    <div class="activity-content">
                                        <span class="fw-bold text-dark">
                                            Email
                                        </span>
                                        <div><?php echo $user['user_email']; ?></div>
                                    </div>
                                </div>
                                <div class="activity-item d-flex">
                                    <div class="activity-content">
                                        <span class="fw-bold text-dark">
                                            Phone Number
                                        </span>
                                        <div><?php echo $user['user_phone']; ?></div>
                                    </div>
                                </div>
                                <div class="activity-item d-flex">
                                    <div class="activity-content">
                                        <span class="fw-bold text-dark">
                                            Address
                                        </span>
                                        <div><?php echo $user['user_address']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body pb-0">
                            <?php
                            /* SELECT Query */
                            $campaignStatus = 1; // Accepted
                            $query = "SELECT COUNT(*) FROM campaign WHERE campaign_status = ? AND campaign_end > CURDATE()";
                            $stmt = $con->prepare($query);
                            $stmt->bind_param("i", $campaignStatus);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $totalCamp = mysqli_fetch_assoc($result)['COUNT(*)'];
                            ?>
                            <h5 class="card-title">
                                Total Ongoing Campaign (<?php echo $totalCamp ?>)<span> | Pie Chart</span>
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
                                                        $campaignCategoryId = 1; // Cash
                                                        $query = "SELECT COUNT(*) FROM campaign WHERE campaign_status = ? AND campaign_category_id = ? AND campaign_end > CURDATE()";
                                                        $stmt = $con->prepare($query);
                                                        $stmt->bind_param("ii", $campaignStatus, $campaignCategoryId);
                                                        $stmt->execute();
                                                        $result = $stmt->get_result();
                                                        $totalCategoryCash = mysqli_fetch_assoc($result)['COUNT(*)'];
                                                        ?> {
                                                            value: <?php echo $totalCategoryCash ?>,
                                                            name: "Cash",
                                                        },

                                                        <?php
                                                        $campaignCategoryId = 2; // School
                                                        $query = "SELECT COUNT(*) FROM campaign WHERE campaign_status = ? AND campaign_category_id = ? AND campaign_end > CURDATE()";
                                                        $stmt = $con->prepare($query);
                                                        $stmt->bind_param("ii", $campaignStatus, $campaignCategoryId);
                                                        $stmt->execute();
                                                        $result = $stmt->get_result();
                                                        $totalCategorySchool = mysqli_fetch_assoc($result)['COUNT(*)'];
                                                        ?> {
                                                            value: <?php echo $totalCategorySchool ?>,
                                                            name: "School Necessity",
                                                        },

                                                        <?php
                                                        $campaignCategoryId = 3; // Faci
                                                        $query = "SELECT COUNT(*) FROM campaign WHERE campaign_status = ? AND campaign_category_id = ? AND campaign_end > CURDATE()";
                                                        $stmt = $con->prepare($query);
                                                        $stmt->bind_param("ii", $campaignStatus, $campaignCategoryId);
                                                        $stmt->execute();
                                                        $result = $stmt->get_result();
                                                        $totalCategoryFaci = mysqli_fetch_assoc($result)['COUNT(*)'];
                                                        ?> {
                                                            value: <?php echo $totalCategoryFaci ?>,
                                                            name: "Facilitator",
                                                        },

                                                        <?php
                                                        $campaignCategoryId = 4; // Service
                                                        $query = "SELECT COUNT(*) FROM campaign WHERE campaign_status = ? AND campaign_category_id = ? AND campaign_end > CURDATE()";
                                                        $stmt = $con->prepare($query);
                                                        $stmt->bind_param("ii", $campaignStatus, $campaignCategoryId);
                                                        $stmt->execute();
                                                        $result = $stmt->get_result();
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

    <!-- Imports -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.4.0/echarts.min.js" integrity="sha512-LYmkblt36DJsQPmCK+cK5A6Gp6uT7fLXQXAX0bMa763tf+DgiiH3+AwhcuGDAxM1SvlimjwKbkMPL3ZM1qLbag==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../js/main.js"></script>

</body>

</html>