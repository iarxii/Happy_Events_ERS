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
    $post_product_id = mysql_fix_string($dbconn, $_POST['prod-id']);
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
    $valUpdateDate = mysql_fix_string($dbconn, $updated_date);

    if (isset($post_product_id)) {
      try {
        //Update Record
        $query = "UPDATE Products SET `product_name`='$valProdName',`product_description`='$valProdDescr',`product_type`='$valProdType',`product_category`='$valCategory',`product_availability`= $valProdAvailability,`product_sell_price`=$valSellPrice,`product_base_rent_price`=$valRentPrice,`product_item_code`='$valItemCode',`product_size`='$valProdSize',`product_colour`='$valColor',`product_bin_number`='$valBinNum',`img_preview_url`='$valPrevImg' WHERE `Product_id`=$post_product_id";

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
    //Get the product details of the id GET Param
    //Initialize Global Variable
    $product_id = mysql_fix_string($dbconn, $_GET['id']);

    try {
      //Get the product record of the id GET Param
      $query = "SELECT * FROM Products WHERE Product_id=$product_id";

      $result = $dbconn->query($query);

      if(!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator.");

      $rows = $result->num_rows;

      if($rows<=0) {
          //there is no result so notify user that the account cannot be found
          echo '<div class="alert alert-info">Ooops, this product cannot be found. Please search for another product or contact the System Administrator if this an error or the issue persists.</div>';
      } else {
        for ($j = 0; $j < $rows ; ++$j) {
          $row = $result->fetch_array(MYSQLI_ASSOC);

          $output_product_id = htmlspecialchars($row['Product_id']);
          $output_product_name = htmlspecialchars($row['product_name']);
          $output_product_description = htmlspecialchars($row['product_description']);
          $output_product_type = htmlspecialchars($row['product_type']);
          $output_product_category = htmlspecialchars($row['product_category']);
          $output_product_available = htmlspecialchars($row['product_availability']);
          $output_product_sellprice = htmlspecialchars($row['product_sell_price']);
          $output_product_rentprice = htmlspecialchars($row['product_base_rent_price']);
          $output_product_itemcode = htmlspecialchars($row['product_item_code']);
          $output_product_size = htmlspecialchars($row['product_size']);
          $output_product_colour = htmlspecialchars($row['product_colour']);
          $output_product_binnumber = htmlspecialchars($row['product_bin_number']);
          $output_img_preview_url = htmlspecialchars($row['img_preview_url']);
          $output_product_creation_date = htmlspecialchars($row['product_creation_date']);
          $output_product_created_by = htmlspecialchars($row['product_created_by']);

          if($output_product_available == true){
            $available = "checked";
          } else {
            $available = "unchecked";
          }
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
    <title>Edit Product Information | Happy Events Equipment Rentals</title>
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
      <!-- Update Product Form -->
      <div id="admin-update-product-info-form-container" style="background-color: #1c9941; color: #fff; border-radius: 25px" class="shadow p-4 my-4">
        <h1 class="mt-4 text-center">Update Product Entry Details</h1>
        <!--target="_blank"-->
        <form action="edit-product.php?id=<?php echo $product_id;?>" method="post"  id="admin-update-product-entry-form" class="basic-form-style p-4 shadow fs-3">
          <div id="emailHelp" class="form-text text-center p-4 mb-4 shadow sniglet-font -thick text-danger bg-light" style="border-radius: 25px">Please take note that this form is only for the capturing of <strong>Updated Product Details</strong>.</div>
          
          <div class="mb-3" hidden>
            <label for="prod-id" class="form-label">Product ID</label>
            <input type="number" class="form-control rounded-pill" id="prod-id" name="prod-id" required value="<?php echo $product_id;?>" />
          </div>
          <div class="mb-3">
            <label for="updatedProdInputPrevImg" class="form-label">Preview Image</label>
            <input type="text" class="form-control rounded-pill" id="updatedProdInputPrevImg" name="updatedProdInputPrevImg" required value="<?php echo $output_img_preview_url;?>" />
          </div>
          <div class="mb-3">
            <label for="updatedProdInputProdName" class="form-label">Product Name</label>
            <input type="text" class="form-control rounded-pill" id="updatedProdInputProdName" name="updatedProdInputProdName" required value="<?php echo $output_product_name;?>" />
          </div>
          <div class="mb-3">
            <label for="updatedProdInputProdDescr" class="form-label">Product Description</label>
            <textarea type="text" class="form-control rounded" id="updatedProdInputProdDescr" name="updatedProdInputProdDescr" rows="5" required value="<?php echo $output_product_description;?>"><?php echo $output_product_description;?></textarea>
          </div>
          <div class="mb-3">
            <label for="updatedProdInputProdType" class="form-label">Product Type</label>
            <input type="text" class="form-control rounded-pill" id="updatedProdInputProdType" name="updatedProdInputProdType" required value="<?php echo $output_product_type;?>" />
          </div>
          <div class="mb-3">
            <label for="updatedProdInputCategory" class="form-label">Category</label>
            <select class="form-select" aria-label="Product Category" aria-placeholder="Please select a Category" placeholder="Please select a Category" id="updatedProdInputCategory" name="updatedProdInputCategory" value="<?php echo $output_product_category;?>">
              <option selected>Please select your Category</option>
              <option value="test">Test</option>
              <option value="test1">Category1</option>
              <option value="test2">Category2</option>
            </select>
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="updatedProdInputProdAvailability" name="updatedProdInputProdAvailability" <?php echo $available;?> />
            <label class="form-check-label text-start" for="updatedProdInputProdAvailability" aria-checked="true" checked="checked" aria-required="true" required>Is the Product currently Available?</label>
          </div>
          <div class="mb-3">
            <label for="updatedProdInputSellPrice" class="form-label">Selling Price</label>
            <input type="number" class="form-control rounded-pill" id="updatedProdInputSellPrice" name="updatedProdInputSellPrice" required value="<?php echo $output_product_sellprice;?>" />
          </div>
          <div class="mb-3">
            <label for="updatedProdInputRentPrice" class="form-label">Rental Price</label>
            <input type="number" class="form-control rounded-pill" id="updatedProdInputRentPrice" name="updatedProdInputRentPrice" required value="<?php echo $output_product_rentprice;?>" />
          </div>
          <div class="mb-3">
            <label for="updatedProdInputItemCode" class="form-label">Item Code</label>
            <input type="text" class="form-control rounded-pill" id="updatedProdInputItemCode" name="updatedProdInputItemCode" value="<?php echo $output_product_itemcode;?>" />
          </div>
          <div class="mb-3">
            <label for="updatedProdInputSize" class="form-label">Size</label>
            <input type="text" class="form-control rounded-pill" id="updatedProdInputSize" name="updatedProdInputSize" value="<?php echo $output_product_size;?>" />
          </div>
          <div class="mb-3">
            <label for="updatedProdInputColor" class="form-label">Select a colour!</label>
            <input type="color" class="form-control form-control-color rounded-pill" id="updatedProdInputColor" name="updatedProdInputColor"  value="<?php echo $output_product_colour;?>" title="Select a Color" />
          </div>
          <div class="mb-3">
            <label for="updatedProdInputBinNum" class="form-label">Bin Number</label>
            <input type="text" class="form-control rounded-pill" id="updatedProdInputBinNum" name="updatedProdInputBinNum" value="<?php echo $output_product_binnumber;?>" />
          </div>

          <button type="submit" class="btn btn-outline-light btn-block rounded-pill sniglet-font">
            <span class="fs-1 m-4">Update Record <i class="fas fa-save"></i></span>
          </button>
        </form>
      </div>
      <!-- ./ Update Product  Form -->
    </div>

    <div class="w-100 text-center fw-bold fixed-bottom" style="background-color: #1c9941;color: #fff; font-size: 10px">
      <p class="py-4">Crafted by Thabang Mposula (8008999) &copy; 2021 | Systems Development 3 (HSYD300-1) SA1</p>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
