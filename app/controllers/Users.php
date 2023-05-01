<?php

class Users extends Controller{

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function login()
    {
        $data = [
            "uName" => "",
            "pass" => "",
            "error-login" => ""
        ];

        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $data['uName'] = $_POST['uName'];
            $data['pass'] = $_POST['pass'];

            $userData = $this->userModel->getUser($data);
            if($userData){
                $_SESSION['USER_ID'] = $userData['UserID'];
                header('location: '. URLROOT . '/accounts/dashboard');
            }
            else{
                $data['error-login'] = "Invalid Username or Password";
            }
        }

        $this->view('users/login', $data);
    }

    public function signup()
    {
        $data = [
            "fName" => "",
            "lName" => "",
            "uName" => "",
            "error-img" => "",
            "error-fName" => "",
            "error-lName" => "",
            "error-uName" => "",
            "error-pass" => "",
            "error-passConf" => "",
        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data['fName'] = $_POST['fName'];
            $data['lName'] = $_POST['lName'];
            $data['uName'] = $_POST['uName'];

            //Validate the input fields
            if(empty($_FILES['inputFile']['name'])){
                $data['error-img'] = "Please add some image of you";
            }
            if(empty($_POST['fName'])){
                $data['error-fName'] = "Please type your Firstname";
            }
            if(empty($_POST['lName'])){
                $data['error-lName'] = "Please type your Lastname";
            }
            if(empty($_POST['uName'])){
                $data['error-uName'] = "Please type your Username";
            }

            if(empty($_POST['pass'])){
                $data['error-pass'] = "Please type your Password";
            }
            else if(strlen($_POST['pass']) < 6){
                $data['error-pass'] = "Password must be atleast 8 characters";
            }
            else if($_POST['pass'] != $_POST['passConfirm']){
                $data['error-pass'] = "Password do not match. Try again";
            }

            if(empty($data['error-img']) && empty($data['error-fName']) && empty($data['error-lName'])
                && empty($data['error-uName']) && empty($data['error-pass'])){
                $userData = [
                    "fName" => $_POST['fName'],
                    "lName" => $_POST['lName'],
                    "uName" => $_POST['uName'],
                    "pass" => $_POST['pass'],
                    "imgName" => $_FILES['inputFile']['name'],
                    "imgTmpName" => $_FILES['inputFile']['tmp_name']
                ];

                if($this->userModel->setUser($userData)){
                    header('location: ' . URLROOT . '/users/login');
                }
                else{
                    exit("Failed to Insert User data");
                }
            }
        }
        
        $this->view('users/signup', $data);
    }
}