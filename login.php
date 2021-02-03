<?php
require "credentials.php";
require "authenticate.php";
$error = false;
$password = $email = "";

// Create connection
$conn = mysqli_connect($servername, $username, $db_password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["email"]) && isset($_POST["senha"])){

    $conn = mysqli_connect($servername, $username, $db_password, $dbname);


    $email = mysqli_real_escape_string($conn,$_POST["email"]);
    $password = mysqli_real_escape_string($conn,$_POST["senha"]);
    $password = md5($password);

    $sql = "SELECT id,name,email,password FROM $table_users
            WHERE email = '$email';";

    $result = mysqli_query($conn, $sql);
    if($result){
      if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if ($user["password"] == $password) {

          $_SESSION["user_id"] = $user["id"];
          $_SESSION["user_name"] = $user["name"];
          $_SESSION["user_email"] = $user["email"];

          header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/index.php");
          exit();
        }
        else {
          $error_msg = "Senha incorreta!";
          $error = true;
        }
      }
      else{
        $error_msg = "Usuário não encontrado!";
        $error = true;
      }
    }
    else {
      $error_msg = mysqli_error($conn);
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
    <title> Login Blog</title>
    <link rel="stylesheet" href="css\login.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  </head>
  <body>


<?php if ($error): ?>
  <h4 class="alert alert-danger"><?php echo $error_msg; ?></h4>
<?php endif; ?>

<div class="container caixa_login border rounded">
  <h1>Login</h1>

   <?php if ($login): ?>
    <h3>Você já está logado!</h3>
    </body>
    </html>
     <?php exit(); ?>
   <?php endif; ?>

  <form action="login.php" method="post">
    <div class="form-group">
      <label for="exampleInputEmail1">Endereço de Email</label>
      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email  " name="email">
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Senha</label>
      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Senha" name="senha">
    </div>
    <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
  </form>

</div>
  </body>
</html>
