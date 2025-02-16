<?php
$host = "mail.tecnoweb.org.bo";
$port = "5432";
$dbname = "db_grupo16sa";
$user = "grupo16sa";
$password = "grup016grup016*";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    echo "Error de conexión a PostgreSQL.";
} else {
    echo "Conexión exitosa a PostgreSQL.";
}
