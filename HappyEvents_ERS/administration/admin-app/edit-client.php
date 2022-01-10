<?php
  session_start();
  include("../../scripts/config.php");

  //Connection Test==============================================>
      // Check connection
      /*if ($dbconn->connect_error) {
          die("<div class='p-4 alert alert-danger'>Connection failed: " . $db->connect_error) . "</div>";
      } else {
          die("Connected successfully");
      }*/
      
  //end of Connection Test============================================>

  function mysql_fix_string($dbconn, $string) {
      if(get_magic_quotes_gpc()) $string = stripslashes($string);
      return $dbconn->real_escape_string($string);
  }

  //reu this update code if a post request is made to save the updated data
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Initialize Global Variable
    /*$post_client_id = mysql_fix_string($dbconn, $_POST['prod-id']);
    $valPrevImg = mysql_fix_string($dbconn, "default.png");
    $valProdName = mysql_fix_string($dbconn, $_POST['updatedProdInputProdName']);
    $valProdDescr = mysql_fix_string($dbconn, $_POST['updatedProdInputProdDescr']);
    $valProdType = mysql_fix_string($dbconn, $_POST['updatedProdInputProdType']);
    $valCategory = mysql_fix_string($dbconn, $_POST['updatedProdInputCategory']);
    $avail = mysql_fix_string($dbconn, $_POST['updatedProdInputProdAvailability']);
    if( $avail == "on"){
        $valProdAvailability = 1;
    }else{
        $valProdAvailability = 0;
    };
    $valSellPrice = mysql_fix_string($dbconn, number_format($_POST['updatedProdInputSellPrice'],2));
    $valRentPrice = mysql_fix_string($dbconn, number_format($_POST['updatedProdInputRentPrice'],2));
    $valItemCode = mysql_fix_string($dbconn, $_POST['updatedProdInputItemCode']);
    $valProdSize = mysql_fix_string($dbconn, $_POST['updatedProdInputSize']);
    $valColor = mysql_fix_string($dbconn, $_POST['updatedProdInputColor']);
    $valBinNum = mysql_fix_string($dbconn, $_POST['updatedProdInputBinNum']);
    $updated_date = date("Y-m-d H:i:s");
    $valUpdateDate = mysql_fix_string($dbconn, $updated_date);*/

    $post_client_id = mysql_fix_string($dbconn, $_POST['client-id']);
    $client_username =  mysql_fix_string($dbconn,$_POST['clientUpdtInputUsername']);
    $client_fname = mysql_fix_string($dbconn,$_POST['clientUpdtInputFName']);
    $client_lname = mysql_fix_string($dbconn,$_POST['clientUpdtInputLName']);
    $client_contact = mysql_fix_string($dbconn,$_POST['clientUpdtInputContact']);
    $client_email = mysql_fix_string($dbconn,$_POST['clientUpdtInputEmail']);
    $client_dob = mysql_fix_string($dbconn,$_POST['clientUpdtInputDOB']);
    $client_idnum = mysql_fix_string($dbconn,$_POST['clientUpdtInputIDNum']);
    $client_res_address = mysql_fix_string($dbconn,$_POST['clientUpdtInputResAddress']);
    $client_type = "Registered";
    $client_pwd_hash = mysql_fix_string($dbconn,$_POST['clientUpdtInputPassword']);

    if (isset($post_client_id)) {
      try {
        //Update Record
        $query = "UPDATE Clients SET `username`='$client_username',`first_name`='$client_fname',`last_name`='$client_lname',`contact_number`='$client_contact',`email_address`='$client_email',`date_of_birth`='$client_dob',`id_number`='$client_idnum',`residential_address`='$client_res_address',`user_type`='$client_type',`password_hash`='$client_pwd_hash' WHERE `client_id`=$post_client_id";

        $result = $dbconn->query($query);

        if(!$result) die("Database Access Failed. Please contact the System Administrator.");

        //$result->close();
        //$dbconn->close();

        echo '<div class="alert alert-success fw-bold">success</div>';
        //Navigate to the Success Notification
        header("Location: edit-success.html");
      } catch (\Throwable $err) {
        //throw $err;
        echo '<div class="alert alert-danger fw-bold">An Error has Occured: [ '.$err.' ]</div>';
      }
    }
  } else {
    //Get the client details of the id GET Param
    //Initialize Global Variable
    $client_id = mysql_fix_string($dbconn, $_GET['id']);

    try {
      //Get the client record of the id GET Param
      $query = "SELECT * FROM Clients WHERE client_id=$client_id";

      $result = $dbconn->query($query);

      if(!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator.");

      $rows = $result->num_rows;

      if($rows<=0) {
          //there is no result so notify user that the account cannot be found
          echo '<div class="alert alert-info">Ooops, this client cannot be found. Please search for another client or contact the System Administrator if this an error or the issue persists.</div>';
      } else {
        for ($j = 0; $j < $rows ; ++$j) {
          $row = $result->fetch_array(MYSQLI_ASSOC);
          
          /*$output_client_name = htmlspecialchars($row['clients_name']);
          $output_client_description = htmlspecialchars($row['client_description']);
          $output_client_type = htmlspecialchars($row['client_type']);
          $output_client_category = htmlspecialchars($row['client_category']);
          $output_client_available = htmlspecialchars($row['client_availability']);
          $output_client_sellprice = htmlspecialchars($row['client_sell_price']);
          $output_client_rentprice = htmlspecialchars($row['client_base_rent_price']);
          $output_client_itemcode = htmlspecialchars($row['client_item_code']);
          $output_client_size = htmlspecialchars($row['client_size']);
          $output_client_colour = htmlspecialchars($row['client_colour']);
          $output_client_binnumber = htmlspecialchars($row['client_bin_number']);
          $output_img_preview_url = htmlspecialchars($row['img_preview_url']);
          $output_client_creation_date = htmlspecialchars($row['client_creation_date']);
          $output_client_created_by = htmlspecialchars($row['client_created_by']);*/

          $output_client_id = htmlspecialchars($row['Client_id']);
          $output_username =  htmlspecialchars($row['username']);
          $output_fname = htmlspecialchars($row['first_name']);
          $output_lname = htmlspecialchars($row['last_name']);
          $output_contact = htmlspecialchars($row['contact_number']);
          $output_email = htmlspecialchars($row['email_address']);
          $output_dob = htmlspecialchars($row['date_of_birth']);
          $output_idnum = htmlspecialchars($row['id_number']);
          $output_res_address = htmlspecialchars($row['residential_address']);
          $output_pwd_hash = htmlspecialchars($row['password_hash']);
        }

        $result->close();
        $dbconn->close();
      }
    } catch (\Throwable $err) {
      //throw $err;
      die("An Error has Occured: [ ".$err." ]");
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Edit Client Information | Happy Events Equipment Rentals</title>
    <!-- Required Meta Tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <link rel="stylesheet" href="../../styles/style.css" />

    <!--fontawesome-->
    <script src="https://kit.fontawesome.com/a2763a58b1.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Unica+One&display=swap" rel="stylesheet" />
  </head>
  <body>
    <div class="container">
      <!-- Update client Form -->
      <div id="admin-update-client-info-form-container" style="background-color: #1c9941; color: #fff; border-radius: 25px" class="shadow p-4 my-4">
        <h1 class="mt-4 text-center">Update Client Account Details</h1>
        
        <form action="edit-client.php?id=<?php echo $client_id;?>" method="post" id="client-registration-form" class="basic-form-style p-4 shadow fs-3">
              <div id="emailHelp" class="form-text text-center p-4 mb-4 shadow sniglet-font -thick text-danger bg-light" style="border-radius: 25px">Please take note that this form is only for updating user account information of <strong>Clients/Customers</strong>.</div>

              <div class="mb-3" hidden>
                <label for="client-id" class="form-label">Client ID</label>
                <input type="text" class="form-control rounded-pill" id="client-id" name="client-id" required value="<?php echo $output_client_id ;?>" />
              </div>
              <div class="mb-3">
                <label for="clientUpdtInputUsername" class="form-label">Username</label>
                <input type="text" class="form-control rounded-pill" id="clientUpdtInputUsername" name="clientUpdtInputUsername" required value="<?php echo $output_username ;?>" />
              </div>
              <div class="mb-3">
                <label for="clientUpdtInputPassword" class="form-label">Password</label>
                <input type="text" class="form-control rounded-pill" id="clientUpdtInputPassword" name="clientUpdtInputPassword" required value="<?php echo $output_pwd_hash ;?>" />
              </div>
              <div class="mb-3">
                <label for="clientUpdtInputFName" class="form-label">First Name</label>
                <input type="text" class="form-control rounded-pill" id="clientUpdtInputFName" name="clientUpdtInputFName" required value="<?php echo $output_fname ;?>" />
              </div>
              <div class="mb-3">
                <label for="clientUpdtInputLName" class="form-label">Last Name</label>
                <input type="text" class="form-control rounded-pill" id="clientUpdtInputLName" name="clientUpdtInputLName" required value="<?php echo $output_lname ;?>" />
              </div>
              <div class="mb-3">
                <label for="clientUpdtInputContact" class="form-label">Contact Number</label>
                <input type="tel" class="form-control rounded-pill" id="clientUpdtInputContact" name="clientUpdtInputContact" required value="<?php echo $output_contact ;?>" />
              </div>
              <div class="mb-3">
                <label for="clientUpdtInputEmail" class="form-label">Email address</label>
                <input type="email" class="form-control rounded-pill" id="clientUpdtInputEmail" name="clientUpdtInputEmail" required value="<?php echo $output_email ;?>" />
              </div>
              <div class="mb-3">
                <label for="clientUpdtInputDOB" class="form-label">Date of birth</label>
                <input type="date" class="form-control rounded-pill" id="clientUpdtInputDOB" name="clientUpdtInputDOB" required value="<?php echo $output_dob ;?>" />
              </div>
              <div class="mb-3">
                <label for="clientUpdtInputIDNum" class="form-label">SA ID Number</label>
                <input type="number" class="form-control rounded-pill" id="clientUpdtInputIDNum" name="clientUpdtInputIDNum" value="<?php echo $output_idnum ;?>" />
              </div>
              <div class="mb-3">
                <label for="clientUpdtInputResAddress" class="form-label">Residential address</label>
                <textarea type="email" class="form-control rounded" id="clientUpdtInputResAddress" name="clientUpdtInputResAddress" rows="5"><?php echo $output_res_address ;?></textarea>
              </div>
              <button type="submit" class="btn btn-outline-light btn-block rounded-pill sniglet-font">
                <span class="fs-1 m-4">Update Record <i class="fas fa-save"></i></span>
              </button>
            </form>
      </div>
      <!-- ./ Update client  Form -->
    </div>

    <div class="w-100 text-center fw-bold" style="background-color: #1c9941; color: #fff">
      <p class="py-4">Crafted by Thabang Mposula (8008999) &copy; 2021 | Systems Development 3 (HSYD300-1) SA1</p>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
