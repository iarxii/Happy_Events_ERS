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
    $username = mysql_fix_string($dbconn,$_POST['signInInputUsername']);
    $password = mysql_fix_string($dbconn,$_POST['signInInputPassword']);

    function mysql_fix_string($dbconn, $string) {
        if(get_magic_quotes_gpc()) $string = stripslashes($string);
        return $dbconn->real_escape_string($string);
    }

    $query = "SELECT * FROM Clients WHERE username = '$username' AND password_hash = '$password'";
    $result = $dbconn->query($query);
    if(!$result) die("A Fatal Error has occured. Please try again and if the problem persists, please contact the system administrator.");

    $rows = $result->num_rows;

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
            echo $user_reg_date."<br><br>";*/
        }

        $result->close();
        $dbconn->close();

        //navigate user to the Equipment Catalogue
    }

    
?>