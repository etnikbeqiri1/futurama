<?php
require_once(__DIR__ . "/../core/Database.php");
require_once(__DIR__ . "/../model/OurTeam.php");
require_once(__DIR__ . "/../util/Logging.php");
require_once(__DIR__ . "/../repository/AuditRepository.php");

class OurTeamRepository
{
    private $connection;
    private $auditRepository;

    public function __construct()
    {
        $this->connection = Database::getConn();
        $this->auditRepository = new AuditRepository();
    }

    /**
     * @param OurTeam $ourTeam
     */
    public function insert(OurTeam $ourTeam)
    {
        $sql = "INSERT INTO `ourteam` (`ourteam_id`, `ourteam_name`, `ourteam_jobDescription`, `ourteam_img`) VALUES (NULL , :name , :desc , :img ) ; ";

        $queryEx = $this->connection->prepare($sql);

        $name = $ourTeam->getName();
        $desc = $ourTeam->getJobDescription();
        $img = $ourTeam->getImg();

        $queryEx->bindparam(":name", $name);
        $queryEx->bindparam(":desc", $desc);
        $queryEx->bindparam(":img", $img);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "insert", "OurTeam", $this->connection->lastInsertId(), "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param OurTeam $ourTeam
     */
    public function update(OurTeam $ourTeam)
    {
        $sql = "UPDATE `ourteam` SET `ourteam_name` = :name,
                `ourteam_jobDescription` = :desc,
                `ourteam_img` =  :img
                WHERE `ourteam`.`ourteam_id` = :id;";

        $queryEx = $this->connection->prepare($sql);

        $name = $ourTeam->getName();
        $desc = $ourTeam->getJobDescription();
        $img = $ourTeam->getImg();
        $id = $ourTeam->getId();

        $queryEx->bindparam(":name", $name);
        $queryEx->bindparam(":desc", $desc);
        $queryEx->bindparam(":img", $img);
        $queryEx->bindparam(":id", $id);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "update", "OurTeam", $this->connection->lastInsertId(), "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param OurTeam $ourTeam
     */
    public function delete(OurTeam $ourTeam)
    {
        $sql = "DELETE FROM `ourteam` WHERE `ourteam`.`ourteam_id` = :id";
        $queryEx = $this->connection->prepare($sql);
        $id = $ourTeam->getId();
        $queryEx->bindparam(":id", $id);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "delete", "OurTeam", $this->connection->lastInsertId(), "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param $id
     * @return OurTeam|null
     * @throws Exception
     */
    public function get($id){
        $sql = $this->connection->prepare("SELECT * FROM ourteam WHERE ourteam_id = :id");
        $sql->bindparam(":id", $id);
        $sql->execute();

        $result = $sql->fetch();
        if($result == null){
            return null;
        }

        return $this->mapOurTeam($result);
    }

    private function mapOurTeam(array $array)
    {
        $slider = new OurTeam($array["ourteam_id"]
            , $array["ourteam_name"]
            , $array["ourteam_jobDescription"]
            , $array["ourteam_img"]);
        return $slider;
    }

    /**
     * @return OurTeam[]
     * @throws Exception
     */
    public function listAll()
    {
        $ourteam = [];
        $sth = $this->connection->prepare("SELECT * FROM `ourteam`");
        $sth->execute();

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($result as $array) {
            $ourteam[] = $this->mapOurTeam($array);
        }

        return $ourteam;
    }
}

?>
