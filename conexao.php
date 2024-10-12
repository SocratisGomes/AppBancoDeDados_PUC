<?php

$serverName = "**************.windows.net";
$database = "**************";
$user = "********";
$pass = "********";

try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo"CONEXÃO REALIZADA";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
