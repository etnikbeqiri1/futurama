<?php
require_once(__DIR__.'/../util/AccessVerify.php');
require_once(__DIR__.'/../repository/NewsRepository.php');
class AdminNewsController{
    private $newsRepository;

    public function __construct()
    {
        $this->newsRepository = new NewsRepository();
    }

    public function delete(){
        verifyXML();
        verifyAdmin();
        if(is_numeric($_POST['id'])){
            header('Content-Type: application/json');
            $news = $this->newsRepository->get($_POST['id']);
            if($news != null){
                try{
                    $this->newsRepository->delete($news);
                    die(json_encode(array("success" => true, "description" => "Deleted successfuly")));
                }catch(Exception $ex){
                    die(json_encode(array("success" => false, "description" => $ex->getMessage())));
                }
            }else{
                die(json_encode(array("success" => false, "description" => "We couldn't find the news you requested to delete.")));
            }
        }
    }

    public function add(){
        verifyXML();
        verifyAdmin();
        if(isset($_FILES['file']) && !empty($_POST['title']) && !empty($_POST['content'])){
            header('Content-Type: application/json');
            $filename = round(microtime(true) * 1000)."-news-".$_FILES['file']['name'];
            $location = __DIR__."/../img/news/".$filename;
            $valid_extensions = array("jpg","jpeg","png");
            $imageFileType = pathinfo($location,PATHINFO_EXTENSION);

            if( in_array(strtolower($imageFileType),$valid_extensions) ) {

                $fileMoved = move_uploaded_file($_FILES['file']['tmp_name'],$location);
                if($fileMoved){
                    try {
                        $news = new News(null, $_POST['title'], $_POST['content'], "img/news/".$filename, null);
                        $this->newsRepository->insert($news);
                        die(json_encode(array("success" => true, "description" => "News added successfuly")));
                    }catch(Exception $ex){
                        die(json_encode(array("success" => false, "description" => $ex->getMessage())));
                    }
                }else{
                    die(json_encode(array("success" => false, "description" => "Couldn't move the file, please try again later")));
                }
            }else{
                die(json_encode(array("success" => false, "description" => "Only jpg, jpeg, png allowed to upload")));
            }

        }
    }
    public function index(){
        verifyAdmin();
        verifyXML();
        $newsList = $this->newsRepository->listAll();
        $tableBody = "";
        foreach($newsList as $news){
            $tableBody .= "<div class=\"row\" style=\"margin-bottom: 25px;\">";
            $tableBody .= "    <div class=\"col-12\">";
            $tableBody .= "<div class=\"news-row\">";
            $tableBody .= "<div class=\"row\">";
            $tableBody .= "<div class=\"col-4\">";
            $tableBody .= "<img src=\"".$news->getImage()."\"  class=\"news-image\" alt=\"\">";
            $tableBody .= "</div>";
            $tableBody .= "<div class=\"col-8 padding-10\">";
            $tableBody .= "<h1>".$news->getTitle()."</h1>";
            $tableBody .= "<p>".$news->getContent()." </p>";
            $tableBody .= "<button type=\"button\" name=\"button\" delete=\"".$news->getId()."\" class=\"btn btn-danger\">Delete</button>";
            $tableBody .= "<span class=\"clear\"></span>";
            $tableBody .= "</div>";
            $tableBody .= "</div>";
            $tableBody .= "</div>";
            $tableBody .= "</div>";
            $tableBody .= "</div>";
        }
        require_once(__DIR__.'/../view/AdminNewsView.php');
    }
}