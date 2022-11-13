<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sadaqah Crowdfunding</title>
    <link rel="icon" href="images/logo-LZNK.ico">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.4/swiper-bundle.min.css" integrity="sha512-pJrGHWDVOeiy4UkMtHu0fpD8oLLssFcaW0fsVXUkA1/jDLopa554Z1AZo5SKtekHnnmyat0ipiP0snKDrt0GNg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/homepage.css">
    <link rel="stylesheet" href="./css/custom-css.css">

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/counterup2@2.0.2/dist/index.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.4/swiper-bundle.min.js" integrity="sha512-k2o1KZdvUi59PUXirfThShW9Gdwtk+jVYum6t7RmyCNAVyF9ozijFpvLEWmpgqkHuqSWpflsLf5+PEW6Lxy/wA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>

<body>
    <?php
    include_once(__DIR__ . '/php/dbcon.php');
    date_default_timezone_set('Asia/Singapore');

    /*** Relaunch modal ***/
    // Login modal
    if ((isset($_GET["error"]) && $_GET["error"] == 'username') || (isset($_GET["error"]) && $_GET["error"] == 'password')) {
        echo '
        <script type="text/javascript">
            window.onload = () => {
                $("#loginModal").modal("show");
            };
        </script>
        ';
    }

    // Register Modal
    if ((isset($_GET["error"]) && $_GET["error"] == 'usernametaken')) {
        echo '
        <script type="text/javascript">
            window.onload = () => {
                $("#registerModal").modal("show");
            };
        </script>
        ';
    }
    ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <div class="logo">
                <span class="text-success">Sadaqah Crowdfunding</span>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- 
                <form class="d-flex" role="search">
                    <div class="input-group me-4">
                        <input type="text" class="form-control" placeholder="Search">
                        <button class="btn btn-success">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form> 
                -->

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#campaign">Campaign</a>
                    </li>
                    <li class="nav-item me-4">
                        <a class="nav-link" href="#categories">Categories</a>
                    </li>
                    <li class="nav-item me-2">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                    </li>
                    <li class="nav-item me-2">
                        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <!-- Start Main -->
    <main>
        <!-- Start Banner -->
        <div class="jumbotron jumbo1">
            <img class="jumbo1" src="images/homepage-banner.png" alt="Banner">
        </div>
        <!-- End Banner -->

        <!-- Start Info 1 -->
        <div class="p-3">
            <div class="container-fluid">
                <div class="row">
                    <!-- Text -->
                    <div class="col-md-4">
                        <div class="">
                            <h2 class="fw-bolder">You have the ability to make a difference.</h2>
                            <p class="fw-regular">"Alone we can do so little; together we can do so much. – Helen Keller"</p>
                        </div>
                    </div>

                    <!-- Counter -->
                    <div class="col-md-2 offset-md-4">
                        <div class="text-center">
                            <div class="border rounded-3 bg-success text-white">
                                <h3 class="counter my-2 fw-bold">
                                    <?php
                                    $query = "SELECT SUM(campaign_raised) FROM campaign";
                                    $result = mysqli_query($con, $query);
                                    $count = mysqli_fetch_assoc($result)['SUM(campaign_raised)'];

                                    echo "RM" . number_format($count, 2);
                                    ?>
                                </h3>
                            </div>
                            <h5 class="fw-light">has been raised</h5>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="text-center">
                            <div class="border rounded-3 bg-success text-white">
                                <h3 class="counter my-2 fw-bold">
                                    <?php
                                    $query = "SELECT COUNT(user_id) FROM user";
                                    $result = mysqli_query($con, $query);
                                    $count = mysqli_fetch_assoc($result)['COUNT(user_id)'];

                                    echo $count;
                                    ?>
                                </h3>
                            </div>
                            <h5 class="fw-light">total donators</h5>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="text-center">
                            <div class="border rounded-3 bg-success text-white">
                                <h3 class="counter my-2 fw-bold">
                                    <?php
                                    $query = "SELECT COUNT(campaign_id) FROM campaign";
                                    $result = mysqli_query($con, $query);
                                    $count = mysqli_fetch_assoc($result)['COUNT(campaign_id)'];

                                    echo $count;
                                    ?>
                                </h3>
                            </div>
                            <h5 class="fw-light">available campaigns</h5>
                        </div>
                    </div>
                    <!-- End of Counter -->
                </div>
            </div>
            <script>
                const counterUp = window.counterUp.default

                const callback = entries => {
                    entries.forEach(entry => {
                        const el = entry.target
                        if (entry.isIntersecting && !el.classList.contains('is-visible')) {
                            counterUp(el, {
                                duration: 2000,
                                delay: 16,
                            })
                            el.classList.add('is-visible')
                        }
                    })
                }

                const IO = new IntersectionObserver(callback, {
                    threshold: 1
                })

                const el = document.querySelector('.counter')
                IO.observe(el)

                const counters = document.querySelectorAll('.counter');
                for (const el of counters) {
                    counterUp(el, {
                        duration: 1000,
                        delay: 16,
                    })
                }
            </script>
        </div>
        <!-- End Info 1 -->

        <!-- Campaign -->
        <section id="campaign">
            <div class="bg-success">
                <div class="container pt-5 py-5 text-center">
                    <h3 class="fw-bold text-white">Campaigns</h3>
                    <h5 class="text-white">The following are the most recent campaigns that are currently accepting donations. Login to see more.</h5>
                </div>
                <div class="cards d-flex justify-content-center pb-4">
                    <?php
                    $campaign_status = 1; // Accepted campaign
                    $query = "SELECT * FROM campaign camp, category cat WHERE camp.campaign_category_id=cat.category_id AND camp.campaign_status=? ORDER BY camp.campaign_id desc LIMIT 3";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("i", $campaign_status);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    ?>
                    <?php
                    $index = 0;
                    while ($camp = $result->fetch_assoc()) {
                        $percentageBar = 100 - ((($camp['campaign_amount'] - $camp['campaign_raised']) / $camp['campaign_amount']) * 100);
                        $percentageBar = round($percentageBar);
                    ?>
                        <!-- Donation Card -->
                        <div class="col-md-3 d-flex align-items-stretch mb-4">
                            <div class="card mx-2">
                                <a href="" type="" class="" data-bs-toggle="modal" data-bs-target="#banner-modal-<?php echo $index ?>">
                                    <img src="<?php echo $camp['campaign_banner']; ?>" class="card-img-top img-thumbnail rounded mx-auto d-block mt-3" style="height:120px; width:200px;" alt="Campaign Banner">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title h-20 mb-3 fw-bold" style="min-height: 2rem;"><?php echo $camp['campaign_name']; ?></h5>
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
                                            $date1 = new DateTime(date("Y-m-d"));
                                            $date2 = new DateTime($camp['campaign_end']);
                                            $diff = $date2->diff($date1)->format("%a");  // Find difference
                                            $daysLeft = intval($diff);   // Rounding days
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
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="<?php echo $percentageBar; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentageBar; ?>%"><?php echo $percentageBar; ?>%</div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-4 justify-content-end">
                                        <!-- <a class="btn btn-outline-primary" href="#" target="_blank" role="button">More Info</a> -->
                                        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#loginModal">Login to Donate</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Campaign Banner Modal -->
                        <div class="modal fade" id="banner-modal-<?php echo $index ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold"><?php echo $camp['campaign_name']; ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="display: flex;">
                                        <img src=" <?php echo $camp['campaign_banner'] ?>" alt="Campaign Banner" class="img-fluid img-thumbnail" style="margin-left: auto; margin-right: auto; max-height: 700px; object-fit: contain; ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        $index++;
                    }
                    ?>

                </div>
            </div>
        </section>
        <!-- End Campaign -->

        <!-- Categories -->
        <section id="categories">
            <div class="container text-center">
                <div class="container pt-5 my-3 d-flex align-items-center justify-content-center">
                    <div class="box border rounded p-2 text-center bg-success text-white">
                        <div class="box-title">
                            <h3 class="fw-bold">Categories</h3>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center py-2">
                    <div class="card col-md-3 my-2 me-4" style="width: 18rem;">
                        <div class="card-body">
                            <div class="card-img mb-3"> <img src="images/category-cash.png" style="height: 80px;"></div>
                            <h4 class="fw-bold">Cash</h4>
                        </div>
                    </div>
                    <div class="card col-md-3 my-2 me-4" style="width: 18rem;">
                        <div class="card-body">
                            <div class="card-img mb-3"> <img src="images/category-school.png" style="height: 80px;"></div>
                            <h4 class="fw-bold">School</h4>
                        </div>
                    </div>
                    <div class="card col-md-3 my-2 me-4" style="width: 18rem;">
                        <div class="card-body">
                            <div class="card-img mb-3"> <img src="images/category-facilitator.png" style="height: 80px;"></div>
                            <h4 class="fw-bold">Facilitator</h4>
                        </div>
                    </div>
                    <div class="card col-md-3 my-2 me-4" style="width: 18rem;">
                        <div class="card-body">
                            <div class="card-img mb-3"> <img src="images/category-service.png" style="height: 80px;"></div>
                            <h4 class="fw-bold">Service</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Categories -->

        <!-- Mission Vision -->
        <div class="container text-center mb-5">
            <div class="container pt-5 my-3 d-flex align-items-center justify-content-center">
                <div class="box border rounded p-2 text-center bg-success text-white">
                    <div class="box-title">
                        <h3 class="fw-bold">We are a reliable donation platform</h3>
                    </div>
                </div>
            </div>
            <h5>To make Sadaqah Crowdfunding the best platform for people to discover the assistance they require and the cash they require to realise their goals. We promise to keep an eye on a campaign's originality and success till it achieves its objectives. </h5>
            <div class="row justify-content-md-center">
                <div class="col-md-4">
                    <script src="https://cdn.lordicon.com/qjzruarw.js"></script>
                    <lord-icon src="https://cdn.lordicon.com/hqrgkqvs.json" trigger="loop" delay="2000" style="width:250px;height:250px">
                    </lord-icon>
                    <h4 class="fw-bold">We keep things real</h4>
                    <p>We collaborate with community leaders on the ground to show you the challenges at hand and what is most required.</p>
                </div>
                <div class="col-md-4">
                    <script src="https://cdn.lordicon.com/qjzruarw.js"></script>
                    <lord-icon src="https://cdn.lordicon.com/hbwqfgcf.json" trigger="loop" delay="2000" style="width:250px;height:250px">
                    </lord-icon>
                    <h4 class="fw-bold">We show you the progression</h4>
                    <p>Every ringgit counts, and we show you how, collectively, your contributions have kept causes, communities, and individuals going forward.</p>
                </div>
                <div class="col-md-4">
                    <script src="https://cdn.lordicon.com/qjzruarw.js"></script>
                    <lord-icon src="https://cdn.lordicon.com/nrzqxhfu.json" trigger="loop" delay="2000" style="width:250px;height:250px">
                    </lord-icon>
                    <h4 class="fw-bold">0% platform fee, 100% to the cause</h4>
                    <p>We ensure that all donations made through the platform are directed to the intended cause.</p>
                </div>
            </div>
        </div>

        <!-- -->
        <section>
            <div class="bg-success">
                <div class="container pt-5">
                    <div class="row d-flex text-center">
                        <div class="col-12">
                            <h3 class="fw-bold text-white">Get started to donate with three simple steps!</h3>
                        </div>
                    </div>
                    <div class="row justify-content-center py-5">
                        <div class="card col-md-3 my-2 me-4" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">1. Register</h5>
                                <p class="card-text">Begin by signing up for an account on the platform.</p>
                            </div>
                        </div>
                        <div class="card col-md-3 my-2 me-4" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">2. Donate</h5>
                                <p class="card-text">Submit donation through the dashboard and wait for it to be validated.</p>
                            </div>
                        </div>
                        <div class="card col-md-3 my-2 me-4" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">3. Verification</h5>
                                <p class="card-text">Once verified, your donation will be transferred to the designated campaign!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- -->

        <!-- Footer -->
        <footer class="footer">
            <section class="border-top pt-5 pb-2 text-center text-sm-start">
                <div class="container">
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-4">
                            <a href="#">
                                <div class="logo">
                                    <span class="text-success">Sadaqah Crowdfunding</span>
                                </div>
                            </a>
                            <p class="mt-3 fw-light">
                                <span>sadaqahcrowdfunding@gmail.com</span><br>
                                <span>1-800-88-1740</span><br>
                                <span>Menara Zakat, Jalan Teluk Wanjah, 05200 Alor Setar, Kedah</span><br>
                            </p>
                        </div>
                        <div class="col-md-2 my-4 my-sm-0">
                            <h5 class="fw-bold">Learn More</h5>
                            <a href="#campaign" class="footer-link">Campaign</a><br>
                            <a href="#categories" class="footer-link">Categories</a><br>
                        </div>
                        <div class="col-md-2 my-4 my-sm-0">
                            <h5 class="fw-bold">Categories</h5>
                            <a href="#" class="footer-link">Cash</a><br>
                            <a href="#" class="footer-link">School</a><br>
                            <a href="#" class="footer-link">Facilitator</a><br>
                            <a href="#" class="footer-link">Service</a><br>
                        </div>
                    </div>
                    <div class="row my-4 pt-3 border-top">
                        <div class="col-md-6">&copy; Copyright <strong><span>Lembaga Zakat Negeri Kedah Darul Aman</span></strong>. All Rights Reserved</div>
                    </div>
                </div>
            </section>
        </footer>
        <!-- End Footer -->
    </main>
    <!-- End Main -->




    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fw-bold fs-5">Login Form</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#loginModal" aria-label="Close"></button>
                </div>
                <!-- Form -->
                <form action="php/user_login_action.php" method="POST" id="loginForm" class="needs-validation" novalidate>
                    <div class="modal-body">
                        <div class="mb-3">
                            <img src="./images/logo-LZNK-big.png" class="mx-auto d-block" style="max-width:40%;" alt="Logo">
                        </div>
                        <!-- Input -->
                        <div class="form-group mb-3">
                            <label for="user_username" class="form-label fw-semibold">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" class="form-control" id="user_username" name="user_username" placeholder="Enter your username" required>

                                <div class="invalid-tooltip">Username cannot be blank</div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="user_password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control" placeholder="Enter your password" name="user_password" required />

                                <div class="invalid-tooltip">Password cannot be blank</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <?php
                            /* Check for wrong password */
                            if (isset($_GET["error"]) && $_GET["error"] == 'username') {
                                echo '<div class="alert alert-danger" role="alert">Username does not exist</div>';
                            } else if (isset($_GET["error"]) && $_GET["error"] == 'password') {
                                echo '<div class="alert alert-danger" role="alert">Wrong password</div>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <div>
                            Don't have an account?
                            <a href="#registerModal" data-target="#registerModal" data-bs-toggle="modal" title="Go to Register Form">
                                <span class="text-success">Register Now</span>
                            </a>
                        </div>
                        <button type="submit" class="btn btn-success" name="login-button">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade registerModal" id="registerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fw-bold fs-5">Registration Form</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#registerModal" aria-label="Close"></button>
                </div>
                <!-- Form -->
                <form action="php/user_register_save.php" method="POST" id="registerForm" class="needs-validation" novalidate>
                    <div class="modal-body">
                        <div class="mb-3">
                            <img src="./images/logo-LZNK-big.png" class="mx-auto d-block" style="max-width:40%;" alt="Logo">
                        </div>
                        <!-- Input -->
                        <div class="form-group mb-3">
                            <label for="username" class="form-label fw-semibold">Username</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="username" name="username" required />

                                <div class="invalid-tooltip">Username cannot be blank</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <?php
                            /* Check for wrong password */
                            if (isset($_GET["error"]) && $_GET["error"] == 'usernametaken') {
                                echo '<span style="color: red;">Username has been taken!</span>';
                            }
                            ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" data-toggle="password" required />
                                <div class="input-group-text">
                                    <i class="bi bi-eye-fill" id="toggleNewPassword" style="cursor: pointer"></i>
                                </div>
                                <div class="invalid-tooltip">Password cannot be blank</div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="name" class="form-label fw-semibold">Full Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="name" name="name" required />

                                <div class="invalid-tooltip">Name cannot be blank</div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="email" name="email" required />

                                <div class="invalid-tooltip">Email cannot be blank</div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone" class="form-label fw-semibold">Phone Number</label>
                            <div class="input-group">
                                <input type="number" step=1 class="form-control" id="phone" name="phone" required />

                                <div class="invalid-tooltip">Phone number cannot be blank</div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="address" class="form-label fw-semibold">Address</label>
                            <div class="input-group">
                                <textarea type="text" class="form-control" id="address" name="address" rows="3" required></textarea>

                                <div class="invalid-tooltip">Address cannot be blank</div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-between">
                        <div>
                            Already a member?
                            <a href="#loginModal" data-target="#loginModal" data-bs-toggle="modal" title="Go to Login Form">
                                <span class="text-success">Login Now</span>
                            </a>
                        </div>
                        <button type="submit" class="btn btn-success" name="register-button">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach((form) => {
            form.addEventListener('submit', (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);

            const loginModal = document.getElementById('loginModal')
            loginModal.addEventListener('hidden.bs.modal', event => {
                form.classList.remove('was-validated');
            })

            const registerModal = document.getElementById('registerModal')
            registerModal.addEventListener('hidden.bs.modal', event => {
                form.classList.remove('was-validated');
            })
        });


        // var email = document.getElementById('email');
        // email.oninput = () => {
        //     const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        //     if (!re.test(email.value)) {
        //         email.setCustomValidity("Invalid field.");
        //         email.classList.add('is-invalid');
        //     } else {
        //         email.classList.remove('is-invalid');
        //         email.setCustomValidity("")
        //     }
        // }
    </script>

    <script>
        /* Reset input in login and register form when click */
        $('#loginModal').on('hidden.bs.modal', function(e) {
            $(this).find('#loginForm')[0].reset();
        });
        $('#registerModal').on('hidden.bs.modal', function(e) {
            $(this).find('#registerForm')[0].reset();
        });

        /* Toggle password visibility */
        !(function($) {
            //eyeOpenClass: 'bi bi-eye-fill',
            //eyeCloseClass: 'bi bi-eye-slash-fill',
            "use strict";

            $(function() {
                $('[data-toggle="password"]').each(function() {
                    var input = $(this);
                    var eye_btn = $(this).parent().find(".input-group-text");
                    eye_btn.css("cursor", "pointer").addClass("input-password-hide");
                    eye_btn.on("click", function() {
                        if (eye_btn.hasClass("input-password-hide")) {
                            eye_btn
                                .removeClass("input-password-hide")
                                .addClass("input-password-show");
                            eye_btn
                                .find(".bi")
                                .removeClass("bi-eye-fill")
                                .addClass("bi-eye-slash-fill");
                            input.attr("type", "text");
                        } else {
                            eye_btn
                                .removeClass("input-password-show")
                                .addClass("input-password-hide");
                            eye_btn
                                .find(".bi")
                                .removeClass("bi-eye-slash-fill")
                                .addClass("bi-eye-fill");
                            input.attr("type", "password");
                        }
                    });
                });
            });
        })(window.jQuery);
    </script>
</body>

</html>