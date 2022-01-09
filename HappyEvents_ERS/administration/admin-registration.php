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