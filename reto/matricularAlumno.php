<?php
session_start();
   if (!isset($_SESSION['idUsuario']) || $_SESSION['elPerfil']!="centro") {
        header("Location:index.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Registrarse (Alumnos)</title>
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
    <link rel="stylesheet" href="css/registrar.css"/>
</head>

<body>
<?php
    //incluyo barra de navegación (Menu)
    include("nav.html");
    include("funciones.php");
    require('DB/conexion.php');
        echo "id centro: ".$_SESSION['idUsuario']."<br>";
    /////** */si se pulsa registrar*****/////
    if (isset($_POST['registrar'])) {
        //Escapado, esliminación de espacios y guardado de valores de los campos en variables
        $nomAlumno=trim(mysqli_real_escape_string($llave, $_POST['nomAlumno']));
        $primerApell=trim(mysqli_real_escape_string($llave,$_POST['primerApell']));
        $segundoApell=trim(mysqli_real_escape_string($llave,$_POST['segundoApell']));
        $fechaNac=$_POST['fechaNac'];
        $telefono=$_POST['telefono'];
        $email=trim($_POST['email']);
        //echo "$fechaNac<br>";
        //echo validarFecha($fechaNac)."<br>".validarEmail($email);
        if (!validarNombres($nomAlumno) || !validarApellidos($primerApell) || !validarFecha($fechaNac) || !validarTelefono($telefono) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorValidacion="<div class='alert alert-danger text-center'>Alguno de los campos <span class='font-weight-bold'>no está bien rellenado</span>.</div>";
        }
        else {//compruebo si está registrado
            $result=siEstaRegistradoAl('alumnos', 'alumno_name', 'primerApell', $nomAlumno, $primerApell);
            
            if ($result!="noExiste") {//si existe muestro error
                $errorYaExisteCentro=$result;
            }
            else {
                $centroEduc=$_SESSION['idUsuario'];
                $insertarAlumno="insert into alumnos values(null, '$nomAlumno', '$primerApell', '$segundoApell', '$fechaNac', '$telefono', '$email', '$centroEduc')";
                $ejInsercion = mysqli_query($llave, $insertarAlumno);
                if (!$ejInsercion) {
                    echo "Error al insertar datos de Empresa: ".mysqli_error($llave);
                    unset($_POST['registrar']);
                    die();
                }
                else{
                    $todoCorrecto="<div class='alert alert-success text-center'>Matriculado <span class='font-weight-bold'>Correctamente</span>!</div>";
                }
            }
        }
    }
    if (isset($_POST['subrExcel'])) {
        $nomOrigial=$_FILES['archivo']['name'];
        $nomTemporal=$_FILES['archivo']['tmp_name'];
        $nomFinal="copia_".$nomOrigial;

        if (copy($nomTemporal, $nomFinal)) {
            echo "Se ha copiado correctamente el archivo excel<br>";
        }
        else{
            echo "Error al copiar el fichero excel<br>";
        }
        if (file_exists($nomFinal)) {
            $fp=fopen($nomFinal, 'r');
            $rows=0;
            
            while ($datos = fgetcsv($fp, 1000, ";")) {
                $rows++;
                if ($rows>1) {
                    $resultado=insertarExcel($datos[0], $datos[1], $datos[2], $datos[3], $datos[4], $datos[5], $_SESSION['idUsuario']);
                    if ($resultado) {
                        echo "Insertado bien<br>";
                    }
                    else{
                        echo "Insertado MAL<br>";
                    }
                }
            }
            unlink($nomFinal);
        }
        else{
            echo "No existe el archivo copiado<br>";
        }
    }
?>
       <div class="InfoValidacionJS" id="InfoValidacionJS">
<?php
        //En este div se mostrán los mensaje de error y de éxito.
            if (isset($errorValidacion)) {
                mostrarMensaje($errorValidacion); 
            }
            if (isset($todoCorrecto)) {
                mostrarMensaje($todoCorrecto); 
            }
            if (isset($errorYaExisteCentro)) {
                mostrarMensaje($errorYaExisteCentro); 
            }
?>
    </div>
    <form action="matricularAlumno.php" method="post">
        <div class="container">
            <h2 class="display-4 text-center">Matricular alumnos</h2>
            <div class="row">
                <div class="col-md-6">
                    <input type="text" id="nomAlumno" name="nomAlumno" class="form-control" placeholder="Nombre"
                        required="" autofocus="">
                </div>
                <div class="col-md-6">
                    <input type="text" id="primerApell" name="primerApell" class="form-control" placeholder="Primer apellido"
                        required="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <input type="text" id="segundoApell" name="segundoApell" class="form-control" placeholder="Segundo apellido">
                </div>
                <div class="col-md-6">
                    <input type="date" id="fechaNac" name="fechaNac" class="form-control"
                        placeholder="Fecha de nacimiento" required="" alt="Fecha de nacimiento">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <input type="number" id="telefono" name="telefono" class="form-control" placeholder="Nº teléfono"
                        required="">
                </div>
                <div class="col-md-6">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Correo electrónico"
                        required="">
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-sm-6">
                    <input type="reset" class="btn btn-primary" value="RESTABLECER" />
                </div>
                <div class="col-sm-6">
                    <input id="registrar" type="submit" class="btn btn-primary" value="REGISTRARSE"
                        name="registrar" onclick="return validarMarticAl();" />
                </div>
            </div>
        </div>
    </form>
    <form action="matricularAlumno.php" method="post" enctype="multipart/form-data">
        <div class="container">
            <h4 class="display-4 text-center">Subir desde excel</h4>
            <div class="form-group row text-center">
                <div class="col-sm-6">
                    <input type="file" name="archivo" id="archivo" class="btn btn-primary"/>
                </div>
                <div class="col-sm-6">
                    <input id="subrExcel" type="submit" class="btn btn-primary" value="SUBIR"
                        name="subrExcel" onclick="return validarMarticAl();" />
                </div>
            </div>
        </div>
    </form>
</body>
<!--Validar campos con javascript-->
<script src="js/registrar.js"></script>

</html>