<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="./css/custom-css.css">

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Relaunch modal -->
    <?php
    /* Login modal */
    if ((isset($_GET["error"]) && $_GET["error"] == 'username') || (isset($_GET["error"]) && $_GET["error"] == 'password')) {
        echo '
        <script type="text/javascript">
            window.onload = () => {
                $("#loginModal").modal("show");
            };
        </script>
        ';
    }

    /* Register Modal */
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
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><strong>Sadaqah Crowdfunding</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Campaign
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Cash</a></li>
                            <li><a class="dropdown-item" href="#">School</a></li>
                            <li><a class="dropdown-item" href="#">Service</a></li>
                            <li><a class="dropdown-item" href="#">Facilitator</a></li>
                        </ul>
                    <li class="nav-item">
                        <a class="nav-link" href="#aboutUs">About Us</a>
                    </li>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contactUs">Contact Us</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <div class="input-group me-4">
                        <input type="text" class="form-control" placeholder="Search">
                        <button class="btn btn-success">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
                <button class="btn btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                <button class="btn btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
            </div>
        </div>
    </nav>
    <main>
        <!-- main content -->
        <div class="jumbotron jumbo1"></div>
        <!-- Php Numbers -->
        <div class="calculations d-flex">
            <div class="text me-auto pt-3 ms-4">
                <h3><strong>You have the ability to make a difference.</strong></h3>
                <p><strong>Every ringgit counts and has aided those in need</strong></p>
            </div>
            <div class="money d-flex py-2">
                <div class="raised border mx-2 rounded-3 d-flex flex-column text-center">
                    <?php
                    include_once(__DIR__ . '/php/dbcon.php');
                    $query = "SELECT SUM(campaign_raised) FROM campaign";
                    $result = mysqli_query($con, $query);
                    $count = mysqli_fetch_assoc($result)['SUM(campaign_raised)'];
                    ?>
                    <div class="cal bg-success text-white rounded phpButton w-80 mx-3 align-self-center">
                        <p><strong><?php echo "RM" . $count; ?></strong> </p>
                    </div>
                    <div>
                        <p>Raised</p>
                    </div>
                </div>
                <div class="raised border mx-2 rounded-3 d-flex flex-column text-center">
                    <?php
                    $query = "SELECT COUNT(user_id) FROM user";
                    $result = mysqli_query($con, $query);
                    $count = mysqli_fetch_assoc($result)['COUNT(user_id)'];
                    ?>
                    <div class="cal bg-success text-white rounded phpButton w-80 mx-3 align-self-center">
                        <p><strong><?php echo $count ?></strong> </p>
                    </div>
                    <div class="w-100">
                        <p>Givers</p>
                    </div>
                </div>
                <div class="raised border mx-2 rounded-3 d-flex flex-column text-center">
                    <?php
                    $query = "SELECT COUNT(campaign_id) FROM campaign";
                    $result = mysqli_query($con, $query);
                    $count = mysqli_fetch_assoc($result)['COUNT(campaign_id)'];
                    ?>
                    <div class="cal bg-success text-white rounded phpButton w-80 mx-3 align-self-center">
                        <p><strong><?php echo $count ?></strong> </p>
                    </div>
                    <div class="w-100">
                        <p>Campaigns</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Php Numbers -->
        <div class="aboutUs" id="aboutUs">
            <h2 class="mt-5 mb-5 text-center">ABOUT US</h2>
            <div class="cards d-flex justify-content-center mb-4">

                <div class="card mx-2" style="width: 18rem; height:20rem">
                    <img src="https://9tailedkitsune.com/wp-content/uploads/2021/12/nezukoowo.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>

                <div class="card mx-2" style="width: 18rem; height:20rem">
                    <img src="https://9tailedkitsune.com/wp-content/uploads/2021/12/nezukoowo.jpg" class=" card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>

                <div class="card mx-2" style="width: 18rem; height:20rem;">
                    <img src="https://9tailedkitsune.com/wp-content/uploads/2021/12/nezukoowo.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mission Vision -->
        <div class="jumbotron jumbo2 border mt-5 row" id="missionVision">
            <div class="col bannerLeft"></div>
            <div class="col  bannerRight">
                <h3 class="mt-5 ms-3 text-white">Our Mission</h3>
                <p class="ms-3 text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, accusantium vitae! Cumque porro quos, ipsa, provident ullam quasi eum adipisci dicta, aliquid error excepturi! Totam veniam tempore corporis aspernatur odio excepturi ipsam omnis magni asperiores, exercitationem porro laboriosam debitis explicabo.</p>
                <h3 class="mt-3 ms-3 text-white">Our Vision</h3>
                <p class="ms-3 text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, accusantium vitae! Cumque porro quos, ipsa, provident ullam quasi eum adipisci dicta, aliquid error excepturi! Totam veniam tempore corporis aspernatur odio excepturi ipsam omnis magni asperiores, exercitationem porro laboriosam debitis explicabo.</p>
                <div class="d-flex flex-row-reverse mt-5">
                    <button class="btn btn-outline-success ms-2 me-5 text-white btn1">Donate</button>
                    <button class="btn btn-outline-success text-white btn2">Contact Us</button>
                </div>
            </div>
        </div>
        <!-- Mission Vision End-->
        <!-- Categories -->
        <div class="jumbo3 ">
            <h3 class="mt-5"><strong class="mt-5">CATEGORIES</strong></h3>
            <p class="font-weight-light">Let us help you in creating a better tomorrow.</p>

            <div class="choices d-flex justify-content-center ">

                <div class="cash w-10 border border rounded alert alert-light me-4 cardDisplay">
                    <a href="#">
                        <img src="images/category-cash.png" style="height: 30px;">
                        <span>Cash</span>
                    </a>
                </div>
                <div class="school w-10 border border rounded alert alert-light me-4 cardDisplay">
                    <a href="#">
                        <img src="images/category-school.png" style="height: 30px;">
                        <span>School</span>
                    </a>
                </div>
                <div class="faci w-10 border border rounded alert alert-light me-4 cardDisplay">
                    <a href="#">
                        <img src="images/category-facilitator.png" style="height: 30px;">
                        <span>Facilitator</span>
                    </a>
                </div>
                <div class="service w-10 border border rounded alert alert-light me-4 cardDisplay">
                    <a href="#">
                        <img src="images/category-service.png" style="height: 30px;">
                        <span>Service</span>
                    </a>
                </div>
            </div>
            <div class="d-flex flex-row mt-3 mb-3 ms-3">
                <h2 class="text-start me-3">Latest Campaigns</h2> <button class="btn btn-success">View More</button>
            </div>
        </div>
        <div class="donation pt-5">
            <div class="cards d-flex justify-content-center pb-4">
            <?php
                $query = "SELECT * FROM campaign ORDER BY campaign_id limit 5";
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
                <div class="card mx-2" style="width: 18rem; height:22rem">
                    <img src="https://9tailedkitsune.com/wp-content/uploads/2021/12/nezukoowo.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <!--Insert PHP Donation title  -->
                        <h5 class="card-title overflow-auto" style="height:60px;"><?php echo $row['campaign_name']; ?></h5>
                        <p class="card-text overflow-auto style="height:60px;">test</p> 
                        <!-- Insert Category Type and Country -->
                        <div class="position-absolute bottom-0 end-0 mb-2 me-2" style="gap:10px">
                                <a class="btn btn-outline-success" href="#" target="_blank" role="button">More Info</a>
                                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#donate">Donate</button>
                            </div>
                    </div>
                </div>
                <?php
                }
                ?>
                
            </div>
        </div>
        <!-- Contact Us -->
        <div class="jumbotron jumbo4 mt-5 d-flex align-items-center justify-content-center" id="contactUs">
            <div class="text-center">
                <h3 class="d-flex align-items-center mb-3">Got Any Questions To Ask Us?</h3>
                <button class="btn btn-success btn-lg btnContact">Contact Us</button>
            </div>
        </div>
        <!-- End Of Contact Us -->
        <!-- Footer -->
        <footer class="text-center text-lg-start bg-white text-muted">
            <!-- Section: Links  -->
            <section class="">
                <div class="container text-center text-md-start mt-5">
                    <!-- Grid row -->
                    <div class="row mt-3">
                        <!-- Grid column -->
                        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                            <!-- Content -->
                            <h3 class="text-black">Sadaqah <br> Crowdfunding</h3>
                            </p>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                            <!-- Links -->
                            <h6 class="text-uppercase fw-bold mb-4 text-black">
                                Categories
                            </h6>
                            <p>
                                <a href="#!" class="text-reset">Cash</a>
                            </p>
                            <p>
                                <a href="#!" class="text-reset">School Necessity</a>
                            </p>
                            <p>
                                <a href="#!" class="text-reset">Services</a>
                            </p>
                            <p>
                                <a href="#!" class="text-reset">Facilitator</a>
                            </p>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                            <!-- Links -->
                            <h6 class="text-uppercase fw-bold mb-4 text-black">
                                About
                            </h6>
                            <p>
                                <a href="#missionVision" class="text-reset">Our Mission</a>
                            </p>
                            <p>
                                <a href="#missionVision" class="text-reset">Our Vission</a>
                            </p>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                            <!-- Links -->
                            <h6 class="text-uppercase fw-bold mb-4 text-black">Contact</h6>
                            <p><i class="fab fa-facebook-f me-3 text-secondary"></i> Sadaqah Crowdfunding</p>
                            <p class="d-flex"><i class="fas fa-envelope me-3 text-secondary mt-2"></i>sadaqahcrowdfunding@gmail.com</p>
                            <p><i class="fas fa-phone me-3 text-secondary"></i> +6012-345-6789</p>
                            <p><i class="fa-sharp fa-solid fa-location-dot me-3 text-secondary"></i>Menara Zakat, Jalan Teluk Wanjah, 05200 Alor Setar, Kedah</p>
                        </div>
                        <!-- Grid column -->
                    </div>
                    <!-- Grid row -->
                </div>
            </section>
            <!-- Section: Links  -->

            <!-- Copyright -->
            <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.025);">
                © 2022 Copyright:
                <a class="text-reset fw-bold" href="#">Lembaga Zakat Negeri Kedah</a>
            </div>
            <!-- Copyright -->
        </footer>
        <!-- Footer -->
    </main>
    <!-- End of Main -->

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Form -->
                <form action="php/user_login_action.php" method="POST" id="loginForm">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Login Form</h1>
                        <a class="btn-close" data-bs-dismiss="modal" data-bs-target="#loginModal"></a>
                    </div>
                    <div class="modal-body">
                        <a href="../index.php">
                            <img src="https://i0.wp.com/www.zakatkedah.com.my/wp-content/uploads/2021/05/Logo-Zakat-Kedah-Baru-2021.png?w=696&ssl=1" class="mx-auto d-block" style="max-width:40%;" alt="Logo">
                        </a>

                        <!-- Input -->
                        <div class="form-group mb-3">
                            <label for="user_username" class="form-label">Username</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input type="text" class="form-control" id="user_username" name="user_username" placeholder="Enter username" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="user_password" class="form-label">Password</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input type="password" class="form-control" placeholder="Enter your password" name="user_password" required />
                            </div>
                        </div>

                        <div class="mb-3">
                            <?php
                            /* Check for wrong password */
                            if (isset($_GET["error"]) && $_GET["error"] == 'username') {
                                echo '<span style="color: red;">Username does not exist!</span>';
                            } else if (isset($_GET["error"]) && $_GET["error"] == 'password') {
                                echo '<span style="color: red;">Wrong password!</span>';
                            }
                            ?>
                        </div>
                        Don't have an account?
                        <a href="#registerModal" data-target="#registerModal" data-bs-toggle="modal" title="Go to Register Form">
                            Register Now
                        </a>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="login-button">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade registerModal" id="registerModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Form -->
                <form action="php/user_register_save.php" method="POST" id="registerForm">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Registration Form</h1>
                        <a class="btn-close" data-bs-dismiss="modal" data-bs-target="#registerModal"></a>
                    </div>
                    <div class="modal-body">
                        <a href="../index.php">
                            <img src="https://i0.wp.com/www.zakatkedah.com.my/wp-content/uploads/2021/05/Logo-Zakat-Kedah-Baru-2021.png?w=696&ssl=1" class="mx-auto d-block" style="max-width:40%;" alt="Logo">
                        </a>
                        <!-- Input -->
                        <div class="form-group mb-2">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required />
                        </div>

                        <div class="mb-2">
                            <?php
                            /* Check for wrong password */
                            if (isset($_GET["error"]) && $_GET["error"] == 'usernametaken') {
                                echo '<span style="color: red;">Username has been taken!</span>';
                            }
                            ?>
                        </div>

                        <div class="form-group mb-2">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" data-toggle="password" required />
                                <div class="input-group-text">
                                    <i class="fa fa-eye" id="toggleNewPassword" style="cursor: pointer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required />
                        </div>

                        <div class="form-group mb-2">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required />
                        </div>

                        <div class="form-group mb-2">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="number" step=1 class="form-control" id="phone" name="phone" required />
                        </div>

                        <div class="form-group mb-2">
                            <label for="address" class="form-label">Address</label>
                            <textarea type="text" class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>

                        Already a member?
                        <a href="#loginModal" data-target="#loginModal" data-bs-toggle="modal" title="Go to Login Form">
                            Login Now
                        </a>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="register-button">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



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
            //eyeOpenClass: 'fa-eye',
            //eyeCloseClass: 'fa-eye-slash',
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
                                .find(".fa")
                                .removeClass("fa-eye")
                                .addClass("fa-eye-slash");
                            input.attr("type", "text");
                        } else {
                            eye_btn
                                .removeClass("input-password-show")
                                .addClass("input-password-hide");
                            eye_btn
                                .find(".fa")
                                .removeClass("fa-eye-slash")
                                .addClass("fa-eye");
                            input.attr("type", "password");
                        }
                    });
                });
            });
        })(window.jQuery);
    </script>
</body>

</html>