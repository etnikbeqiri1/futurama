<?php
require_once(__DIR__ . "/../core/Database.php");
require_once(__DIR__ . "/../model/Role.php");
require_once(__DIR__ . "/../model/Module.php");
require_once(__DIR__ . "/../repository/AuditRepository.php");

class RoleRepository
{
    private $connection;
    private $auditRepository;

    public function __construct()
    {
        $this->connection = Database::getConn();
        $this->auditRepository = new AuditRepository();

    }

    private function mapRole(array $array)
    {
        return new Role($array["role_id"],
            $array["role_name"]);
    }

    public function insert(Role $role)
    {
        $sql = $this->connection->prepare("INSERT INTO role(role_name) VALUES (:role_name)");
        $name = $role->getName();
        $sql->bindparam(":role_name", $name);
        $sql->execute();

        $id = $this->connection->lastInsertId();


        $audit = new Audit(null, $_SESSION["id"], "insert", "Role", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);

        return $this->get($id);
    }

    public function delete(Role $role)
    {
        $query = $this->connection->prepare("DELETE FROM role WHERE role_id = :role_id");
        $id = $role->getId();
        $query->bindparam(":role_id", $id);
        $query->execute();

        $audit = new Audit(null, $_SESSION["id"], "delete", "Role", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    public function update(Role $role)
    {
        $query = $this->connection->prepare("UPDATE FROM role SET role_name = :role_name
                                            WHERE role_id = :role_id");
        $name = $role->getName();
        $id = $role->getId();
        $query->bindparam(":role_id", $id);
        $query->bindparam(":role_name", $name);
        $query->execute();

        $audit = new Audit(null, $_SESSION["id"], "update", "Role", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @return Role[]
     */
    public function listAll(){
        $roles = [];
        $sql = $this->connection->prepare("SELECT * FROM role");
        $sql->execute();

        $results = $sql->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($results as $result) {
            $roles[] = $this->mapRole($result);
        }
        return $roles;
    }


    /**
     * @param $id
     * @return Role|null
     */
    public function get($id){
        $sql = $this->connection->prepare("SELECT * FROM role WHERE role_id = :role_id");
        $sql->bindparam(":role_id", $id);
        $sql->execute();

        $result = $sql->fetch();
        if($result == null){
            return null;
        }

        return $this->mapRole($result);
    }

    /**
     * @param Role $role
     * @return Module[]
     */
    public function getModules(Role $role){
        $modules = [];

        $moduleRepository = new ModuleRepository();

        $sql = $this->connection->prepare("SELECT * FROM role_modules WHERE role_modules_role = :role_id");
        $id = $role->getId();
        $sql->bindparam("role_id", $id);
        $sql->execute();

        $results = $sql->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($results as $result) {
            $modules[] = $moduleRepository->get($result["role_modules_module"]);
        }

        return $modules;
    }
}