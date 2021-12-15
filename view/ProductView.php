<?php
if($products == "" || $products == null){
    $products = [];
}
include_once(__DIR__.'/../includes/header.php');
?>

<div id="container">
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-12">
            <h1>What do we do</h1>
        </div>
    </div>

        <?php
        for ($i = 0; $i<count($products); $i++) {
            if((($i+1)%3) == 1){
                echo '<div class="row">';
            }

            echo "<div class=\"col-3 box\">
            <div class=\"photo-circle egg-sour\">
                <img src=\"".$products[$i]['img']."\"";
            echo "\">
           </div>
           <h3>".$products[$i]['title']."</h3>";
            echo "<span>".$products[$i]['description']."</span>
           </div>";
            if(($i+1)%3 == 0){
                echo '</div>';
            }
        }
        ?>


    </div>
</div>

<?php
include_once(__DIR__.'/../includes/footer.php');
?>
<script src="js/seconds.js"></script>