<?php
require_once(__DIR__ . "/../core/Database.php");
require_once(__DIR__ . "/../model/User.php");
require_once(__DIR__ . "/../repository/AuditRepository.php");

class UserRepository
{
    private $connection;
    private $auditRepository;

    public function __construct()
    {
        $this->connection = Database::getConn();
        $this->auditRepository = new AuditRepository();
    }

    /**
     * @param User $user
     */
    public function insert(User $user)
    {
        $sql = "INSERT INTO `user` (`user_full_name`, `user_email`, `user_username`, `user_password`, `user_role`)
                VALUES (:full_name, :email, :username, :password, :role); ";

        $queryEx = $this->connection->prepare($sql);

        $fullName = $user->getFullName();
        $email = $user->getEmail();
        $username = $user->getUsername();
        $password = $user->getPassword();
        $role = $user->getRole();

        $queryEx->bindparam(":full_name", $fullName);
        $queryEx->bindparam(":email", $email);
        $queryEx->bindparam(":username", $username);
        $queryEx->bindparam(":password", $password);
        $queryEx->bindparam(":role", $role);
        $queryEx->execute();

        $audit = new Audit(null, $this->connection->lastInsertId(), "insert", "User", $this->connection->lastInsertId(), "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param User $user
     */
    public function update(User $user)
    {
        $sql = "UPDATE user SET user_full_name = :full_name,
                user_email = :email,
                user_username =  :username,
                user_password = :password,
                user_role = :role
                WHERE user_id = :id";

        $queryEx = $this->connection->prepare($sql);

        $fullName = $user->getFullName();
        $email = $user->getEmail();
        $username = $user->getUsername();
        $password = $user->getPassword();
        $role = $user->getRole();
        $id = $user->getId();

        $queryEx->bindparam(":full_name", $fullName);
        $queryEx->bindparam(":email", $email);
        $queryEx->bindparam(":username", $username);
        $queryEx->bindparam(":password", $password);
        $queryEx->bindparam(":role", $role);
        $queryEx->bindparam(":id", $id);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "update", "User", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param User $user
     */
    public function delete(User $user)
    {
        $sql = "DELETE FROM `user` WHERE `user`.`user_id` = :id";
        $queryEx = $this->connection->prepare($sql);
        $id = $user->getId();
        $queryEx->bindparam(":id", $id);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "delete", "User", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param array $array
     * @return User
     * @throws Exception
     */
    private function mapUser(array $array)
    {
        return new User($array["user_id"]
            , $array["user_full_name"]
            , $array["user_email"]
            , $array["user_username"]
            , $array["user_password"]
            , false
            , $array["user_role"]);
    }

    /**
     * @return User[]
     * @throws Exception
     */
    public function listAll()
    {
        $users = [];
        $sth = $this->connection->prepare("SELECT * FROM `user`");
        $sth->execute();

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($result as $array) {
            $users[] = $this->mapUser($array);
        }

        return $users;
    }

    /**
     * @param $id
     * @return User|null
     * @throws Exception
     */
    public function get($id){
        $tickets = [];
        $sql = $this->connection->prepare("SELECT * FROM user WHERE user_id = :user_id");
        $sql->bindparam(":user_id", $id);
        $sql->execute();

        $result = $sql->fetch();
        if($result == null){
            return null;
        }

        return $this->mapUser($result);
    }

    /**
     * @param $username
     * @return User[]
     * @throws Exception
     */
    public function findByUsername($username)
    {
        $users = [];
        $username = strtolower($username);
        $sth = $this->connection->prepare("SELECT * FROM `user` where `user`.`user_username` = :username");

        $sth->bindparam(":username", $username);

        $sth->execute();

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($result as $array) {
            $users[] = $this->mapUser($array);
        }

        return $users;
    }

    /** >
     * @param $email
     * @return User[]
     * @throws Exception
     */
    public function findByEmail($email)
    {
        $users = [];
        $sth = $this->connection->prepare("SELECT * FROM `user` where `user`.`user_email` = :email");

        $sth->bindparam(":email", $email);

        $sth->execute();

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($result as $array) {
            $users[] = $this->mapUser($array);
        }

        return $users;
    }
}
?>