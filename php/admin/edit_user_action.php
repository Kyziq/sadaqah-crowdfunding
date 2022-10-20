<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 1) {
} else {
    header("Location: ../user_login.php");
}
