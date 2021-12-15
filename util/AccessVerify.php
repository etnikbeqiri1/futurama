<?php
include_once(__DIR__.'/../repository/UserRepository.php');
function verifyXML(){
    if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && !isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        require_once(__DIR__ . '/../view/Error404View.php');
        exit;
    }
}

function verifyAdmin(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_SESSION['login']) && isset($_SESSION['id']) && !empty($_SESSION['login']) && is_numeric($_SESSION['id'])){
        $userRepository = new UserRepository();
        $user = $userRepository->get($_SESSION['id']);
        if($user == null || $user->getRole() != 0){
            Header('Location: out');
            exit;
        }
    }else{
        Header('Location: out');
        exit;
    }
}

function verifyUser(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_SESSION['login']) && isset($_SESSION['id']) && !empty($_SESSION['login']) && is_numeric($_SESSION['id'])){
        $userRepository = new UserRepository();
        $user = $userRepository->get($_SESSION['id']);
        if($user == null || $user->getRole() != 1){
            Header('Location: out');
            exit;
        }
    }else{
        Header('Location: out');
        exit;
    }
}
