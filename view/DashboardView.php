<?php
if (!isset($modules)) {
    $modules = [];
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futurama Admin Panel</title>
    <link rel="icon" href="img/logoalt.png">
    <link rel="stylesheet" href="css/user-panel.style.css">
    <link rel="stylesheet" href="https://fontawesome-pro-5-12-0-web.now.sh/css/all.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/modal.style.css">
    <link rel="stylesheet" href="css/alertify.min.css">
    <link rel="stylesheet" href="css/default.min.css">

    <!-- include alertify script -->
    <script src="js/alertify.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

</head>
<body>
<header>
    <style>
        .logout-button{
            padding: 10px;
            border: none;
            border-radius: 11px;
            background-color: #F1F1F1;
            cursor: pointer;
            width: 100px;
        }
        .logout-button:hover{
            background-color: #e8e8e8;

        }

        button:focus {outline:0;}

    </style>

    <div class="mobile-icon" onclick="showMenu()">
        <center><i class="fa fa-bars" id="nav-icon"></i></center>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-6">

            <img src="img/logo-black.png" style="width:100px" alt=""/>
        </div>
        <div class="col-6" style="text-align: right">
            <button href="out" onclick="window.location.replace('out'); " class="logout-button">Logout <i class="fad fa-sign-out-alt"></i></button>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="menu" id="menuNav">
        <div class="row">
            <?php
            foreach ($modules as $module) {
                ?>

                <div class="col-3">
                    <div open="<?php echo $module->getPath() ?>" class="menuRow">
                        <i class="<?php echo $module->getIcon() ?> fa-3x"></i>
                        <span class="element"><a><?php echo $module->getName() ?></a></span>
                    </div>
                </div>

                <?php
            }
            ?>
        </div>


    </div>

</header>

<div id="container">

</div>

</body>
<script src="js/admin-panel.main.js" charset="utf-8"></script>
</html>
