<?php

require_once '../init.php';
require_once '../src/admin.php';

include 'partial/head.php';
include 'partial/header.php';

$id = $_GET['id'] ?? null;

if (!empty($id) && is_numeric($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$category) {
        $alerts[] = [
            'type' => 'danger',
            'message' => 'Gönderiken kategori kodu ile eşleşen veri bulunamadı. Kategoriler sayfasına yönlendiriliyorsunuz.'
        ];

        header('refresh:2;url=categories.php');
    }
} else {
    $alerts[] = [
        'type' => 'danger',
        'message' => 'Gönderilen kategori kodu yanlış. Kategoriler sayfasına yönlendiriliyorsunuz.'
    ];

    header('refresh:2;url=categories.php');
}

if ($_POST) {
    $name = trim($_POST['name']) ?? $category['name'];
    $description = trim($_POST['description']) ?? $category['description'];

    $alerts = [];

    if (empty($name)) {
        $alerts[] = [
            'type' => 'danger',
            'message' => 'Kategori ismi boş olamaz.'
        ];
    }

    if (empty(array_filter($alerts, 'array_filter'))) {
        $stmt = $db->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
        if ($stmt->execute([$name, $description, $category['id']])) {
            $alerts[] = [
                'type' => 'success',
                'message' => 'Ürün başarıyla düzenlendi. Lütfen bekleyin, yönlendiriliyorsunuz...'
            ];

            header('refresh:2;url=categories.php');
        } else {
            $alerts[] = [
                'type' => 'danger',
                'message' => 'Ürün düzenlenirken veritabanı hatası oluştu. Lütfen tekrar deneyiniz.'
            ];
            $alerts[] = [
                'type' => 'info',
                'message' => 'Veritabanı hata mesajı: ' . $stmt->errorInfo()[2]
            ];
        }
    }
}

?>


<div class="mt-4">
    <div class="container">
        <?php include 'partial/alerts.php'; ?>

        <?php if (isset($category) && $category) { ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Kategori İsmi</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $_POST['name'] ?? $category['name'] ?? "" ?>">
                </div>
                <div class="form-group">
                    <label for="description">Kategori Açıklaması</label>
                    <textarea class="form-control" id="description" name="description" rows="4"><?php echo $_POST['description'] ?? $category['description'] ?? "" ?></textarea>
                </div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">Gönder</button>
                </div>
            </form>
        <?php } ?>
    </div>
</div>

<?php
include 'partial/footer.php';
?>