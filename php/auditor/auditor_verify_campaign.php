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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link href="../style.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    /* Start session and validate user */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 2) {
        include_once '../dbcon.php'; // Connect to database 
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
                    <i class="bi bi-credit-card"></i>
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
        $query = "SELECT * FROM campaign WHERE campaign_status=?"; // SQL
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
                    $startDate = date("d M Y", strtotime($r["campaign_start"]));
                    $endDate = date("d M Y", strtotime($r["campaign_end"]));
                    $createdCampaignDate = date("d M Y", strtotime($r["campaign_created_date"]));
                ?>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-header">Requested on <?php echo $createdCampaignDate ?></div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <img src="<?php echo $r['campaign_banner']; ?>" class="card-img-top mx-2 mt-2 rounded" style="width:95%;" alt="Campaign Banner">
                                </div>
                                <!-- Verify Donation Form -->
                                <form action="auditor_verify_campaign_action.php" method="POST">
                                    <!-- Input Values -->
                                    <div class="form-floating">
                                        <input type="text" class="form-control-plaintext" id="campaign_name" name="campaign_name" value="<?php echo $r['campaign_name']; ?>" readonly>
                                        <label for="campaign_name">Campaign Name</label>
                                    </div>
                                    <div class="form-floating">
                                        <textarea class="form-control-plaintext" id="campaign_description" name="campaign_description" style="height: 100px"><?php echo $r['campaign_description']; ?></textarea>
                                        <label for="campaign_description">Campaign Description</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="text" class="form-control-plaintext" id="campaign_amount" name="campaign_amount" value="<?php echo $r['campaign_amount']; ?>" readonly>
                                        <label for="campaign_amount">Campaign Amount (RM)</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control-plaintext" id="campaign_start" name="campaign_start" value="<?php echo $startDate; ?>" readonly>
                                                <label for="campaign_start">Campaign Start</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control-plaintext" id="campaign_end" name="campaign_end" value="<?php echo $endDate ?>" readonly>
                                                <label for="campaign_end">Campaign End</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="campaign_status" name="campaign_status" required>
                                            <option value="" selected disabled>Select Action</option>
                                            <option value="1">Approve</option>
                                            <option value="2">Decline</option>
                                        </select>
                                        <label for="campaign_status">Action</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" id="auditor_comment" name="auditor_comment" placeholder="Leave a comment" style="height: 100px" required></textarea>
                                        <label for="auditor_comment">Comment</label>
                                    </div>

                                    <div class="d-flex mt-auto justify-content-center" style="gap:10px">
                                        <button class="btn btn-primary d-flex flex-row-reverse" type="submit">Verify</button>
                                    </div>
                                </form>
                                <!-- End Of Verify Donation Form -->
                            </div>
                        </div>
                    </div>
                <?php
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