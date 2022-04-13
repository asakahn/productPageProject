<?php

  session_start();

  include("connect.php"); // Create database and table if haven't

  // Connect to database
  $conn = mysqli_connect($servername, $username, $password, $dbName);
  if(!$conn) { // If connection to database failed, then stop PHP
    die("Connection failed" . mysqli_connect_error());
  }

  include("cart_session.php");

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
      <div class="product-list-container">
        <h2>SWEATSHIRTS</h2>
        <br>

          <?php
            $sql_select_sweatshirts = "SELECT * FROM clothes WHERE category='sweatshirt'";
            $sweatshirtsResult = mysqli_query($conn, $sql_select_sweatshirts);
            while($row = mysqli_fetch_assoc($sweatshirtsResult)){

              $tempTitle = $row['title'];
              $tempDescription = $row['description'];
              $tempPriceFloat = $row['price'];
              $tempImgURL = $row['photo_location'];
              $tempUniqueID = $row['unique_id'];

              echo <<<CONTENT
                <div class="product-list-item">
                  <div class="product-list-container-img">
                    <img class="product-list-item-img" src="{$tempImgURL}" />
                  </div>
                  <div class="product-list-container-info">
                    <p class="product-list-item-title">{$tempTitle}</p>
                    <p class="product-list-item-desc">
                      {$tempDescription}
                    </p>
                    <div class="add-to-cart">
                      <p class="add-to-cart-price">\${$tempPriceFloat}</p>
                      <form method="post" action="index.php">
                        <button class="btn btn-blue" type="submit" name="{$tempUniqueID}">Add to Cart</button>
                      </form>
                    </div>
                  </div>
                </div>
                <br>
CONTENT;
            }

          ?>

      </div>

      <script src="js/main.js"></script>
    </body>
</html>
<?php
  mysqli_close($conn); // Close Connection
?>
