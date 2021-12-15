<?php
require_once(__DIR__ . "/../core/Database.php");
require_once(__DIR__ . "/../model/Slider.php");
require_once(__DIR__ . "/../util/Logging.php");
require_once(__DIR__ . "/../repository/AuditRepository.php");

class SliderRepository
{
    private $connection;
    private $auditRepository;

    public function __construct()
    {
        $this->connection = Database::getConn();
        $this->auditRepository = new AuditRepository();

    }

    /**
     * @param Slider $slider
     */
    public function insert(Slider $slider)
    {
        $sql = "INSERT INTO `slider` (`slider_color`, `slider_image`, `slider_title`, `slider_description`)
                VALUES (:color, :image, :title, :description); ";

        $queryEx = $this->connection->prepare($sql);

        $color = $slider->getColor();
        $image = $slider->getImage();
        $title = $slider->getTitle();
        $description = $slider->getDescription();

        $queryEx->bindparam(":color", $color);
        $queryEx->bindparam(":image", $image);
        $queryEx->bindparam(":title", $title);
        $queryEx->bindparam(":description", $description);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "insert", "Slider", $this->connection->lastInsertId(), "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param Slider $slider
     */
    public function update(Slider $slider)
    {
        $sql = "UPDATE `slider` SET `slider_color` = :color,
                `slider_image` = :image,
                `slider_title` =  :title,
                `slider_description` = :description,
                WHERE `slider`.`slider_id` = :id;";

        $queryEx = $this->connection->prepare($sql);

        $color = $slider->getColor();
        $image = $slider->getImage();
        $title = $slider->getTitle();
        $description = $slider->getDescription();
        $id = $slider->getId();

        $queryEx->bindparam(":color", $color);
        $queryEx->bindparam(":image", $image);
        $queryEx->bindparam(":title", $title);
        $queryEx->bindparam(":description", $description);
        $queryEx->bindparam(":id", $id);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "update", "Slider", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param Slider $slider
     */
    public function delete(Slider $slider)
    {
        $sql = "DELETE FROM `slider` WHERE `slider`.`slider_id` = :id";
        $queryEx = $this->connection->prepare($sql);
        $id = $slider->getId();
        $queryEx->bindparam(":id", $id);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "delete", "Slider", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param array $array
     * @return Slider
     */
    private function mapSlider(array $array)
    {
        $slider = new Slider($array["slider_id"]
            , $array["slider_color"]
            , $array["slider_image"]
            , $array["slider_title"]
            , $array["slider_description"]);
        return $slider;
    }

    /**
     * @return Slider[]
     * @throws Exception
     */
    public function listAll()
    {
        $sliders = [];
        $sth = $this->connection->prepare("SELECT * FROM `slider`");
        $sth->execute();

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($result as $array) {
            $sliders[] = $this->mapSlider($array);
        }

        return $sliders;
    }
}

?>