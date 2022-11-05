<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Donator Dashboard</title>
    <link rel="icon" href="../../images/logo-LZNK.ico">

    <!-- Imports -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link href="../../css/style.css" rel="stylesheet" />
    <link href="../../css/custom-css.css" rel="stylesheet" />
</head>

<body>
    <?php
    /* Start session and validate donator login */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 3) {
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
                <a class="nav-link" href="donator.php">
                    <i class="bi bi-grid"></i> <span>Donator Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="donator_edit_profile.php">
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
            <h1>Donator Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="donator.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Donator Dashboard</li>
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
                                        Total Campaign
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>
                                                <?php
                                                $user_id = $_SESSION['user_id'];
                                                $query = "SELECT COUNT(c.campaign_id) FROM user u, donate d, campaign c WHERE u.user_id = d.donator_id AND d.campaign_id = c.campaign_id AND u.user_id = ?";
                                                $stmt = $con->prepare($query);
                                                $stmt->bind_param("i", $user_id);
                                                $stmt->execute();
                                                $result = $stmt->get_result(); // Get the MySQLI result

                                                $count = mysqli_fetch_assoc($result)['COUNT(c.campaign_id)'];
                                                echo $count;
                                                ?>
                                            </h6>
                                            <span class="text-muted small">that you</span>
                                            <span class="text-primary small fw-bold">participated</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Total Donation
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>
                                                <?php
                                                $user_id = $_SESSION['user_id'];
                                                $donate_status = 1; // 1 = Accepted
                                                $query = "SELECT SUM(d.donate_amount) FROM user u, donate d WHERE u.user_id = d.donator_id AND u.user_id = ? AND d.donate_status = ?";
                                                $stmt = $con->prepare($query);
                                                $stmt->bind_param("ii", $user_id, $donate_status);
                                                $stmt->execute();
                                                $result = $stmt->get_result(); // Get the MySQLI result
                                                $count = mysqli_fetch_assoc($result)['SUM(d.donate_amount)'];

                                                $result = $count == 0 ? 0 : $count;
                                                echo 'RM' . $result;
                                                ?>
                                            </h6>
                                            <span class="text-muted small">you</span>
                                            <span class="text-success small fw-bold">contributed</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-12">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Total Donation Accepted
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-check-lg"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>
                                                <?php
                                                $user_id = $_SESSION['user_id'];
                                                $donate_status = 1; // 1 = Accepted
                                                $query = "SELECT COUNT(d.donate_id) FROM user u, donate d WHERE u.user_id = d.donator_id AND u.user_id = ? AND donate_status=?";
                                                $stmt = $con->prepare($query);
                                                $stmt->bind_param("ii", $user_id, $donate_status);
                                                $stmt->execute();
                                                $result = $stmt->get_result(); // Get the MySQLI result

                                                $count = mysqli_fetch_assoc($result)['COUNT(d.donate_id)'];
                                                echo $count;
                                                ?>
                                            </h6>
                                            <span class="text-danger small fw-bold">accepted</span>
                                            <span class="text-muted small">warm-heartedly</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Donation History</h5>
                                    <?php
                                    $query = "SELECT * FROM campaign c, donate d WHERE c.campaign_id = d.campaign_id AND d.donator_id = ? ORDER BY donate_date DESC";
                                    $stmt = $con->prepare($query);
                                    $stmt->bind_param("i", $user_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result(); // Get the MySQLI result
                                    $count_rows = $result->num_rows;

                                    // At least 1 donation
                                    if ($count_rows >= 1) {
                                    ?>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Campaign</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Donation Amount</th>
                                                    <th scope="col">Donation Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $index = 0;
                                                if ($count_rows >= 1) {
                                                    while ($camp = $result->fetch_assoc()) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo $camp['campaign_name'] ?></td>
                                                            <td>
                                                                <?php
                                                                $date = date('d-m-Y h:m:s', strtotime($camp['donate_date']));
                                                                echo $date;
                                                                ?>
                                                            </td>
                                                            <td>RM<?php echo $camp['donate_amount'] ?></td>
                                                            <?php
                                                            if ($camp['donate_status'] == 1) {
                                                                echo '<td class="text-success">';
                                                                echo 'Accepted';
                                                            } else if ($camp['donate_status'] == 2) {
                                                                echo '<td class="text-success">';
                                                                echo 'Declined';
                                                            } else if ($camp['donate_status'] == 3) {
                                                                echo '<td class="text-warning">';
                                                                echo 'Pending';
                                                            }
                                                            ?>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Accepted Donation Table -->
                        <?php
                        $donate_status = 1; // Accepted donation

                        $query = "SELECT * FROM user u, donate d, campaign c WHERE d.donator_id = u.user_id && d.campaign_id = c.campaign_id && d.donate_status = ? && u.user_id=?";
                        $stmt = $con->prepare($query);
                        $stmt->bind_param("ii", $donate_status, $_SESSION['user_id']);
                        $stmt->execute();
                        $result = $stmt->get_result(); // Get the MySQLi result
                        $count_rows = $result->num_rows;

                        $index = 1;
                        // Must at least have 1 donation accepted
                        if ($count_rows >= 1) {
                        ?>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"> Accepted Donation History</h5>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Campaign</th>
                                                    <th scope="col">Donation Date</th>
                                                    <th scope="col">Donation Amount</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <?php

                                            while ($receipt = $result->fetch_assoc()) {
                                                $campaign_start = date('d M Y', strtotime($receipt['campaign_start']));
                                                $campaign_end = date('d M Y', strtotime($receipt['campaign_end']));
                                                $donate_date = date('d M Y h:i A', strtotime($receipt['donate_date']));
                                            ?>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo $receipt['campaign_name'] ?></td>
                                                        <td>
                                                            <?php
                                                            $donate_date = date('d M Y h:i A', strtotime($receipt['donate_date']));
                                                            echo $donate_date;
                                                            ?>
                                                        </td>
                                                        <td>RM<?php echo $receipt['donate_amount']; ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" onclick="toggleTable();" data-bs-toggle="modal" data-bs-target="#receipt-modal-<?php echo $index ?>">
                                                                Receipt
                                                            </button>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="receipt-modal-<?php echo $index; ?>" tabindex="-1" aria-labelledby="receipt-modal-label-<?php echo $index; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="receipt-modal-label-<?php echo $index; ?>">Receipt</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div id="printableArea-<?php echo $index; ?>">
                                                                        <div class="container">
                                                                            <div class="text-center">
                                                                                <img src="../../images/logo-LZNK-big.png" alt="test" style="height: 70px" class="mb-3">
                                                                                <h4>Sadaqah Crowdfunding Receipt</h4>
                                                                                <p class="fw-light">Invoice No #<?php echo $receipt['donate_id']; ?></p>
                                                                            </div>

                                                                            <hr class="border-success border-2 border-top">

                                                                            <div class="border border-dark border-1 p-3 mb-3 rounded-3  border-opacity-25">
                                                                                <div class="row mb-3 justify-content-between">
                                                                                    <div class="col-4">
                                                                                        <div class="fw-bold">Billed To:</div>
                                                                                        <div class="fw-regular">Lembaga Zakat Negeri Kedah.</div>
                                                                                        <div class="fw-regular">Menara Zakat, Jalan Teluk Wanjah, 05200 Alor Setar, Kedah.</div>
                                                                                        <div class="fw-regular">1-800-88-1740.</div>
                                                                                    </div>
                                                                                    <div class="col-4">
                                                                                        <div class="fw-bold">Donator Details:</div>
                                                                                        <div class="fw-regular"><?php echo $receipt['user_name']; ?>.</div>
                                                                                        <div class="fw-regular"><?php echo $receipt['user_address']; ?>.</div>
                                                                                        <div class="fw-regular">+6<?php echo $receipt['user_phone']; ?>.</div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row justify-content-between">
                                                                                    <div class="col-4">
                                                                                        <div class="fw-bold">Payment Method:</div>
                                                                                        <div class="fw-regular">Online</div>
                                                                                    </div>
                                                                                    <div class="col-4">
                                                                                        <div class="fw-bold">Donate Date:</div>
                                                                                        <div class="fw-regular"><?php echo $donate_date; ?></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="border border-dark border-1 p-3 mb-3 rounded-3  border-opacity-25">
                                                                                <div class="row mb-3">
                                                                                    <div class="col">
                                                                                        <div class="fw-bold">Campaign Name</div>
                                                                                        <div class="fw-regular"><?php echo $receipt['campaign_name']; ?></div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col">
                                                                                        <div class="fw-bold">Campaign Duration</div>
                                                                                        <div class="fw-regular"><?php echo $campaign_start; ?> - <?php echo $campaign_end; ?></div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <div class="fw-bold">Donation Amount</div>
                                                                                        <div class="fw-regular">RM<?php echo $receipt['donate_amount']; ?></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-primary" onclick="printReceipt('printableArea-<?php echo $index; ?>');">Print</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </tbody>
                                            <?php
                                                $index++;
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Account Details
                                <span> | Donator
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
                            $query = "SELECT COUNT(*) FROM campaign WHERE campaign_status = 1";
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
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center bg-primary"><i class="bi bi-arrow-up-short"></i></a>

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
    <script src="../../js/main.js"></script>
</body>

</html>