

<?php
include(__DIR__ . '/../includes/header.php');
if(!isset($ourteam)){
    $ourteam = "[]";
}
if(!isset($technologies)){
    $technologies = "[]";

}
?>


<div id="container">
    <div class="row">
        <div class="col-5">
            <img class="about-us-image" src="<?php echo $whoarewe[0]['img']; ?>">
        </div>
        <div class="col-6">
            <h1 class="about-us-title"><?php echo $whoarewe[0]['title']; ?></h1>
            <p><?php echo $whoarewe[0]['description']; ?></p>
        </div>
    </div>

    <div class="clearfix"></div>

    <h1>Our Team</h1>

    <div class="row">

        <?php
        foreach((array)$ourteam as $member):
            ?>

            <div class="col-3">
                <div class="team-container">
                    <div class="image-container" style="background-image: url('<?php echo $member['img']; ?>');"></div>
                    <h2><?php echo $member['name']; ?></h2>
                    <h3><?php echo $member['jobDescription']; ?></h3>
                </div>
            </div>

        <?php
        endforeach;
        ?>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-12">
            <h1>Technologies that we use</h1>
        </div>
    </div>


    <?php


    for($i=0; $i<count($technologies) ; $i++):
        if((($i+1)%3) == 1){
            echo "<div class=\"row\">";
        }
            ?>
            <div class="col-3 box">
                <div class="photo-circle chablis">
                    <img src="<?php echo $technologies[$i]['img'];?>">
                </div>
                <h3><?php echo $technologies[$i]['title'];?></h3>
                <span>"<?php echo $technologies[$i]['description'];?>"</span>
            </div>

        <?php

        if((($i+1)%3) == 0){
            echo "</div>";
        }
    endfor;
    ?>

</div>

<?php
include(__DIR__ . '/../includes/footer.php');
?>
