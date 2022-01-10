<?php
    session_start();
    include("scripts/config.php");

    //Connection Test==============================================>
        // Check connection
        /*if ($dbconn->connect_error) {
            die("<div class='p-4 alert alert-danger'>Connection failed: " . $db->connect_error) . "</div>";
        } else {
            die("Connected successfully");
        }*/
        
    //end of Connection Test============================================>
    
    //Declaring variables
    $reguser_fname = mysql_fix_string($dbconn,$_POST['clientRegInputFName']);
    $reguser_lname = mysql_fix_string($dbconn,$_POST['clientRegInputLName']);

    //generate a username for the user automatically
    $reguser_init_username = $reguser_fname."_".substr($reguser_lname, 1, 2).generateRandomString(4);

    $reguser_contact = mysql_fix_string($dbconn,$_POST['clientRegInputContact']);
    $reguser_email = mysql_fix_string($dbconn,$_POST['clientRegInputEmail']);
    $reguser_dob = mysql_fix_string($dbconn,$_POST['clientRegInputDOB']);
    $reguser_idnum = mysql_fix_string($dbconn,$_POST['clientRegInputIDNum']);
    $reguser_res_address = mysql_fix_string($dbconn,$_POST['clientRegInputResAddress']);
    $reguser_type = "Registered";

    //generate a temporary password
    $reguser_pwd_hash = generateRandomString(10);

    $reguser_regdate = date("Y-m-d H:i:s");
    

    function mysql_fix_string($dbconn, $string) {
        if(get_magic_quotes_gpc()) $string = stripslashes($string);
        return $dbconn->real_escape_string($string);
    }

    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $insertquery = "INSERT INTO Clients VALUES(NULL, '$reguser_init_username', '$reguser_fname', '$reguser_lname', '$reguser_contact', '$reguser_email', '$reguser_dob', '$reguser_idnum', '$reguser_res_address', '$reguser_type', '$reguser_pwd_hash', '$reguser_regdate')";
    $result = $dbconn->query($insertquery);

    if(!$result) die("<div class='alert alert-danger text-center'>A Fatal Error has occured. Please try again and if the problem persists, please contact the system administrator.</div><br><br><a href='index.html'>Return to Home Page</a>");

    echo '<div class="alert alert-success p-4 text-center w-100">Operation Completed Successfully.</div>';

    
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Happy Events Equipment Rentals | Client Registration</title>
    <!-- Required Meta Tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <link rel="stylesheet" href="styles/style.css" />
  </head>

  <body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-whitez fs-5z" style="background: #e6f5e5 !important; color: #1c9941 !important; overflow-x: hidden">
      <div class="container">
        <div class="navbar-brand fw-bold d-block fs-3z" style="color: #1c9941 !important">
          <!--href="#"-->
          <!---->
          <img src="media/assets/Happy Events New Logo with BG.png" alt="logo" class="img-fluid shadow bg-success" style="height: 150px !important; border-radius: 25px; border: solid #1c9941 0px" />

          Happy Events Rentals&trade;<span class="sniglet-font">.ERS</span>&copy;
          <span class="text-warning fs-1 fw-bold"><i class="fas fa-spinner"></i></span>
        </div>

        <button class="navbar-toggler shadow rounded-pill p-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="background-color: #1c9941 !important">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end fw-bold" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link text-center" href="index.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center" href="about.html">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center" href="app/EquipmentCatalogue.html">Shop</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center" data-bs-toggle="modal" data-bs-target="#clientSignInModal" style="cursor: pointer">Sign In</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active text-center" aria-current="page" href="#">Registration</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center" href="contact.html">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- ./ Navigation Bar -->

      <h1 class="text-center">Thank you for registering an account with us.</h1>

      <div class="container">
        <p>Please launch the email confirmation link sent to your email address and then enter the OTP Sent to your phone via email. This will verify your contact details.</p>
      </div>

      <hr class="bg-white" />
    <!-- footer -->
    <div class="footer mb-0 pt-4">
      <div class="container">
        <div class="row">
          <div class="col-md text-center pb-4">
            <img src="media/assets/Happy Events Rental Light Theme Full Logo.png" alt="logo" class="img-fluid shadow" style="border-radius: 25px" />

            <p class="mt-4"><strong class="unica-one-font">Happy Events Equipment Rentals</strong> is an Equipment Rental company which sells and primarily leases equipment for all types of events. Whatever you need, we got it.</p>
          </div>
          <div class="col-md text-start pb-4">
            <h2 class="text-start sniglet-font-thick">Navigation</h2>
            <ul class="list-group list-group-flush pb-4" id="footer-navigation">
              <li class="list-group-item bg-transparent"><a href="#">Home</a></li>
              <li class="list-group-item bg-transparent"><a href="about.html">About</a></li>
              <li class="list-group-item bg-transparent"><a href="app/EquipmentCatalogue.html">Shop</a></li>
              <li class="list-group-item bg-transparent"><a data-bs-toggle="modal" data-bs-target="#clientSignInModal" style="cursor: pointer">Sign In</a></li>
              <li class="list-group-item bg-transparent"><a href="contact.html">Contact</a></li>
            </ul>

            <h2 class="text-start sniglet-font-thick">Important Links</h2>
            <ul class="list-group list-group-flush pb-4" id="footer-navigation">
              <li class="list-group-item bg-transparent"><a href="https://sacoronavirus.co.za/">COVID-19</a></li>
              <li class="list-group-item bg-transparent"><a href="#">Privacy Policy</a></li>
              <li class="list-group-item bg-transparent"><a href="#">Return Policy</a></li>
              <li class="list-group-item bg-transparent"><a href="#">Terms of Use</a></li>
            </ul>
          </div>
          <div class="col-md pb-4">
            <h2 class="sniglet-font-thick">Sign up for our Newsletter</h2>
            <p>By signing up, you will be added to our mailing list for our Monthly Newsletters. This will also enter you automatically in our promotional prize draws as well as make you elidgible to receiving Monthly Checkout Discounts (if you are a registered client).</p>
            <form class="row g-3">
              <div class="col-auto">
                <label for="staticEmail2" class="visually-hidden">Email</label>
                <input type="email" class="form-control -plaintext text-center rounded-pill shadow" id="staticEmail2" placeholder="email@example.com" />
              </div>
              <div class="col-auto">
                <button type="submit" class="btn btn-outline-light rounded-pill mb-3">Subscribe</button>
              </div>
            </form>
          </div>
        </div>

        <hr class="text-white" />

        <div class="w-100 text-center">
          <p class="py-4">Crafted by Thabang Mposula (8008999) &copy; 2021 | Systems Development 3 (HSYD300-1) SA1</p>
        </div>
      </div>
    </div>

   <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>