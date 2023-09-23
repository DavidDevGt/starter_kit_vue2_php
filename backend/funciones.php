<?php
// Importamos las funciones del archivo database.php para poder conectarnos a la base de datos
require_once('database.php');

/**
 * Envía datos en formato JSON.
 *
 * Esta función convierte un array de PHP en JSON y lo envía con el Content-Type correcto.
 * Útil para APIs y comunicación con frontends que esperan recibir JSON.
 *
 * @param array $data Los datos a convertir y enviar.
 */
function sendJSON($data)
{
    // Establecemos el encabezado para indicar que la respuesta es JSON
    header('Content-Type: application/json');
    // Convertimos el array a JSON y lo mostramos
    echo json_encode($data);
}

/**
 * Obtiene todos los registros activos de una tabla.
 *
 * Esta función devuelve todos los registros de una tabla donde el campo active sea 1.
 *
 * @param string $tableName El nombre de la tabla de donde se obtendrán los registros.
 * @return array Registros obtenidos.
 */
function getAllFromTable($tableName)
{
    // Conectamos a la base de datos
    $conn = dbConnect();

    // Preparamos la consulta SQL
    $sql = "SELECT * FROM $tableName WHERE active = 1";

    // Ejecutamos la consulta
    $result = dbQuery($conn, $sql);

    // Recopilamos los resultados en un array
    $items = [];
    while ($row = dbFetchAssoc($result)) {
        $items[] = $row;
    }

    // Cerramos la conexión
    dbClose($conn);

    // Devolvemos los registros obtenidos
    return $items;
}

/**
 * Obtiene un registro específico de una tabla por su ID.
 *
 * Esta función devuelve un registro específico de una tabla usando un ID y comprobando
 * que esté activo.
 *
 * @param string $tableName El nombre de la tabla de donde se obtendrá el registro.
 * @param string $idField El nombre del campo de ID de la tabla.
 * @param int $idValue El valor del ID para filtrar el registro.
 * @return array|false Registro obtenido o false si no se encontró.
 */
function getOneFromTable($tableName, $idField, $idValue)
{
    // Conectamos a la base de datos
    $conn = dbConnect();

    // Preparamos la consulta SQL
    $sql = "SELECT * FROM $tableName WHERE $idField = $idValue AND active = 1";

    // Ejecutamos la consulta
    $result = dbQuery($conn, $sql);

    // Obtenemos el registro
    $item = dbFetchAssoc($result);

    // Cerramos la conexión
    dbClose($conn);

    // Devolvemos el registro obtenido
    return $item;
}

/**
 * Marca un registro como inactivo (soft delete).
 *
 * Esta función no borra realmente el registro en la base de datos, sino que lo marca como inactivo
 * cambiando el valor del campo active a 0.
 *
 * @param string $tableName El nombre de la tabla donde se marcará el registro.
 * @param string $idField El nombre del campo de ID de la tabla.
 * @param int $idValue El valor del ID del registro a marcar.
 */
function softDeleteFromTable($tableName, $idField, $idValue)
{
    // Conectamos a la base de datos
    $conn = dbConnect();

    // Preparamos la consulta SQL para marcar el registro como inactivo
    $sql = "UPDATE $tableName SET active = 0 WHERE $idField = $idValue";

    // Ejecutamos la consulta
    dbQuery($conn, $sql);

    // Cerramos la conexión
    dbClose($conn);
}
