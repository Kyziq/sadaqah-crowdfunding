<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Donation Page</title>
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
    /* Start session and validate donator login */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 3) {
        include_once '../dbcon.php'; // Connect to database 
        date_default_timezone_set('Asia/Singapore');

        $query = "SELECT * FROM user WHERE user_id=?"; // SQL with parameter for user ID
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result(); // Get the MySQLi result
        $user = $result->fetch_assoc(); // Fetch data  
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
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $user['user_username']; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo $user['user_username']; ?></h6>
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
                <a class="nav-link collapsed" href="donator_edit_profile.php">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="donator_donate.php">
                    <i class="bi bi-cash-coin"></i>
                    <span>Donate</span>
                </a>
            </li>
        </ul>
    </aside>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Donate</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="donator.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Donate</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row align-items-top">
                <h5 class="card-title">Available Campaign(s) List</h5>
                <?php
                $campaign_status = 1; // Accepted campaign
                $query = "SELECT * FROM campaign camp, category cat WHERE camp.campaign_category_id = cat.category_id AND camp.campaign_status=? ORDER BY camp.campaign_id";
                $stmt = $con->prepare($query);
                $stmt->bind_param("i", $campaign_status);
                $stmt->execute();
                $result = $stmt->get_result();

                $index = 0;
                while ($camp = $result->fetch_assoc()) {
                    /* Percentage Bar */
                    $percentageBar = 100 - ((($camp['campaign_amount'] - $camp['campaign_raised']) / $camp['campaign_amount']) * 100);
                    $percentageBar = round($percentageBar);

                    /* Date */
                    // Days Left
                    $date1 = new DateTime(date("Y-m-d"));
                    $date2 = new DateTime($camp['campaign_end']);
                    $diff = $date2->diff($date1)->format("%a");  // Find difference
                    $daysLeft = intval($diff);   // Rounding days

                    // Current date must more than campaign start date
                    $currentDate = date("Y-m-d");
                    $startDate = date("Y-m-d", strtotime($camp['campaign_start']));
                    if ($currentDate >= $startDate) {
                ?>
                        <!-- Donation Card -->
                        <div class="col-lg-3 d-flex align-items-stretch">
                            <div class="card">
                                <a href="" type="" class="" data-bs-toggle="modal" data-bs-target="#banner-modal-<?php echo $index ?>">
                                    <img src="<?php echo '../../' . $camp['campaign_banner']; ?>" class="card-img-top img-thumbnail rounded mx-auto d-block mt-3" style="height:120px; width:200px;" alt="Campaign Banner">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title h-20 mb-3" style="min-height: 5rem;"><?php echo $camp['campaign_name']; ?></h5>
                                    <h6 class="card-subtitle mb-2"><b>Category: </b><?php echo $camp['category_name']; ?></h6>
                                    <h6 class="card-subtitle mb-3 overflow-auto" style="height:10rem;"><b>Description: </b><br><?php echo $camp['campaign_description']; ?></h6>
                                    <h6 class="card-subtitle mb-3 text-muted">
                                        <div>
                                            <?php
                                            $startDate = date("d M Y", strtotime($camp['campaign_start']));
                                            $endDate = date("d M Y", strtotime($camp['campaign_end']));
                                            ?>
                                            Duration: <b><?php echo $startDate . " - " . $endDate; ?></b>
                                        </div>
                                        <div>
                                            <?php

                                            ?>
                                            Days Left: <b><?php echo $daysLeft; ?></b>
                                        </div>
                                    </h6>
                                    <div class="camp-progress">
                                        <div class="d-flex justify-content-between">
                                            <div class="fw-light">
                                                <?php echo 'RM' . $camp['campaign_raised']; ?>
                                            </div>
                                            <div class="fw-bold">
                                                of RM<?php echo $camp['campaign_amount']; ?>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated fw-bold" role="progressbar" aria-valuenow="<?php echo $percentageBar; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentageBar; ?>%"><?php echo $percentageBar; ?>%</div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-4 justify-content-end">
                                        <!-- <a class="btn btn-outline-primary" href="#" target="_blank" role="button">More Info</a> -->
                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#donate-modal-<?php echo $index ?>">Donate</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Click Image Modal -->
                        <div class="modal fade" id="banner-modal-<?php echo $index ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><?php echo $camp['campaign_name']; ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="display: flex;">
                                        <img src=" <?php echo '../../' . $camp['campaign_banner'] ?>" alt="Campaign Banner" class="img-fluid img-thumbnail" style="margin-left: auto; margin-right: auto; max-height: 700px; object-fit: contain; ">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Donate Modal -->
                        <div class="modal fade" id="donate-modal-<?php echo $index ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="donator_donate_save.php" method="POST" enctype="multipart/form-data">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5 fw-bold">Donation Form (Campaign ID <?php echo $camp['campaign_id']; ?>)</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Input -->
                                            <input type="hidden" class="form-control" id="user_username" name="user_username" value="<?php echo $user['user_username']; ?>">
                                            <input type="hidden" class="form-control" id="campaignId" name="campaign_id" value="<?php echo $camp['campaign_id']; ?>">

                                            <div class="form-group mb-3">
                                                <label for="campaign_name" class="form-label fw-semibold">Campaign Name</label>
                                                <input type="text" class="form-control-plaintext" id="campaign_name" name="campaign_name" value="<?php echo $camp['campaign_name']; ?>" readonly>
                                            </div>
                                            <div class="form-group mb-3 col-5">
                                                <label for="donate_amount" class="form-label fw-semibold">Donation Amount</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">RM</span>
                                                    <input type="number" class="form-control" id="donate_amount" name="donate_amount" required>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="donate_proof" class="form-label fw-semibold">Proof of Payment</label>
                                                <span class="text-muted small">(.png/.jpg/.jpeg/.pdf)</span>
                                                <input type="file" class="form-control" id="donate_proof" name="donate_proof" accept="image/png,image/jpg,image/jpeg,application/pdf" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" name="donatorDonateButton">Donate Now</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                <?php
                        $index++;
                    }
                }
                ?>
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

    <!-- Imports -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.4.0/echarts.min.js" integrity="sha512-LYmkblt36DJsQPmCK+cK5A6Gp6uT7fLXQXAX0bMa763tf+DgiiH3+AwhcuGDAxM1SvlimjwKbkMPL3ZM1qLbag==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../js/main.js"></script>

</body>

</html>