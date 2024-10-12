<?php

$serverName = "eixo1.database.windows.net";
$database = "baseDeDadosEixo1";
$user = "grupo3";
$pass = "Eixo1puc";

try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo"CONEXÃO REALIZADA";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>