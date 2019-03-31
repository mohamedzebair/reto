//document.getElementById("registrarEmpresa").addEventListener("click", validar);
//////PATRONES//////
patronNombres = /^[A-Za-zñÑáéíóúÁÉÍÓÚ]{1}[A-Za-zñÑáéíóúÁÉÍÓÚ\s]{1,38}[A-Za-zñÑáéíóúÁÉÍÓÚ]$/;
patronApellidos = /^[A-Za-zñÑáéíóúÁÉÍÓÚ]{1}[A-Za-zñÑáéíóúÁÉÍÓÚ\s]{2,48}[A-Za-zñÑáéíóúÁÉÍÓÚ]$/;
patronTelfn=/^\d{9}$/;
patronPass=/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,20}$/;
patronFecha=/^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/;
patronEmail=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3,4})+$/;

/***********nodo donde se verán los mensajes****** */
mensajeInfo=document.getElementById("InfoValidacionJS");
/**************************** */
/********Funciones mensajes de error de validacion*************/
function errorNombre() {
    return "<div class='alert alert-danger'>Los <span class='font-weight-bold'>campos nombre </span>deben de tener como mínimo 3 y como máximo 40 LETRAS.</div>";
}
function errorApellidos() {
    return "<div class='alert alert-danger'>El <span class='font-weight-bold'>campo apellido</span> debe de tener como mínimo 4 y como máximo 50 LETRAS.</div>";
}
function errorTelefono() {
    return "<div class='alert alert-danger'>El <span class='font-weight-bold'>campo teléfono</span> debe de tener 9 dígitos.</div>";
}
function errorPass() {
    return "<div class='alert alert-danger'>La <span class='font-weight-bold'>contraseña</span> debe ser una combinación de dígitos, minúsculas y mayúsculas (mínimo 8 y máximo 20 caracteres).</div>";
}
function errorPassNoIgual() {
    return "<div class='alert alert-danger'>Las <span class='font-weight-bold'>contraseñas</span> no coinciden.</div>";
}
function errorFecha() {
    return "<div class='alert alert-danger'>El <span class='font-weight-bold'>campo fecha </span>debe ser dd/mm/yyyy.</div>";
}
function errorSelectCentro() {
    return "<div class='alert alert-danger'>Debe <span class='font-weight-bold'>seleccionar </span> su centro educativo.</div>";
}
function errorEmail() {
    return "<div class='alert alert-danger'>El <span class='font-weight-bold'>email</span> no es válido.</div>";
}
function errorLocalidad() {
    return "<div class='alert alert-danger'>El <span class='font-weight-bold'>campo localidad</span> no puede estar vacío.</div>";
}
function validacionEmp() {
    //variable que guarda los errores de validacion
    var errores="";
    //Guardo valores de campos en variables
    var nomEmpresa=document.getElementById("nomEmpresa").value;
    var nomResponsable=document.getElementById("nomResponsable").value;
    var apellResponsable=document.getElementById("apellResponsable").value;
    var telefono=document.getElementById("telefono").value;
    var pass1=document.getElementById("pass1").value;
    var pass2=document.getElementById("pass2").value;
    
    //Comprobar si el valor cumple con los requisitos del patron
    if (!patronNombres.test(nomEmpresa) || !patronNombres.test(nomResponsable)) {//varidar nombre empresa
        errores=errorNombre();
    }
    if (!patronApellidos.test(apellResponsable)) {//varidar apellidos responsable
        errores+=errorApellidos();
    }
    if (!patronTelfn.test(telefono)) {//varidar Nº telefono
        errores+=errorTelefono();
    }
    if (!patronPass.test(pass1) || !patronPass.test(pass2) ) {//varidar contraseñas
        errores+=errorPass();
    }
    if (pass1!=pass2) {
        errores+=errorPassNoIgual();
    }
    if (errores=="") {
        mensajeInfo.innerHTML="";
        return true;
    }
    else{
        mensajeInfo.innerHTML=errores;
        return false;
    }
    
}
function validacionAl() {
    //variable que guarda los errores de validacion
    var errores="";
    //Guardo valores de campos en variables
    var nomAlumno=document.getElementById("nomAlumno").value;
    var apellAlumno=document.getElementById("apellAlumno").value;
    var fechaNac=document.getElementById("fechaNac").value;
    var centroEduc=document.getElementById("centroEduc").value;
    var telefono=document.getElementById("telefono").value;
    var email=document.getElementById("email").value;
    var pass1=document.getElementById("pass1").value;
    var pass2=document.getElementById("pass2").value;
   // mensajeInfo.innerHTML=fechaNac;
    
    //Comprobar si el valor cumple con los requisitos del patron
    if (!patronNombres.test(nomAlumno) || !patronNombres.test(nomResponsable)) {//varidar nombre empresa
        errores+=errorNombre();
    }
    if (!patronApellidos.test(apellAlumno)) {//varidar apellidos responsable
        errores+=errorApellidos();
    }
    if (!patronFecha.test(fechaNac)) {
        errores+=errorFecha();
    }
    if (centroEduc=="") {
        errores+=errorSelectCentro();
    }
    if (!patronEmail.test(email)) {
        errores+=errorEmail();
    }
    if (!patronTelfn.test(telefono)) {//varidar Nº telefono
        errores+=errorTelefono();
    }
    if (!patronPass.test(pass1) || !patronPass.test(pass2) ) {//varidar contraseñas
        errores+=errorPass();
    }
    if (pass1!=pass2) {
        errores+=errorPassNoIgual();
    }
    if (errores=="") {
        mensajeInfo.innerHTML="";
        return true;
    }
    mensajeInfo.innerHTML=errores;
    return false;
}

