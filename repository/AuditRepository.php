<?php

require_once(__DIR__ . "/../core/Database.php");
require_once(__DIR__ . "/../model/Audit.php");

class AuditRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getConn();
    }

    private function mapAudit(array $array)
    {
        return new Audit($array["audit_id"],
            $array["audit_user"],
            $array["audit_action"],
            $array["audit_entity"],
            $array["audit_entity_pk"],
            $array["audit_message"],
            $array["audit_date"]
        );
    }

    /**
     * @param Audit $module
     * @return Audit|null
     */
    public function insert(Audit $audit)
    {
        $sql = $this->connection->prepare("INSERT INTO audit(audit_user,audit_action,audit_entity,audit_entity_pk,audit_message,audit_date) 
                                            VALUES (:audit_user,:audit_action,:audit_entity,:audit_entity_pk,:audit_message,:audit_date)");
        $name = $audit->getId();
        $user = $audit->getUser();
        $action = $audit->getAction();
        $entity = $audit->getEntity();
        $entityPk = $audit->getEntityPk();
        $message = $audit->getMessage();
        $date = $audit->getDate();

        $sql->bindparam(":audit_user", $user);
        $sql->bindparam(":audit_action", $action);
        $sql->bindparam(":audit_entity", $entity);
        $sql->bindparam(":audit_entity_pk", $entityPk);
        $sql->bindparam(":audit_message", $message);
        $sql->bindparam(":audit_date", $date);
        $sql->execute();

        $id = $this->connection->lastInsertId();
    }

    /**
     * @return Audit[]
     */
    public function listAll()
    {
        $audits = [];
        $sql = $this->connection->prepare("SELECT * FROM audit ORDER BY audit_date DESC");
        $sql->execute();

        $results = $sql->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($results as $result) {
            $audits[] = $this->mapAudit($result);
        }
        return $audits;
    }
}

?>