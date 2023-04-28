<?php
session_start();

// Leer el archivo JSON y convertir su contenido a un arreglo asociativo
$usuarios = json_decode(file_get_contents('usuarios.json'), true);

// Obtener los datos del formulario de login
$username = $_POST['username'];
$password = $_POST['password'];

// Verificar si el usuario y contraseña ingresados corresponden a alguna entrada en el arreglo asociativo
if (isset($usuarios[$username]) && $usuarios[$username] == $password) {
  // Iniciar la sesión y redirigir al usuario a la página principal
  $_SESSION['username'] = $username;
  header('Location: ../main.php');
} else {
  // Mostrar un mensaje de error
  echo 'Username or password incorrect';
}
?>
