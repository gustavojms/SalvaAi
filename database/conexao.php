<?php

session_start();

    // $localhost = "localhost";
    // $user = "root";
    // $password = "12345678";
    // $banco = "ped1";
    // global $pdo;

    // try {
    //     $pdo = new PDO("mysql:dbname=".$banco."; host =".$localhost, $user, $password);
    //     $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // } catch (PDOException $e) {
    //     echo "ERRO: " .$e -> getMessage();
    //     exit;
    // }

    $dsn = 'mysql:host=127.0.0.1;dbname=ped1;port=3306';
    $pdo = new PDO($dsn, 'root', '@drfla0005');
?>
