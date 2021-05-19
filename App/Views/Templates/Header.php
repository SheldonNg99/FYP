<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Home Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,400i|Nunito:300,300i" rel="stylesheet">
        <link rel="stylesheet" href="<?= BASEURL;  ?>/css/Homestyle.css">
        <link rel="stylesheet" href="<?= BASEURL;  ?>/fontawesome/css/all.css">
        <link rel="stylesheet" href="<?= BASEURL;  ?>/css/lightslider.css">
        <script type="text/javascript" src="<?= BASEURL;  ?>/js/Jquery.js"></script>
        <script type="text/javascript" src="<?= BASEURL;  ?>/js/Main.js"></script>
        <script type="text/javascript" src="<?= BASEURL;  ?>/js/lightslider.js"></script>
    </head>
    <div class="Top_Navigation">
      <div class="Icons_Wrapper">
        <!--This is hamburger -->
        <div class="Left_Icon_Wrapper">
          <i class="fas fa-bars" onclick="openNav()"></i>
        </div>

        <!-- Logo -->
        <div class="Middle_Icon_Wrapper">
          Hello World
        </div>
        <!-- Cart & Profile -->
        <div class="Right_Icon_Wrapper">
          <i class="fas fa-user-alt"></i>
        </div>
      </div>
    </div>

    <div id="mySidenav" class="Side_Navigation Desktop_Hide">
      <i href="javascript:void(0)" class="Side_Navigation_Close_Btn fas fa-times" onclick="closeNav()"></i>
      <a href="#">About</a>
      <a href="#">Services</a>
      <a href="#">Clients</a>
      <div class="theme-switch-wrapper">
        <label class="theme-switch" for="checkbox">
          <input type="checkbox" id="checkbox" />
          <div class="slider round"></div>
        </label>
      </div>
    </div>

    <div id="" class="Desktop_Side_Navigation Mobile_Hide">
      <span></span>
      <a href="#"><i class="fas fa-home"></i>Home</a>
      <a href="#"><i class="fas fa-boxes"></i>Explore</a>
      <a href="#"><i class="fas fa-square-full"></i>Subscriptions</a>
      <div class="theme-switch-wrapper">
        <label class="theme-switch" for="checkbox">
          <input type="checkbox" id="checkbox" />
          <div class="slider round"></div>
        </label>
      </div>
    </div>
</html>

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "99%";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>

<script type="text/javascript" src="<?= BASEURL;  ?>/js/darkmode.js"></script>
