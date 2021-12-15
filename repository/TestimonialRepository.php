<?php
require_once(__DIR__ . "/../core/Database.php");
require_once(__DIR__ . "/../model/Testimonial.php");
require_once(__DIR__ . "/../util/Logging.php");
require_once(__DIR__ . "/../repository/AuditRepository.php");

class TestimonialRepository
{
    private $connection;
    private $auditRepository;

    public function __construct()
    {
        $this->connection = Database::getConn();
        $this->auditRepository = new AuditRepository();

    }

    /**
     * @param Testimonial $testimonial
     */
    public function insert(Testimonial $testimonial)
    {
        $sql = "INSERT INTO `testimonial` (`testimonial_id`, `testimonial_name`, `testimonial_title`, `testimonial_message`, `testimonial_rating`, `testimonial_image`) VALUES (NULL, :name, :title, :message, :rating,:img); ";

        $queryEx = $this->connection->prepare($sql);

        $name = $testimonial->getName();
        $title = $testimonial->getTitle();
        $message = $testimonial->getMessage();
        $rating = $testimonial->getRating();
        $img = $testimonial->getImage();

        $queryEx->bindparam(":name", $name);
        $queryEx->bindparam(":title", $title);
        $queryEx->bindparam(":message", $message);
        $queryEx->bindparam(":rating", $rating);
        $queryEx->bindparam(":img", $img);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "insert", "Testimonial", $this->connection->lastInsertId(), "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param Testimonial $testimonial
     */
    public function update(Testimonial $testimonial)
    {
        $sql = "UPDATE `testimonial` SET `testimonial_name` = :name,
                `testimonial_title` = :title,
                `testimonial_message` = :message,
                `testimonial_rating` = :rating,
                `testimonial_image` =  :img
                WHERE `testimonial`.`testimonial_id` = :id;";

        $queryEx = $this->connection->prepare($sql);

        $name = $testimonial->getName();
        $title = $testimonial->getTitle();
        $message = $testimonial->getMessage();
        $rating = $testimonial->getRating();
        $img = $testimonial->getImage();
        $id = $testimonial->getId();

        $queryEx->bindparam(":name", $name);
        $queryEx->bindparam(":title", $title);
        $queryEx->bindparam(":message", $message);
        $queryEx->bindparam(":rating", $rating);
        $queryEx->bindparam(":img", $img);
        $queryEx->bindparam(":id", $id);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "update", "Testimonial", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param Testimonial $testimonial
     */
    public function delete(Testimonial $testimonial)
    {
        $sql = "DELETE FROM `testimonial` WHERE `testimonial`.`testimonial_id` = :id";
        $queryEx = $this->connection->prepare($sql);
        $id = $testimonial->getId();
        $queryEx->bindparam(":id", $id);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "delete", "Testimonial", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param $id
     * @return Testimonial|null
     * @throws Exception
     */
    public function get($id){
        $sql = $this->connection->prepare("SELECT * FROM testimonial WHERE testimonial_id = :id");
        $sql->bindparam(":id", $id);
        $sql->execute();

        $result = $sql->fetch();
        if($result == null){
            return null;
        }

        return $this->mapTestimonials($result);
    }




    private function mapTestimonials(array $array)
    {
        $testimonial = new Testimonial($array["testimonial_id"]
            , $array["testimonial_name"]
            , $array["testimonial_title"]
            , $array["testimonial_message"]
            , $array["testimonial_rating"]
            , $array["testimonial_image"]);
        return $testimonial;
    }
    /**
     * @return Testimonial[]
     * @throws Exception
     */
    public function listAll()
    {
        $testimonials = [];
        $sth = $this->connection->prepare("SELECT * FROM `testimonial`");
        $sth->execute();

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($result as $array) {
            $testimonials[] = $this->mapTestimonials($array);
        }
        return $testimonials;
    }

















}

?>