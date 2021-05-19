<?php

class Home extends Controller{
  public function index(){
    //Send the data from the url
    $data['title'] = 'Home';
    //Send the data by using model
    $this->view('Templates/Header',$data);
    $this->view('Home/Homepage',$data);
    $this->view('Templates/Footer');
  }

  public function session(){
    //Send the data from the url
    $data['title'] = 'Home';
    //Send the data by using model
    $this->view('Templates/Header',$data);
    $this->view('Home/Homepage',$data);
    $this->view('Templates/Footer');
  }

  public function error(){
    if(isset($_SESSION['loggedin'])){
      echo '<a class="nav-link" href="'. BASEURL .'/Login/LogoutUser">Log out</a>';
    }
    else{
      echo '<button type="button" class="btn btn-outline-success my-2 my-sm-0" data-toggle="modal" data-target="#staticBackdrop">
                Login In
              </button>';
    }

  }
}
