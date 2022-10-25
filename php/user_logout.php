<?php
session_start();
session_destroy();
header("Location: user_login_register.php");
