<?php

session_start();

$host = "localhost";
$user = "root";
$password = "";
$banco = "salvaai";
global $pdo;

try {
    $pdo = new PDO("mysql:dbname=" . $banco . "; host =" . $host, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "ERRO: " . $e->getMessage();
    exit;
}

$dsn = 'mysql:host=' . $host . ';dbname=' . $banco . ';port=3306';
$pdo = new PDO($dsn, $user, $password);
