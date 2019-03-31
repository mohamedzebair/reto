<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Registrarse (centro educativo)</title>
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
        $centro_name=trim(mysqli_real_escape_string($llave, $_POST['centro_name']));
        $responsable_name=trim(mysqli_real_escape_string($llave,$_POST['responsable_name']));
        $primerApell=trim(mysqli_real_escape_string($llave,$_POST['primerApell']));
        $segundoApell=trim(mysqli_real_escape_string($llave,$_POST['segundoApell']));
        $localidad=trim(mysqli_real_escape_string($llave,$_POST['localidad']));
        $num_telefono=$_POST['num_telefono'];
        $email=trim($_POST['email']);
        $pass1=trim(mysqli_real_escape_string($llave,$_POST['pass1']));
        $pass2=trim(mysqli_real_escape_string($llave,$_POST['pass2']));
        //echo "$primerApell<br>";
        //echo validarFecha($primerApell)."<br>".validarEmail($email);
        if (!validarNombres($centro_name) || !validarNombres($responsable_name) || !validarApellidos($primerApell) || empty($localidad) || !validarTelefono($num_telefono) || !filter_var($email, FILTER_VALIDATE_EMAIL) || !validarPass($pass1, $pass2)) {
            $errorValidacion="<div class='alert alert-danger text-center'>Alguno de los campos <span class='font-weight-bold'>no está bien rellenado</span>.</div>";
        }
        else {//compruebo si está registrado
            $result=siEstaRegistradoCentro('centroseduc', 'centro_name', $centro_name);
            
            if ($result!="noExiste") {//si existe muestro error
                $errorYaExisteCentro=$result;
            }
            else {
                $insertarCentro="insert into centroseduc values(null, '$centro_name', '$responsable_name', '$primerApell', '$segundoApell', '$localidad', '$num_telefono', '$email')";
                $ejInsercionEmp = mysqli_query($llave, $insertarCentro);
                if (!$ejInsercionEmp) {
                    echo "Error al insertar datos de del centro: ".mysqli_error($llave);
                    unset($_POST['registrar']);
                    die();
                }
                else {
                    $nomUsuario=$responsable_name."_".$primerApell;
                    $todoCorrecto=insertarUsuario($pass1, $nomUsuario);
                }
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
            if (isset($errorYaExisteCentro)) {
                mostrarMensaje($errorYaExisteCentro); 
            }
        ?>
    </div>
    <form action="registrarCentroEduc.php" method="post">
        <div class="container">
            <h2 class="display-4 text-center">Registrar Centro Educativo</h2>
            <div class="row">
                <div class="col-md-6">
                    <input type="text" id="centro_name" name="centro_name" class="form-control" placeholder="Nombre del centro"
                        required="" autofocus="">
                </div>
                <div class="col-md-6">
                    <input type="text" id="responsable_name" name="responsable_name" class="form-control" placeholder="Nombre del responsable"
                        required="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <input type="text" id="primerApell" name="primerApell" class="form-control"
                        placeholder="Primer apellido del responsable" required="">
                </div>
                <div class="col-md-6">
                    <input type="text" id="segundoApell" name="segundoApell" class="form-control"
                        placeholder="Segundo apellido del responsable">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <input type="number" id="num_telefono" name="num_telefono" class="form-control" placeholder="Nº teléfono"
                        required="">
                </div>
                <div class="col-md-6">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Correo electrónico"
                        required="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input type="text" id="localidad" name="localidad" class="form-control" placeholder="Localidad"
                        required="">
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
                        name="registrar" onclick="return validacionCentro();" />
                </div>
            </div>
        </div>
    </form>
</body>
<!--Validar campos con javascript-->
<script src="js/registrar.js"></script>

</html>