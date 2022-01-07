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

    echo "Operation Complete."

    /*$rows = $result->num_rows;

    if($rows==0) {
        //there is no result so notify user that the account cannot be found
        echo "The Username and Password you have provided may be incorrect or may not exist. Please check your inputs and try again.";
    } else {
        for ($j = 0; $j < $rows ; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $user_id = htmlspecialchars($row['Client_id']);
            $user_fname = htmlspecialchars($row['first_name']);
            $user_lname = htmlspecialchars($row['last_name']);
            $user_contact = htmlspecialchars($row['contact_number']);
            $user_email = htmlspecialchars($row['email_address']);
            $user_type = htmlspecialchars($row['user_type']);
            $user_reg_date = htmlspecialchars($row['registration_date']);

            /*echo $user_id."<br>";
            echo $user_fname."<br>";
            echo $user_lname."<br>";
            echo $user_contact."<br>";
            echo $user_email."<br>";
            echo $user_type."<br>";
            echo $user_reg_date."<br><br>";
        }

        $result->close();
        $dbconn->close();

        //navigate user to the Equipment Catalogue
    }*/

    
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
      <h1 class="text-center">Thank you for registering an account with us.</h1>

      <div class="container">
        <p>Please launch the email confirmation link sent to your email address and then enter the OTP Sent to your phone via email. This will verify your contact details.</p>
      </div>

      <hr class="bg-white" />
    <!-- footer -->
    <div class="footer mb-0 pt-4 fixed-bottom">
      <div class="container">
        <div class="row">
          <div class="col text-center">
            <img src="media/assets/happy events gray logo symbol.png" alt="logo" class="img-fluid" style="border-radius: 10px; border: solid #344646 5px" />

            <p><strong>Happy Events Equipment Rentals</strong> is an Equipment Rental company which sells and primarily leases equipment for all types of events. Whatever you need, we got it.</p>
          </div>
          <div class="col text-start">
            <h2 class="text-start">Navigation</h2>
            <ul class="list-group list-group-flush" id="footer-navigation">
              <li class="list-group-item"><a href="index.php">Home</a></li>
              <li class="list-group-item"><a href="about.html">About</a></li>
              <li class="list-group-item"><a href="#">Shop</a></li>
              <!--<li class="list-group-item"><a data-bs-toggle="modal" data-bs-target="#clientSignInModal" style="cursor: pointer">Sign In</a></li>-->
              <li class="list-group-item"><a href="contact.html">Contact</a></li>
            </ul>

            <h2 class="text-start">Important Links</h2>
            <ul class="list-group list-group-flush" id="footer-navigation">
              <li class="list-group-item"><a href="https://sacoronavirus.co.za/">COVID-19</a></li>
              <li class="list-group-item"><a href="#">Privacy Policy</a></li>
              <li class="list-group-item"><a href="#">Return Policy</a></li>
              <li class="list-group-item"><a href="#">Terms of Use</a></li>
            </ul>
          </div>
          <div class="col">
            <h2>Sign up for our Newsletter</h2>
            <p>By signing up, you will be added to our mailing list for our Monthly Newsletters. This will also enter you automatically in our promotional prize draws as well as make you elidgible to receiving Monthly Checkout Discount Coupons (if you are a registered client).</p>
            <form class="row g-3">
              <div class="col-auto">
                <label for="staticEmail2" class="visually-hidden">Email</label>
                <input type="email" class="form-control-plaintext text-center" id="staticEmail2" placeholder="email@example.com" />
              </div>
              <div class="col-auto">
                <button type="submit" class="btn btn-dark rounded-pill mb-3">Subscribe</button>
              </div>
            </form>
          </div>
        </div>

        <hr />

        <div class="w-100 text-center">
          <p class="py-4">Crafted by Thabang Mposula (8008999) &copy; 2021 | Systems Development 3 (HSYD300-1) SA1</p>
        </div>
      </div>
    </div>

   <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>