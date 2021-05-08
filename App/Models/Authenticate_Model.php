<?php

class Authenticate_Model extends Dbh{

  private $username;
  private $email;
  private $password;
  private $repassword;
  private $gender;

  //Validate the Register Data
  public function ValidateRegisterData($data){
    //Load the Data
    $username = $this->username = $data['name'];
    $email = $this->email = $data['email'];
    $password = $this->password = $data['psw'];
    $repassword = $this->repassword = $data['psw-repeat'];
    $gender = $this->gender = $data['gender'];

    //Email validation
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      $results['DataError'] = array(
        'message' => "Invalid Email",
      );
      return $results;
    }
    //Check the gender whether it is filled in or not
    else if(empty($gender)){
      $results['DataError'] = array(
        'message' => "Invalid Gender",
      );
      return $results;
    }
    /*password Validation*/
    /*The length of the password need to more than 8*/

    else if(strlen($password) <= 8){
      $results['DataError'] = array(
        'message' => "Length of Password must Be More than 8",
      );
      return $results;
    }

    else if(!preg_match("#[0-9]+#",$password)){
      $results['DataError'] = array(
        'message' => "Number must include in Password",
      );
      return $results;
    }
    else if(!preg_match("#[a-z]+#",$password)){
      $results['DataError'] = array(
        'message' => "Character must include in Password",
      );
      return $results;
    }
    else if(!preg_match("#[A-Z]+#",$password)){
      $results['DataError'] = array(
        'message' => "Capital letter must include in Password",
      );
      return $results;
    }
    else if($password != $repassword){
      $results['DataError'] = array(
        'message' => "Invalid Second Password",
      );
      return $results;
    }
    //return success when nothing wrong
    $results['DataError'] = array(
        'message' => "Success",
    );
    return $results;

  }
  //User Register
  public function UserRegistration($data){

    $username = $this->username = $data['name'];
    $email = $this->email = $data['email'];
    $password = $this->password = $data['psw'];
    $repassword = $this->repassword = $data['psw-repeat'];
    $gender = $this->gender = $data['gender'];
    $Type = "User";
    //Set the default timezone to use
    date_default_timezone_set('Asia/Kuala_Lumpur');
    //Get the datetime when the user register the account
    $User_Register_Datetime = date('Y-m-d H:i:s');
    //Hash the password
    $Hash_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user(User_Name,User_Email,User_Password,User_Gender,User_Type,User_Register_Time) VALUES (?,?,?,?,?,?)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$username,$email, $Hash_password,$gender,$Type,$User_Register_Datetime]);
    //Row count to count the row
    $results = $stmt->rowCount();
    return $results;
  }
  //Validate the Login Data
  public function ValidateLoginData($data){
    //Load the data
    $username = $this->username = $data['name'];
    $password = $this->password = $data['psw'];
    if(empty($username)){
      $results['DataError'] = array(
        'message' => "1: Invalid Username",
      );
      return $results;
    }
    else if(empty($password)){
      $results['DataError'] = array(
        'message' => "Invalid Password",
      );
      return $results;
    }

    //return success when nothing wrong
    $results['DataError'] = array(
        'message' => "Success",
    );
    return $results;
  }
  //User login
  public function UserAuthentication($data){
    //Prepare statement to prevent SQL injection
    $username = $data['name'];
    $password = $data['psw'];

    $sql = "SELECT User_Password FROM user WHERE User_Name = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam('s',$username);
    $stmt->execute([$username]);

    // Store the result so we can check if the account exists in the database
    $results = $stmt->fetchAll();
    //return $results;
    if($results > 0){
      foreach($results as $result){
        if(password_verify($password, $result['User_Password'])){
          // Verification success! User has loggedin!
          // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
          if(isset($_SESSION['blah'])){
            //return success when nothing wrong
            $results['DataError'] = array(
                'message' => "Success",
            );
          }
          else{
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $username;
            $_SESSION['id'] = session_id();

            $results['DataError'] = array(
                'message' => "Success",
            );
          }
          return $results;
        }
        else{
          //Return false when it is invalid password
          $results['DataError'] = array(
              'message' => "Invalid Password",
          );
          return $results;
        }
      }
    }
    else{
      //Invalid Username if something wrong with username
      $results['DataError'] = array(
          'message' => "Invalid Username",
      );
      return $results;
      exit;
    }
  }
  //Check whether the user is active or not
  public function UserAuthenticationTracking(){
    //Set the default timezone to use
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $session_id = $_SESSION['id'];
    $Start_DateTime = date('Y-m-d H:i:s');
    $Duration = date('Y-m-d H:i:s');
    $End_DateTime = NULL;
    //1. Select User id with the session name
    $sql = "SELECT User_Id FROM user WHERE User_Name = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam('s',$_SESSION['name']);
    $stmt->execute([$_SESSION['name']]);

    $results = $stmt->fetchAll();
    if($results > 0){
      foreach($results as $result){
        $user_id = $result['User_Id'];

        //2. Check wether the user is active and listed in the table
        $sql = "SELECT Login_Tracking_Id FROM logintracking WHERE Session_Id = ? AND End_Time IS NULL";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$session_id]);
        $results = $stmt->rowCount();
        if($results > 0) {
          $sql = "UPDATE logintracking
                  SET Duration = ?
                  WHERE Session_Id = ?
                  AND End_Time IS NULL";
          $stmt = $this->connect()->prepare($sql);
          $stmt->execute([$Duration,$session_id]);
          $results = $stmt->rowCount();
        }
        else{
          $sql = "INSERT INTO logintracking(Session_Id,Start_Time,Duration,User_Id) VALUES (?,?,?,?)";
          $stmt = $this->connect()->prepare($sql);
          //$stmt->bindParam('sssi',$session_id,$Start_DateTime,$Duration,$user_id);
          $stmt->execute([$session_id,$Start_DateTime,$Duration,$user_id]);
          $results = $stmt->rowCount();
        }
        //3. Lastly return should be return 1
        return $results;
      }
    }
    else{
      //Invalid Username if something wrong with username
      $results['DataError'] = array(
          'message' => "Invalid Username",
      );
      return $results;
    }
  }
  //Get User Duration
  public function EndUserAuthentication(){
    //Current time
    $End_Datetime = date('Y-m-d H:i:s');
    //1. Get the user when has been login
    $session_id = $_SESSION['id'];
    $sql = "SELECT Login_Tracking_Id FROM logintracking WHERE Session_Id = ? AND End_Time IS NULL";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$session_id]);
    $results = $stmt->rowCount();
    //2. check the result
    if($results > 0){
      //If 1 then End the session
      $sql = "INSERT INTO logintracking(End_Time) VALUES (?)";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$End_Datetime]);
      $results = $stmt->rowCount();
    }
    else{
      //else return error
      $results['DataError'] = array(
          'message' => "Invalid End Time",
      );
    }
    return $results;
  }

  //Get User Duration
  public function UserAuthenticationduration(){
    $session_id = $_SESSION['id'];
    $Current_Time = date('Y-m-d H:i:s');
    $sql = "SELECT Duration FROM logintracking WHERE Session_Id = ? AND End_Time IS NULL";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$session_id]);
    $results = $stmt->fetchAll();
    if ($results > 0) {
      foreach ($results as $result) {
        $Duration = $result['Duration'];
        $mins = (strtotime($Current_Time) - strtotime($Duration)) / 60;
        $results['DataReturn'] = array(
            'Response' => $mins;
        );
        /*if ($mins > 100) {
          $results['DataError'] = array(
              'message' => "Expired",
          );
        }
        else{
          $results['DataError'] = array(
              'message' => "Is Not Expired",
          );
        }*/
        return $results;
      }
    }
    else{
      //Invalid Username if something wrong with username
      $results['DataError'] = array(
          'message' => "Invalid Duration",
      );
      return $results;
    }

  }

}
