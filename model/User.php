<?php
require_once(__DIR__ . "/../util/Logging.php");
require_once(__DIR__."/../util/Helpers.php");
class User
{
    private $id;
    private $full_name;
    private $email;
    private $username;
    private $password;
    private $role;

    /**
     * User constructor.
     * @param $id
     * @param $full_name
     * @param $email
     * @param $username
     * @param $password
     * @param $hash
     * @param $role
     * @throws Exception
     */
    function __construct($id, $full_name, $email, $username, $password, $hash, $role)
    {
        $this->setId($id);
        $this->setFullName($full_name);
        $this->setEmail($email);
        $this->setUsername($username);
        $this->setPassword($password, $hash);
        $this->setRole($role);
    }

    /**
     * @param $id
     */
    private function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $full_name
     * @throws Exception
     */
    public function setFullName($full_name)
    {
        if ($full_name == "" || $full_name == null) {
            throw new Exception("Full name is required");
        }
        if (count(explode(" ", $full_name)) < 2) {
            throw new Exception("Full name should contain minimum two words");
        }
        if (preg_match('/[^A-Za-z ]/', $full_name)) {
            throw new Exception("Full name should only contain letters of the English alphabet");
        }

        $this->full_name = $full_name;
    }

    public function getFullName()
    {
        return name_format($this->full_name);
    }

    /**
     * @param $email
     * @throws Exception
     */
    public function setEmail($email)
    {
        if ($email == "" || $email == null) {
            throw new Exception("Email is required");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        $this->email = strtolower($email);
    }

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $username
     * @throws Exception
     */
    public function setUsername($username)
    {
        if ($username == "" || $username == null) {
            throw new Exception("Username is required");
        }

        if (strlen($username) < 6 || strlen($username) > 12) {
            throw new Exception("Username Should be al least 6 characters and lower than 12");
        }

        if (preg_match('/[^A-Za-z0-9]/', $username)) {
            throw new Exception("Username Needs to be ONLY String With Letters And Numbers!");
        }

        $this->username = strtolower($username);
    }

    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param $password
     * @param bool $hash
     * @throws Exception
     */
    public function setPassword($password, $hash = true)
    {
        if ($password == "" || $password == null) {
            throw new Exception("Password is required");
        }

        if ($hash) {
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        }
        else {
            $this->password = $password;
        }
    }

    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $role
     * @throws Exception
     */
    public function setRole($role)
    {
        if ($role != 0 && $role != 1) {
            throw new Exception("Role should be 0 or 1 (Admin or User)");
        }

        $this->role = $role;
    }

    public function getRole()
    {
        return $this->role;
    }
}