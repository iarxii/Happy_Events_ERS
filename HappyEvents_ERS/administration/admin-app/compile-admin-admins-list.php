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

//Initialize Global Variable
$entryPointVal = mysql_fix_string($dbconn, $_GET['entry']);
//echo $entryPointVal."<br>";

function mysql_fix_string($dbconn, $string) {
    if(get_magic_quotes_gpc()) $string = stripslashes($string);
    return $dbconn->real_escape_string($string);
}

if (isset($entryPointVal)) {
  
  if ($entryPointVal == "pageinit") {
    //initializing the Shops Product List
    try {
      //compile list
      $query = "SELECT * FROM Employees";

      $result = $dbconn->query($query);

      if(!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator.");

      $rows = $result->num_rows;
      //echo $rows."<br>";
      $comp_admins_list = "";

      if($rows<=0) {
          //there is no result so notify user that the account cannot be found
          echo `<tr><td colspan="13"><h1 class="fw-bold text-center my-4">No System Admin User Accounts to Display!</h1></td></tr>`;
      } else {
        for ($j = 0; $j < $rows ; ++$j) {
          $row = $result->fetch_array(MYSQLI_ASSOC);

          $employee_id = htmlspecialchars($row['Employee_id']);
          $username = htmlspecialchars($row['username']);
          $firstname = htmlspecialchars($row['first_name']);
          $lastname = htmlspecialchars($row['last_name']);
          $contact = htmlspecialchars($row['contact_number']);
          $email = htmlspecialchars($row['email_address']);
          $dob = htmlspecialchars($row['date_of_birth']);
          $idnumber = htmlspecialchars($row['id_number']);
          $resaddress = htmlspecialchars($row['residential_address']);
          $usertype = htmlspecialchars($row['user_type']);
          $registrationdate = htmlspecialchars($row['registration_date']);

          $comp_admins_list .= '<tr>
              <td class="text-center table-info">
                <button class="btn btn-info p-3 rounded-pill mb-2 shadow" onclick="showModal('."'$employee_id'".','."'admins'".')" style="font-size: 30px"><i class="fas fa-edit"></i></button>
                <span style="font-size: 10px">Edit</span>
              </td>
              <td class="text-center table-danger">
                <button class="btn btn-danger p-3 rounded-pill mb-2 shadow" onclick="deleteAdminRecord('."'$employee_id'".')" style="font-size: 30px"><i class="fas fa-trash-alt"></i></button>
                <span style="font-size: 10px">Delete</span>
              </td>

              <td scope="row" class="fw-bold">'.$employee_id.'</td>
              <td>'.$username.'</td>
              <td>'.$firstname.'</td>
              <td>'.$lastname.'</td>
              <td>'.$contact.'</td>
              <td>'.$email.'</td>
              <td>'.$dob.'</td>
              <td>'.$idnumber.'</td>
              <td>'.$resaddress.'</td>
              <td>'.$usertype.'</td>
              <td>'.$registrationdate.'</td>
            </tr>';
        }

        $result->close();
        $dbconn->close();
        
        //navigate user to the Equipment Catalogue
      }

      echo $comp_admins_list;
    } catch (\Throwable $err) {
      //throw $err;
      echo "An Error has Occured: [ ".$err." ]";
    }
  }
}
?>