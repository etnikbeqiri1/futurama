<?php
require_once(__DIR__.'/../repository/NewsRepository.php');
require_once(__DIR__.'/../model/News.php');
class NewsController{

    private $newsRepository;

    public function __construct()
    {
        $this->newsRepository = new NewsRepository();
    }

    public function index(){
        if(isset($_GET['id']) && is_numeric($_GET['id'])){
            $newsData = $this->newsRepository->get($_GET['id']);
            if($newsData == null){
                require_once (__DIR__.'/../view/Error404View.php');
                return;
            }
            require_once(__DIR__.'/../view/NewsGetView.php');
        }else{
            $pages = ceil($this->newsRepository->count()/4);
            if(isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $pages)
                $page = $_GET['page'];
            else
                $page = 1;
                $startForm = ($page-1) * 4;

            $leftButton = false;
            $rightButton = false;
            if($page <= 1)
                $leftButton = true;
            if($page >= $pages){
                $rightButton = true;
            }
            $data = $this->newsRepository->getPagination($startForm, 4);
            require_once(__DIR__.'/../view/NewsView.php');
        }
    }


}