<?php
include __DIR__.'/../includes/header.php';
include __DIR__.'/../util/Helpers.php';
?>
<div id="container">
    <div class="row">
        <div class="col-12">
            <img src="<?php echo $newsData->getImage(); ?>" height="300px" width="100%">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h3 class="title"><?PHP echo $newsData->getTitle(); ?></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p><?PHP echo nl2br($newsData->getContent()); ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <span style="color:gray;"><?PHP echo time_elapsed_string($newsData->getDate()); ?></span>
        </div>
    </div>
</div>

<?php
include __DIR__.'/../includes/footer.php';
?>
