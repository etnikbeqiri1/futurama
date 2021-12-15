<?php
require_once(__DIR__ . "/../core/Database.php");
require_once(__DIR__ . "/../model/Visitor.php");
require_once(__DIR__ . "/../util/Logging.php");
require_once(__DIR__ . "/../repository/AuditRepository.php");

class VisitorRepository
{
    private $connection;
    private $auditRepository;

    public function __construct()
    {
        $this->connection = Database::getConn();
        $this->auditRepository = new AuditRepository();

    }

    /**
     * @param Visitor $visitor
     * @return Visitor|null
     */
    public function insert(Visitor $visitor)
    {
        $sql = "INSERT INTO `visitor` (`visitor_browser`, `visitor_os`, `visitor_cookie_id`,`visitor_date`) 
                VALUES (:visitor_browser, :visitor_os , :visitor_cookie_id, :visitor_date);";

        $queryEx = $this->connection->prepare($sql);
        $browser = $visitor->getBrowser();
        $os = $visitor->getOs();
        $cookieId = $visitor->getCookieId();
        $date = $visitor->getDate();


        $queryEx->bindparam(":visitor_browser", $browser);
        $queryEx->bindparam(":visitor_os", $os);
        $queryEx->bindparam(":visitor_cookie_id", $cookieId);
        $queryEx->bindparam(":visitor_date", $date);
        $queryEx->execute();

        $id = $this->connection->lastInsertId();

        return $this->get($id);
    }

    /**
     * @param Visitor $visitor
     */
    public function update(Visitor $visitor)
    {
        $sql = "UPDATE `visitor` SET `visitor_browser` = :visitor_browser,
                `visitor_os` = :visitor_os,
                `visitor_cookie_id` =  :visitor_cookie_id,
                `visitor_date` =  :visitor_date
                WHERE `visitor`.`visitor_id` = :visitor_id;";

        $queryEx = $this->connection->prepare($sql);

        $id = $visitor->getId();
        $browser = $visitor->getBrowser();
        $os = $visitor->getOs();
        $cookieId = $visitor->getCookieId();

        $queryEx->bindparam(":visitor_browser", $browser);
        $queryEx->bindparam(":visitor_os", $os);
        $queryEx->bindparam(":visitor_cookie_id", $cookieId);
        $queryEx->bindparam(":visitor_id", $id);

        $queryEx->execute();
    }

    /**
     * @param array $array
     * @return Visitor
     */
    private function mapVisitor(array $array)
    {
        return new Visitor($array["visitor_id"],
            $array["visitor_browser"],
            $array["visitor_os"],
            $array["visitor_cookie_id"],
            $array["visitor_date"]);
    }

    /**
     * @param Visitor $visitor
     */
    public function delete(Visitor $visitor)
    {
        $query = $this->connection->prepare("DELETE FROM visitor WHERE visitor_id = :visitor_id");
        $id = $visitor->getId();
        $query->bindparam(":visitor_id", $id);
        $query->execute();
    }

    /**
     * @return Visitor[]
     */
    public function listAll()
    {
        $visitor = [];
        $sql = $this->connection->prepare("SELECT * FROM visitor");
        $sql->execute();

        $results = $sql->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($results as $result) {
            $visitor[] = $this->mapVisitor($result);
        }
        return $visitor;
    }


    /**
     * @param $id
     * @return Visitor|null
     */
    public function get($id)
    {
        $sql = $this->connection->prepare("SELECT * FROM visitor WHERE visitor_id = :visitor_id");
        $sql->bindparam(":visitor_id", $id);
        $sql->execute();

        $result = $sql->fetch();
        if ($result == null) {
            return null;
        }

        return $this->mapVisitor($result);
    }

    /**
     * @return int
     */
    public function count()
    {
        $sql = $this->connection->prepare("SELECT COUNT(*) FROM visitor");
        $sql->execute();

        return $sql->fetchColumn();
    }

    /**
     * @return int
     */
    public function countVisits()
    {
        $sql = $this->connection->prepare("SELECT DISTINCT visitor_cookie_id FROM visitor");
        $sql->execute();
        return count($sql->fetchAll(\PDO::FETCH_ASSOC));
    }
}