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
$employee_id = mysql_fix_string($dbconn, $_GET['id']);
//echo $entryPointVal."<br>";

function mysql_fix_string($dbconn, $string) {
    if(get_magic_quotes_gpc()) $string = stripslashes($string);
    return $dbconn->real_escape_string($string);
}

if (isset($employee_id)) {
  try {
    //compile list
    $query = "DELETE FROM Employees WHERE `Employee_id`=$employee_id";

    $result = $dbconn->query($query);

    if(!$result) die("Database Access Failed. Please contact the System Administrator.");

    //$result->close();
    //$dbconn->close();

    echo "success";
  } catch (\Throwable $err) {
    //throw $err;
    echo "An Error has Occured: [ ".$err." ]";
  }
}
?>