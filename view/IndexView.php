<?php
include(__DIR__ . '/../includes/header.php');
if(!isset($testimonialsData) || $testimonialsData == null){
    $testimonialsData = "[]";
}
if(!isset($sliderData) || $sliderData == null){
    $sliderData = "[]";

}
if(!isset($whatWeDoData) || $whatWeDoData == null){
    $whatWeDoData = "[]";
}


?>
<script>
    sliderData = <?php echo $sliderData; ?>;
    testimonials = <?php echo $testimonialsData; ?>;
</script>
<div id="container">
    <div id="slider" class="slider dbizarre">
        <div class="row">
            <div id="slider-data" class="col-6">
                <div class="slider-data">
                    <div>
                        <h1 class="slider-data-title" id="typedTitle">Let us build your app</h1>
                    </div>
                    <span class="slider-data-description" id="typedDesicripion">lorem ipsum dolor sit amet, dist
                            siko rimo tririanti on fri</span>
                    <button class="slider-data-button" onclick="window.location.href='contact'">Contact
                        Us
                    </button>
                </div>
            </div>
            <div class="col-6 image-slider">
                <img style="display: none;" class="slider-image" alt="women on her phone" src="../img/slider1.png"/>
            </div>
        </div>


    </div>



<div class="clearfix"></div>

<div class="row">
    <div class="col-12">
        <h1>What do we do</h1>
    </div>
</div>

<div class="row">
    <?php

    for ($i = 0; $i<3; $i++) {
        echo "<div class=\"col-3 box\">
            <div class=\"photo-circle egg-sour\">
                <img src=\"".$whatWeDoData[$i]['img']."\"";
        echo "\">
           </div>
           <h3>".$whatWeDoData[$i]['title']."</h3>";
        echo "<span>".$whatWeDoData[$i]['description']."</span>
           </div>";
    }
    ?>


</div>

<div class="row">
    <div class="col-12">
        <h1>Testimonials</h1>
    </div>
</div>

    <div class="clearfix"></div>

    <div class="row">


        <div class="col-3 testmonialProfile">
            <img src="img/elon_musk.jpg">
            <h2>Melon Tusk</h2>
            <span>Multi millionare</span>
        </div>

        <div class="col-9 testmonialContent">
            <h2 class="testmonialText">"This is better than X Æ A-12"</h2>
            <span class="stars"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                        class="fa fa-star"></i> <i class="fa fa-star"></i></span>
        </div>

    </div>

    <div class="clearfix"></div>
    <div class="clearfix"></div>

</div>

<?php
include __DIR__.'/../includes/footer.php';
?>

