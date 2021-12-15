<?php
require_once(__DIR__."/../repository/ProductRepository.php");
class ProductController{
    private $productRepository;


    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    public function index(){
        $products = $this->getProducts();
        require_once(__DIR__."/../view/ProductView.php");
    }

    public function getProducts(){
        $productArr = [];
        foreach($this->productRepository->listAll() as $product){
            $arr = [];
            $arr["img"] = $product->getImage();
            $arr["title"] = $product->getTitle();
            $arr["description"] = $product->getDescription();
            $arr["id"] = $product->getId();
            $productArr[] = $arr;
        }
        return $productArr;
    }
}