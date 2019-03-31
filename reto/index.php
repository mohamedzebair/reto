<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INICIO</title>
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
    <link rel="stylesheet" href="css/indexHTML.css"/>
</head>

<body>
    <?php
    //incluyo barra de navegación (Menu)
    include("nav.html");
    ?>
    <h1 class="display-4 text-center">Formación en centros de trabajo</h1>
    <div class="contenedor">
        <a href="#">
            <div class="divEmpresas">
                <h2 class="empresasTitle">¿Buscas candidatos?</h2>
                <div class="paraEmpresas"></div>
                <p>Si eres una <span class="font-weight-bold">Empresa</span> y buscas alumnos para realizar la FCT en tu empresa, entra en este apartado</p>
            </div>
        </a>
        <a href="#">
            <div class="divAlumnos">
                <h2 class="alumnosTitle">¿Buscas empresas?</h2>
                <div class="paraAlumnos"></div>
                <p>Si eres un/a <span class="font-weight-bold">Alumn@</span> y buscas empresas para realizar tu FCT, entra en este apartado</p>
            </div>
        </a>
    </div>
</body>

</html>