<?php
require_once(__DIR__ . "/../core/Database.php");
require_once(__DIR__ . "/../model/Module.php");
require_once(__DIR__ . "/../repository/AuditRepository.php");

class ModuleRepository
{
    private $connection;
    private $auditRepository;

    public function __construct()
    {
        $this->connection = Database::getConn();
        $this->auditRepository = new AuditRepository();
    }

    private function mapModule(array $array)
    {
        return new Module($array["module_id"],
            $array["module_name"],
            $array["module_icon"],
            $array["module_path"]
        );
    }

    /**
     * @param Module $module
     * @return Module|null
     */
    public function insert(Module $module)
    {
        $sql = $this->connection->prepare("INSERT INTO module(module_name,module_icon,module_path) 
                                            VALUES (:module_name, :module_icon, :module_path)");
        $name = $module->getName();
        $icon = $module->getIcon();
        $path = $module->getPath();

        $sql->bindparam(":module_name", $name);
        $sql->bindparam(":module_icon", $icon);
        $sql->bindparam(":module_path", $path);
        $sql->execute();

        $id = $this->connection->lastInsertId();

        $audit = new Audit(null, $_SESSION["id"], "insert", "Module", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);

        return $this->get($id);
    }

    /**
     * @param Module $module
     */
    public function delete(Module $module)
    {
        $query = $this->connection->prepare("DELETE FROM module WHERE module_id = :module_id");
        $id = $module->getId();
        $query->bindparam(":module_id", $id);
        $query->execute();

        $audit = new Audit(null, $_SESSION["id"], "delete", "Module", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param Module $module
     * @return Module
     */
    public function update(Module $module)
    {
        $query = $this->connection->prepare("UPDATE FROM module SET module_name = :module_name,
                                            module_icon = :module_icon, module_path = :module_path
                                            WHERE module_id = :module_id");

        $name = $module->getName();
        $icon = $module->getIcon();
        $path = $module->getPath();
        $id = $module->getId();

        $query->bindparam(":module_name", $name);
        $query->bindparam(":module_icon", $icon);
        $query->bindparam(":module_path", $path);
        $query->bindparam(":module_id", $id);

        $query->execute();

        $audit = new Audit(null, $_SESSION["id"], "update", "Module", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);

        return $module;
    }

    /**
     * @return Module[]
     */
    public function listAll(){
        $modules = [];
        $sql = $this->connection->prepare("SELECT * FROM module");
        $sql->execute();

        $results = $sql->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($results as $result) {
            $modules[] = $this->mapModule($result);
        }
        return $modules;
    }


    /**
     * @param $id
     * @return Module|null
     */
    public function get($id){
        $tickets = [];
        $sql = $this->connection->prepare("SELECT * FROM module WHERE module_id = :module_id");
        $sql->bindparam(":module_id", $id);
        $sql->execute();

        $result = $sql->fetch();
        if($result == null){
            return null;
        }

        return $this->mapModule($result);
    }
}