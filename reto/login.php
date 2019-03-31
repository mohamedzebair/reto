<?php
//trabajando con sesiones
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>LOGIN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="css/estilos.css"/>
    
</head>

<body>
<?php
    //incluyo barra de navegación (Menu)
    //*********El error es de este include , si lo comentas ya no salta el error, eso quiere decir que entra en confusion por alguna historia de las cabeceras (header(Locatio...))******//
    include("nav.html");
    /******************/
    
    include("funciones.php");
    require('DB/conexion.php');
      if (isset($_POST['entrar'])) {
        $nombre=trim(mysqli_real_escape_string($llave, $_POST['nombre']));
        $pass=trim(mysqli_real_escape_string($llave, $_POST['pass']));
        $consulta = "select * from usuarios where usuario_name='$nombre' and contrasena=md5('$pass')"; //monto consulta
        $ejConsult = mysqli_query($llave, $consulta); //ejecuto consulta
        if (!$ejConsult) { //si hay error en consulta
          //este error tiene que ser visible solo por el admin//QUITAR ANTES DE ENTREGAR PROYECTO  
          echo mysqli_error($llave);
            die();
        }
        else {
          if (mysqli_num_rows($ejConsult) == 0) { //sin resultados en consulta, usuario incorrecto ,error de validación
              unset($_POST['entrar']);
              $errorLogin="<h3 style='color:red'>ERROR: Usuario o Contraseña Incorrectos!.<h3>";
          }
          else {//si llega aquí es que el usuario es válido.
            $filaResult = mysqli_fetch_assoc($ejConsult); //resultados
            if (empty($filaResult['contrasena'])) {
                echo "El campo contraseña no puede estar vacío<br>";
            }else {
                //creo sesión del perfil para identificar si es alumno o empresa
                $_SESSION['elPerfil']=$filaResult['perfil'];
                //creo sesion con datos del usuario
                $_SESSION['nomUsuario']=$filaResult['usuario_name'];
                $_SESSION['idUsuario']=$filaResult['idUsuario'];
                /*función(fuchero funciones.php) que comprueba el perfil del usuario y lo envía a su página correspondiente*/
            // rederigir($_SESSION['elPerfil']);
                if ($_SESSION['elPerfil']=='admin') {
                    header("Location: admin.php");
                    exit;
                }elseif ($_SESSION['elPerfil']=='alumno') {
                    header("Location: alumno.php");
                    exit;
                }elseif ($_SESSION['elPerfil']=='centro') {
                header("Location: matricularAlumno.php");
                exit;
                }elseif ($_SESSION['elPerfil']=='empresa') {
                    //echo $_SESSION['idUsuario']." Perfil-> ".$_SESSION['elPerfil'];
                    header("Location: empresa.php");
                    exit;
                }
            }
          }
        }
      }
      mysqli_close($llave); //cerrar sesión con la base de datos
      //si existe error en el login lo mustro
      if (isset($errorLogin)) {
        echo $errorLogin;
      }
      
?>
        <div class="tex-center">
      <form class="form-signin" action="login.php" method="post">
            <!--<img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">-->
            <h1 class="h3 mb-3 font-weight-normal text-center">Iniciar de sesión</h1>
            <input type="text" class="form-control" placeholder="Nombre de usuario" required=""
                autofocus="" name="nombre">
            <input type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required="" name="pass">
            <input type="submit" value="ENTRAR" class="btn btn-lg btn-primary btn-block" name="entrar"/>
        </form>
    </div>
</body>

</html>