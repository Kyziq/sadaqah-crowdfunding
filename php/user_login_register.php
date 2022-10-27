<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <!-- ***** Imports ***** -->
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="../js/script.js" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Relaunch modal -->
    <?php
    if ((isset($_GET["login"]) && $_GET["login"] == 'failed') || (isset($_GET["passw"]) && $_GET["passw"] == 'failed')) {
    ?>
        <script type="text/javascript">
            window.onload = () => {
                $("#loginModal").modal("show");
            };
        </script>
    <?php
    }
    ?>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-mainColour">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sadaqah Crowd Funding</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Campaign
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Cash</a></li>
                            <li><a class="dropdown-item" href="#">School</a></li>
                            <li><a class="dropdown-item" href="#">Services</a></li>
                            <li><a class="dropdown-item" href="#">Facilitator</a></li>
                        </ul>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
                </form>
            </div>
        </div>
    </nav>
  
    <!-- Login Modal -->
    <div class="container p-5 my-5">
        <div class="modal fade" id="loginModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Form -->
                    <form action="user_login_action.php" method="post">
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
                                if (isset($_GET["login"]) && $_GET["login"] == 'failed') {
                                    echo '<span style="color: red;">Account does not exist!</span>';
                                } else if (isset($_GET["passw"]) && $_GET["passw"] == 'failed') {
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
    </div>

    <!-- Register Modal -->
    <div class="container p-5 my-5">
        <div class="modal fade registerModal" id="registerModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Form -->
                    <form action="user_register_save.php" method="post">
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
    </div>
    
    <!-- main content -->
    <div class="jumbotron">
        <h1 class=text-center>hello World</h1>
    </div>
    <script>
        // Toggle password visibility
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