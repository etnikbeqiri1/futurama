<?php
include __DIR__.'/../includes/header.php';
include __DIR__.'/../util/Helpers.php';
?>
<div id="container">
    <div class="clearfix"></div>
    <?PHP
    for($i=0; $i<count($data); $i++){
        if(($i%2) == 0)
            echo '<div class="row">';

        echo '<div class="col-6 news" onclick="location.href = \'news?id='.$data[$i]->getId().'\';">
        <img width="100%" height="182px" src="'.$data[$i]->getImage().'">
            <h3>'.$data[$i]->getTitle().'</h3>
            <p>'.substr($data[$i]->getContent(), 0, 155).'...</p>
            <span style="color:grey">'.time_elapsed_string($data[$i]->getDate()).'</span>
        </div>';

        if(($i%2) == 1 || count($data) < 2 || (count($data) == 3 && $i==2))
            echo '</div> <div class="clearfix"></div>';
    }
    ?>
    <div class="row">
        <div class="col-12">
            <div class="left">
                <button class="btn" onclick="location.href = '?page=<?PHP echo $page-1; ?>'" <?PHP if($leftButton) echo 'disabled'; ?>>Previous Page</button>
            </div>
            <div class="right">
                <button class="btn" onclick="location.href = '?page=<?PHP echo $page+1; ?>'" <?PHP if($rightButton) echo 'disabled'; ?>>Next Page</button>
            </div>
        </div>
    </div>
</div>
<?php
include __DIR__.'/../includes/footer.php';
?>
