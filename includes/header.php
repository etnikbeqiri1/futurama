<?php
require_once(__DIR__.'/../controllers/HeaderController.php');
$headerController = new HeaderController();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="icon" href="img/logoalt.png">

    <title>Futurama</title>
</head>

<body>
<header>
    <h2 class="title">Futurama</h2>
    <a href="javascript:void(0);" class="mobile-icon" onclick="showMenu()"><i class="fa fa-bars"
                                                                              id="nav-icon"></i></a>
    <div class="menu" id="menuNav">
        <span class="element <?php echo $headerController->whichActive($_SERVER['REQUEST_URI'], 1);?>"><a href="home">Home</a></span>
        <span class="element <?php echo $headerController->whichActive($_SERVER['REQUEST_URI'], 2);?>"><a href="about">About</a></span>
        <span class="element <?php echo $headerController->whichActive($_SERVER['REQUEST_URI'], 3);?>"><a href="contact">Contact</a></span>
        <span class="element <?php echo $headerController->whichActive($_SERVER['REQUEST_URI'], 4);?>"><a href="product">Products</a></span>
        <span class="element <?php echo $headerController->whichActive($_SERVER['REQUEST_URI'], 5);?>"><a href="news">News</a></span>

        <a href="login" class="right-elements">Login</a>
    </div>

</header>