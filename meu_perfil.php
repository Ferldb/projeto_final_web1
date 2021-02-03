<?php

require "db_functions.php";
require "force_authenticate.php";
$error = false;
$success = false;
$name = $email = $senha = $id = $dt_nasc = "";
$conn = connect_db();

if($_SERVER["REQUEST_METHOD"] == "GET"){
  if(isset($_GET["id"])){
    $id = $_GET["id"];

    $sql = "SELECT id,name,email,password,dtnasc FROM $table_users
            WHERE id =" . $id;

    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);


  }
}




 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Blog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/perfil.css">
  </head>
  <body >

<nav class="navbar navbar-expand-lg navbar-light bg-dark fixed-top">
  <a class="navbar-brand escolhas" href="index.php">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
  </div>
  </div>
</nav>

<div class="perfil">
  <form action="cadastro.php" method="POST">
    <div class="form-group">
      <label for="Nome">Nome</label>
      <input disabled type="text" class="form-control" name="name" value="<?= $user["name"] ?>" >
    </div>
    <div class="form-group">
      <label for="Nome">Data de Nascimento</label>
      <input  disabled datetime="DD-MM-YYYY" type="date" name="dt_nasc" value="<?= $user["dtnasc"] ?>" required class="form-control">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Endereço de Email</label>
      <input disabled type="email" class="form-control" name="email" value="<?= $user["email"] ?>" required placeholder="Email">
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Senha</label>
      <input  disabled type="password" class="form-control" name="password"  value="<?= $user["password"] ?>" required placeholder="Senha">
    </div>

    </form>
</div>

  </body>
</html>
