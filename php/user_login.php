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
    <div class="container p-5 my-5">
        <a href="../index.php">
            <img src="https://i0.wp.com/www.zakatkedah.com.my/wp-content/uploads/2021/05/Logo-Zakat-Kedah-Baru-2021.png?w=696&ssl=1" class="mx-auto d-block" style="max-width:20%;" alt="Logo">
        </a>
        <!-- Login Form -->
        <form action="user_login_action.php" method="post">
            <div class="h5">Login Form</div>

            <!-- Input -->
            <div class="form-group mb-3">
                <label for="user_username" class="form-label">Username</label>
                <div class="input-group">
                    <div class="input-group-text">
                        <i class="fas fa-user"></i>
                    </div>
                    <input type="text" class="form-control" id="user_username" name="user_username" placeholder="Enter username">
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

            <!-- Button -->
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" name="login-button">Login</button>
            </div>
        </form>

        <div class="mb-3">
            Don't have an account?
            <a href="user_register.php"><button class="btn btn-outline-primary">Register Now</button></a>
        </div>
    </div>
</body>

</html>