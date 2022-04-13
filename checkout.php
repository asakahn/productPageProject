<?php

  session_start();

  include("connect.php"); // Create database and table if haven't

  // Connect to database
  $conn = mysqli_connect($servername, $username, $password, $dbName);
  if(!$conn) { // If connection to database failed, then stop PHP
    die("Connection failed" . mysqli_connect_error());
  }

  if(!isset($_SESSION["checkout_page"]) && $_SESSION["checkout_page"] != true){
    header("Location: index.php");
  }
  session_unset();
  session_destroy();

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
            Cart (0)
          </a>
        </div>
      </nav>
      <br>
        <div class="cart-container">
          <h2>YOUR ORDER</h2>
          <br>
          <h3><b>Thank you for your order</b></h3><br>
          <p>Your order will be processed within 3-5 business days.</p><br>
          <p>We will send you tracking information via Email in a couple days.</p>


      <script src="js/main.js"></script>
    </body>
</html>
<?php
  mysqli_close($conn); // Close Connection
?>
