<?php

require "db_functions.php";

$error = false;
$success = false;
$name = $email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"]) && isset($_POST["dt_nasc"])) {

    $conn = connect_db();

    $name = mysqli_real_escape_string($conn,$_POST["name"]);
    $name = trim($name);
    $email = mysqli_real_escape_string($conn,$_POST["email"]);
    $password = mysqli_real_escape_string($conn,$_POST["password"]);
    $confirm_password = mysqli_real_escape_string($conn,$_POST["confirm_password"]);
    $dt_nasc = mysqli_real_escape_string($conn,$_POST["dt_nasc"]);

    if ($password == $confirm_password) {
      if(strlen($password) >= 8){
      $password = md5($password);

   $sql = "INSERT INTO $table_users
            (name, email, password,dtnasc) VALUES
            ('$name', '$email', '$password', '$dt_nasc');";

      if(mysqli_query($conn, $sql)){
        $success = true;
      }
      else {
        $error_msg = mysqli_error($conn);
        $error = true;
      }
    }
    else{
      $error_msg = "Senha precisa ter mais de 8 caracteres";
      $error = true;
      }
    }
    else {
      $error_msg = "Senha não confere com a confirmação.";
      $error = true;
    }
  }
  else {
    $error_msg = "Por favor, preencha todos os dados.";
    $error = true;
  }
}






 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Cadastro Blog</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
      <link rel="stylesheet" href="css/login.css">
  </head>
  <body>

    <?php if ($success): ?>
    <div class="alert alert-success sucesso" role="alert">
      <h4 class="alert-heading">Parabéns!!</h4>
      <p>Sua conta foi criada com sucesso.</p>
      <hr>
      <p class="mb-0">Clique <a href="index.php" class="alert-link">aqui </a>para voltar ao início.</p>
    </div>
<?php endif; ?>

<?php if ($error): ?>
  <h3 class="alert alert-danger"><?php echo $error_msg; ?></h3>
<?php endif; ?>

    <div class="container caixa_login border rounded">
      <h1>Cadastro</h1>
      <form action="cadastro.php" method="POST">
        <div class="form-group">
          <label for="Nome">Nome</label>
          <input type="text" class="form-control" name="name" required placeholder="Nome" value="<?php echo $name; ?>" >
        </div>
        <div class="form-group">
          <label for="Nome">Data de Nascimento</label>
          <input type="date" name="dt_nasc" value="" required class="form-control">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Endereço de Email</label>
          <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required placeholder="Email">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Senha</label>
          <input type="password" class="form-control" name="password"  value="" required placeholder="Senha">
          <small>Sua senha deve conter pelo menos 8 caracteres</small>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Confirmar Senha</label>
          <input type="password" class="form-control" name="confirm_password" value="" required placeholder="Confirmar Senha">
          <small>Sua confirmação deve ser igual a senha original</small>
        </div>
        <input type="submit" class="btn btn-primary" value="Cadastrar">
        </form>
    </div>

  </body>
</html>
