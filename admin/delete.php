<?php

require_once '../init.php';
require_once '../src/admin.php';

$table = $_GET['table'] ?? null;
$id = $_GET['id'] ?? null;

if (!empty($table) && !empty($id) && is_numeric($id)) {
    switch ($table) {
        case 'categories':
            $stmt = $db->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->execute([$id]);
            $stmt = $db->prepare("UPDATE products SET category_id = NULL WHERE category_id = ?");
            $stmt->execute([$id]);
            header('Location: categories.php');
            break;
        case 'campaigns':
            $stmt = $db->prepare("DELETE FROM campaigns WHERE id = ?");
            $stmt->execute([$id]);
            header('Location: campaigns.php');
            break;
    }
}
