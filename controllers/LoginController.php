<?php
require_once(__DIR__ . "/../repository/UserRepository.php");
include_once(__DIR__ . "/../util/Logging.php");

class LoginController
{
    private $userRepository;

    function __construct()
    {
        $this->userRepository = new UserRepository();
    }


    function post(){
        $this->checkLogin();
        if (isset($_POST["login_submit"])) {
            try {
                $this->login($_POST["login_username"], $_POST["login_password"]);
                $this->checkLogin();
            } catch (Exception $e) {
                $error_message = $e->getMessage();
            }
        } else if (isset($_POST["register_submit"])) {
            try {
                $this->register($_POST["register_full_name"],
                    $_POST["register_email"],
                    $_POST["register_username"],
                    $_POST["register_password"],
                    $_POST["register_password_confirm"]);

                $success_message = "Registered successfully please login to your account to continue";
            } catch (Exception $e) {
                $error_message = $e->getMessage();
            }
        }
        require_once(__DIR__."/../view/LoginView.php");
    }

    private function checkLogin(){
        if(isset($_SESSION["id"])){
            header('Location: dashboard');
            exit;
        }
    }

    function index(){
        $this->checkLogin();
        require_once(__DIR__."/../view/LoginView.php");
    }

    /**
     * @param $username
     * @param $password
     * @throws Exception
     */
    function login($username, $password)
    {
        $users = $this->userRepository->findByUsername($username);
        if (count($users) == 0) {
            throw new Exception("Invalid username or Password");
        }
        log_message($users[0]->getPassword());
        if (password_verify($password, $users[0]->getPassword())) {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $users[0]->getId();
        } else {
            throw new Exception("Invalid username or Password");
        }
    }

    /**
     * @param $full_name
     * @param $email
     * @param $username
     * @param $password
     * @param $password_confirm
     * @throws Exception
     */
    function register($full_name, $email, $username, $password, $password_confirm)
    {
        if ($password != $password_confirm) {
            throw new Exception("Password and Password Confirm should be the same");
        }
        $user = new User(null, $full_name, $email, $username, $password, true, 1);

        if (count($this->userRepository->findByUsername($username)) > 0) {
            throw new Exception("There is a user with this username, please try another one");
        }

        if (count($this->userRepository->findByEmail($email)) > 0) {
            throw new Exception("There is a user with this username, please try another one");
        }

        $this->userRepository->insert($user);
    }
    public function url_login_page_redirect($location , $atRoot=FALSE, $atCore=FALSE, $parse=FALSE){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];

            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $base_url = 'http://localhost/';

        if ($parse) {
            $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }

        return $base_url.$location;
    }
}

?>
