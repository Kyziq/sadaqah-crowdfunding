<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Edit Campaign</title>
    <link rel="icon" href="../../images/logo-LZNK.ico">

    <!-- Imports -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.css" />
    <link href="../../css/style.css" rel="stylesheet" />
    <link href="../../css/custom-css.css" rel="stylesheet" />

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    /* Start session and validate admin */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 1) {
        /* DB Connect */
        include_once '../dbcon.php';

        /* SELECT Query */
        $query = "SELECT * FROM user WHERE user_id=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $r = $result->fetch_assoc();

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
                <a class="nav-link" data-bs-target="#campaign-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-calendar-event"></i>
                    <span>Campaign</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="campaign-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="admin_create_campaign.php">
                            <i class="bi bi-circle"></i><span>Create Campaign</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin_edit_campaign.php" class="active">
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
            <h1>Edit Campaign</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="admin.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Campaign</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ongoing Campaign List</h5>
                            <?php
                            /* SELECT Query */
                            $query = "SELECT * FROM campaign camp, status sta WHERE camp.campaign_status = sta.status_id";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-sm display" style="width:100%" id="adminEditCampaignTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col" class="col-lg-2">Name</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" class="no-sort col-lg-3">Description</th>
                                            <th scope="col" class="no-sort">Banner</th>
                                            <th scope="col" class="col-lg-1">Category</th>
                                            <th scope="col">Raised</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Start</th>
                                            <th scope="col">End</th>
                                            <th scope="col" class="no-sort">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $index = 1;
                                        while ($r = $result->fetch_assoc()) {
                                            $currentDate = date('Y-m-d');
                                            $startDate = date('Y-m-d', strtotime($r['campaign_start']));
                                            $endDate = date('Y-m-d', strtotime($r['campaign_end']));
                                            $createdDate = date('Y-m-d', strtotime($r['campaign_created_date']));

                                            // Make sure ongoing campaign
                                            if (date('Y-m-d', strtotime($r['campaign_end'])) > date('Y-m-d')) {
                                        ?>
                                                <tr>
                                                    <th scope="row"><?php echo $index; ?></th>

                                                    <td class="lh-sm">
                                                        <div class="overflow-auto lh-sm" style="height: 105px; max-height: 105px; ">
                                                            <?php echo $r['campaign_name']; ?>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        if ($r['status_id'] == 1) {
                                                            echo '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>' . $r['status_desc'] . '</span>';
                                                        } else if ($r['status_id'] == 2) {
                                                            echo '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>' . $r['status_desc'] . '</span>';
                                                        } else if ($r['status_id'] == 3) {
                                                            echo '<span class="badge bg-warning"><i class="bi bi-info-circle me-1"></i>' . $r['status_desc'] . '</span>';
                                                        }
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <div class="overflow-auto lh-sm text-justify" style="height: 105px; max-height: 105px; text-align: justify;">
                                                            <?php echo $r['campaign_description']; ?>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <a href=" #myModal" type="" class="" data-bs-toggle="modal" data-bs-target="#banner-modal-1-<?php echo $index ?>">
                                                            <img src=" <?php echo '../../' . $r['campaign_banner'] ?>" alt="Campaign Banner" class="img-fluid img-thumbnail" style="height: 5rem; width: 5rem;">
                                                        </a>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        if ($r['campaign_category_id'] == 1) {
                                                            echo "Cash";
                                                        } else if ($r['campaign_category_id'] == 2) {
                                                            echo "School Necessity";
                                                        } else if ($r['campaign_category_id'] == 3) {
                                                            echo "Facilitator";
                                                        } else if ($r['campaign_category_id'] == 4) {
                                                            echo "Service";
                                                        }
                                                        ?>
                                                    </td>

                                                    <td><?php echo $r['campaign_raised']; ?></td>

                                                    <td><?php echo $r['campaign_amount']; ?></td>

                                                    <td><?php echo $startDate; ?></td>

                                                    <td><?php echo $endDate; ?></td>

                                                    <td>
                                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#edit-campaign-1-<?php echo $index ?>" data-placement="bottom" title="Edit Campaign" data-toggle="tooltip"><i class="bi bi-pencil-square"></i></button>
                                                    </td>
                                                </tr>

                                                <!-- Campaign Banner Modal -->
                                                <div class="modal fade" id="banner-modal-1-<?php echo $index ?>" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title fw-bold"><?php echo $r['campaign_name']; ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body" style="display: flex;">
                                                                <img src=" <?php echo '../../' . $r['campaign_banner']; ?>" alt="Campaign Banner" class="img-fluid img-thumbnail" style="margin-left: auto; margin-right: auto; max-height: 700px; object-fit: contain; ">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Edit Campaign Modal -->
                                                <div class="modal fade" id="edit-campaign-1-<?php echo $index ?>" tabindex="-1" aria-labelledby="edit-campaign-label" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <form action="admin_edit_campaign_action.php" method="POST" enctype="multipart/form-data">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5 fw-bold" id="editCampaignLabel">Edit Campaign Form</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <!-- Form -->
                                                                        <input type="hidden" name="campaignId" value="<?php echo $r['campaign_id']; ?>">
                                                                        <input type="hidden" name="campaignCreatedDate" value="<?php echo $r['campaign_created_date']; ?>">
                                                                        <input type="hidden" name="campaignBannerDir" value="<?php echo $r['campaign_banner']; ?>">

                                                                        <div class="form-group mb-2">
                                                                            <label for="campaignName" class="form-label fw-semibold">Campaign Name <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control" id="campaignName" name="campaignName" value="<?php echo $r['campaign_name']; ?>" required>
                                                                        </div>
                                                                        <div class="form-group mb-2">
                                                                            <label for="campaignDesc" class="form-label fw-semibold">Campaign Description <span class="text-danger">*</span></label>
                                                                            <textarea class="form-control" id="campaignDesc" name="campaignDesc" rows="4" required><?php echo $r['campaign_description']; ?></textarea>
                                                                        </div>
                                                                        <div class="form-group mb-2">
                                                                            <label for="campaignFileBanner" class="form-label fw-semibold">Campaign Banner <span class="text-danger">*</span></label>
                                                                            <input type="file" class="form-control" id="campaignFileBanner" name="campaignFileBanner" accept="image/*">
                                                                        </div>
                                                                        <div class="form-group col-md-4 mb-2">
                                                                            <label for="campaignCategory" class="form-label fw-semibold">Campaign Category <span class="text-danger">*</span></label>
                                                                            <select class="form-select" id="campaignCategory" name="campaignCategory" required>
                                                                                <?php
                                                                                if ($r['campaign_category_id'] == 1) {
                                                                                ?>
                                                                                    <option value="1" selected>Cash</option>
                                                                                    <option value="2">School Necessity</option>
                                                                                    <option value="3">Facilitator</option>
                                                                                    <option value="4">Service</option>
                                                                                <?php
                                                                                }
                                                                                ?>

                                                                                <?php
                                                                                if ($r['campaign_category_id'] == 2) {
                                                                                ?>
                                                                                    <option value="1">Cash</option>
                                                                                    <option value="2" selected>School Necessity</option>
                                                                                    <option value="3">Facilitator</option>
                                                                                    <option value="4">Service</option>
                                                                                <?php
                                                                                }
                                                                                ?>

                                                                                <?php
                                                                                if ($r['campaign_category_id'] == 3) {
                                                                                ?>
                                                                                    <option value="1">Cash</option>
                                                                                    <option value="2">School Necessity</option>
                                                                                    <option value="3" selected>Facilitator</option>
                                                                                    <option value="4">Service</option>
                                                                                <?php
                                                                                }
                                                                                ?>

                                                                                <?php
                                                                                if ($r['campaign_category_id'] == 4) {
                                                                                ?>
                                                                                    <option value="1">Cash</option>
                                                                                    <option value="2">School Necessity</option>
                                                                                    <option value="3">Facilitator</option>
                                                                                    <option value="4" selected>Service</option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group col-md-4 mb-2">
                                                                            <label for="campaignRaised" class="form-label fw-semibold">Campaign Raised (RM) <span class="text-danger">*</span></label>
                                                                            <input type="number" class="form-control" id="campaignRaised" name="campaignRaised" value="<?php echo $r['campaign_raised']; ?>" required>
                                                                        </div>

                                                                        <div class="form-group col-md-4 mb-2">
                                                                            <label for="campaignAmount" class="form-label fw-semibold">Campaign Amount (RM) <span class="text-danger">*</span></label>
                                                                            <input type="number" class="form-control" id="campaignAmount" name="campaignAmount" value="<?php echo $r['campaign_amount']; ?>" required>
                                                                        </div>

                                                                        <div class="form-group mb-2 col-md-6">
                                                                            <label for="startDate" class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                                                                            <input type="date" class="form-control" id="startDate" name="startDate" value="<?php echo $startDate; ?>" required>
                                                                        </div>

                                                                        <div class="form-group mb-2 col-md-6">
                                                                            <label for="endDate" class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                                                                            <input type="date" class="form-control" id="endDate" name="endDate" value="<?php echo $endDate; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary" name="editCampaignOneButton">Save</button>
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Completed Campaign List</h5>
                            <?php
                            /* SELECT Query */
                            $query = "SELECT * FROM campaign camp, status sta WHERE camp.campaign_status = sta.status_id";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-sm display" style="width:100%" id="adminEditCampaignTable2">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col" class="col-lg-2">Name</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" class="no-sort col-lg-3">Description</th>
                                            <th scope="col" class="no-sort">Banner</th>
                                            <th scope="col" class="col-lg-1">Category</th>
                                            <th scope="col">Raised</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Start</th>
                                            <th scope="col">End</th>
                                            <th scope="col" class="no-sort">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $index = 1;
                                        while ($r = $result->fetch_assoc()) {
                                            $currentDate = date('Y-m-d');
                                            $startDate = date('Y-m-d', strtotime($r['campaign_start']));
                                            $endDate = date('Y-m-d', strtotime($r['campaign_end']));
                                            $createdDate = date('Y-m-d', strtotime($r['campaign_created_date']));

                                            // Make sure ended campaign
                                            if ($currentDate > $endDate) {
                                        ?>
                                                <tr>
                                                    <th scope="row"><?php echo $index; ?></th>

                                                    <td class="lh-sm">
                                                        <div class="overflow-auto lh-sm" style="height: 105px; max-height: 105px;">
                                                            <?php echo $r['campaign_name']; ?>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        if ($r['status_id'] == 1) {
                                                            echo '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>' . $r['status_desc'] . '</span>';
                                                        } else if ($r['status_id'] == 2) {
                                                            echo '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>' . $r['status_desc'] . '</span>';
                                                        } else if ($r['status_id'] == 3) {
                                                            echo '<span class="badge bg-warning"><i class="bi bi-info-circle me-1"></i>' . $r['status_desc'] . '</span>';
                                                        }
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <div class="overflow-auto lh-sm" style="height: 105px; max-height: 105px; text-align: justify;">
                                                            <?php echo $r['campaign_description']; ?>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <a href="#myModal" type="" class="" data-bs-toggle="modal" data-bs-target="#banner-modal-2-<?php echo $index ?>">
                                                            <img src=" <?php echo '../../' . $r['campaign_banner'] ?>" alt="Campaign Banner" class="img-fluid img-thumbnail" style="height: 5rem; width: 5rem;">
                                                        </a>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        if ($r['campaign_category_id'] == 1) {
                                                            echo "Cash";
                                                        } else if ($r['campaign_category_id'] == 2) {
                                                            echo "School Necessity";
                                                        } else if ($r['campaign_category_id'] == 3) {
                                                            echo "Facilitator";
                                                        } else if ($r['campaign_category_id'] == 4) {
                                                            echo "Service";
                                                        }
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $r['campaign_raised']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $r['campaign_amount']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $startDate; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $endDate; ?>
                                                    </td>

                                                    <td>
                                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#edit-campaign-2-<?php echo $index ?>" data-placement="bottom" title="New Campaign Version" data-toggle="tooltip"><i class="bi bi-plus-square"></i></button>
                                                    </td>
                                                </tr>

                                                <!-- Campaign Banner Modal -->
                                                <div class="modal fade" id="banner-modal-2-<?php echo $index ?>" tabindex="-1">
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

                                                <!-- New Campaign Modal -->
                                                <div class="modal fade" id="edit-campaign-2-<?php echo $index ?>" tabindex="-1" aria-labelledby="edit-campaign-label" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <form action="admin_create_campaign_action.php" method="POST" enctype="multipart/form-data">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5 fw-bold" id="editCampaignLabel">New Campaign Form</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <!-- Form -->
                                                                        <input type="hidden" name="campaignId" value="<?php echo $r['campaign_id']; ?>">
                                                                        <input type="hidden" name="campaignCreatedDate" value="<?php echo $r['campaign_created_date']; ?>">
                                                                        <input type="hidden" class="form-control" id="campaignRaised" name="campaignRaised" value="0">

                                                                        <div class="form-group mb-2">
                                                                            <label for="campaignName" class="form-label fw-semibold">Campaign Name <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control" id="campaignName" name="campaignName" value="<?php echo $r['campaign_name']; ?>" required>
                                                                        </div>
                                                                        <div class="form-group mb-2">
                                                                            <label for="campaignDesc" class="form-label fw-semibold">Campaign Description <span class="text-danger">*</span></label>
                                                                            <textarea class="form-control" id="campaignDesc" name="campaignDesc" rows="4" required><?php echo $r['campaign_description']; ?></textarea>
                                                                        </div>
                                                                        <div class="form-group mb-2">
                                                                            <label for="campaignFileBanner" class="form-label fw-semibold">Campaign Banner <span class="text-danger">*</span></label>
                                                                            <input type="file" class="form-control" id="campaignFileBanner" name="campaignFileBanner" accept="image/*" required>
                                                                        </div>
                                                                        <div class="form-group col-md-6 mb-2">
                                                                            <label for="campaignCategory" class="form-label fw-semibold">Campaign Category <span class="text-danger">*</span></label>
                                                                            <select class="form-select" id="campaignCategory" name="campaignCategory" required>
                                                                                <?php
                                                                                if ($r['campaign_category_id'] == 1) {
                                                                                ?>
                                                                                    <option value="1" selected>Cash</option>
                                                                                    <option value="2">School Necessity</option>
                                                                                    <option value="3">Facilitator</option>
                                                                                    <option value="4">Service</option>
                                                                                <?php
                                                                                }
                                                                                ?>

                                                                                <?php
                                                                                if ($r['campaign_category_id'] == 2) {
                                                                                ?>
                                                                                    <option value="1">Cash</option>
                                                                                    <option value="2" selected>School Necessity</option>
                                                                                    <option value="3">Facilitator</option>
                                                                                    <option value="4">Service</option>
                                                                                <?php
                                                                                }
                                                                                ?>

                                                                                <?php
                                                                                if ($r['campaign_category_id'] == 3) {
                                                                                ?>
                                                                                    <option value="1">Cash</option>
                                                                                    <option value="2">School Necessity</option>
                                                                                    <option value="3" selected>Facilitator</option>
                                                                                    <option value="4">Service</option>
                                                                                <?php
                                                                                }
                                                                                ?>

                                                                                <?php
                                                                                if ($r['campaign_category_id'] == 4) {
                                                                                ?>
                                                                                    <option value="1">Cash</option>
                                                                                    <option value="2">School Necessity</option>
                                                                                    <option value="3">Facilitator</option>
                                                                                    <option value="4" selected>Service</option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group col-md-6 mb-2">
                                                                            <label for="campaignAmount" class="form-label fw-semibold">Campaign Amount (RM) <span class="text-danger">*</span></label>
                                                                            <input type="number" class="form-control" id="campaignAmount" name="campaignAmount" required>
                                                                        </div>


                                                                        <div class="form-group mb-2 col-md-6">
                                                                            <label for="startDate" class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                                                                            <input type="date" class="form-control" id="startDate" name="startDate" required>
                                                                        </div>

                                                                        <div class="form-group mb-2 col-md-6">
                                                                            <label for="endDate" class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                                                                            <input type="date" class="form-control" id="endDate" name="endDate" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary" name="createCampaignButton">Create</button>
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
                                    </tbody>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.js"></script>
    <script src="../../js/main.js"></script>
</body>

</html>