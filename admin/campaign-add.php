<?php

require_once '../init.php';
require_once '../src/admin.php';

include 'partial/head.php';
include 'partial/header.php';

if ($_POST) {
    $name = trim($_POST['name']);
    $link = trim($_POST['link']);
    $type = trim($_POST['type']);

    $alerts = [];

    if (empty($name)) {
        $alerts[] = [
            'type' => 'danger',
            'message' => 'Kampanya ismi boş olamaz.'
        ];
    }

    if (empty($link)) {
        $link = null;
    }

    if (empty($_FILES["image"]["name"])) {
        $alerts[] = [
            'type' => 'danger',
            'message' => 'Kampanya resmi boş olamaz.'
        ];
    } else {
        $targetDir = "../uploads/";
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $image = $fileName;
        } else {
            $alerts[] = [
                'type' => 'danger',
                'message' => 'Kampanya resmi yüklenirken bir hata oluştu.'
            ];
        }
    }

    if (empty(array_filter($alerts, 'array_filter'))) {
        $stmt = $db->prepare("INSERT INTO campaigns(name, image, link, type) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$name, $image, $link, $type])) {
            $alerts[] = [
                'type' => 'success',
                'message' => 'Kampanya başarıyla eklendi. Lütfen bekleyin, yönlendiriliyorsunuz...'
            ];

            header('refresh:2;url=campaigns.php');
        } else {
            $alerts[] = [
                'type' => 'danger',
                'message' => 'Kampanya eklenirken veritabanı hatası oluştu. Lütfen tekrar deneyiniz.'
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
        <form method="POST" enctype="multipart/form-data" action="">
            <div class="form-group">
                <label for="type">Kampanya Tipi</label>
                <select class="form-control" name="type" id="type">
                    <option value="1" <?php echo ($_POST['type'] ?? null) === 1 ? 'selected' : '' ?>>Slider</option>
                    <option value="2" <?php echo ($_POST['type'] ?? null) === 2 ? 'selected' : '' ?>>Ürün Altı</option>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Kampanya İsmi</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $_POST['name'] ?? "" ?>">
            </div>
            <div class="form-group">
                <label for="image">Kampanya Görseli</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <div class="form-group">
                <label for="link">Kampanya Linki</label>
                <input type="text" class="form-control" id="link" name="link" value="<?php echo $_POST['link'] ?? "" ?>">
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