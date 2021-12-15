<?php
require_once(__DIR__.'/../repository/UserRepository.php');
require_once(__DIR__.'/../util/AccessVerify.php');
require_once(__DIR__.'/../model/User.php');
class ProfileController{

    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function edit(){
        verifyXML();
        verifyUser();
        header('Content-Type: application/json');
        if(is_numeric($_SESSION['id']) && !empty($_POST['fullName']) && !empty($_POST['email']) && !empty($_POST['username']) && isset($_POST['password'])){
            $user = $this->userRepository->get($_SESSION['id']);
            if($user != null){
                try{
                    $user->setFullName($_POST['fullName']);
                    $user->setEmail($_POST['email']);
                    $user->setUsername($_POST['username']);
                    if(!empty($_POST['password'])) $user->setPassword($_POST['password']);
                    $this->userRepository->update($user);

                    die(json_encode(array("success" => true, "description" => "You've changed your info successfuly")));
                }catch(Exception $ex){
                    die(json_encode(array("success" => false, "description" => $ex->getMessage())));
                }
            }else{
                die(json_encode(array("success" => false, "description" => "Please relogin")));
            }
        }else{
            die(json_encode(array("success" => false, "description" => "wrong")));
        }
    }

    public function index(){
        verifyXML();
        verifyUser();
        $user = $this->userRepository->get($_SESSION['id']);
        if($user == null)
            Header('Location: out');

        require_once(__DIR__.'/../view/MyProfileView.php');
    }
}