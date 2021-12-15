<?php
require_once(__DIR__."/../repository/UserRepository.php");
require_once(__DIR__."/../util/AccessVerify.php");
class ClientsController{
    private $userRepository;

    /**
     * ClientsController constructor.
     */
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function userDelete(){
        verifyAdmin();
        verifyXML();
        if(is_numeric($_POST['id'])){
            header('Content-Type: application/json');
            $user = $this->userRepository->get($_POST['id']);
            if($user != null){
                try{
                    $this->userRepository->delete($user);
                    die(json_encode(array("success" => true, "description" => "User deleted succesfuly")));
                }catch(Exception $ex){
                    die(json_encode(array("success" => false, "description" => $ex->getMessage())));
                }
            }else{
                die(json_encode(array("success" => false, "description" => "User wasnt found on the database.")));
            }
        }
    }

    public function userEdit(){
        verifyAdmin();
        verifyXML();
        if(!empty($_POST['fullName']) && !empty($_POST['email']) && !empty($_POST['username']) && is_numeric($_POST['privilege']) && isset($_POST['password']) && is_numeric($_POST['id'])){
            header('Content-Type: application/json');
            $user = $this->userRepository->get($_POST['id']);
            if($user != null){
                try {
                    $user->setEmail($_POST['email']);
                    $user->setFullName($_POST['fullName']);
                    $user->setRole($_POST['privilege']);
                    $user->setUsername($_POST['username']);
                    if (!empty($_POST['password'])) $user->setPassword($_POST['password']);
                    $this->userRepository->update($user);
                    die(json_encode(array("success" => true, "description" => "User updated successfuly")));
                }catch(Exception $ex){
                    if(strpos(strtolower($ex->getMessage()), "1062")){
                        die(json_encode(array("success" => false, "description" => "There is already an user with that username")));
                    }else {
                        die(json_encode(array("success" => false, "description" => $ex->getMessage())));
                    }
                }
            }else{
                die(json_encode(array( "success" => false, "description" => "User wasnt found.")));
            }
        }
    }

    public function index(){
        verifyAdmin();
        verifyXML();
        $json = [];
        $tableBody = "";
        foreach ($this->userRepository->listAll() as $user) {
            $element = [];
            $element["id"] = $user->getId();
            $element["email"] = $user->getEmail();
            $element["full_name"] = $user->getFullName();
            $element["username"] = $user->getUsername();
            $element["role"] = $user->getRole();

            $json[] = $element;

            $tableBody .= "<tr>";
            $tableBody .= "<td>" . $user->getId() . "</td>";
            $tableBody .= "<td>" . $user->getFullName() . "</td>";
            $tableBody .= "<td>" . $user->getEmail() . "</td>";
            $tableBody .= "<td>" . $user->getUsername() . "</td>";
            $tableBody .= "<td>" . $user->getRole() . "</td>";
            $tableBody .= "<td><button edit=\"" . $user->getId() . "\" type=\"button\" class=\"btn btn-blue\">Edit</button></td>";
            $tableBody .= "<td><button delete=\"" . $user->getId() . "\" type=\"button\" class=\"btn btn-danger\">Delete</button></td>";
            $tableBody .= "</tr>";
        }
        $json = json_encode($json);

        include(__DIR__."/../view/ClientsView.php");
    }


}