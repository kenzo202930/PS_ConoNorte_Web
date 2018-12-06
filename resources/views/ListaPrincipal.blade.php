<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>PS. Cono Norte</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
</head>


<body>
<!--  start BARRA DE MENU-->
<nav class="light-blue lighten-1" role="navigation">

    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo" id="nombreps">PS. Cono
            Norte</a>
        <!-- hora actual-->
        <ul class="right">
            <li><p id="demo"></p></li>
        </ul>
    </div>
</nav>


<!--  start TABLAS-->
</br>
</br>

<div class="contenedor">
    <h5 id="titulo">Lista de Citas </h5>
    </br>
    <table class="highlight">
        <thead>
        <tr>
            <th>Especialidad</th>
            <th>Especialista de Turno</th>
            <th>Nro Citas</th>
            <th>Atencion</th>
        </tr>
        </thead>

        <tbody class="contenedortabla">

        </tbody>
    </table>
</div>


<div class="section no-pad-bot" id="index-banner">
    <!--  start DATOS PRINCIPALES-->
    <div class="container">
        <br><br>
        <h1 class="header center orange-text"><b><p id="demo"></p></b></h1>
    </div>
    <!--  end DATOS PRINCIPALES-->
</div>
<!--  footer -->
<footer class="page-footer light-blue lighten-1">
    <div class="footer-copyright">
        <div class="contiene">
            Seguridad <a class="orange-text text-lighten-3" href="http://materializecss.com">Informática</a>
        </div>
    </div>
</footer>


<!--  Scripts-->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>

<!--  buscador-->
<script>
    $(document).ready(function () {
        $('.sidenav').sidenav();

        Listar();

    });

    function Listar() {
        $.ajax({
            type: 'GET',
            url: "/api/ListarEspecialistaDia",
            success: function (response) {
                var resp = response.data;
                $.each(resp, function (key, value) {
                    debugger
                    var CitasTotalesDia = value.Nro_Citas;
                    var TotalCitasRegistradas = CitasRegistradasEspecialidad(value.Especialista_Id);
                    var Total = CitasTotalesDia - TotalCitasRegistradas;

                    var Asistencia = ValidarMedicoAsistencia(value.IdMedico);
                    Asistencia = Asistencia === 0 ? "No" : "Si";

                    $(".contenedortabla").append('<tr>\n' +
                        '                <td>' + value.Especialidad + '</td>\n' +
                        '                <td>' + value.Nombre + '</td>\n' +
                        '                <td>' + Total + '</td>\n' +
                        '                <td> ' + Asistencia + ' </td>                \n' +
                        '            </tr>');
                })
            }
        });
    }

    function CitasRegistradasEspecialidad(EspecialidadId) {
        var Total;
        $.ajax({
            type: 'POST',
            url: '/api/TotalCitas',
            data: {
                'Especialista_Id': EspecialidadId
            },
            async: false,
            success: function (resp) {
                Total = resp.Total;
            },
            error: function () {
            }
        });
        return Total;
    }

    function ValidarMedicoAsistencia(MedicoID) {
        var Validar;
        $.ajax({
            type: 'POST',
            url: '/api/ValidarMedicoAsistencia',
            data: {
                'MedicoId': MedicoID
            },
            async: false,
            success: function (resp) {
                Validar = resp.Validar;
            },
            error: function () {
            }
        });
        return Validar;
    }
</script>


<p id="demo"></p>   <!-- Muestra la hora actual -->
<p id="demo2"></p> <!-- Muestra el mensaje a las 7:00:00 -->

<script>
    var myVar = setInterval(function () {
        myTimer()
    }, 1000);

    //funcion para programar mensajes//
    function myTimer() {
        var hora = new Date();
        var myhora = hora.toLocaleTimeString();
        document.getElementById("demo").innerHTML = "Son las " + myhora + " horas";
    }
</script>


</body>
</html>
