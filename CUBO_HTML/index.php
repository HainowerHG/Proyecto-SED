<!DOCTYPE html>
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
                  <div class="logo">
                    <img src="img/logo.png" alt="marca" style="width: 100%;">
                  </div>
                    <div class="texto">
                      <h3>¡Bienvenido a CUBO!</h3>
                      <p>Ingresa a tu cuenta y registra los personas que hace parte de su nucleo amiliar</p>
                    </div>
                    <div class="formulario container-fluid">
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Iniciar Sesión</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Registrate</button>
                        </li>
                      </ul>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                          
                            <form>
                              <div class="mb-3">
                                <input type="email" class="form-control blue-input"  aria-describedby="emailHelp" placeholder="Correo Electronico">
                              </div>
                              <div class="mb-3">
                                
                                <input type="password" class="form-control blue-input" id="exampleInputPassword1" placeholder="Contraseña">
                              </div>
                              <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Mantener sesión iniciada</label>
                              </div>
                              <button type="submit" class="btn btn-primary">Ingresar</button>
                            </form>
                          
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                          <form>
                            <div class="mb-3">
                              <input type="text" class="form-control blue-input"  aria-describedby="emailHelp" placeholder="Nombre completo" required>
                            </div>
                            <div class="mb-3">
                              <input type="email" class="form-control blue-input"  aria-describedby="emailHelp" placeholder="Correo Electronico" required>
                            </div>
                            
                            <div class="input-group mb-3">
                              
                              <input type="password" class="form-control blue-input" placeholder="contraseña" name="password" id="password" aria-label="Username" aria-describedby="basic-addon1">
                              <button  class="showpasswd" type="button" onclick="mostrarContrasena()"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"><img src="img/eye-off.svg" alt=""></span></button>
                            
                            </div>
                            <button type="submit" class="btn btn-primary" >Ingresar</button>
                          </form>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
            </div>
        
    </div>
  </body>
  <script src="js/jquery-3.6.4.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script>
    function mostrarContrasena(){
        var tipo = document.getElementById("password");
        if(tipo.type == "password"){
            tipo.type = "text";
        }else{
            tipo.type = "password";
        }
    }
  </script>
</html>