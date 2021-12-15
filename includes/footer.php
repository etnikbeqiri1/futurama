<footer>
    <div class="footer-body">
        <div class="row">
            <div class="col-6">
                <span>Copyright &copy; <?PHP echo date("Y"); ?> <b>Futurama</b> - All Rights Reserved</span>
            </div>
            <div class="col-6">
                <div style="float:right">
                    <img src="img/logo.png" alt="Logo" width="100"/>
                </div>
            </div>
        </div>

    </div>
</footer>
<script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php if($headerController->whichActive($_SERVER['REQUEST_URI'], 1) == 'active')
        echo '<script src="js/main.js"></script>';
    else
        echo '<script src="js/seconds.js"></script>';
    ?>
</body>

</html>
