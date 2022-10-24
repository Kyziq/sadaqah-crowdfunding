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
    <!-- Registration Form -->
    <div class="container">
        Registration Form
        <form action="user_register_save.php" method="post">

            <!-- <div class="form-floating">
                <input type="email" id="email" class="form-control" placeholder="Input email">
                <label for="email" class="form-label">Email</label>
            </div> -->

            <label for="username" class="form-label">Username:</label>
            <div class="mb-3">
                <input type="text" class="form-control" id="username" name="username" required />
            </div>

            <label for="password" class="form-label">Password:</label>
            <div class="input-group mb-3">
                <input type="password" class="form-control" id="password" name="password" data-toggle="password" required />
                <div class="input-group-text">
                    <i class="fa fa-eye" id="toggleNewPassword" style="cursor: pointer"></i>
                </div>
            </div>

            <label for="name" class="form-label">Full Name:</label>
            <div class="mb-3">
                <input type="text" class="form-control" id="name" name="name" required />
            </div>

            <label for="email" class="form-label">Email:</label>
            <div class="mb-3">
                <input type="email" class="form-control" id="email" name="email" required />
            </div>

            <label for="phone" class="form-label">Phone Number:</label>
            <div class="mb-3">
                <input type="number" step=1 class="form-control" id="phone" name="phone" required />
            </div>

            <label for="address" class="form-label">Address:</label>
            <div class="mb-3">
                <textarea type="text" class="form-control" id="address" name="address" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary" name="register-button">Register</button>

        </form>
        <span class="text">
            Already a member?
            <a href="user_login.php">Login Now</a>
        </span>
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