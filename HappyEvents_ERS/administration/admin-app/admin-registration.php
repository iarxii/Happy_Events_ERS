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
    
    //Declaring variables
    $reguser_fname = mysql_fix_string($dbconn,$_POST['newAdminInputFName']);
    $reguser_lname = mysql_fix_string($dbconn,$_POST['newAdminInputLName']);

    //generate a username for the user automatically
    $reguser_init_username = $reguser_fname."_".substr($reguser_lname, 1, 2).generateRandomString(4);

    $reguser_contact = mysql_fix_string($dbconn,$_POST['newAdminInputContact']);
    $reguser_email = mysql_fix_string($dbconn,$_POST['newAdminInputEmail']);
    $reguser_dob = mysql_fix_string($dbconn,$_POST['newAdminInputDOB']);
    $reguser_idnum = mysql_fix_string($dbconn,$_POST['newAdminInputIDNum']);
    $reguser_res_address = mysql_fix_string($dbconn,$_POST['newAdminInputResAddress']);
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

    $insertquery = "INSERT INTO Employees VALUES(NULL, '$reguser_init_username', '$reguser_fname', '$reguser_lname', '$reguser_contact', '$reguser_email', '$reguser_dob', '$reguser_idnum', '$reguser_res_address', '$reguser_type', '$reguser_pwd_hash', '$reguser_regdate')";
    $result = $dbconn->query($insertquery);

    if(!$result) die("Database Access Failed. Please contact the System Administrator.");

    echo "success";
?>