function validarMarticAl() {
    //variable que guarda los errores de validacion
    var errores="";
    //Guardo valores de campos en variables
    var nomAlumno=document.getElementById("nomAlumno").value;
    var primerApell=document.getElementById("primerApell").value;
    var fechaNac=document.getElementById("fechaNac").value;
    var telefono=document.getElementById("telefono").value;
    var email=document.getElementById("email").value;
   // mensajeInfo.innerHTML=fechaNac;
    
    //Comprobar si el valor cumple con los requisitos del patron
    if (!patronNombres.test(nomAlumno) || !patronNombres.test(nomResponsable)) {//varidar nombre empresa
        errores+=errorNombre();
    }
    if (!patronApellidos.test(primerApell)) {//varidar apellidos responsable
        errores+=errorApellidos();
    }
    if (!patronFecha.test(fechaNac)) {
        errores+=errorFecha();
    }
    if (!patronEmail.test(email)) {
        errores+=errorEmail();
    }
    if (!patronTelfn.test(telefono)) {//varidar Nº telefono
        errores+=errorTelefono();
    }
    if (errores=="") {
        mensajeInfo.innerHTML="";
        return true;
    }
    mensajeInfo.innerHTML=errores;
    return false;
}
/*****Validar datos de centro educativo*** */
function validacionCentro() {
    //variable que guarda los errores de validacion
    var errores="";
    //Guardo valores de campos en variables
    var centro_name=document.getElementById("centro_name").value;
    var primerApell=document.getElementById("primerApell").value;
    var segundoApell=document.getElementById("segundoApell").value;
    var localidad=document.getElementById("localidad").value;
    var num_telefono=document.getElementById("num_telefono").value;
    var email=document.getElementById("email").value;
    var pass1=document.getElementById("pass1").value;
    var pass2=document.getElementById("pass2").value;
   // mensajeInfo.innerHTML=fechaNac;
    
    //Comprobar si el valor cumple con los requisitos del patron
    if (!patronNombres.test(centro_name) || !patronNombres.test(nomResponsable)) {//varidar nombre empresa
        errores+=errorNombre();
    }
    if (!patronApellidos.test(primerApell)) {//varidar apellidos responsable
        errores+=errorApellidos();
    }
    if (localidad=="") {
        errores+=errorLocalidad();
    }
    if (!patronTelfn.test(num_telefono)) {//varidar Nº telefono
        errores+=errorTelefono();
    }
    if (!patronEmail.test(email)) {
        errores+=errorEmail();
    }
   
    if (!patronPass.test(pass1) || !patronPass.test(pass2) ) {//varidar contraseñas
        errores+=errorPass();
    }
    if (pass1!=pass2) {
        errores+=errorPassNoIgual();
    }
    if (errores=="") {
        mensajeInfo.innerHTML="";
        return true;
    }
    mensajeInfo.innerHTML=errores;
    return false;
}