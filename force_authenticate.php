<?php

  require "authenticate.php";

  if(!$login){
    header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/index.php");
    exit();
  }

?>
