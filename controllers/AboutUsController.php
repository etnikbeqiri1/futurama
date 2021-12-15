<?php

//INSERT INTO `ourteam` (`id`, `name`, `jobDescription`, `img`) VALUES (NULL, 'JOHN DOE', 'CEO', 'img/teammember1.png'); 

//INSERT INTO `technologies` (`id`, `title`, `description`, `img`) VALUES (NULL, 'HTML', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...', 'img/html.png'); 

require(__DIR__ . "/../repository/OurTeamRepository.php");
require(__DIR__ . "/../repository/TechnologiesRepository.php");
require(__DIR__ . "/../repository/WhoAreWeRepository.php");
require_once(__DIR__ . "/../util/Logging.php");
class AboutUsController
{
    private $ourTeamRepository;
    private $technologiesRepository;
    private $whoAreWeRepository;


    public function __construct()
    {
        $this->ourTeamRepository = new OurTeamRepository();
        $this->technologiesRepository = new TechnologiesRepository();
        $this->whoAreWeRepository = new WhoAreWeRepository();
    }

    public function index()
    {
        $ourteam = $this->getOurTeam();
        $technologies = $this->getTechnologies();
        $whoarewe = $this->getWhoAreWe();
        require_once(__DIR__ . '/../view/AboutusView.php');
    }

    public function getOurTeam()
    {
        $OurTeamData = [];

        foreach ($this->ourTeamRepository->listAll() as $member){
            $thisTeamMember = [];
            $thisTeamMember["name"] = $member->getName();
            $thisTeamMember["jobDescription"] = $member->getJobDescription();
            $thisTeamMember["img"] = $member->getImg();
            $OurTeamData[] = $thisTeamMember;
        }

        return $OurTeamData;
    }
    public function getTechnologies()
    {
        $technologiess = [];

        foreach ($this->technologiesRepository->listAll() as $tech){
            $thisTechnology = [];
            $thisTechnology["title"] = $tech->getTitle();
            $thisTechnology["description"] = $tech->getDescription();
            $thisTechnology["img"] = $tech->getImg();
            $technologiess[] = $thisTechnology;
        }
        //print_r($technologiess);
        return $technologiess;
    }
    public function getWhoAreWe()
    {
        $whoAreWe = [];

        foreach ($this->whoAreWeRepository->listAll() as $item) {
            $thisItem = [];
            $thisItem["title"] = $item->getTitle();
            $thisItem["description"] = $item->getDescription();
            $thisItem["img"] = $item->getImg();
            $whoAreWe[] = $thisItem;
        }
        return $whoAreWe;
    }
}
?>