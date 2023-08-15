<?php
if (isset($_GET["BD"])) {
    $BD = $_GET["BD"];
}
if (isset($_GET["tablaBD"])) {
    $tabla = $_GET["tablaBD"];
}
if (isset($_GET["tabla"])) {
    $tabla = $_GET["tabla"];
}

if (isset($_GET["usr"])) {
    $usuario = $_GET["usr"];
}
if (isset($_GET["ape"])) {
    $usuarioApe = $_GET["ape"];
}
if (isset($_GET["email"])) {
    $email = $_GET["email"];
}
if (isset($_GET["pass"])) {
    $pass = $_GET["pass"];
}
if (isset($_GET["msg"])) {
    $msg = $_GET["msg"];
}



require("Controller/conect.php");
include "Views/php/navbar.php";
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
<div class="title">
    <h1 class="title-home">Base de datos:
        <?php echo $BD ?>
    </h1>
    <h2 class="title-home">Tabla:
        <?php echo $tabla ?>
    </h2>
    <script>
        alert("<?= $msg; ?>");
    </script>
</div>
<link rel="stylesheet" href="../css/BD.css">

<div class="añadr">
    <a href="index.php?vista=añadirData&BD=<?php echo $BD ?>&usr=<?php echo $usuario ?>&ape=<?php echo $usuarioApe ?>&email=<?php echo $email ?>&pass=<?php echo $pass ?>&tabla=<?php echo $tabla ?>"
        id="tableCreate">Añadir datos a la tabla
        <img src="Controller/img/table.png" alt="" id="tableIconData">
    </a>
</div>
<div class="tablaContainer">

    <?php

    $useBd = "USE $BD";
    $selectTable = "SELECT * FROM $tabla";

    try {
        // Ejecuta la consulta "USE" para seleccionar la base de datos deseada
        $usarBD = mysqli_query($sqlCreacion, $useBd);
        if ($usarBD) {
            // Verificar si se ha seleccionado ver los últimos registros
            $mostrarUltimosRegistros = isset($_GET['ultimosRegistros']) && $_GET['ultimosRegistros'] === 'true';

            // Obtiene la cantidad total de registros en la tabla
            $countQuery = "SELECT COUNT(*) as total FROM $tabla";
            $countResult = mysqli_query($sqlCreacion, $countQuery);
            $totalRegistros = mysqli_fetch_assoc($countResult)['total'];

            // Calcula la cantidad total de páginas
            $registrosPorPagina = 20;
            $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

            // Obtiene el número de página actual desde la variable GET, o establece el valor predeterminado en 1 si no se proporciona
            $paginaActual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;

            // Ajustar el número de página actual si se seleccionaron los últimos registros
            if ($mostrarUltimosRegistros) {
                $paginaActual = $totalPaginas;
            }

            // Calcula el índice del primer registro de la página actual
            $indiceInicio = ($paginaActual - 1) * $registrosPorPagina;

            // Consulta para obtener los registros de la página actual con la cláusula LIMIT
            $paginaQuery = "SELECT * FROM $tabla ORDER BY id ";
            // Si se seleccionaron los últimos registros, ordenamos en sentido descendente
            if ($mostrarUltimosRegistros) {
                $paginaQuery .= "DESC ";
            }
            $paginaQuery .= "LIMIT $indiceInicio, $registrosPorPagina";
            $paginaResult = mysqli_query($sqlCreacion, $paginaQuery);

            $columnas = array();
            echo "<table>";
            echo "<tr>";
            // Obtiene los nombres de las columnas y los muestra en la primera fila de la tabla
            while ($infoColumnas = mysqli_fetch_field($paginaResult)) {
                echo "<th>" . htmlspecialchars($infoColumnas->name) . "</th>";
                $columnas[] = $infoColumnas->name;
            }
            echo "<th>" . "Eliminar" . "</th>"; // Agrega la nueva columna "Eliminar"
            echo "<th>" . "Editar" . "</th>";
            echo "</tr>";
            
            // Muestra los datos de cada fila en la tabla
            while ($row = mysqli_fetch_assoc($paginaResult)) {

                echo "<tr>";
            
                // Recorre cada columna de la fila y muestra su valor
                foreach ($columnas as $columna) {
                    echo "<td>" . htmlspecialchars($row[$columna]) . "</td>";
                }
                $queryParams = http_build_query([
                    'usr' => $usuario,
                    'ape' => $usuarioApe,
                    'email' => $email,
                    'pass' => $pass,
                    'tabla' => $tabla,
                    'BD' => $BD
                ]);
                // Agrega la columna <a> con el enlace "Eliminar" en cada fila
                $params = http_build_query($row);
                echo '<td><a href="#" class="eliminar-registro" data-id="' . $row["ID"] . '">Eliminar</a></td>';
                
                echo "<td><a href='index.php?vista=editar_registro&ID=" . urlencode($row["ID"]) . "&$queryParams'>Editar</a></td>";            
                echo "</tr>";
            }
            echo "</table>";
            


            echo "<br>";
            // Muestra la paginación debajo de la tabla
            echo "<div class='pagination'>";

            $paginasAMostrar = 5;
            $paginaInicial = max(1, $paginaActual - floor($paginasAMostrar / 2));
            $paginaFinal = min($totalPaginas, $paginaInicial + $paginasAMostrar - 1);

            if ($paginaFinal - $paginaInicial + 1 < $paginasAMostrar) {
                $paginaInicial = max(1, $paginaFinal - $paginasAMostrar + 1);
            }
            echo "<a class='page-link' href='index.php?vista=tablasBD&BD=$BD&tablaBD=$tabla&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass'>Primeros registros</a>";

            for ($i = $paginaInicial; $i <= $paginaFinal; $i++) {
                if ($i === $paginaActual) {
                    echo '<li class="page-link">Página ' . $i . '</li>';
                } else {

                    echo "<a class='page-link' href='index.php?vista=tablasBD&BD=$BD&tablaBD=$tabla&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass&pagina=$i'> PÁGINA $i</a>";
                }
            }

            // Agregar botón para ver los últimos registros
            echo "<a class='page-link' href='index.php?vista=tablasBD&BD=$BD&tablaBD=$tabla&usr=$usuario&ape=$usuarioApe&email=$email&pass=$pass&ultimosRegistros=true'>Últimos registros</a>";

            echo "</div>";
        }
    } catch (\Throwable $th) {
        // Maneja cualquier excepción o error aquí
    }
    ?>
</div>
<script>
    document.querySelectorAll('.eliminar-registro').forEach(el => {
  el.addEventListener('click', function (event) {
    event.preventDefault();

    // Obtener el identificador del registro que se desea eliminar del atributo "data-id"
    const idRegistro = el.getAttribute('data-id');

    // Realizar la petición AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'Controller/eliminarDato.php?tabla=<?php echo $tabla ?>&bd=<?php echo $BD ?>&ID=' + idRegistro, true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          // La eliminación fue exitosa, puedes realizar alguna acción adicional si es necesario, como actualizar la tabla o mostrar un mensaje de éxito.
          // Por ejemplo, recargar la página después de eliminar el registro:
          location.reload();
        } else {
          // Ocurrió un error al eliminar el registro, puedes mostrar un mensaje de error o realizar alguna acción de manejo de errores.
        }
      }
    };
    xhr.send();
  });
});
</script>