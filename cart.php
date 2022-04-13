<?php

  session_start();

  include("connect.php"); // Create database and table if haven't

  // Connect to database
  $conn = mysqli_connect($servername, $username, $password, $dbName);
  if(!$conn) { // If connection to database failed, then stop PHP
    die("Connection failed" . mysqli_connect_error());
  }

  if(isset($_POST["remove_all_items"])){
    session_unset();
    session_destroy();
    header("location: cart.php");
  }

  include("cart_session.php");

  if(isset($_POST["checkout_btn"])){
    header("Location: checkout.php");
    $_SESSION["checkout_page"] = true;
  }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Drip Clothing</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
      <nav class="navbar">
        <div class="container">
          <a style="text-decoration: none;"href="#"><p class="navbar-title">DRIP</p></a>
          <a style="margin-left: 50px" class="navbar-link" href="/productPageProject">Sweatshirts</a>
          <a class="navbar-link" href="/productPageProject/hoodies.php">Hoodies</a>
          <a class="navbar-cart" href="/productPageProject/cart.php">
            <img class="cart-img" src="img/shopping-cart.png" width="20px" />
            Cart (<?php echo $_SESSION["cartItemsTotal"]; ?>)
          </a>
        </div>
      </nav>
      <br>
        <div class="cart-container">
          <h2>CART</h2>
          <br>
          <?php
            if(empty($_SESSION["cartArray"])){
              echo "<p>Your cart is empty.</p>";
            } else {
              // PRINT EMPTY SPACE (HEADERS: QUANTITY AND PRICE)
              echo <<<CONTENT
              <div class="table-products-in-cart">
                <div class="table-products-image">

                </div>
                <div class="table-products-title">

                </div>
                <div class="table-products-quantity">
                  Quantity
                </div>
                <div class="table-products-price">
                  Price
                </div>
                <div class="table-products-action">

                </div>
              </div>
              <br><hr><br>
CONTENT;

              foreach($_SESSION["cartArray"] as $value){
                //echo $value[0] . "<br>"; // unique id
                //echo $value[1] . "<br>"; // quantity

                $sql_select_items_for_cart = "SELECT * FROM clothes where unique_id='$value[0]'";
                $selectItemCartResult = mysqli_query($conn, $sql_select_items_for_cart);
                $selectItemCartRow = mysqli_fetch_assoc($selectItemCartResult);

                $tempTitle = $selectItemCartRow['title'];
                $tempPriceFloat = $selectItemCartRow['price'];
                $tempImgURL = $selectItemCartRow['photo_location'];
                $tempUniqueID = $selectItemCartRow['unique_id'];
                $tempPriceMultipliedQuantity = $value[1]*$tempPriceFloat;

                echo <<<CONTENT2
                <div class="table-products-in-cart">
                  <div class="table-products-image">
                    <img class="in-cart-img" src="{$tempImgURL}" />
                  </div>
                  <div class="table-products-title">
                    {$tempTitle}
                  </div>
                  <div class="table-products-quantity">
                    <form method="post" action="cart.php">
                      <input class="quantity-input" type="number" name="item_quantity_{$tempUniqueID}" value="{$value[1]}"/><br><br>
                      <button class="btn btn-blue" type="submit" name="update_{$tempUniqueID}">Update</button>
                    </form>
                  </div>
                  <div class="table-products-price">
                    \${$tempPriceMultipliedQuantity}
                  </div>
                  <div class="table-products-action">
                    <form method="post" action="cart.php">
                      <button class="btn btn-red" type="submit" name="remove_{$tempUniqueID}">Remove</button>
                    </form>
                  </div>
                </div>
                <br><hr><br>
CONTENT2;

              }
              // PRINT SPACE BELOW ITEMS (TOTAL: PRICE, CHECKOUT BUTTON)
              echo <<<CONTENT3
              <div class="table-products-in-cart">
                <div class="table-products-image">
                <form method="post" action="cart.php">
                  <button class="btn btn-red" type="submit" name="remove_all_items">Remove All Items</button>
                </form>
                </div>
                <div class="table-products-title">

                </div>
                <div class="table-products-quantity">
                  <b>TOTAL:</b>
                </div>
                <div class="table-products-price">
                  \${$_SESSION["cartItemsTotalPrice"]}
                </div>
                <div class="table-products-action">
                  <form method="post" action="cart.php">
                    <button class="btn btn-blue" type="submit" name="checkout_btn">Checkout</button>
                  </form>
                </div>
              </div>
CONTENT3;

              //$sql_select_items_for_cart = "SELECT * FROM clothes where unique_id="

            }
           ?>

      <script src="js/main.js"></script>
    </body>
</html>
<?php
  mysqli_close($conn); // Close Connection
?>
