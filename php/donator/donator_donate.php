<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Donator Dashboard</title>

    <!-- Imports -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link href="../style.css" rel="stylesheet" />
</head>

<body>
    <?php
    /* Start session and validate donator login */
    include("../dbcon.php");
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
                <?php
                $query = "SELECT * FROM campaign ORDER BY campaign_id";
                $result = mysqli_query($con, $query) or die("Error: " . mysqli_error($con));
                $numrow = mysqli_num_rows($result);
                ?>
                <?php
                for ($a = 0; $a < $numrow; $a++) {
                    $row = mysqli_fetch_array($result);
                    if ($row['campaign_raised'] == 0) {
                        $percentageBar = 0;
                    } else {
                        $percentageBar = 100 - (($row['campaign_amount'] - $row['campaign_raised']) / 100);
                    }
                ?>
                <!-- card -->
                <div class="col-lg-3 d-flex align-items-stretch" style="">
                    <div class="card">
                        <img src="<?php echo $row['campaign_banner']; ?>" class="card-img-top mx-auto mt-2 rounded" style="width:95%" alt="...">
                        <div class="card-body">
                            <h5 class="card-title h-20 mb-3" style="height:100px"><?php echo $row['campaign_name']; ?></h5>
                            <h6 class="card-subtitle mb-3 text-muted overflow-auto" style="height:100px"><?php echo $row['campaign_description']; ?></h6>
                            <h6 class="card-subtitle mb-3 text-muted"><?php echo $row['campaign_start']; ?></h6>
                            <div class="camp-progress my-3">
                                <div class="d-flex justify-content-between">
                                    <div class="fw-light">
                                        <?php echo 'RM' . $row['campaign_raised']; ?>
                                    </div>
                                    <div class="fw-bold">
                                        of RM<?php echo $row['campaign_amount']; ?>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $percentageBar;?>%">
                                    </div>
                                </div>
                            </div>
                            <div class="card-btn d-flex mt-auto justify-content-end" style="gap:10px">
                                <a class="btn btn-outline-success" href="#" target="_blank" role="button">More Info</a>
                                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#donate">Donate</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>

            <!-- Donate Modal -->
            <div class="modal fade" id="donate" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Donation</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="donator_donation.php" method="post">
                                <div class="form-group mb-3">
                                    <label for="campaignId">Campaign Id:</label>
                                    <input type="text" class="form-control" id="campaignId" name="campaign_id" value="<?php echo $row['campaign_id']; ?>" readonly> 
                                </div>
                                <div class="form-group mb-3">
                                <label for="campaignName">Campaign Name:</label>
                                    <input type="text" class="form-control" id="campaignName" value="<?php echo $row['campaign_name']; ?>" readonly> 
                                </div>
                                <div class="form-group mb-3">
                                <label for="campaignDonate">Donate Amount RM:</label>
                                    <input type="number" class="form-control" id="campaignDonate" name="donate_amount" placeholder="Insert Amount..." required> 
                                </div>
                                <div class="form-group mb-3">
                                <label for="campaignProof">Donate Date:</label>
                                    <input type="date" class="form-control" id="campaignDate" name="donate_date" required> 
                                </div>
                                <div class="form-group mb-3">
                                <label for="campaignProof">Donate Proof:</label>
                                    <input type="file" class="form-control" id="campaignProof" name="donate_proof" required> 
                                </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" name="donate-button">Donate Now</button>
                        </div>
                        </form>
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
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center bg-success"><i class="bi bi-arrow-up-short"></i></a>

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