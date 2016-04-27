<script>
        var $countdown = $("#timer");
        // start the idle timer plugin
        $.idleTimeout('#logout_popup', 'div.ui-dialog-buttonpane button:first', {
            idleAfter: 5,
            pollingInterval: 2,
            keepAliveURL: 'keepalive.php',
            serverResponseEquals: 'OK',
            onTimeout: function () {
                window.location = "timeout.htm";
            },
            onIdle: function () {
                $(this).modal("open");
            },
            onCountdown: function (counter) {
                $countdown.html(counter); // update the counter
            }
        });
</script>
