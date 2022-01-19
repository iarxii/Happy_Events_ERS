<?php
  session_start();
  include("scripts/config.php");
  
  //<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< Check User Account Loggin Status
  function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  $randStr = generateRandomString(6);

  $user_id = null;
  $username = "Client_".$randStr;
  $user_fname = "Client";
  $user_lname = $randStr;
  $user_contact = "contact_number_pending";
  $user_email = "email_pending";
  $user_type = "Prospective";
  $user_reg_date = date("Y-m-d H:i:s");

  $user_profile_pic = "default.png";

  $userloggedin = "false";

  //define("usersignedin", false, true);
  //echo usersignedin;

  if (isset($_SESSION['userauth'])) {
    
    if($_SESSION['userauth'] == true){
      # load these details instead of querying them
      $user_id = htmlspecialchars($_SESSION['userid']);
      $username = htmlspecialchars($_SESSION['username']);
      $user_fname = htmlspecialchars($_SESSION['fname']);
      $user_lname = htmlspecialchars($_SESSION['lname']);
      $user_contact = htmlspecialchars($_SESSION['contact']);
      $user_email = htmlspecialchars($_SESSION['email']);
      $user_type = htmlspecialchars($_SESSION['type']);
      $user_reg_date = htmlspecialchars($_SESSION['regdate']);
      $user_profile_pic = htmlspecialchars($_SESSION['profpic']);

      $userloggedin = "true";
    }
    
  }
  /*else{
    if(isset($_GET['userauth'])){
      //get the account details of the user id
      if($_GET['userauth'] == true){
        //Declaring variables
        $userid = mysql_fix_string($dbconn,$_GET['id']);

        $query = "SELECT * FROM Clients WHERE Client_id = $userid";
        $result = $dbconn->query($query);
        if(!$result) die("A Fatal Error has occured. Please try again and if the problem persists, please contact the system administrator.");

        $rows = $result->num_rows;

        if($rows==0) {
            //there is no result so notify user that the account cannot be found
            //echo "The Username and Password you have provided may be incorrect or may not exist. Please check your inputs and try again.";
            header("Location: index.php?return=unf&usrnm=Error");
        } else {
            for ($j = 0; $j < $rows ; ++$j) {
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $user_id = htmlspecialchars($row['Client_id']);
                $username = htmlspecialchars($row['username']);
                $user_fname = htmlspecialchars($row['first_name']);
                $user_lname = htmlspecialchars($row['last_name']);
                $user_contact = htmlspecialchars($row['contact_number']);
                $user_email = htmlspecialchars($row['email_address']);
                $user_type = htmlspecialchars($row['user_type']);
                $user_reg_date = htmlspecialchars($row['registration_date']);
            }

            $userloggedin = "true";
            $user_profile_pic = "IARXII_SAN.jpg";

            $_SESSION['userauth'] = mysql_fix_string($dbconn,$_GET['userauth']);
            $_SESSION['userid'] = mysql_fix_string($dbconn, $user_id);
            $_SESSION['username'] = mysql_fix_string($dbconn, $username);
            $_SESSION['fname'] = mysql_fix_string($dbconn, $user_fname);
            $_SESSION['lname'] = mysql_fix_string($dbconn, $user_lname);
            $_SESSION['contact'] = mysql_fix_string($dbconn, $user_contact);
            $_SESSION['email'] = mysql_fix_string($dbconn, $user_email);
            $_SESSION['type'] = mysql_fix_string($dbconn, $user_typ);
            $_SESSION['regdate'] = mysql_fix_string($dbconn, $user_reg_date);
            $_SESSION['profpic'] = mysql_fix_string($dbconn, $user_profile_pic);

            $result->close();
            $dbconn->close();
        }

      }
      
    }
  }*/
  //<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< ./ Check User Account Loggin Status
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us | Happy Events Equipment Rentals</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <link rel="stylesheet" href="styles/style.css" />

    <!--fontawesome-->
    <script src="https://kit.fontawesome.com/a2763a58b1.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Unica+One&display=swap" rel="stylesheet" />
  </head>
  <body>
    <!-- Sign In Modal -->
    <!-- Modal -->
    <div class="modal fade" id="clientSignInModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="clientSignInModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="border-radius: 25px !important; overflow: hidden !important">
        <div class="modal-content shadow border border-success border-3" style="border-radius: 25px !important; overflow: hidden">
          <div class="modal-header gray-bg border-warning border-bottom border-3">
            <img src="media/assets/Happy Events New Logo with BG.png" alt="logo" class="img-fluid shadow bg-success" style="height: 80px !important; border-radius: 25px; border: solid #1c9941 0px" />
            <h5 class="modal-title fs-3 mx-4 fw-bold" id="clientSignInModalLabel">Client Sign In!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body fs-3 fw-bold sniglet-font text-center" style="color: #1c9941 !important">
            <form action="client-login.php" method="post" autocomplete="on" id="client-login-form" class="text-center">
              <div class="mb-3">
                <label for="signInInputUsername" class="form-label">Username</label>
                <input type="text" class="form-control rounded-pill text-center border border-success border-4" id="signInInputUsername" name="signInInputUsername" value="" />
              </div>
              <div class="mb-3">
                <label for="signInInputPassword" class="form-label">Password</label>
                <input type="password" class="form-control rounded-pill text-centerborder border-success border-4 text-center" id="signInInputPassword" name="signInInputPassword" />
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-success btn-block rounded-pill sniglet-font fs-1 fw-bold">Sign In!</button>
              </div>
            </form>
          </div>
          <div class="modal-footer text-center d-grid gap-2 bg-success" style="border-radius: 25px 25px 0 0">
            <div class="d-grid gap-2 w-100">
              <a type="button" class="btn btn-warning rounded-pill sniglet-font text-success" href="client-registration.html">Don't have an account? Register one >>></a>
            </div>
            <!--<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>-->
          </div>
        </div>
      </div>
    </div>
    <!-- ./ Sign In Modal -->

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-whitez fs-5z" style="background: #e6f5e5 !important; color: #1c9941 !important">
      <div class="container">
        <div class="navbar-brand fw-bold d-block fs-3z" style="color: #1c9941 !important; overflow-x: hidden">
          <!--href="#"-->
          <!---->
          <img src="media/assets/Happy Events New Logo with BG.png" alt="logo" class="img-fluid shadow bg-success" style="height: 150px !important; border-radius: 25px; border: solid #1c9941 0px" />

          Happy Events Rentals&trade;<span class="sniglet-font">.ERS</span>&copy;
          <span class="text-warning fs-1 fw-bold"><i class="fas fa-spinner"></i></span>
        </div>
        <button class="navbar-toggler shadow rounded-pill p-4 mt-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="background-color: #1c9941 !important">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end fw-bold" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link text-center" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center" href="app/EquipmentCatalogue.php">Shop</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center" href="about.php">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active text-center" aria-current="page" href="#">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center" href="client-registration.html">Registration</a>
            </li>
            <li class="nav-item">
              <?php
                if($userloggedin === "true"){
                  echo '<a class="nav-link text-center" href="app/EquipmentCatalogue.php#mini-profile-card"><i class="fas fa-id-badge"></i> @'.$username.'</a>';
                }else{
                  echo '<a class="nav-link text-center" data-bs-toggle="modal" data-bs-target="#clientSignInModal" style="cursor: pointer">Sign In</a>';
                }
              ?>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- ./ Navigation Bar -->

    <!-- Main -->
    <hr class="bg-white" />

    <div class="container text-center">
      <h1 class="text-center" style="font-size: 70px">Contact Us</h1>
      <hr class="text-success" />
      <img src="media/assets/Happy Events Rental Light Theme Full Logo.png" alt="logo" class="img-fluid shadow" style="border-radius: 25px; border: solid #1c9941 0px" />

      <img src="media/assets/IMG_20211116_172017-COLLAGE.jpg" alt="" class="img-fluid shadow my-4" style="border-radius: 25px" />

      <div class="py-4 text-center">
        <table class="table table-success text-success">
          <thead>
            <th colspan="2" class="fw-bold">My Contact Details:</th>
          </thead>
          <tbody>
            <tr class="table-activez">
              <td>Student Name:</td>
              <td>Thabang Mposula</td>
            </tr>
            <tr class="table-activez">
              <td>Contact Number:</td>
              <td>071 269 4232</td>
            </tr>
            <tr class="table-activez">
              <td>Email address:</td>
              <td>Thabang.Mposula@outlook.com | Thabang.Mposulanobela@gmail.com</td>
            </tr>
            <tr class="table-activez">
              <td colspan="2">Crafted by Thabang Mposula (8008999) © 2021 | Systems Development 3 (HSYD300-1) SA1</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- ./ Main -->

    <hr class="bg-white" />
    <!-- footer -->
    <div class="footer mb-0 pt-4">
      <div class="container">
        <div class="row">
          <div class="col-md text-center pb-4">
            <img src="media/assets/Happy Events Rental Light Theme Full Logo.png" alt="logo" class="img-fluid shadow btn-success" style="border-radius: 25px" />

            <p class="mt-4"><strong class="unica-one-font">Happy Events Equipment Rentals</strong> is an Equipment Rental company which sells and primarily leases equipment for all types of events. Whatever you need, we got it.</p>
          </div>
          <div class="col-md text-start pb-4">
            <h2 class="text-start sniglet-font-thick">Navigation</h2>
            <ul class="list-group list-group-flush py-4" id="footer-navigation">
              <li class="list-group-item bg-transparent"><a href="#">Home</a></li>
              <li class="list-group-item bg-transparent"><a href="about.php">About</a></li>
              <li class="list-group-item bg-transparent"><a href="#">Shop</a></li>
              <li class="list-group-item bg-transparent"><a data-bs-toggle="modal" data-bs-target="#clientSignInModal" style="cursor: pointer">Sign In</a></li>
              <li class="list-group-item bg-transparent"><a href="contact.php">Contact</a></li>
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
