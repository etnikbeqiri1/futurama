<?php
require_once(__DIR__."/../repository/UserRepository.php");
require_once(__DIR__."/../repository/RoleRepository.php");
require_once(__DIR__."/../repository/ModuleRepository.php");
require_once(__DIR__."/../util/Logging.php");

class DashboardController{
    private $userRepository;
    private $roleRepository;
    private $moduleRepository;
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->roleRepository = new RoleRepository();
        $this->moduleRepository = new ModuleRepository();
    }

    public function index(){
        $this->checkLogin();

        $user = $this->userRepository->get($_SESSION["id"]);
        log_message($user->getFullName());
        $role = $this->roleRepository->get($user->getRole());
        log_message($user->getRole());
        $modules = $this->roleRepository->getModules($role);

        include(__DIR__."/../view/DashboardView.php");
    }

    private function checkLogin(){
        if(!isset($_SESSION["id"])){
            header('Location: home');
            exit;
        }
    }
}
?>