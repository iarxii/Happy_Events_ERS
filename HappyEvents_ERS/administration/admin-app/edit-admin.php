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
    $post_employee_id = mysql_fix_string($dbconn, $_POST['employee-id']);
    $admin_username =  mysql_fix_string($dbconn,$_POST['adminUpdtInputUsername']);
    $admin_fname = mysql_fix_string($dbconn,$_POST['adminUpdtInputFName']);
    $admin_lname = mysql_fix_string($dbconn,$_POST['adminUpdtInputLName']);
    $admin_contact = mysql_fix_string($dbconn,$_POST['adminUpdtInputContact']);
    $admin_email = mysql_fix_string($dbconn,$_POST['adminUpdtInputEmail']);
    $admin_dob = mysql_fix_string($dbconn,$_POST['adminUpdtInputDOB']);
    $admin_idnum = mysql_fix_string($dbconn,$_POST['adminUpdtInputIDNum']);
    $admin_res_address = mysql_fix_string($dbconn,$_POST['adminUpdtInputResAddress']);
    $admin_type = "Registered";
    $admin_pwd_hash = mysql_fix_string($dbconn,$_POST['adminUpdtInputPassword']);

    if (isset($post_client_id)) {
      try {
        //Update Record
        $query = "UPDATE admins SET `username`='$admin_username',`first_name`='$admin_fname',`last_name`='$admin_lname',`contact_number`='$admin_contact',`email_address`='$admin_email',`date_of_birth`='$admin_dob',`id_number`='$admin_idnum',`residential_address`='$admin_res_address',`user_type`='$admin_type',`password_hash`='$admin_pwd_hash' WHERE `Employee_id`=$post_employee_id";

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
    $employee_id = mysql_fix_string($dbconn, $_GET['id']);

    try {
      //Get the client record of the id GET Param
      $query = "SELECT * FROM Employees WHERE Employee_id=$employee_id";

      $result = $dbconn->query($query);

      if(!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator.");

      $rows = $result->num_rows;

      if($rows<=0) {
          //there is no result so notify user that the account cannot be found
          echo '<div class="alert alert-info">Ooops, this client cannot be found. Please search for another client or contact the System Administrator if this an error or the issue persists.</div>';
      } else {
        for ($j = 0; $j < $rows ; ++$j) {
          $row = $result->fetch_array(MYSQLI_ASSOC);

          $output_employee_id = htmlspecialchars($row['Employee_id']);
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
    <title>Edit Administrator Information | Happy Events Equipment Rentals</title>
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
    <div class="container" style="margin-bottom: 100px">
      <!-- Update client Form -->
      <div id="admin-update-client-info-form-container" style="background-color: #1c9941; color: #fff; border-radius: 25px" class="shadow p-4 my-4">
        <h1 class="mt-4 text-center">Update System Administrator Account Details</h1>
        
        <form action="edit-admin.php?id=<?php echo $employee_id;?>" method="post" id="client-registration-form" class="basic-form-style p-4 shadow fs-3">
          <div id="emailHelp" class="form-text text-center p-4 mb-4 shadow sniglet-font -thick text-danger bg-light" style="border-radius: 25px">Please take note that this form is only for updating user account information of <strong>System Administrators</strong>.</div>

          <div class="mb-3" hidden>
            <label for="employee-id" class="form-label">Client ID</label>
            <input type="text" class="form-control rounded-pill" id="employee-id" name="employee-id" required value="<?php echo $output_employee_id ;?>" />
          </div>
          <div class="mb-3">
            <label for="adminUpdtInputUsername" class="form-label">Username</label>
            <input type="text" class="form-control rounded-pill" id="adminUpdtInputUsername" name="adminUpdtInputUsername" required value="<?php echo $output_username ;?>" />
          </div>
          <div class="mb-3">
            <label for="adminUpdtInputPassword" class="form-label">Password</label>
            <input type="text" class="form-control rounded-pill" id="adminUpdtInputPassword" name="adminUpdtInputPassword" required value="<?php echo $output_pwd_hash ;?>" />
          </div>
          <div class="mb-3">
            <label for="adminUpdtInputFName" class="form-label">First Name</label>
            <input type="text" class="form-control rounded-pill" id="adminUpdtInputFName" name="adminUpdtInputFName" required value="<?php echo $output_fname ;?>" />
          </div>
          <div class="mb-3">
            <label for="adminUpdtInputLName" class="form-label">Last Name</label>
            <input type="text" class="form-control rounded-pill" id="adminUpdtInputLName" name="adminUpdtInputLName" required value="<?php echo $output_lname ;?>" />
          </div>
          <div class="mb-3">
            <label for="adminUpdtInputContact" class="form-label">Contact Number</label>
            <input type="tel" class="form-control rounded-pill" id="adminUpdtInputContact" name="adminUpdtInputContact" required value="<?php echo $output_contact ;?>" />
          </div>
          <div class="mb-3">
            <label for="adminUpdtInputEmail" class="form-label">Email address</label>
            <input type="email" class="form-control rounded-pill" id="adminUpdtInputEmail" name="adminUpdtInputEmail" required value="<?php echo $output_email ;?>" />
          </div>
          <div class="mb-3">
            <label for="adminUpdtInputDOB" class="form-label">Date of birth</label>
            <input type="date" class="form-control rounded-pill" id="adminUpdtInputDOB" name="adminUpdtInputDOB" required value="<?php echo $output_dob ;?>" />
          </div>
          <div class="mb-3">
            <label for="adminUpdtInputIDNum" class="form-label">SA ID Number</label>
            <input type="number" class="form-control rounded-pill" id="adminUpdtInputIDNum" name="adminUpdtInputIDNum" value="<?php echo $output_idnum ;?>" />
          </div>
          <div class="mb-3">
            <label for="adminUpdtInputResAddress" class="form-label">Residential address</label>
            <textarea type="email" class="form-control rounded" id="adminUpdtInputResAddress" name="adminUpdtInputResAddress" rows="5"><?php echo $output_res_address ;?></textarea>
          </div>
          <button type="submit" class="btn btn-outline-light btn-block rounded-pill sniglet-font">
            <span class="fs-1 m-4">Update Record <i class="fas fa-save"></i></span>
          </button>
        </form>
      </div>
      <!-- ./ Update client  Form -->
    </div>

    <div class="w-100 text-center fw-bold fixed-bottom" style="background-color: #1c9941; color: #fff; font-size: 10px">
      <p class="py-4">Crafted by Thabang Mposula (8008999) &copy; 2021 | Systems Development 3 (HSYD300-1) SA1</p>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
