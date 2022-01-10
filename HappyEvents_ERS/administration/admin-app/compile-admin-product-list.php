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
      $query = "SELECT * FROM Products";

      $result = $dbconn->query($query);

      if(!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator.");

      $rows = $result->num_rows;
      //echo $rows."<br>";
      $comp_prod_list = "";
      $hidden = "";

      if($rows<=0) {
          //there is no result so notify user that the account cannot be found
          echo '<tr><td colspan="17"><h1 class="fw-bold text-center my-4">Uh-oh... No products to display! &#128517;</h1></td></tr>';
      } else {
        for ($j = 0; $j < $rows ; ++$j) {
          $row = $result->fetch_array(MYSQLI_ASSOC);

          $product_id = htmlspecialchars($row['Product_id']);
          $product_name = htmlspecialchars($row['product_name']);
          //echo $product_name;
          $product_description = htmlspecialchars($row['product_description']);
          $product_type = htmlspecialchars($row['product_type']);
          $product_category = htmlspecialchars($row['product_category']);
          $product_available = htmlspecialchars($row['product_availability']);
          $product_sellprice = htmlspecialchars($row['product_sell_price']);
          $product_rentprice = htmlspecialchars($row['product_base_rent_price']);
          $product_itemcode = htmlspecialchars($row['product_item_code']);
          $product_size = htmlspecialchars($row['product_size']);
          $product_colour = htmlspecialchars($row['product_colour']);
          $product_binnumber = htmlspecialchars($row['product_bin_number']);
          $img_preview_url = htmlspecialchars($row['img_preview_url']);
          $product_creation_date = htmlspecialchars($row['product_creation_date']);
          $product_created_by = htmlspecialchars($row['product_created_by']);

          if($product_available == true){
            $available = "Yes";
          } else {
            $available = "No";
          }

          $comp_prod_list .= '<tr>
              <td class="text-center table-info">
                <button class="btn btn-info p-3 rounded-pill mb-2 shadow" onclick="showModal('."'$product_id'".','."'products'".')" style="font-size: 30px"><i class="fas fa-edit"></i></button>
                <span style="font-size: 10px">Edit</span>
              </td>
              <td class="text-center table-danger">
                <button class="btn btn-danger p-3 rounded-pill mb-2 shadow" onclick="deleteProductRecord('."'$product_id'".')" style="font-size: 30px"><i class="fas fa-trash-alt"></i></button>
                <span style="font-size: 10px">Delete</span>
              </td>

              <td scope="row" class="fw-bold">'.$product_id.'</td>
              <td><img src="../../media/general/product_imgs/'.$img_preview_url.'" alt="" class="img-fluid" style="border-radius: 25px" /></td>
              <td>'.$product_name.'</td>
              <td>'.$product_description.'</td>
              <td>'.$product_type.'</td>
              <td>'.$product_category.'</td>
              <td>'.$available.'</td>
              <td>R'.$product_sellprice.'</td>
              <td>R'.$product_rentprice.'</td>
              <td>'.$product_itemcode.'</td>
              <td>'.$product_size.'</td>
              <td>'.$product_colour.'</td>
              <td>'.$product_binnumber.'</td>
              <td>'.$product_creation_date.'</td>
              <td>'.$product_created_by.'</td>
            </tr>';
        }

        $result->close();
        $dbconn->close();
        
        //navigate user to the Equipment Catalogue
      }

      echo $comp_prod_list;
    } catch (\Throwable $err) {
      //throw $err;
      echo "An Error has Occured: [ ".$err." ]";
    }
  }
}
?>