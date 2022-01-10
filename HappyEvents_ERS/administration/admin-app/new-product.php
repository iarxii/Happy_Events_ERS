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
  $valPrevImg = mysql_fix_string($dbconn, "default.png");
  $valProdName = mysql_fix_string($dbconn, $_POST['newProdInputProdName']);
  $valProdDescr = mysql_fix_string($dbconn, $_POST['newProdInputProdDescr']);
  $valProdType = mysql_fix_string($dbconn, $_POST['newProdInputProdType']);
  $valCategory = mysql_fix_string($dbconn, $_POST['newProdInputCategory']);
  $avail = mysql_fix_string($dbconn, $_POST['newProdInputProdAvailability']);
  if( $avail == "on"){
      $valProdAvailability = 1;
  }else{
      $valProdAvailability = 0;
  };
  $valSellPrice = mysql_fix_string($dbconn, number_format($_POST['newProdInputSellPrice'],2));
  $valRentPrice = mysql_fix_string($dbconn, number_format($_POST['newProdInputRentPrice'],2));
  $valItemCode = mysql_fix_string($dbconn, $_POST['newProdInputItemCode']);
  $valProdSize = mysql_fix_string($dbconn, $_POST['newProdInputSize']);
  $valColor = mysql_fix_string($dbconn, $_POST['newProdInputColor']);
  $valBinNum = mysql_fix_string($dbconn, $_POST['newProdInputBinNum']);
  $valCreatedBy = mysql_fix_string($dbconn, 1);
  $created_date = date("Y-m-d H:i:s");
  $valCreatedDate = mysql_fix_string($dbconn, $created_date); //date now here

  echo "Img Prev: ".$valPrevImg."<br>";
  echo "Prod Name: ".$valProdName."<br>";
  echo "Prod Descr: ".$valProdDescr."<br>";
  echo "Prod Type: ".$valProdType."<br>";
  echo "Category: ".$valCategory."<br>";
  echo "Avail: ".$valProdAvailability."<br>";
  echo "Sell: ".$valSellPrice."<br>";
  echo "Rent: ".$valRentPrice."<br>";
  echo "Item Code: ".$valItemCode."<br>";
  echo "Prod Sz: ".$valProdSize."<br>";
  echo "Color: ".$valColor."<br>";
  echo "Bin: ".$valBinNum."<br>";
  echo "Created by: ".$valCreatedBy."<br>";
  echo "Create Date: ".$created_date."<br>";

  function mysql_fix_string($dbconn, $string) {
      if(get_magic_quotes_gpc()) $string = stripslashes($string);
      return $dbconn->real_escape_string($string);
  }

  try {
    $insertquery = "INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_type`, `product_category`, `product_availability`, `product_creation_date`, `product_created_by`, `product_sell_price`, `product_base_rent_price`, `product_item_code`, `product_size`, `product_colour`, `product_bin_number`, `img_preview_url`) VALUES (null,'$valProdName','$valProdDescr','$valProdType','$valCategory',$valProdAvailability,'$valCreatedDate',$valCreatedBy,$valSellPrice,$valRentPrice,'$valItemCode','$valProdSize','$valColor','$valBinNum','$valPrevImg')";

    $result = $dbconn->query($insertquery);

    if(!$result) die("Database Access Failed. Please contact the System Administrator. Error: [ ".$dbconn -> error." ]");

    header("Location: admin.html?return=new_prod_success");
  } catch (\Throwable $err) {
    //throw $err;
    echo "Error( $err )";
  }
  
?>