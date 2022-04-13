<?php

// Get all UNIQUE ID's and add them to our array
$sql_select_uniqueid = "SELECT unique_id FROM clothes";
$uniqueIDResult = mysqli_query($conn, $sql_select_uniqueid);

$uniqueID_Array = array ();

while($row = mysqli_fetch_assoc($uniqueIDResult)){
  array_push($uniqueID_Array, $row['unique_id']);
}

// Create SESSION cartArray if it's not initliazed yet
if(!isset($_SESSION["cartArray"])){
  $_SESSION["cartArray"] = array ();
  $_SESSION["cartItemsTotal"] = 0;
}

// Add new item to cartArray / Increase quantity when that item that already exists
foreach($uniqueID_Array as $value){
  //echo $value . "<br>";
  if(isset($_POST[$value])){

    // If value already exists in cartArray then just increment Quantity
    for($i = 0; $i < count($_SESSION["cartArray"]); $i++){
      if($_SESSION["cartArray"][$i][0] == $value){
        $_SESSION["cartArray"][$i][1] += 1;
        unset($_POST[$value]);
        header("Location: " . $_SERVER["PHP_SELF"]);
        break 2;
      }
    }

    // Otherwise, push the item into cart
    array_push($_SESSION["cartArray"], array($value, 1));
    unset($_POST[$value]);
    header("Location: " . $_SERVER["PHP_SELF"]);
  }
}

// Remove an item from cartArray
foreach($uniqueID_Array as $value){
  if(isset($_POST["remove_" . $value])){

    for($i = 0; $i < count($_SESSION["cartArray"]); $i++){
      if($_SESSION["cartArray"][$i][0] == $value){
        unset($_SESSION["cartArray"][$i]); // Remove unique id from array
        $_SESSION["cartArray"] = array_values($_SESSION["cartArray"]); // Re-index the array
        header("Location: " . $_SERVER["PHP_SELF"]);
        break 2;
      }
    }
  }
}

// Update quantity of cartArray items
foreach($uniqueID_Array as $value){

  if(isset($_POST["update_" . $value])){ // If any of the update_quantity_btn is clicked

    for($i = 0; $i < count($_SESSION["cartArray"]); $i++){ // Scan through cartArray

      if($_SESSION["cartArray"][$i][0] == $value){ // If found match

        if($_POST["item_quantity_" . $value] <= 0){ // If quantity entered is 0, then remove it from cartArray
          unset($_SESSION["cartArray"][$i]); // Remove unique id from array
          $_SESSION["cartArray"] = array_values($_SESSION["cartArray"]); // Re-index the array
          header("Location: " . $_SERVER["PHP_SELF"]);
          break 2;

        } else {  // Else change to quantity entered
          $_SESSION["cartArray"][$i][1] = $_POST["item_quantity_" . $value];
          header("Location: " . $_SERVER["PHP_SELF"]);
          break 2;
        }
      }

    }

  }
}

// Get cart total
$_SESSION["cartItemsTotal"] = count($_SESSION["cartArray"]);

// Get total item price
$_SESSION["cartItemsTotalPrice"] = 0;
foreach($_SESSION["cartArray"] as $value){
  $sql_select_items_price = "SELECT price FROM clothes where unique_id='$value[0]'";
  $selectItemCartPriceResult = mysqli_query($conn, $sql_select_items_price);
  $selectItemCartRow = mysqli_fetch_assoc($selectItemCartPriceResult);

  $tempPrice = $selectItemCartRow["price"] * $value[1];
  $_SESSION["cartItemsTotalPrice"] += $tempPrice;
}


//echo print_r($_SESSION["cartArray"]) . "<br>";

?>
