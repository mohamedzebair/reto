<?php
    /**********FUNCIONES DE LA PÁGINA LOGIN**********/
   function rederigir($perfi){
        //saber qué usuario, segun el tipo de usuario que sea, creo sesion con su nombre e id y lo redirijo a su página correspondiente
        if ($perfi=='admin') {
        header("Location:admin.php");
        die();
        }elseif ($perfi=='alumno') {
        header("Location:alumno.php");
            die();
        }elseif ($perfi=='centro') {
        header("Location:matricularAlumno.php");
        die();
        }elseif ($perfi=='empresa') {
        //echo $_SESSION['idUsuario']." Perfil-> ".$_SESSION['elPerfil'];
        header("Location:empresa.php");
        die();
        }
   }
   /**************************************/
    /**********FUNCIONES PARA VALIDAR LOS DATOS**********/
   function validarNombres($valor){
        $patronNombre="/^[A-Za-zñÑáéíóúÁÉÍÓÚ]{1}[A-Za-zñÑáéíóúÁÉÍÓÚ\s]{1,38}[A-Za-zñÑáéíóúÁÉÍÓÚ]$/";
        if (preg_match($patronNombre, $valor)) {
            return true;
        }
    }
    function validarApellidos($valor){
        $patronApellidos = "/^[A-Za-zñÑáéíóúÁÉÍÓÚ]{1}[A-Za-zñÑáéíóúÁÉÍÓÚ\s]{2,48}[A-Za-zñÑáéíóúÁÉÍÓÚ]$/";
        if (preg_match($patronApellidos, $valor)) {
            return true;
        }
    }
    function validarTelefono($valor){
        $patronTelfn="/^\d{9}$/";
        if (preg_match($patronTelfn, $valor)) {
            return true;
        }
    }
    function validarPass($valor1, $valor2){
        $patronPass="/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,20}$/";
        if (preg_match($patronPass, $valor1) && preg_match($patronPass, $valor2) && $valor1==$valor2) {
            return true;
        }
    }
    function validarFecha($valor){
        $patronFecha="/^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/";
        if (preg_match($patronFecha, $valor)) {
            return true;
        }
    }/*
    function validarEmail($valor){
        $patronEmail="/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3,4})+$/";
        if (preg_match($patronEmail, $valor)) {
            return true;
        }
    }*/
    /**************************************/
    /**********FUNCION comprobar si alumno está registrado**/
    function siEstaRegistradoAl($nomTabla, $columna1, $columna2, $valor1, $valor2){
        global $llave;

        $consSiExiste="select * from $nomTabla where $columna1='$valor1' and $columna2='$valor2'";
        $ejCons = mysqli_query($llave, $consSiExiste);
        if (!$ejCons) { //si hay error en consulta
            echo mysqli_error($llave);
            unset($_POST['registrar']);
            die();
        }
        if (mysqli_num_rows($ejCons) != 0) {
            return "<div class='alert alert-danger text-center'>Error, ya <span class='font-weight-bold'>estás registrado.</span></div>";
        }
        return "noExiste";
    }
    /**************************************/
    /**********FUNCION comprobar si alumno está registrado**/
    function siEstaRegistradoCentro($nomTabla, $columna1, $valor1){
        global $llave;

        $consSiExiste="select * from $nomTabla where $columna1='$valor1'";
        $ejCons = mysqli_query($llave, $consSiExiste);
        if (!$ejCons) { //si hay error en consulta
            echo mysqli_error($llave);
            unset($_POST['registrar']);
            die();
        }
        if (mysqli_num_rows($ejCons) != 0) {
            return "<div class='alert alert-danger text-center'>Error, el centro educativo ya <span class='font-weight-bold'>está registrado.</span></div>";
        }
        return "noExiste";
    }
    /**************************************/
    /**********FUNCIONES PARA INSERTAR USUARIO**********/
    function insertarUsuario($pass, $nomUsuario){
        global $llave;
        $actualizarUsuario="UPDATE usuarios SET  contrasena= md5('$pass') WHERE usuario_name='$nomUsuario'";
        $ejInsercionUsu = mysqli_query($llave, $actualizarUsuario);
        if (!$ejInsercionUsu) {
            echo "Error al insertar datos de Usuario: ".mysqli_error($llave);
            unset($_POST['registrar']);
            die();
        }
        else {
            return "<div class='alert alert-success text-center'>Registrado <span class='font-weight-bold'>Correctamente</span>!</div><div class='alert alert-info text-center'>Su nombre de usuario para iniciar sesión es ( <span class='font-weight-bold'> $nomUsuario </span> ).</div>";
        }
    }
    /**************************************/
    /**********FUNCIONES PARA MOSTRAR MENSAJES DE ERROR O EXITO A LA HORA DE INSERTAR DATOS**********/
    function mostrarMensaje($mensaje){
            echo $mensaje;
            unset($mensaje);
        
    }
    /**************************************/
    /**********FUNCIÓN PARA MOSTRAR Los centros educativos existentes********/
    function listaCentrosEduc(){
        global $llave;
        $consulta = "select id_centro, centro_name from centroseduc"; //monto consulta
        $ejeCons = mysqli_query($llave, $consulta);
        if (!$ejeCons) { //si hay error en consulta
            echo mysqli_error($llave);
        }
        if (mysqli_num_rows($ejeCons)!=0) { //no hay usuarios en la bd
            while ($filaResult=mysqli_fetch_assoc($ejeCons)) {
                //guardo valores en lista desplegable
                echo "<option value='".$filaResult['id_centro']."'>".$filaResult['centro_name']."</option>";
            }
        }
    }

    /******Insertar desde excel */
function insertarExcel($nomAl, $primerApell, $segundoApell, $fechaNac, $numTel, $email, $centroEduc){
    global $llave;
    $sentencua="insert into alumnos values(null, '$nomAl', '$primerApell', '$segundoApell', '$fechaNac', '$numTel', '$email', $centroEduc)";
    $ejecutar=mysqli_query($llave, $sentencua);
    return $ejecutar;
}
   
?>