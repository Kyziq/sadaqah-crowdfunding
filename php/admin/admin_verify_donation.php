<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Donation Verification</title>
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
    /* Start session and validate admin login */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 1) {
        /* DB Connect and Setting */
        include_once '../dbcon.php';

        /* SELECT Query */
        $query = "SELECT * FROM user WHERE user_id=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

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
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $user['user_username']; ?></span>
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
                <a class="nav-link" href="admin_verify_donation.php">
                    <i class="bi bi-credit-card"></i>
                    <span>Verify Donation</span>
                </a>
            </li>
        </ul>
    </aside>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Verify Donation</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="admin.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Verify Donation</li>
                </ol>
            </nav>
        </div>
        <?php
        $donate_status = 3; // 3 = Pending

        /* SELECT Query */
        $query = "SELECT * FROM user u, donate d, campaign c WHERE d.donator_id=u.user_id AND c.campaign_id=d.campaign_id AND donate_status=? ORDER BY d.donate_date DESC"; // SQL
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $donate_status);
        $stmt->execute();
        $result = $stmt->get_result();
        $count_rows = $result->num_rows;
        ?>
        <section class="section">
            <h5 class="card-title">Pending Donation Verification List</h5>
            <div class="row align-items-top">

                <?php
                $index = 0;
                if ($count_rows == 0) {
                ?>
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="alert alert-primary my-2 mx-2" role="alert">
                                There are currently no pending donation verification requests.
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    while ($r = $result->fetch_assoc()) {
                        $donateDate = date("d M Y h:iA", strtotime($r['donate_date']));
                    ?>
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between">

                                        <a href="" type="" class="" data-bs-toggle="modal" data-bs-target="#banner-modal-<?php echo $index ?>">
                                            <img src="<?php echo '../../' . $r['campaign_banner']; ?>" class="card-img-top img-thumbnail rounded" style="height:70px; width:70px;" alt="Campaign Banner">
                                        </a>

                                        <?php
                                        echo $donateDate;
                                        ?>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- Verify Donation Form -->
                                    <form action="admin_verify_donation_action.php" method="POST">
                                        <input type="hidden" name="donateId" value="<?php echo $r['donate_id']; ?>">
                                        <input type="hidden" name="campaignId" value="<?php echo $r['campaign_id']; ?>">
                                        <input type="hidden" name="donateAmount" value="<?php echo $r['donate_amount']; ?>">

                                        <!-- Input Values -->
                                        <div class="form-floating">
                                            <input type="text" class="form-control-plaintext" id="campaignName" name="campaignName" value="<?php echo $r['campaign_name']; ?>" readonly>
                                            <label for="campaignName" class="form-label">Campaign Name</label>
                                        </div>
                                        <div class="form-floating">
                                            <input type="text" class="form-control-plaintext" id="donatorName" name="donatorName" value="<?php echo $r['user_name']; ?>" readonly>
                                            <label for="donatorName" class="form-label">Donator Name</label>
                                        </div>
                                        <div class="form-floating">
                                            <input type="text" class="form-control-plaintext" id="donateAmount" value="RM<?php echo $r['donate_amount']; ?>" readonly>
                                            <label for="donateAmount" class="form-label">Donate Amount</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="donateStatus" name="donateStatus" required>
                                                <option value="" selected disabled>Select Action</option>
                                                <option value="1">Approve</option>
                                                <option value="2">Decline</option>
                                            </select>
                                            <label for="donateStatus" class="form-label">Action <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="d-flex justify-content-end" style="gap:10px">
                                            <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#proof-modal-<?php echo $index ?>">Proof of Payment</button>
                                            <button class="btn btn-primary d-flex flex-row-reverse" type="submit" name="verifyDonationButton">Verify</button>
                                        </div>
                                    </form>
                                    <!-- End Of Verify Donation Form -->

                                    <!-- Campaign Banner Modal -->
                                    <div class="modal fade" id="banner-modal-<?php echo $index ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold"><?php echo $r['campaign_name']; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="display: flex;">
                                                    <img src=" <?php echo '../../' . $r['campaign_banner'] ?>" alt="Campaign Banner" class="img-fluid img-thumbnail" style="margin-left: auto; margin-right: auto; max-height: 700px; object-fit: contain; ">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Proof of Payment -->
                                    <div class="modal fade" id="proof-modal-<?php echo $index ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        Proof of Payment
                                                        (<?php echo $r['user_name'] . ' - RM' . $r['donate_amount']; ?>)
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="display: flex;">
                                                    <?php
                                                    $allowedImageExt =  array('png', 'jpg', 'jpeg');
                                                    $allowedFileExt =  array('pdf');
                                                    $ext = pathinfo($r['donate_proof'], PATHINFO_EXTENSION);

                                                    // Image (Proof of Payment)
                                                    if (in_array($ext, $allowedImageExt)) {
                                                    ?>
                                                        <img src="<?php echo "../../" . $r['donate_proof'] ?>" alt="Proof of Payment" class="img-fluid img-thumbnail" style="margin-left: auto; margin-right: auto; max-height: 700px; object-fit: contain; ">
                                                    <?php
                                                    }
                                                    // PDF (Proof of Payment)
                                                    else if (in_array($ext, $allowedFileExt)) {
                                                    ?>
                                                        <embed src="<?php echo "../../" . $r['donate_proof'] ?>" frameborder="0" width="100%" height="700px">
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Imports -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="../../js/main.js"></script>
</body>

</html>