<?php
require_once(__DIR__ . "/../core/Database.php");
require_once(__DIR__ . "/../model/Technologies.php");
require_once(__DIR__ . "/../util/Logging.php");
require_once(__DIR__ . "/../repository/AuditRepository.php");

class TechnologiesRepository
{
    private $connection;
    private $auditRepository;

    public function __construct()
    {
        $this->connection = Database::getConn();
        $this->auditRepository = new AuditRepository();

    }

    /**
     * @param Technologies $tech
     */
    public function insert(Technologies $tech)
    {
        $sql = "INSERT INTO `technologies` (`technologies_id`, `technologies_title`, `technologies_description`, `technologies_img`) VALUES (NULL, :title, :desc, :img); ";

        $queryEx = $this->connection->prepare($sql);

        $name = $tech->getTitle();
        $desc = $tech->getDescription();
        $img = $tech->getImg();

        $queryEx->bindparam(":name", $name);
        $queryEx->bindparam(":desc", $desc);
        $queryEx->bindparam(":img", $img);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "insert", "Technologies", $this->connection->lastInsertId(), "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param Technologies $tech
     */
    public function update(Technologies $tech)
    {
        $sql = "UPDATE `technologies` SET `technologies_title` = :name,
                `technologies_description` = :desc,
                `technologies_img` =  :img
                WHERE `technologies`.`technologies_id` = :id;";

        $queryEx = $this->connection->prepare($sql);

        $name = $tech->getTitle();
        $desc = $tech->getDescription();
        $img = $tech->getImg();
        $id = $tech->getId();

        $queryEx->bindparam(":name", $name);
        $queryEx->bindparam(":desc", $desc);
        $queryEx->bindparam(":img", $img);
        $queryEx->bindparam(":id", $id);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "update", "Technologies", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param Technologies $tech
     */
    public function delete(Technologies $tech)
    {
        $sql = "DELETE FROM `technologies` WHERE `technologies`.`technologies_id` = :id";
        $queryEx = $this->connection->prepare($sql);
        $id = $tech->getId();
        $queryEx->bindparam(":id", $id);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "delete", "Technologies", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param $id
     * @return Technologies|null
     * @throws Exception
     */
    public function get($id){
        $sql = $this->connection->prepare("SELECT * FROM technologies WHERE technologies_id = :id");
        $sql->bindparam(":id", $id);
        $sql->execute();

        $result = $sql->fetch();
        if($result == null){
            return null;
        }

        return $this->mapTechnologies($result);
    }


    private function mapTechnologies(array $array)
    {
        $technologies = new Technologies($array["technologies_id"]
            , $array["technologies_title"]
            , $array["technologies_description"]
            , $array["technologies_img"]);
        return $technologies;
    }

    /**
     * @return Technologies[]
     * @throws Exception
     */
    public function listAll()
    {
        $technologies = [];
        $sth = $this->connection->prepare("SELECT * FROM `technologies`");
        $sth->execute();

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($result as $array) {
            $technologies[] = $this->mapTechnologies($array);
        }

        return $technologies;
    }
}

?>
