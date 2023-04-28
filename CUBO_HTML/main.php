<?php
<html lang="es">
<head>
  <title>index</title>
  <link rel="icon" type="image/x-icon" href="./assets/favicon.ico" />
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">

</head>

<body>
  <div class="container-fluid">
      
          <div class="row">
              
              <div class="col-md-4" style="position: relative;margin: auto;">
               <div class="caja">
               <?php 
                session_start(); // Iniciar la sesión

                if (isset($_SESSION['usuario'])) {
                    // Si la sesión está iniciada y la variable 'usuario' está definida
                    $usuario = $_SESSION['usuario'];
                    // Mostrar los datos del usuario
                    echo "<h1>Bienvenido, " . $usuario['nombre'] . "!</h1>";
                    echo "<p>Correo electrónico: " . $usuario['username'] . "</p>";
                    echo "<img src='" . $usuario['file'] . "' alt='Foto de perfil'>"; // Mostrar la imagen
                } else {
                    // Si la sesión no está iniciada o la variable 'usuario' no está definida
                    echo "<h1>Debes iniciar sesión para ver esta página</h1>";
                }
                ?>
                <button  class="showpasswd" type="button" onclick="php/python.py"></button>
                </div>
              </div>
              
          </div>
      
  </div>
</body>
<script src="js/jquery-3.6.4.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
?>