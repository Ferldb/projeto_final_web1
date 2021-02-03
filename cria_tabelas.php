<?php
require 'credentials.php';

// Create connection
$conn = mysqli_connect($servername, $username, $db_password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE $dbname";
if (mysqli_query($conn, $sql)) {
    echo "<br>Database created successfully<br>";
} else {
    echo "<br>Error creating database: " . mysqli_error($conn);
}

// Choose database
$sql = "USE $dbname";
if (mysqli_query($conn, $sql)) {
    echo "<br>Database changed successfully<br>";
} else {
    echo "<br>Error changing database: " . mysqli_error($conn);
}

// sql to create table
$sql = "CREATE TABLE $table_users (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(128) NOT NULL,
  dtnasc DATE NOT NULL,
  UNIQUE (email)
)";

if (mysqli_query($conn, $sql)) {
    echo "<br>Table created successfully<br>";
} else {
    echo "<br>Error creating database: " . mysqli_error($conn);
}

// sql to create table
$sql = "CREATE TABLE Post (
  idpost INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  texto VARCHAR(4000) NOT NULL,
  iduser INT(6) NOT NULL,
  CONSTRAINT FKUSER FOREIGN KEY (iduser)
  REFERENCES Usuarios(id)
)";

if (mysqli_query($conn, $sql)) {
    echo "<br>Table created successfully<br>";
} else {
    echo "<br>Error creating database: " . mysqli_error($conn);
}
mysqli_close($conn)
?>
