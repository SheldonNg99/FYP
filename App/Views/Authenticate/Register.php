<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'];  ?></title>
    <link rel="stylesheet" href="<?= BASEURL;  ?>/css/mainstyle.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script rel="text/javascript" src="<?= BASEURL;  ?>/js/Main.js"></script>
  </head>
  <body>
    <div class="theme-switch-wrapper">
        <label class="theme-switch" for="checkbox">
            <input type="checkbox" id="checkbox" />
            <div class="slider round"></div>
      </label>
    </div>
    <div id="Login_Main_Container">
      <div id="Login_Image_Wrapper">
        <img src="<?= BASEURL;  ?>/img/Logo.jpeg">
      </div>
      <div id="Login_Main_Wrapper">
        <form id="Login_Form">
          <input type="text" class="Input_Username" id="Username" name="Email" placeholder="Email">
          <br>
          <br>
          <input type="password" class="Input_Password" id="Password" name="Invitation_Code" placeholder="Invitation Code">
          <div class="Small_notice_Wrapper">
            <p href="#" id="Small_notice_text">U can only register account with an invitation code</a>
          </div>

          <button type="submit" id="Login_Button" name="Login">Request&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
        </form>
      </div>
    </div>
  </body>
  <script rel="text/javascript" src="<?= BASEURL;  ?>/js/darkmode.js"></script>
</html>
