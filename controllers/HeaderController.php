<?php
class HeaderController{

    public function whichActive($page, $pageNumber){
        $page = explode("/", $page);
        $page = $page[count($page)-1];
        $page = explode(".", $page);
        $page = $page[0];
        if(strpos($page, "?")){
            $page2 = explode("?", $page);
            $page = $page2[0];
        }
        if($page == "home" && $pageNumber == 1){
            return "active";
        }
        if($page == "about" && $pageNumber == 2){
            return "active";
        }
        if($page == "contact" && $pageNumber == 3){
            return "active";
        }
        if($page == "product" && $pageNumber == 4){
            return "active";
        }
        if($page == "news" && $pageNumber == 5){
            return "active";
        }
    }
}
