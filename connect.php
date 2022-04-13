<?php

  $servername = "localhost:3420";
  $username = "root";
  $password = "";
  $dbName = "dripClothing";

  // Create connection to Database
  $conn = mysqli_connect($servername, $username, $password);
  if(!$conn){ // If connection to database failed, then stop PHP
    die("Connection failed" . mysqli_connect_error());
  }

  // Create a database if it does not exists
  // If it does exist then skip this part.
  $sql_db = "CREATE DATABASE IF NOT EXISTS " . $dbName;
  if(mysqli_query($conn, $sql_db)){
    //echo "Database created sucessfully";
  } else {
    echo "Error creating a database: " . mysqli_error($conn);
  }

  // If the connection and the database creation is successful
  // Change our connection variable, set it to that database specifically.
  $conn = mysqli_connect($servername, $username, $password, $dbName);

  // Create a table if it does not exist
  // If it does exist then skip this part.
  $sql_tb = "CREATE TABLE IF NOT EXISTS clothes (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    description TEXT,
    price FLOAT,
    category VARCHAR(50),
    color VARCHAR(50),
    unique_id VARCHAR(50),
    photo_location VARCHAR(100))";

    if(mysqli_query($conn, $sql_tb)) {
      //echo "Table clothes created successfully";
    } else {
      echo "Error creating table: " . mysqli_error($conn);
    }

    // Create a table if it does not exist
    // If it does exist then skip this part.
    $sql_tb = "CREATE TABLE IF NOT EXISTS orders (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(100),
      price FLOAT,
      category VARCHAR(50),
      color VARCHAR(50),
      unique_id VARCHAR(50))";

      if(mysqli_query($conn, $sql_tb)) {
        //echo "Table clothes created successfully";
      } else {
        echo "Error creating table: " . mysqli_error($conn);
      }

    mysqli_close($conn);

?>
