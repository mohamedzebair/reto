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
        
    /////** */si se pulsa registrar*****/////
    if (isset($_POST['registrar'])) {
        //Escapado, esliminación de espacios y guardado de valores de los campos en variables
        $nomAlumno=trim(mysqli_real_escape_string($llave, $_POST['nomAlumno']));
        $primerApell=trim(mysqli_real_escape_string($llave,$_POST['primerApell']));
        $fechaNac=$_POST['fechaNac'];
        $centroEduc=$_POST['centroEduc'];
        $pass1=trim(mysqli_real_escape_string($llave,$_POST['pass1']));
        $pass2=trim(mysqli_real_escape_string($llave,$_POST['pass2']));
        //echo "$fechaNac<br>";
        //echo validarFecha($fechaNac)."<br>".validarEmail($email);
        if (!validarNombres($nomAlumno) || !validarApellidos($primerApell) || !validarFecha($fechaNac) || empty($centroEduc) || !validarPass($pass1, $pass2)) {
            $errorValidacion="<div class='alert alert-danger text-center'>Alguno de los campos <span class='font-weight-bold'>no está bien rellenado</span>.</div>";
        }
        else {//compruebo si está registrado
            $consSiExiste="select * from alumnos where alumno_name='$nomAlumno' and primerApell='$primerApell' and fecha_nacimiento='$fechaNac' and centroEduc='$centroEduc'";
            $ejCons = mysqli_query($llave, $consSiExiste);
            if (!$ejCons) { //si hay error en consulta
                echo mysqli_error($llave);
                unset($_POST['registrar']);
                die();
            }
            if (mysqli_num_rows($ejCons) != 0) {
                $nomUsuario=$nomAlumno."_".$primerApell;
                $todoCorrecto=insertarUsuario($pass1, $nomUsuario);
            }
            else {
                $errorYaExiste="<div class='alert alert-danger text-center'>Error, para poder registrarte tu centro educativo tiene que <span class='font-weight-bold'>darte de alta.</span> en la plataforma</div>";
            }
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
            if (isset($errorYaExiste)) {
                mostrarMensaje($errorYaExiste); 
            }
        ?>
    </div>
    <form action="registrarAlumno.php" method="post">
        <div class="container">
            <h2 class="display-4 text-center">Registrar alumnos</h2>
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
                    <input type="date" id="fechaNac" name="fechaNac" class="form-control"
                        placeholder="Fecha de nacimiento" required="" alt="Fecha de nacimiento">
                </div>
                <div class="col-md-6">
                    <!--<input type="date" id="fechaNac" name="fechaNac" class="form-control"
                        placeholder="Fecha de nacimiento" required="" alt="Fecha de nacimiento">-->
                    <select class="form-control" placeholder="Seleccione su centro educativo" name="centroEduc" id="centroEduc">
                        <option value="" selected>Centro educativo</option>
                        <?php
                            listaCentrosEduc();
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <input type="password" id="pass1" name="pass1" class="form-control" placeholder="Contraseña"
                        required="">
                </div>
                <div class="col-md-6">
                    <input type="password" id="pass2" name="pass2" class="form-control"
                        placeholder="confirmar contraseña" required="">
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-sm-6">
                    <input type="reset" class="btn btn-primary" value="RESTABLECER" />
                </div>
                <div class="col-sm-6">
                    <input id="registrar" type="submit" class="btn btn-primary" value="REGISTRARSE"
                        name="registrar" onclick="return validacionAl();" />
                </div>
            </div>
        </div>
    </form>
</body>
<!--Validar campos con javascript-->
<script src="js/registrar.js"></script>

</html>