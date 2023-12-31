<?php
  session_start();
  include("../scripts/config.php");

  function mysql_fix_string($dbconn, $string) {
    if(get_magic_quotes_gpc()) $string = stripslashes($string);
    return $dbconn->real_escape_string($string); 
  }

  if(isset($_SESSION['admin_auth'])){
    if($_SESSION['admin_auth'] == true){
      header("Location: admin-app/admin.php?adminauth=".$_SESSION['admin_auth']."&id=".$_SESSION['admin_id']);
    }
  }

  $usrnm = "";
  if (isset($_GET['return'])) {
    $return = mysql_fix_string($dbconn, $_GET['return']);
    
    if ($return == "unf") {
      $usrnm = mysql_fix_string($dbconn, $_GET['usrnm']);
      # User Not Found
      echo '<div class="alert alert-danger fw-bold text-center"><i class="fas fa-exclamation-triangle"></i> | The Username and Password you have provided may be incorrect or may not exist. Please check your inputs and try again.</div>';
    } elseif ($return == "noauth") {
      # Session is not autorized
      echo '<div class="alert alert-danger fw-bold text-center"><i class="fas fa-exclamation-triangle"></i> | Your session has expired. Please sign in again.</div>';
    }
     elseif ($return == "loginreq") {
      # Login required to start a validated session
      echo '<div class="alert alert-danger fw-bold text-center"><i class="fas fa-exclamation-triangle"></i> | Access denied. Please sign in as a System Administrator to continue.</div>';
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Admin Sign In | Happy Events Equipment Rentals</title>
    <!-- Required Meta Tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <link rel="stylesheet" href="../styles/style.css" />

    <!--fontawesome-->
    <script src="https://kit.fontawesome.com/a2763a58b1.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Unica+One&display=swap" rel="stylesheet" />
  </head>
  <body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-whitez fs-5z" style="background: #e6f5e5 !important; color: #1c9941 !important">
      <div class="container">
        <div class="navbar-brand fw-bold d-block fs-3z" style="color: #1c9941 !important; overflow-x: hidden">
          <!--href="#"-->
          <!---->
          <img src="../media/assets/Happy Events New Logo with BG.png" alt="logo" class="img-fluid shadow bg-success" style="height: 150px !important; border-radius: 25px; border: solid #1c9941 0px" />

          Happy Events Rentals&trade;<span class="sniglet-font">.ERS</span>&copy;
          <span class="text-warning fs-1 fw-bold"><i class="fas fa-spinner"></i></span>
        </div>
        <button class="navbar-toggler shadow rounded-pill p-4 mt-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="background-color: #1c9941 !important">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end fw-bold" style="font-size: 10px" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link text-center" href="../index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center" href="../app/EquipmentCatalogue.php">Shop</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center" href="../about.php">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center" href="../contact.php">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center" href="../client-registration.html">Registration</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active text-center" aria-current="page" style="cursor: pointer; font-size: 10px">Admin Sign In</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- ./ Navigation Bar -->

    <div class="container p-4 text-center">
      <img src="../media/assets/Happy Events Rental Light Theme Text Only.png" alt="" class="img-fluid my-4 shadow" style="border-radius: 25px !important; max-height: 30vh !important" />
      <h1 class="text-center fs-1 my-4">Administrator Sign In</h1>
      <hr class="text-success" />
      <hr class="text-success" />
      <hr class="text-success" />
      <form action="admin-login.php" method="post" autocomplete="on" target_blank id="client-login-form" class="text-center mb-4 w-50z sniglet-font fw-bold">
        <div class="mb-md-3">
          <label for="signInInputUsername" class="form-label">Username</label>
          <input type="text" class="form-control rounded-pill text-center border border-success border-4" id="signInInputUsername" name="signInInputUsername" />
        </div>
        <div class="mb-3">
          <label for="signInInputPassword" class="form-label">Password</label>
          <input type="password" class="form-control rounded-pill text-center border border-success border-4" id="signInInputPassword" name="signInInputPassword" />
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-success btn-block rounded-pill sniglet-font fs-1 fw-bold">Sign In!</button>
        </div>
        <!--<div class="text-center">
                <a href="#client-reg-label" data-bs-dismiss="modal">Don't have an account? Register one.</a>
              </div>-->
      </form>
    </div>

    <!-- footer -->
    <div class="footer mb-0 pt-4 fixed-bottomz">
      <div class="container">
        <div class="row">
          <div class="col-md text-center pb-4">
            <img src="../media/assets/Happy Events Rental Light Theme Full Logo.png" alt="logo" class="img-fluid shadow btn-success" style="border-radius: 25px" />

            <p class="mt-4"><strong class="unica-one-font">Happy Events Equipment Rentals</strong> is an Equipment Rental company which sells and primarily leases equipment for all types of events. Whatever you need, we got it.</p>
          </div>
          <div class="col-md text-start pb-4">
            <h2 class="text-start sniglet-font-thick">Navigation</h2>
            <ul class="list-group list-group-flush py-4" id="footer-navigation">
              <li class="list-group-item bg-transparent"><a href="../index.php">Home</a></li>
              <li class="list-group-item bg-transparent"><a href="../about.php">About</a></li>
              <li class="list-group-item bg-transparent"><a href="../app/EquipmentCatalogue.php">Shop</a></li>
              <li class="list-group-item bg-transparent"><a data-bs-toggle="modal" data-bs-target="#clientSignInModal" style="cursor: pointer">Sign In</a></li>
              <li class="list-group-item bg-transparent"><a href="../contact.php">Contact</a></li>
            </ul>

            <h2 class="text-start sniglet-font-thick">Important Links</h2>
            <ul class="list-group list-group-flush py-4" id="footer-navigation">
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
