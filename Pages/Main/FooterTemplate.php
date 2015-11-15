    <script type="text/javascript" src="/lib/fullcalendar-2.4.0/lib/jquery.min.js"></script>
    <script type="text/javascript" src="/lib/bootstrap-3.3.5/lib/js/bootstrap.min.js"></script>
<?php
    foreach ($js as $script) {
        echo '<script type="text/javascript" src="'.$script.'" ></script>';
    }
?>
</body>
</html>
