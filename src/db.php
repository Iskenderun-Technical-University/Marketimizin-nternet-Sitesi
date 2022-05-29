<?php

try {
    $db = new PDO(
        'mysql:host=' . $config['DB_HOST'] . ';dbname=' . $config['DB_NAME'] . ';charset=' . $config['DB_CHARSET'],
        $config['DB_USER'],
        $config['DB_PASS']
    );
} catch (Exception $e) {
    echo '<h1>Veritabanı bağlantısı sağlanamadı.</h1>';
    echo '<p>Hata: ' . $e->getMessage() . '</p>';
    die();
}

return $db;
