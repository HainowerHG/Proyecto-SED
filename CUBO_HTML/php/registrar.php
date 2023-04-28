<?php
// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['username'];
$password = $_POST['password'];
$file = $_FILES['file'];


// Leer el contenido actual del archivo JSON de usuarios
$usuarios = json_decode(file_get_contents('../usuaios.json'), true);
// Agregar el nuevo usuario al array de usuarios
if(isset($file) && $file['error'] == 0){
  $nombre_archivo = $nombre . "_" . $file['name'];
  $ruta_archivo = "../img/imagenes/" . $nombre_archivo;
  $ruta_original="/home/pi/imagenes/".$nombre_archivo;
  if(move_uploaded_file($_FILES['file']['tmp_name'], $ruta_archivo)){
    $nuevo_usuario = array(
        'nombre' => $nombre,
        'username' => $email,
        'password' => $password,
        'file' => $ruta_original
      );

      $usuarios[] = $nuevo_usuario;
      // Guardar el array modificado en el archivo JSON
      file_put_contents('../usuaios.json', json_encode($usuarios));
      session_start();
      $_SESSION['usuario'] = $nuevo_usuario;
      header('Location: ../main.php');
  }
  else
  {
    echo "no se pudo agregar el archivo ". $nombre_archivo;
  }
}
else
{
  echo '<h3 style="color: red;">ERROR AL CARGAR LA IMAGEN </h3>';
}

?>
  