<?php
require(__DIR__ . "/../repository/SliderRepository.php");
require(__DIR__ . "/../repository/TestimonialRepository.php");
require(__DIR__ . "/../repository/ProductRepository.php");
require(__DIR__ . "/../repository/VisitorRepository.php");
require_once(__DIR__ . "/../util/Logging.php");
require_once(__DIR__ . "/../util/Helpers.php");

class IndexController
{

    /**
     * @var SliderRepository
     * @var TestimonialRepository
     * @var ProductRepository
     */
    private $sliderRepository;
    private $testimonialsRepository;
    private $whatWeDoRepository;
    private $visitorRepository;

    public function __construct()
    {
        $this->sliderRepository = new SliderRepository();
        $this->testimonialsRepository = new TestimonialRepository();
        $this->whatWeDoRepository = new ProductRepository();
        $this->whatWeDoRepository = new ProductRepository();
        $this->visitorRepository = new VisitorRepository();
    }

    public function index(){

        if(!isset($_COOKIE["CID"])){
            $cid = generate_cookie_id();
            setcookie("CID",$cid,time() + (86400 * 365), "/");
        }else{
            $cid = $_COOKIE["CID"];
        }
        $browser = get_browser(null, true);
        $visitor = new Visitor(null,$browser["browser"],$browser["platform"],$cid,date('Y-m-d H:i:s'));

        $this->visitorRepository->insert($visitor);

        try {
            $sliderData = $this->getSliderData();
        } catch (Exception $e) {
        }
        $testimonialsData = $this->getTestimonialsData();
        $whatWeDoData = $this->getWhatWeDoData();
        require_once(__DIR__.'/../view/IndexView.php');
    }

    public function out(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        echo( '<meta http-equiv = "refresh" content = "0; url = home" />');
        exit;
    }

    /**
     * @return false|string
     * @throws Exception
     */
    public function getSliderData()
    {
        $sliderData = [];

        foreach ($this->sliderRepository->listAll() as $slider){
            $thisSlider = [];
            $thisSlider["image"] = $slider->getImage();
            $thisSlider["title"] = $slider->getTitle();
            $thisSlider["color"] = $slider->getColor();
            $thisSlider["description"] = $slider->getDescription();
            $sliderData[] = $thisSlider;
        }

        return json_encode($sliderData);
    }
    public function getTestimonialsData()
    {
        $testimonialData = [];

        try {
            foreach ($this->testimonialsRepository->listAll() as $testemonial) {
                $thisTestimonial = [];
                $thisTestimonial["name"] = $testemonial->getName();
                $thisTestimonial["role"] = $testemonial->getTitle();
                $thisTestimonial["picture"] = $testemonial->getImage();
                $thisTestimonial["message"] = $testemonial->getMessage();
                $thisTestimonial["rating"] = $testemonial->getRating();
                $testimonialData[] = $thisTestimonial;
            }
        } catch (Exception $e) {
        }
        return json_encode($testimonialData);
    }

    public function getWhatWeDoData()
    {
        $whatWeDoData = [];

        try {
            foreach ($this->whatWeDoRepository->listAll() as $whatwedooo) {
                $thisWhatWeDoo = [];
                $thisWhatWeDoo["title"] = $whatwedooo->getTitle();
                $thisWhatWeDoo["description"] = $whatwedooo->getDescription();
                $thisWhatWeDoo["img"] = $whatwedooo->getImage();

                $whatWeDoData[] = $thisWhatWeDoo;
            }
        } catch (Exception $e) {
        }
        return $whatWeDoData;
    }

    public function redirectToHome(){
        Header('Location: home');
    }

}
