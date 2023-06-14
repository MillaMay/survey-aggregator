<?php

spl_autoload_register(function ($className) {
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $classFile = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $className . '.php';
    if (file_exists($classFile)) {
        require_once $classFile;
    }
});

try {
    $pdo = new PDO('mysql:host=localhost;dbname=survey-aggregator', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Ошибка подключения к базе данных: ' . $e->getMessage();
    exit();
}
