<?php
session_start();
include("../scripts/config.php");

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
          echo `<h1 class="fw-bold text-center my-4">Uh-oh... No products to display! &#128517;</h1>`;
      } else {
        for ($j = 0; $j < $rows ; ++$j) {
          $row = $result->fetch_array(MYSQLI_ASSOC);

          $product_id = htmlspecialchars($row['Product_id']);
          $product_name = htmlspecialchars($row['product_name']);
          //echo $product_name;
          $product_description = htmlspecialchars($row['product_description']);
          $product_type = htmlspecialchars($row['product_type']);
          $product_category = htmlspecialchars($row['product_category']);
          $product_available = htmlspecialchars($row['product_category']);
          $product_sellprice = htmlspecialchars($row['product_sell_price']);
          $product_rentprice = htmlspecialchars($row['product_base_rent_price']);
          $product_itemcode = htmlspecialchars($row['product_item_code']);
          $product_size = htmlspecialchars($row['product_size']);
          $product_colour = htmlspecialchars($row['product_colour']);
          $product_binnumber = htmlspecialchars($row['product_bin_number']);
          $img_preview_url = htmlspecialchars($row['img_preview_url']);

          if($product_available == true){
            $available = "Yes";
          } else {
            $available = "No";
            $hidden = "hidden";
          }

          $comp_prod_list .= '<div class="product-card" id="prod-card-'.$product_id.'" '.$hidden.'>
            <div class="card h-100 bg-transparent w-100 p-2">
              <img src="../media/general/product_imgs/'.$img_preview_url.'" class="card-img-top shadow" alt="image preview for '.$product_name.'" style="border-radius: 25px !important" />
              <div class="card-body">
                <div class="d-grid gap-2 text-center mb-4" style="border-radius: 25px;">
                  <button id="add-to-cart-btn-'.$product_id.'" type="button" onclick="addCartItem('."'".$product_id."','".$product_name."','".$product_sellprice."','".$product_rentprice."','".$product_itemcode."','".$product_binnumber."','".$img_preview_url."'".')" class="btn btn-warning btn-lg rounded-pill shadow fs-5 sniglet-font-thick text-success"> Add to Cart <i class="fas fa-cart-plus"></i></button>
                </div>
              
                <h3 class="card-title fs-3">'.$product_name.'</h3>
                <p class="fs-5">1 Day Hire Fee: R '.$product_rentprice.'</p>
                <p class="fs-5">Buy for: R '.$product_sellprice.'</p>
                <hr class="text-white">

                <p class="card-text fs-4">'.$product_description.'</p>
                <hr class="text-white">
                
                <div class="text-start">
                  <a class="btn btn-outline-warning btn-sm rounded-pill my-2" data-bs-toggle="collapse" href="#collape-prod-details-list-'.$product_id.'" role="button" aria-expanded="false" aria-controls="collape-prod-details-list-'.$product_id.'">
                    More details here!
                  </a>
                </div>

                <ul class="list-group list-group-flush my-2 bg-transparent collapse" id="collape-prod-details-list-'.$product_id.'">
                  <li class="list-group-item bg-transparent sniglet-font text-white">Type: '.$product_type.'</li>
                  <li class="list-group-item bg-transparent sniglet-font text-white">Category: '.$product_category.'</li>
                  <li class="list-group-item bg-transparent sniglet-font text-white">Available: '.$available.'</li>
                  <li class="list-group-item bg-transparent sniglet-font text-white">Colour: '.$product_colour.'</li>
                  <li class="list-group-item bg-transparent sniglet-font text-white">Size: '.$product_size.'</li>
                  <li class="list-group-item bg-transparent sniglet-font text-white">IC: '.$product_itemcode.'</li>
                  <li class="list-group-item bg-transparent sniglet-font text-white">BN: '.$product_binnumber.'</li>
                </ul>
              </div>
            </div>
          </div>';
        }

        $result->close();
        $dbconn->close();
      }

      echo $comp_prod_list;
    } catch (\Throwable $err) {
      //throw $err;
      echo "An Error has Occured: [ ".$err." ]";
    }
  }
}
?>