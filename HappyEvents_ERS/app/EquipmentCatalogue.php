<?php
  session_start();
  include("../scripts/config.php");

  //Connection Test==============================================>
      // Check connection

      /*if ($dbconn->connect_error) {
          die("Connection failed: Error: [ " . $db->connect_error . " ]");
      } else {
          die("Connected successfully!");
      }*/
      
  //end of Connection Test============================================>

  function mysql_fix_string($dbconn, $string) {
    if(get_magic_quotes_gpc()) $string = stripslashes($string);
    return $dbconn->real_escape_string($string); 
  }

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
    
  }else{
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
            $_SESSION['type'] = mysql_fix_string($dbconn, $user_type);
            $_SESSION['regdate'] = mysql_fix_string($dbconn, $user_reg_date);
            $_SESSION['profpic'] = mysql_fix_string($dbconn, $user_profile_pic);

            $result->close();
            $dbconn->close();
        }

      }
      
    }
  }
  //<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< ./ Check User Account Loggin Status
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Rental Equipment Catalogue | Happy Events Equipment Rentals</title>

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
            <form action="../client-login.php" method="post" autocomplete="on" id="client-login-form" class="text-center">
              <div class="mb-3">
                <label for="signInInputUsername" class="form-label">Username</label>
                <input type="text" class="form-control rounded-pill text-center border border-success border-4" id="signInInputUsername" name="signInInputUsername" value="<?php echo $usrnm;?>" />
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

    <!-- Offcanvas Shopping Cart -->
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" style="width: 600px !important; background-color: #1c9941; color: #fff">
      <div class="offcanvas-header">
        <p class="offcanvas-title fs-1 fw-bold sniglet-font" id="offcanvasExampleLabel"><i class="fas fa-shopping-cart"></i> My Cart</p>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div class="text-center fs-3 my-4">Thank you for shopping with us Mr./Ms./Mrs. <span class="fw-bold" id="users-fullname-display">Users Names</span>. We appreciate your <span class="fw-bold">Petronage</span>.</div>

        <div class="my-4 text-center rounded-pill shadow-lg py-2">
          Cart Total: <span class="fs-1 fw-bold">R<span id="cart-total-display-cart">0.00</span> (<span id="cart-items-count-display-cart">0</span>)</span>
        </div>

        <div class="sidecart-checkout-btn-container d-grid gap-2 mb-4">
          <a id="cart-checkout-btn" class="btn btn-success btn-lg rounded-pill p-4 fw-bold fs-1 shake shadow-lg border-warning border-5 text-warning" href="checkout/checkout.html">Checkout Here! <i class="fas fa-cash-register"></i></a>
        </div>

        <hr class="bg-success mt-4" />

        <!-- ******* .mini-profile-card code snippet
          <div class="sidecart-item-cart shadow mb-4">
                <div class="card bg-transparent border-0" style="max-width: 540px">
                    <div class="row align-items-center g-0">
                    <div class="col-md-4">
                        <img src="../media/assets/placeholder.png" class="img-fluid rounded-start m-2 shadow" style="max-height: 100px !important" alt="..." />
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title fs-2 fw-boldz text-center">Card title</h5>
                            
                        </div>
                    </div>
                    </div>
                    <p class="card-text">
                        <div class="row align-items-center text-center mx-2">
                            <div class="col">
                                <p class="mb-0">Item Amount:</p>
                                <p class="fs-1 fw-bold" id="cart-total-display">R0.00 </p>
                            </div>
                            <div class="col d-grid gap-2">
                                <button class="btn btn-danger btn-lg p-4 rounded-pill fs-1">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </div>
                        </div>
                    </p>
                </div>
            </div>
        -->
        <div class="sidecart-item-cart-container my-4 px-4 py-4 shadow-lg bg-white" id="sidecart-item-cart-container">
          <h1 class="fw-bold text-center my-4 text-success" id="no-items-label">
            <span class="text-warning fs-1 fw-bold"><i class="fas fa-spinner"></i></span> Pick out something you like!
          </h1>
        </div>
        <div class="sidecart-clear-cart-btn-container d-gridz gap-2z mb-4 text-center">
          <button id="clear-cart-btn" class="btn btn-danger btn-lg rounded-pill p-4 fw-bold fs-5 shadow-lg border-light border-5 text-white" onclick="clearCart()">Clear Cart <i class="fas fa-trash-alt"></i></button>
        </div>
      </div>
    </div>
    <!-- ./ Offcanvas Shopping Cart -->

    <!--Navigation bar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-whitez fs-5z" style="background: #e6f5e5 !important; color: #1c9941 !important">
      <div class="container">
        <div class="navbar-brand fw-bold fs-3z" style="color: #1c9941 !important; overflow-x: hidden">
          <!--href="#"-->
          <!---->
          <img src="../media/assets/Happy Events New Logo with BG.png" alt="logo" class="img-fluid shadow bg-success" style="height: 150px !important; border-radius: 25px; border: solid #1c9941 0px" />

          Happy Events Rentals&trade;<span class="sniglet-font">.ERS</span>&copy;
          <span class="text-warning fs-1 fw-bold"><i class="fas fa-spinner"></i></span>
        </div>

        <button class="navbar-toggler shadow rounded-pill p-4 mt-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="background-color: #1c9941 !important">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end fw-bold" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link text-center" href="../index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center active" aria-current="page" href="#">Shop</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center" href="../about.php">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-center" href="../contact.php">Contact</a>
            </li>
            <li class="nav-item" <?php if($userloggedin == "true"){echo "hidden";}?>>
              <a class="nav-link text-center" href="../client-registration.html">Registration</a>
            </li>
            <li class="nav-item" id="signin-nav-card">
              
              <?php
                if($userloggedin === "true"){
                  echo '<a class="nav-link text-center" href="#mini-profile-card"><i class="fas fa-id-badge"></i> @'.$username.'</a>';
                }else{
                  echo '<a class="nav-link text-center" data-bs-toggle="modal" data-bs-target="#clientSignInModal" style="cursor: pointer">Sign In</a>';
                }
              ?>
            </li>
            <li class="nav-item" <?php if($userloggedin == "false"){echo "hidden";}?>>
              <a class="nav-link text-center border-danger px-3" onclick="userSignOut()"><span class="text-danger"><i class="fas fa-sign-out-alt"></i></span></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!--./ End of Navigation Bar-->

    <!-- Main Content -->
    <div class="container pb-4">
      <h1 class="text-center" style="font-size: 70px">Welcome to the Shop! <i class="fas fa-store"></i></h1>
      <p class="fw-bold text-center">Need to Rent of Buy for an Event? We got you!</p>
      <hr class="text-success" />

      <div class="row w-100z px-4 py-4 mt-4 mb-0 mx-0 align-items-center" style="border-radius: 25px 25px 0 0; min-height: 25px; background-color: #1c9941">
        <div class="col -sm text-start">
          <img src="../media/assets/Happy Events Reward Card.png" alt="" class="img-fluid shadow mb-4" style="border-radius: 25px !important" />

          <div class="mini-profile-card row shadow-sm align-items-end" id="mini-profile-card" style="border-radius: 0 25px 25px 25px">
            <div class="col-sm p-2" style="overflow: hidden">
              <img src="../media/user_profile_images/<?php echo $user_profile_pic;?>" alt="profile picture" class="img-fluid shadow" style="border-radius: 0 50rem 50rem 50rem !important; border: #1c9941 solid 4px" />
            </div>

            <div class="col text-center fs-5 fw-boldz border-warning mb-4">
              <h5 class="text-center mt-4"><?php echo "$user_fname $user_lname";?></h5>
              
              <div class="px-4 border-warning" style="border-bottom: #1c9941 solid 5px; border-radius: 0 0 25px 25px; font-size: 10px">
                <span id="mini-profile-card-users-username-display m-4" class="barcode-font"><?php echo $username ;?></span>
              </div>

              <ul class="list-group list-group-flush border-0 sniglet-font mt-2" style="font-size: 5px">
                <li class="list-group-item bg-transparent text-success"><?php echo $username;?></li>
                <li class="list-group-item bg-transparent text-success"><?php echo $user_email;?></li>
                <li class="list-group-item bg-transparent text-success"><?php echo $user_contact;?></li>
                <li class="list-group-item bg-transparent text-success"><?php echo $user_type;?></li>
                <li class="list-group-item bg-transparent text-success"><?php echo $user_reg_date;?></li>
              </ul>
            </div>

            <div class="col-2 p-2 text-center border-warning" style="border-left: #1c9941 solid 5px; border-bottom: #1c9941 solid 5px; border-top-left-radius: 25px; border-bottom-right-radius: 25px">
              <i class="fas fa-id-badge text-whitez"></i>
            </div>
          </div>
        </div>
        <div class="col-sm px-4 pt-4 text-start" style="color: #fff">
          <h5 class="">Are you Buying or looking to Hire?</h5>

          <!--User selects the buy / hire option.-->
          <div class="btn-group fs-1 mb-4 sniglet-font" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked onclick="setTradeOption('rental')" />
            <label class="btn btn-outline-light fw-bold" for="btnradio1">Rental</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" onclick="setTradeOption('buying')" />
            <label class="btn btn-outline-light fw-bold" for="btnradio2">Buying</label>
          </div>

          <div id="rental-duration-container">
            <h5 class="my-2">Rental Duration:</h5>
            <div class="mb-3">
              <label for="rental-duration-start" class="form-label">Start Date:</label>
              <input type="date" class="form-control rounded-pill" onchange="calcRentalDuration()" id="rental-duration-start" />
            </div>
            <div class="mb-3">
              <label for="rental-duration-end" class="form-label">End Date:</label>
              <input type="date" class="form-control rounded-pill" onchange="calcRentalDuration()" id="rental-duration-end" />
            </div>
            <div class="mb-3 text-end">
              Number of Days:
              <span class="fs-1 fw-bold" id="rental-duration-day-count">0</span>
            </div>
            <p class="text-warning text-center sniglet-font">Get the Happy Events Reward Card for more Value! <a href="" class="btn btn-outline-light shadow-sm p-3 fs-5 rounded fw-bold unica-one-font">Apply Today</a></p>
          </div>
        </div>
      </div>

      <div class="row sticky-top text-end align-items-center px-4 mb-4 mt-0 mx-0 shadow" style="background-color: #1c9941 !important; color: #fff; border-radius: 0 0 25px 25px">
        <hr class="text-white" />
        <div class="col-sm -8 text-center pt-4z d-grid gap-2">
          <!--Horizontal mini preview card list (cart items)
          <button class="btn btn-outline-danger p-4 rounded-pill">Hide</button>-->
          <div class="my-2 fs-3z">
            Cart Total:
            <span class="fs-1 fw-bold">R<span id="cart-total-display">0.00</span> (<span id="cart-items-count-display">0</span>)</span>
          </div>
        </div>
        <div class="col-sm -4 text-center py-4 d-grid gap-2">
          <button class="btn btn-outline-light rounded-pill p-3 fs-5 sniglet-font" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">View Shopping Cart</button>
        </div>
      </div>

      <!-- 
        *******Product Cart Code Snippet
        <div class="product-card">
          <div class="card bg-transparent w-100 p-2">
            <img src="../media/assets/placeholder.png" class="card-img-top shadow" alt="..." style="border-radius: 25px !important" />
            <div class="card-body">
              <h3 class="card-title fs-1">Card title</h3>
              <p class="fs-2">1 Day Hire Fee: R1.00</p>
              <p class="fs-2">Buy for: R100.00</p>
              <p class="card-text fs-4">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              <div class="d-grid gap-2 text-center">
                <a href="#" class="btn btn-warning btn-lg rounded-pill shadow fs-1 sniglet-font-thick text-success"> Add to Cart <i class="fas fa-cart-plus"></i></a>
              </div>
            </div>
          </div>
        </div>
      -->
      <div class="product-card-grid-container my-4" id="product-card-grid-container">
        <h1 class="fw-bold text-center my-4">Uh-oh... No products to display! &#128517;</h1>
      </div>
    </div>
    <!-- ./ of Main Content -->

    <!-- footer -->
    <div class="footer mb-0 pt-4">
      <div class="container">
        <div class="row">
          <div class="col-md text-center pb-4">
            <img src="../media/assets/Happy Events Rental Light Theme Full Logo.png" alt="logo" class="img-fluid shadow btn-success" style="border-radius: 25px" />

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
    <!--./ end of footer-->

    <!-- Javascript Code -->
    <script>
      //******* Store: Product List
      //We want to load the Products list using Ajax and PHP to compile a body of .product-card Div Elements for the product-card-grid-container Div Container Element.
      function loadProducts() {
        //Initialize Variables
        var productsContainer = document.getElementById("product-card-grid-container");

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
          productsContainer.innerHTML = this.responseText;
        };
        xhttp.open("GET", "compile-product-list.php?entry=pageinit", true);
        xhttp.send();
      }

      //******* Store: Rental Duration Calculator
      //We want to calculate the number of days between the Rental Start Date and the Rental End Date.

      function calcRentalDuration() {
        //Initialize Variables
        var initRentStartDate = document.getElementById("rental-duration-start");
        var initRentEndDate = document.getElementById("rental-duration-end");

        // To set two dates to two variables
        var startDate = new Date(initRentStartDate.value);
        var endDate = new Date(initRentEndDate.value);

        // To calculate the time difference of two dates
        var Difference_In_Time = endDate.getTime() - startDate.getTime();

        // To calculate the no. of days between two dates
        var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

        if (Difference_In_Days < 0) {
          alert("Error: The Rental End Date cannot be a Date before the Rental Start Date.");
          initRentStartDate.value = new Date();
          initRentEndDate.value = new Date();
          Difference_In_Days = 0;
        }

        if (startDate.getDate("MM/DD/YYYY") == endDate.getDate("MM/DD/YYYY")) {
          Difference_In_Days = 1;
        }

        if (isNaN(Difference_In_Days)) {
          Difference_In_Days = `<span class="text-warning fs-1 fw-bold"><i class="fas fa-spinner"></i></span>`;
        }

        //Update the #rental-duration-day-count eleme with the calculated no. of days (result)
        document.getElementById("rental-duration-day-count").innerHTML = Difference_In_Days;

        return Difference_In_Days;
      }

      //******* User sign out
      function userSignOut() {
        window.location.href = "sign-out.php";
      }

      //******* Store: Cart - Transfer User to Checkout landing page
      //We want to navigate to the checkout-landing.html?checkoutamt=value&cartitems=value

      //******* Store: Cart - Clear Cart
      //We want to clear / remove all child .sidecart-item-cart Div Elements and insert an H3 Element that displays: "No items yet. Pick out something you like!".
      function clearCart(params) {
        //initializing localstorage variables
        localStorage.setItem("trade_option", "rental");
        localStorage.setItem("rental_cart_total", 0.00)
        localStorage.setItem("buying_cart_total", 0.00);
        localStorage.setItem("cart_items_count", 0);
        localStorage.setItem("trade_option", "rental");

        var selCartItemsContainer = document.getElementById("sidecart-item-cart-container");
        var cartTotalDisplay = document.getElementById("cart-total-display");
        var cartItemCountDisplay = document.getElementById("cart-items-count-display");
        var cartTotalDisplayCart = document.getElementById("cart-total-display-cart");
        var cartItemCountDisplayCart = document.getElementById("cart-items-count-display-cart");

        selCartItemsContainer.innerHTML = `<h1 class="fw-bold text-center my-4 text-success" id="no-items-label">
            <span class="text-warning fs-1 fw-bold"><i class="fas fa-spinner" aria-hidden="true"></i></span> Pick out something you like!
          </h1>`;

        cartTotalDisplay.innerHTML = "0.00";
        cartItemCountDisplay.innerHTML = 0;
        cartTotalDisplayCart.innerHTML = "0.00";
        cartItemCountDisplayCart.innerHTML = 0;
      }

      //******* Store: Cart - Add an item to the Cart
      //We want to create a .sidecart-item-cart Div Element of the selected item from the product list into the Cart .sidecart-item-cart-container Div Container Element.
      //addCartItem('$product_id','$product_name','$product_sellprice','$product_rentprice','$product_itemcode','$product_binnumber'."','".$img_preview_url)
      
      //initializing localstorage variables
      if (localStorage.getItem("trade_option") === null) {
          //initialize storage value
          localStorage.setItem("trade_option", "rental");
        }

      if (localStorage.getItem("rental_cart_total") === null) {
        //initialize storage value
        localStorage.setItem("rental_cart_total", 0.00);
      }

      if (localStorage.getItem("buying_cart_total") === null) {
        //initialize storage value
        localStorage.setItem("buying_cart_total", 0.00);
      }

      if (localStorage.getItem("cart_items_count") === null) {
        //initialize storage value
        localStorage.setItem("cart_items_count", 0);
      }

      function addCartItem(prodid, prodname, prodsellprice, prodrentprice, proditemcode, prodbinnumber, imgpreview) {
        //alert("Notice! \n\nFlag check: \n\nProduct Name: [ " + prodname + " ] \n\nProduct Sell Price: [R" + prodsellprice + " ] \n\nProduct Rent Price: [R" + prodrentprice + " ]");
        var selCartItemsContainer = document.getElementById("sidecart-item-cart-container");

        var cartTotalDisplay = document.getElementById("cart-total-display");
        var cartItemCountDisplay = document.getElementById("cart-items-count-display");

        var cartTotalDisplayCart = document.getElementById("cart-total-display-cart");
        var cartItemCountDisplayCart = document.getElementById("cart-items-count-display-cart");

        //hide this label
        document.getElementById("no-items-label").style.display = "none";

        let miniItemCardDiv = document.createElement("div");

        miniItemCardDiv.classList.add("sidecart-item-cart");
        miniItemCardDiv.classList.add("shadow");
        miniItemCardDiv.classList.add("mb-4");

        miniItemCardDiv.id = "cart-item-prod-card-" + prodid;

        if(localStorage.getItem("trade_option") == "rental"){
          $cartItemDispAmt = prodrentprice;
          $tradeoptStr = "(Rental)";
        }else{
          $cartItemDispAmt = prodsellprice;
          $tradeoptStr = "(Buying)";
        }

        miniItemCardDiv.innerHTML =
          `<div class="card bg-transparent border-0" style="max-width: 540px">
                    <div class="row align-items-center g-0">
                    <div class="col-md-4 text-center">
                        <img src="../media/general/product_imgs/` +
          imgpreview +
          `" class="img-fluid rounded-start m-2 shadow" style="max-height: 100px !important" alt="Img Preview: ` +
          prodname +
          `" />
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title fs-2 fw-boldz text-center">` +
          prodname +
          `</h5>
                        </div>
                    </div>
                    </div>
                    <p class="card-text">
                        <div class="row align-items-center text-center mx-2">
                            <div class="col-sm">
                                <p class="mb-0">Item Amount:</p>
                                <p class="fs-1 fw-bold" id="cart-total-display">R` +
          $cartItemDispAmt +
          ` <span style="font-size: 15px!important">` + $tradeoptStr + `</span></p>
                            </div>
                            <div class="col-sm d-grid gap-2">
                                <button class="btn btn-danger btn-lg p-4 rounded-pill fs-1" onclick="removeCartItem('cart-item-prod-card-` +
          prodid +
          `')">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </div>
                        </div>
                    </p>
                </div>`;

        selCartItemsContainer.appendChild(miniItemCardDiv);

        var val;
        //calculate the cartItemCount and cartTotalAmt's
        if (localStorage.getItem("trade_option") == "rental") {
          //rental - calculate the total according to the rental price and update displays
          //localStorage.setItem("rental_cart_total", parseFloat(localStorage.getItem("rental_cart_total")).toFixed(2));
          cartTotalAmt = parseFloat(localStorage.getItem("rental_cart_total")) + parseFloat(prodrentprice);
          alert("Rental (Curr LS Value): "+ parseFloat(localStorage.getItem("rental_cart_total")).toFixed(2));
          alert("Rental (RP: "+ parseFloat(cartTotalAmt).toFixed(2));
          localStorage.setItem("rental_cart_total", parseFloat(cartTotalAmt).toFixed(2));
        } else {
          //buying - calculate the total according to the buying price and update displays
          //localStorage.setItem("buying_cart_total", parseFloat(localStorage.getItem("buying_cart_total")).toFixed(2));
          cartTotalAmt = localStorage.getItem("buying_cart_total") + parseFloat(prodsellprice);
          alert("Rental (Curr LS Value): "+ parseFloat(localStorage.getItem("buying_cart_total")).toFixed(2));
          alert("Rental (RP: "+ parseFloat(cartTotalAmt).toFixed(2));
          localStorage.setItem("buying_cart_total", parseFloat(cartTotalAmt).toFixed(2));
        }

        

        //update the cart items localstorage value
        localStorage.setItem("cart_items_count", parseInt(localStorage.getItem("cart_items_count")) + 1);
        cartItemCount = localStorage.getItem("cart_items_count");

        //display the calculated values
        //cart display
        cartItemCountDisplayCart.innerHTML = cartItemCount;
        cartTotalDisplayCart.innerHTML = cartTotalAmt;

        //Store front display
        cartItemCountDisplay.innerHTML = cartItemCountDisplayCart.innerHTML;
        cartTotalDisplay.innerHTML = cartTotalDisplayCart.innerHTML;
        

        alert("Notice! \n\nItem added to Cart: \n\nProduct Name: [ " + prodname + " ] \n\nProduct Rent Price: [R" + prodrentprice + " ] \n\nProduct Sell Price: [R" + prodsellprice + " ] \n\nItems in Cart [ " + cartItemCount + " ] \n\nCart Total: [ " + cartTotalAmt + " ]");
      }

      function setTradeOption(optionval) {
        localStorage.setItem("trade_option", optionval);
      }

      function setRentDuration(type, datestr) {
        if(type == "start"){
          localStorage.setItem("rental_start", datestr);
        }else{
          localStorage.setItem("rental_end", datestr);
        }

        //calculate the number of days
        var duration = calcRentalDuration();
        localStorage.setItem("rental_duration", duration);
      }

      //******* Store: Cart - Remove a Single Cart item
      //We want to Remove a Single Cart item from the Carts Items List in the Cart when we click a remove item button.
      function removeCartItem(elemid) {
        //show this label
        document.getElementById("no-items-label").style.display = "block";

        var elem = document.getElementById(elemid);

        return elem.parentNode.removeChild(elem);
      }

      //On load: XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
      document.addEventListener("load", loadProducts());
    </script>
    <!-- ,/ Javascript Code -->

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
