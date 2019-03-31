<?php
    session_start();
    //echo $_SESSION['idUsuario']." Perfil-> ".$_SESSION['elPerfil'];
   if (!isset($_SESSION['idUsuario']) || $_SESSION['elPerfil']!="empresa") {
        header("Location:../index.php");
        die();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>EMPRESA</title>
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
    <link rel="stylesheet" href="css/registrar.css" />
</head>

<body>
<?php
    //incluyo barra de navegación (Menu)
    include("nav.php");
    include("funciones.php");
    require('DB/conexion.php');
        
    /////** */si se pulsa registrar*****/////
   /* if (isset($_POST['registrar'])) {
        //Escapado, esliminación de espacios y guardado de valores de los campos en variables
        $titulo=trim(mysqli_real_escape_string($llave, $_POST['titulo']));
        $categoria=trim(mysqli_real_escape_string($llave,$_POST['categoria']));
        $fecha=$_POST['fecha'];
        $centroEduc=$_POST['centroEduc'];
        $descripcion=$_POST['descripcion'];
        $email=trim($_POST['email']);
        $pass1=trim(mysqli_real_escape_string($llave,$_POST['pass1']));
        $pass2=trim(mysqli_real_escape_string($llave,$_POST['pass2']));
        //echo "$fecha<br>";
        //echo validarFecha($fecha)."<br>".validarEmail($email);
        if (!validarNombres($titulo) || !validarApellidos($categoria) || !validarFecha($fecha) || empty($centroEduc) || !validardescripcion($descripcion) || !filter_var($email, FILTER_VALIDATE_EMAIL) || !validarPass($pass1, $pass2)) {
            $errorValidacion="<div class='alert alert-danger text-center'>Alguno de los campos <span class='font-weight-bold'>no está bien rellenado</span>.</div>";
        }
        else {//compruebo si está registrado
            $result=siEstaRegistrado('alumnos', 'alumno_name', 'apellidos_alumno', $titulo, $categoria);
            
            if ($result!="noExiste") {//si existe muestro error
                $errorYaExisteCentro=$result;
            }
            else {
                $insertarEmpresa="insert into alumnos values(null, '$titulo', '$categoria', '$fecha', '$descripcion', '$email', '$centroEduc')";
                $ejInsercionEmp = mysqli_query($llave, $insertarEmpresa);
                if (!$ejInsercionEmp) {
                    echo "Error al insertar datos de Empresa: ".mysqli_error($llave);
                    unset($_POST['registrar']);
                    die();
                }
                else {
                    $todoCorrecto=insertarUsuario($titulo, $categoria, $pass1, 'alumno');
                }
            }
        }
    }*/
   ?>
    <div class="InfoValidacionJS" id="InfoValidacionJS">
        <?php
        /*
        //En este div se mostrán los mensaje de error y de éxito.
            if (isset($errorValidacion)) {
                mostrarMensaje($errorValidacion); 
            }
            if (isset($todoCorrecto)) {
                mostrarMensaje($todoCorrecto); 
            }
            if (isset($errorYaExisteCentro)) {
                mostrarMensaje($errorYaExisteCentro); 
            }*/
        ?>
    </div>
    <form action="registrarAlumno.php" method="post">
        <div class="container">
            <h2 class="display-4 text-center">Publicar oferta</h2>
            <div class="row">
                <div class="col-md-6">
                    <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Titulo"
                        required="" autofocus="">
                </div>
                <div class="col-md-6">
                    <input type="text" id="localidad" name="localidad" class="form-control" placeholder="Localidad"
                        required="">
                </div>
            </div>
            <div class="row">
            <div class="col-md-6">
                    <input type="text" id="categoria" name="categoria" class="form-control" placeholder="Categoría"
                        required="">
                </div>
                <div class="col-md-6">
                    <input type="text" id="subCategoria" name="subCategoria" class="form-control" placeholder="Subcategoría"
                        required="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <textarea rows="5" type="number" id="descripcion" name="descripcion" class="form-control" placeholder="Descripción del puesto"
                        required=""></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                <select class="form-control" placeholder="Seleccione su centro educativo" name="contratacion" id="contratacion">
                        <option value="0" selected>Posibilidad de contratación</option>
                        <option value="si" >Sí</option>
                        <option value="no" >No</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <select class="form-control" placeholder="Seleccione su centro educativo" name="puestos" id="puestos">
                        <option value="0" selected>Número de puestos</option>
                        <option value="1" >Uno</option>
                        <option value="2" >Dos</option>
                        <option value="3" >Tres</option>
                        <option value="4" >Cuatro</option>
                        <option value="5" >Cinco</option>
                        <option value="6" >Seis</option>
                        <option value="7" >Sete</option>
                        <option value="8" >Ocho</option>
                        <option value="9" >Nueve</option>
                        <option value="10" >Diez</option>
                    </select>
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-sm-6">
                    <input type="reset" class="btn btn-primary" value="LIMPIAR" />
                </div>
                <div class="col-sm-6">
                    <input id="registrar" type="submit" class="btn btn-primary" value="PUBLICAR"
                        name="registrar" onclick="return validacionAl();" />
                </div>
            </div>
        </div>
    </form>     
</body>
</html>