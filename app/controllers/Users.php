<?php

  class Users extends Controller {

    public function __construct() {
      $this->userModel = $this->model('User');
    }

    public function login() {
      if( $_SERVER['REQUEST_METHOD'] == POST) {
        //form submitted
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  
        $data = [
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'err_email' => '',
          'err_password' => ''
        ];
  
        if(empty($data['email'])) {
          $data['err_email'] = 'Please enter your email';
        } 
        
        if(empty($data['password'])) {
          $data['err_password'] = 'Please enter your password';
        } 
  
        if($this->userModel->findUserByEmail($data['email']) == false) {
          $data['err_email'] = 'No user found';
        } 
  
        if(empty($data['err_email']) && empty($data['err_password'])) {
          $loggedInUser = $this->userModel->login($data['email'],$data['password']);
          if($loggedInUser) {
            //Create session
            $this->createUserSession($loggedInUser);
          } else {
            $data['err_password'] = 'Password Incorrect';
            $this->view('users/login', $data);
          }
        } else  {
          //Load the form
          $this->view('users/login', $data);
        }
      } else {  
        //form loaded
        $data = [
          'email' => '',
          'password' => '',
          'err_email' => '',
          'err_password' => ''
        ];
  
        //Load the form
        $this->view('users/login', $data);
      }
    }

    public function register() {
      if( $_SERVER['REQUEST_METHOD'] == POST) {
        //form submitted
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
          'name' => trim($_POST['name']),
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'confirm_password' => trim($_POST['confirm_password']),
          'err_name' => '',
          'err_email' => '',
          'err_password' => '',
          'err_confirm_password' => ''
        ];
  
        if(empty($data['name'])) {
          $data['err_name'] = 'Please enter your name';
        } 
        
        if(empty($data['email'])) {
          $data['err_email'] = 'Please enter your email';
        } elseif (!filter_var($data['email'],FILTER_VALIDATE_EMAIL)  ) {
            $data['err_email'] = 'Email is invalid';
        } elseif($this->userModel->findUserByEmail($data['email'])) {
            $data['err_email'] = 'Email is already taken';
        }
          
        if(empty($data['password'])) {
          $data['err_password'] = 'Please enter a password';
        } else {
          if(strlen($data['password']) < 6)
            $data['err_password'] = 'Password must be at least 6 characters';
        }
  
        if(empty($data['confirm_password'])) {
          $data['err_confirm_password'] = 'Please confirm your password';
        } else {
          if($data['password'] != $data['confirm_password'] ) {
            $data['err_confirm_password'] = 'Passwords do not match';
          }
        }

        if(empty($data['err_name']) && empty($data['err_email']) && empty($data['err_password']) && empty($data['err_confirm_password']) ) {
          //hash the password
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
          //Register the user
          if($this->userModel->registerUser($data)) {
            flash('register_success', 'You are registered and can now login');
            //Redirect to login page
            redirect('users/login');
          } else {
            die('Something went wrong');
          }
      
        } else  {
          //Load the form with errors
          $this->view('users/register', $data);
        }
  
      } else {  
        //form loaded
        $data = [
          'name' => '',
          'email' => '',
          'password' => '',
          'confirm_password' => '',
          'err_name' => '',
          'err_email' => '',
          'err_password' => '',
          'err_confirm_password' => ''
        ];
  
        //Load the form
        $this->view('users/register', $data);
      }
    }
  
    public function createUserSession($user) {
      $_SESSION['user_id'] = $user->id;
      $_SESSION['user_email'] = $user->email;
      $_SESSION['user_name'] = $user->name;
      redirect('goals/index');
    }
  
    public function logout() {
      flash('register_success', 'You have been logged out'); //doesn't work if session_destroy called
      unset($_SESSION['user_id']);
      unset($_SESSION['user_email']); 
      unset($_SESSION['user_name']);
      // session_destroy();  Doesn't seem to be needed!
      redirect('users/login');
    }
  }

