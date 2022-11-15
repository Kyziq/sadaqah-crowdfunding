<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Campaign</title>
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
    /* Start session and validate user */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 2) {
        include_once '../dbcon.php'; // Connect to database 
        date_default_timezone_set('Asia/Singapore');

        $query = "SELECT * FROM user WHERE user_id=?"; // SQL with parameters
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result(); // Get the MySQLI result
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
                            <span>Auditor</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="auditor_edit_profile.php">
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
                <a class="nav-link collapsed" href="auditor.php">
                    <i class="bi bi-grid"></i> <span>Auditor Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="auditor_edit_profile.php">
                    <i class="bi bi-person"></i> <span>Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="auditor_verify_campaign.php">
                    <i class="bi bi-cash-coin"></i>
                    <span>Verify Campaign</span>
                </a>
            </li>
        </ul>
    </aside>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Verify Campaign</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="auditor.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Verify Campaign</li>
                </ol>
            </nav>
        </div>
        <?php

        $campaign_status = 3; // 3 = Pending
        $index = 0;
        $query = "SELECT * FROM campaign camp, category cat WHERE cat.category_id=camp.campaign_category_id AND camp.campaign_status=?"; // SQL
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $campaign_status);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>
        <section class="section">
            <div class="row align-items-top">
                <h5 class="card-title">Pending Campaign Verification List</h5>
                <?php
                while ($r = $result->fetch_assoc()) {
                    $currentDate = date("d M Y");
                    $startDate = date("d M Y", strtotime($r["campaign_start"]));
                    $endDate = date("d M Y", strtotime($r["campaign_end"]));
                    $createdCampaignDate = date("d M Y", strtotime($r["campaign_created_date"]));

                    // Make sure ongoing campaign
                    if (date('Y-m-d', strtotime($r['campaign_end'])) > date('Y-m-d')) {
                ?>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between">
                                        <a href="" type="" class="" data-bs-toggle="modal" data-bs-target="#banner-modal-<?php echo $index ?>">
                                            <img src="<?php echo '../../' . $r['campaign_banner']; ?>" class="card-img-top img-thumbnail rounded" style="height:70px; width:70px;" alt="Campaign Banner">
                                        </a>
                                        Requested on <?php echo $createdCampaignDate ?>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- Verify Campaign Form -->
                                    <form action="auditor_verify_campaign_action.php" method="POST">
                                        <input type="hidden" name="campaignId" value="<?php echo $r['campaign_id']; ?>">
                                        <input type="hidden" name="campaignName" value="<?php echo $r['campaign_name']; ?>">

                                        <div class="form-floating">
                                            <input type="text" class="form-control-plaintext" id="campaign_name" value="<?php echo $r['campaign_name']; ?>" readonly>
                                            <label for="campaign_name">Campaign Name</label>
                                        </div>
                                        <div class="fix-floating-label">
                                            <div class="form-floating">
                                                <textarea class="form-control-plaintext" id="campaign_description" style="height: 90px" readonly><?php echo $r['campaign_description']; ?></textarea>
                                                <label for="campaign_description">Campaign Description</label>
                                            </div>
                                        </div>
                                        <div class="form-floating">
                                            <input type="text" class="form-control-plaintext" id="campaignCategory" value="<?php echo $r['category_name']; ?>" readonly>
                                            <label for="campaignCategory">Campaign Category</label>
                                        </div>
                                        <div class="form-floating">
                                            <input type="text" class="form-control-plaintext" id="campaign_amount" value="RM<?php echo $r['campaign_amount']; ?>" readonly>
                                            <label for="campaign_amount">Campaign Amount</label>
                                        </div>
                                        <div class="form-floating col-6 mb-1">
                                            <input type="text" class="form-control-plaintext" id="campaign_duration" value="<?php echo $startDate; ?> - <?php echo $endDate; ?>" readonly>
                                            <label for="campaign_duration">Campaign Duration</label>
                                        </div>

                                        <!-- Input -->
                                        <div class="form-floating mb-3 col-3">
                                            <select class="form-select" id="verificationStatus" name="verificationStatus" required>
                                                <option value="" selected disabled>Select Action</option>
                                                <option value="1">Approve</option>
                                                <option value="2">Decline</option>
                                            </select>
                                            <label for="verificationStatus">Action <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" id="verificationComment" name="verificationComment" placeholder="Leave a comment" style="height: 100px" required></textarea>
                                            <label for="verificationComment">Comment <span class="text-danger">*</span></label>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-primary" type="submit" name="verifyCampaignButton">Submit</button>
                                        </div>
                                    </form>
                                    <!-- End Of Verify Campaign Form -->
                                </div>
                            </div>
                        </div>
                        <!-- Campaign Banner Modal -->
                        <div class="modal fade" id="banner-modal-<?php echo $index ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><?php echo $r['campaign_name']; ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="display: flex;">
                                        <img src=" <?php echo '../../' . $r['campaign_banner'] ?>" alt="Campaign Banner" class="img-fluid img-thumbnail" style="margin-left: auto; margin-right: auto; max-height: 700px; object-fit: contain; ">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="../../js/main.js"></script>
</body>

</html>