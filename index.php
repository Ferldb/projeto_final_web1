<?php
  require "authenticate.php";
  require "db_functions.php";


  $conn = connect_db();
  $editar = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["textbox"])){

    $texto = mysqli_real_escape_string($conn,$_POST["textbox"]);

    $sql = "  INSERT INTO post
             (idpost,texto,iduser) VALUES
             (NULL, '$texto','$user_id');";

   if ($texto == '') {
     echo '<script>
     alert("A Postagem não pode estar vazia!!!");
     </script>';
  }
  else{
   if(mysqli_query($conn, $sql)){
       $success = true;
     }
     else {
        $error_msg = mysqli_error($conn);
         $error = true;
     }
   }
  }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST["apagar"])){
    $sql = "";

    $id = ($_POST["id"]);
    $id = mysqli_real_escape_string($conn,$id);

    if($_POST["apagar"] == "Apagar"){
            $sql = "DELETE FROM post
                    WHERE idpost=" . $id;
        }
        if(!mysqli_query($conn,$sql)){
          die("Problemas para inserir nova tarefa no BD<br>" . mysqli_error($conn));
        }
  }

  if(isset($_POST["editar"])){
    $sql = "";

    $id = ($_POST["id"]);
    $id = mysqli_real_escape_string($conn,$id);

    if($_POST["editar"] == "Editar"){
            $editar = true;
        }
  }

  if (isset($_POST["textboxedit"])){

    $id = ($_POST["id"]);
    $id = mysqli_real_escape_string($conn,$id);
    $textoedit = mysqli_real_escape_string($conn,$_POST["textboxedit"]);

    $sql = "  UPDATE POST
              SET texto = '$textoedit'
              WHERE  idpost=" .$id;

   if(mysqli_query($conn, $sql)){
       $success = true;
     }
     else {
        $error_msg = mysqli_error($conn);
         $error = true;
     }
  }
}

$sql = " SELECT usuarios.name,post.iduser,post.texto,post.idpost FROM USUARIOS,POST
         WHERE usuarios.id = post.iduser";

if (!($postagens = mysqli_query($conn,$sql))) {
  die("Problemas para inserir no BD<br>".
    mysqli_error($conn));
}
if (!($topics2 = mysqli_query($conn,$sql))) {
  die("Problemas para inserir no BD<br>".
    mysqli_error($conn));
}

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Blog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Calistoga&display=swap" rel="stylesheet">
  </head>
  <body>
<nav class="navbar navbar-expand-lg navbar-light bg-dark fixed-top ">
  <a class="navbar-brand escolhas" href="index.php">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>

  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
      <?php if (!($login)): ?>
  <div class="btn-group mr-2" role="group" aria-label="First group">
    <button type="submit" class="btn btn-info" onclick="window.location.href = 'login.php';">Login</button>
    <button type="button" class="btn btn-secondary" onclick="window.location.href = 'cadastro.php';">Cadastro</button>
  </div>
<?php else :?>
  <button type="submit" class="btn btn-info" onclick="window.location.href = 'logout.php';">Logout</button>
    <?php endif; ?>
  </div>
  </div>
  <?php if ($login): ?>
    <form class="form-inline my-2 my-lg-0">
      <button type="button" class="btn btn-primary" onclick="window.location.href = '<?= 'meu_perfil.php' . "?id=" . $user_id?>'">Meu Perfil</button>
    </form>
    <?php endif; ?>
  </div>
</nav>
</nav>
<div class="container principal ">
<div class="row">
  <div class="col-lg-3 lateralbar fixed-top bg-dark">
  <ul class="nav flex-column">
    <?php if (mysqli_num_rows($topics2) == 0): ?>
      <li class="nav-item">
        <a class="nav-link  lnav  " href="#Posts">Sem Posts :( </a>
      </li>
    <?php else: ?>
  <?php while($topics = mysqli_fetch_assoc($topics2)): ?>
    <li class="nav-item">
      <a class="nav-link  lnav  " href="#Post<?= $topics["idpost"] ?>" >Post <?= $topics["idpost"]  ?></a>
    </li>
        <?php endwhile; ?>
        <?php endif; ?>
  </ul>
  </div>
  <?php if ($editar):?>

    <div class="col-lg-9 main">
        <div class="postagens">
          <form action="index.php" method="post">
          <h3 class="post">Edite Sua Postagem:</h3>
          <form class="" action="index.html" method="post">

          <textarea rows="8" cols="100" id="textbox" class="post"style="resize:none" <?php if (!($login)) { echo 'disabled';} ?> name="textboxedit"></textarea>
          <input type="sumbit" name="id" value="<?= $id ?>" hidden>
          <input type="submit" class="btn btn-warning botao" value="Terminar">

          </form>
        </div>
      </body>
  </html>
<?php exit(); ?>
  <?php endif ?>
<div class="col-lg-9 main">
    <div class="postagens">
      <form action="index.php" method="post">
      <h3 class="post">Faça Sua Postagem:</h3>
      <?php if (!($login)): ?>
      <p>Realize seu LOGIN para inserir uma nova postagem</p>
      <?php endif ?>
      <textarea rows="8" cols="100" id="textbox" class="post"style="resize:none" <?php if (!($login)) { echo 'disabled';} ?> name="textbox"></textarea>
      <input <?php if (!($login)) { echo 'disabled';} ?> type="submit" class="btn btn-warning botao" value="Postar">
      </form>
    </div>
        <h2 id="Posts">Posts</h2>
        <?php if(mysqli_num_rows($postagens) == 0): ?>
              <p>Ainda não há Posts :(( </p>
          <?php else: ?>
      <?php while($texto = mysqli_fetch_assoc($postagens)): ?>
        <span>
          <div class="textbox">
            <h3 id="Post<?= $texto["idpost"] ?>"><?= $texto["name"]; ?></h3>
            <h6> Post<?= $texto["idpost"]; ?></h3>
            <p>
            <?= $texto["texto"]; ?>
            </p>
            <?php if ($login): ?>
            <form class="" action="index.php" method="post">
              <input type="text" name="id" value="<?=$texto["idpost"]?>" hidden>
              <input type="submit" name="apagar" value="Apagar" class="btn btn-danger" <?php if ($texto["iduser"] != $user_id) { echo "disabled"; } ?> >

              <input type="submit" name="editar" value="Editar" class="btn btn-success" <?php if ($texto["iduser"] != $user_id) { echo "disabled"; } ?> >

            </form>
              <?php endif ?>
          </div>
        </span>

      <?php endwhile; ?>
      <?php endif ?>
    </div>
  </div>
</div>


</div>
</div>

  </body>
</html>
