<script>
    var countdown = new Counter({
        seconds: 3, // Seconds

        onCounterStart: function() {
            // show pop up with a message 
        },

        // callback function for each second
        onUpdateStatus: function(second) {
            // change the UI that displays the seconds remaining in the timeout 
        },

        // callback function for final action after countdown
        onCounterEnd: function() {
            // show message that session is over (redirect or log out)
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
        }
    });
    countdown.start();

    function Counter(options) {
        var timer;
        var instance = this;
        var seconds = options.seconds || 10;
        var onUpdateStatus = options.onUpdateStatus || function() {};
        var onCounterEnd = options.onCounterEnd || function() {};
        var onCounterStart = options.onCounterStart || function() {};

        function decrementCounter() {
            onUpdateStatus(seconds);
            if (seconds === 0) {
                stopCounter();
                onCounterEnd();
                return;
            }
            seconds--;
        };

        function startCounter() {
            onCounterStart();
            clearInterval(timer);
            timer = 0;
            decrementCounter();
            timer = setInterval(decrementCounter, 1000);
        };

        function stopCounter() {
            clearInterval(timer);
        };

        return {
            start: function() {
                startCounter();
            },
            stop: function() {
                stopCounter();
            }
        }
    };
</script>