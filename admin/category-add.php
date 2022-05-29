<?php

require_once '../init.php';
require_once '../src/admin.php';

include 'partial/head.php';
include 'partial/header.php';

if ($_POST) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    $alerts = [];

    if (empty($name)) {
        $alerts[] = [
            'type' => 'danger',
            'message' => 'Kategori ismi boş olamaz.'
        ];
    }

    if (empty(array_filter($alerts, 'array_filter'))) {
        $stmt = $db->prepare("INSERT INTO categories(name, description) VALUES (?, ?)");
        if ($stmt->execute([$name, $description])) {
            $alerts[] = [
                'type' => 'success',
                'message' => 'Ürün başarıyla eklendi. Lütfen bekleyin, yönlendiriliyorsunuz...'
            ];

            header('refresh:2;url=categories.php');
        } else {
            $alerts[] = [
                'type' => 'danger',
                'message' => 'Ürün eklenirken veritabanı hatası oluştu. Lütfen tekrar deneyiniz.'
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
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Kategori İsmi</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $_POST['name'] ?? "" ?>">
            </div>
            <div class="form-group">
                <label for="description">Kategori Açıklaması</label>
                <textarea class="form-control" id="description" name="description" rows="4"><?php echo $_POST['description'] ?? "" ?></textarea>
            </div>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Gönder</button>
            </div>
        </form>
    </div>
</div>

<?php
include 'partial/footer.php';
?>