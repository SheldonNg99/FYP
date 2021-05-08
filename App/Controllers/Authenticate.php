<?php

class Authenticate extends Controller{
  public function Login(){
    //Send the data from the url
    $data['title'] = 'Login';
    //Send the data by using model
    $this->view('Templates/Header',$data);
    $this->view('AuthenticateViews/Login',$data);
    $this->view('Templates/Footer');
  }

  public function Register(){
    //Send the data from the url
    $data['title'] = 'Register';
    //Send the data by using model
    $this->view('Templates/Header',$data);
    $this->view('AuthenticateViews/Register',$data);
    $this->view('Templates/Footer');
  }
  //User Login
  public function UserLogin(){
    //Check whether it is post or not
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      //pass to to validate the data
      $results = $this->model('Authenticate_Model')->ValidateLoginData($_POST);
      $result = $results['DataError']['message'];
      //Validate the data return success
      if($result == "Success"){
        //Go through the login process
        $results = $this->model('Authenticate_Model')->UserAuthentication($_POST);
        $result = $results['DataError']['message'];
        //Login process return success
        if($result == "Success"){
          //Go through the tracking process
          $results = $this->model('Authenticate_Model')->UserAuthenticationTracking();
          Flasher::setFlash($results, ' Success', 'primary');
          header('Location: '. BASEURL);
          exit;

        }
        else{
          Flasher::setFlash($result, 'Failed', 'danger');
          header('Location: '. BASEURL);
          exit;
        }
      }
      else{
        Flasher::setFlash($result, 'Failed', 'danger');
        header('Location: '. BASEURL);
        exit;
      }
    }
    else{
      $result = "POST ERROR";
      Flasher::setFlash($result, 'Failed', 'danger');
      header('Location: '. BASEURL);
      exit;
    }
  }
  //User Register
  public function UserRegister(){
    //Check whether it is post or not
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      //pass to to validate the data
      $results = $this->model('Authenticate_Model')->ValidateRegisterData($_POST);
      $result = $results['DataError']['message'];
      //Once Data is valid success
      if ($result == "Success") {
        $this->model('Authenticate_Model')->UserRegistration($_POST);
        header('Location: '. BASEURL);
        exit;
      }
      else{
        $result = $results['DataError']['message'];
        Flasher::setFlash($result, 'Error', 'danger');
        header('Location: '. BASEURL);
        exit;
      }
    }
    else{
      $result = "POST ERROR";
      Flasher::setFlash($result, 'Error', 'danger');
      header('Location: '. BASEURL);
      exit;
    }
  }
  //User Logout
  public function UserLogout(){
    session_start();
    session_destroy();
    // Redirect to the Home page:
    header('Location: '. BASEURL);
  }
  //Update User online status
  public function UserUpdateTracking(){
    $results = $this->model('Authenticate_Model')->UserAuthenticationTracking();
    $result = $results['DataError']['message'];
    Flasher::setFlash($result, ' Success', 'primary');
    header('Location: '. BASEURL);
    exit;
  }
  //End the Session when User Idle more than 10mins
  public function UserIdleTracking(){
    //1. Get the duration of the user
    $results = $this->model('Authenticate_Model')->UserAuthenticationduration();
    $result = $results['DataError']['message'];
    //2. if NOT do NOTHING
    if ($result != "Is Not Expired") {

    }
    //else end the session
    else{
      $results = $this->model('Authenticate_Model')->EndUserAuthentication();
      header('Location: '. BASEURL);
    }
    Flasher::setFlash($result, 'Error', 'primary');
    // Redirect to the Home page:
    header('Location: '. BASEURL);
  }
  //Just testing the duration of the user
  public function GetUserDuration(){
    $results = $this->model('Authenticate_Model')->UserAuthenticationduration();
    $result = $results['DataReturn']['Response'];
    Flasher::setFlash($result, 'Error', 'primary');
  }


}
