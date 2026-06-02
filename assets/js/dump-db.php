<?php
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=tdclassic;charset=utf8mb4", "root", "1");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query("SELECT post_content FROM wp_posts WHERE post_status = 'publish'");
    $contents = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    file_put_contents(__DIR__ . '/../db-content.txt', implode(PHP_EOL, $contents));
    echo "Successfully dumped " . count($contents) . " posts to assets/db-content.txt" . PHP_EOL;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
