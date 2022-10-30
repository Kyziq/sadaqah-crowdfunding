<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Edit Campaign</title>
    <link rel="icon" href="../../images/logo-LZNK.ico">

    <!-- Imports -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link href="../style.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
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
                <a class="nav-link collapsed" href="admin.php">
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
                <a class="nav-link" data-bs-target="#campaign-nav" data-bs-toggle="collapse" href="#">
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
                <a class="nav-link collapsed" href="admin_verify_donation.php">
                    <i class="bi bi-credit-card"></i>
                    <span>Verify Payment</span>
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
                            <h5 class="card-title">Edit Campaign</h5>
                            <?php

                            include_once '../dbcon.php';
                            $query = "SELECT * FROM campaign";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="col-lg">ID</th>
                                            <th scope="col" class="col-lg-2">Name</th>
                                            <th scope="col" class="col-lg-3">Description</th>
                                            <th scope="col">Banner</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Raised (RM)</th>
                                            <th scope="col">Amount (RM)</th>
                                            <th scope="col">Start</th>
                                            <th scope="col">End</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $index = 0;
                                        while ($r = $result->fetch_assoc()) {
                                            $startDate = date('Y-m-d', strtotime($r['campaign_start']));
                                            $endDate = date('Y-m-d', strtotime($r['campaign_end']));
                                            $createdDate = date('Y-m-d', strtotime($r['campaign_created_date']));
                                        ?>

                                            <tr>
                                                <th scope="row">
                                                    <?php echo $r['campaign_id']; ?>
                                                </th>
                                                <td>
                                                    <?php echo $r['campaign_name']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $r['campaign_description']; ?>
                                                </td>
                                                <td>
                                                    <a href="#myModal" type="" class="" data-bs-toggle="modal" data-bs-target="#banner-modal-<?php echo $index ?>">
                                                        <img src=" <?php echo $r['campaign_banner'] ?>" alt="Campaign Banner" class="img-fluid img-thumbnail" style="height: 5rem;">
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
                                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#edit-campaign-<?php echo $index ?>">Edit</button>
                                                </td>

                                                <!-- Click Image Modal -->
                                                <div class="modal fade" id="banner-modal-<?php echo $index ?>" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Campaign Banner</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body" style="display: flex;">
                                                                <img src=" <?php echo $r['campaign_banner'] ?>" alt="Campaign Banner" class="img-fluid img-thumbnail" style="margin-left: auto; margin-right: auto; max-height: 700px; object-fit: contain; ">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Edit Campaign Modal -->
                                                <div class="modal fade" id="edit-campaign-<?php echo $index ?>" tabindex="-1" aria-labelledby="edit-campaign-label" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="admin_edit_campaign_action.php" method="POST" onsubmit="return validateEditCampaignForm()" enctype="multipart/form-data">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Campaign Form</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Form -->
                                                                    <input type="hidden" name="campaignId" value="<?php echo $r['campaign_id']; ?>">
                                                                    <input type="hidden" name="campaignCreatedDate" value="<?php echo $r['campaign_created_date']; ?>">

                                                                    <div class="form-group mb-2">
                                                                        <label for="name" class="form-label">Campaign Name</label>
                                                                        <input type="text" class="form-control" name="campaignName" value="<?php echo $r['campaign_name']; ?>">
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label for="description" class="form-label">Campaign Description</label>
                                                                        <textarea class="form-control" name="campaignDesc" rows="4"><?php echo $r['campaign_description']; ?></textarea>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label for="banner" class="form-label">Campaign Banner</label>
                                                                        <input type="hidden" name="campaignBannerDir" value="<?php echo $r['campaign_banner']; ?>">
                                                                        <input type="file" class="form-control" accept="image/*" name="campaignFileBanner">
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label for="category" class="form-label">Campaign Category</label>
                                                                        <select class="form-select" name="campaignCategory">
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
                                                                    <div class="form-group mb-2">
                                                                        <label for="raised" class="form-label">Campaign Raised</label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">RM</span>
                                                                            <input type="number" class="form-control" name="campaignRaised" value="<?php echo $r['campaign_raised']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label for="amount" class="form-label">Campaign Amount</label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">RM</span>
                                                                            <input type="number" class="form-control" name="campaignAmount" value="<?php echo $r['campaign_amount']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label for="amount" class="form-label">Start Date</label>
                                                                        <input type="date" class="form-control" id="startDate" name="startDate" value="<?php echo $startDate; ?>">
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label for="amount" class="form-label">End Date</label>
                                                                        <input type="date" class="form-control" id="endDate" name="endDate" value="<?php echo $endDate; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary" name="edit-campaign-button">Save</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                        <?php
                                            $index++;
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
        <script>
            function validateEditCampaignForm() {
                let startDate = new Date($('#startDate').val());
                let endDate = new Date($('#endDate').val());

                if (startDate > endDate) {
                    alert("Start date must be before end date");
                    return false;
                }
            }
        </script>
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
    <script src="../main.js"></script>

    <?php
    // Close connection
    $stmt->close();
    $con->close();
    ?>
</body>

</html>