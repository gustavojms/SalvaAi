<?php

session_start();

    $localhost = "localhost";
    $user = "root";
    $password = "20121b6-rc0246";
    $banco = "ped1";
    global $pdo;

    try {
        $pdo = new PDO("mysql:dbname=".$banco."; host =".$localhost, $user, $password);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "ERRO: " .$e -> getMessage();
        exit;
    }
?>