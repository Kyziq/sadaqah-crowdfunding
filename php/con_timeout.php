<?php
define("INTERVAL", 30 * 60); // 30 minutes timeout

if (!isset($_COOKIE['expire_time'])) {
?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: 'Your session has expired. Please login again.<br>(Last logged <?php echo $_SESSION['last_logged_in'] ?>)',
            showConfirmButton: true,
            confirmButtonText: 'Confirm',
            confirmButtonColor: '#0d6efd',
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                <?php echo "window.location.href = '../user_logout.php'"; ?>
            }
        })
    </script>
<?php
    session_unset();
    session_destroy();
}

setcookie('expire_time', 'time', time() + INTERVAL);
