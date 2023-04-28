<?php

$output = shell_exec('sudo sh ../img/imagenes/scrip.sh > /dev/null 2>&1 &');
session_start();
      header('Location: ../main.php');
?>