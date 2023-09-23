<?php
// Configuración de la conexión a la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'FerreteriaERP');

// Conexión a la base de datos
function dbConnect() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (mysqli_connect_errno()) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    return $conn;
}

// Desconexión de la base de datos
function dbClose($conn) {
    mysqli_close($conn);
}

// Realizar consultas a la base de datos
function dbQuery($conn, $query) {
    $query = trim($query);  // Aplicar trim() al query antes de ejecutarlo
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conn));
    }
    return $result;
}

// Obtener el siguiente registro de un conjunto de resultados como un array asociativo
function dbFetchAssoc($result) {
    return mysqli_fetch_assoc($result);
}

// Obtener el siguiente registro de un conjunto de resultados como un array numérico
function dbFetchRow($result) {
    return mysqli_fetch_row($result);
}

// Obtener el número de filas de un conjunto de resultados
function dbNumRows($result) {
    return mysqli_num_rows($result);
}

// Obtener la última ID insertada
function dbLastInsertId($conn) {
    return mysqli_insert_id($conn);
}

// Liberar el conjunto de resultados
function dbFreeResult($result) {
    mysqli_free_result($result);
}

// Ejemplo de uso:
// $conn = dbConnect();
// $result = dbQuery($conn, "SELECT * FROM Proveedores");
// while ($row = dbFetchAssoc($result)) {
//     echo $row['nombreProveedor'];
// }
// dbFreeResult($result);
// dbClose($conn);

?>
