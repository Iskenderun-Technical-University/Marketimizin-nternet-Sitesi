<?php

require_once '../init.php';
require_once '../src/admin.php';

include 'partial/head.php';
include 'partial/header.php';

$id = $_GET['id'] ?? null;

if (!empty($id) && is_numeric($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM campaigns WHERE id = ?");
    $stmt->execute([$id]);
    $campaign = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$campaign) {
        $alerts[] = [
            'type' => 'danger',
            'message' => 'Gönderiken kategori kodu ile eşleşen veri bulunamadı. Kategoriler sayfasına yönlendiriliyorsunuz.'
        ];

        header('refresh:2;url=campaigns.php');
    }
} else {
    $alerts[] = [
        'type' => 'danger',
        'message' => 'Gönderilen kategori kodu yanlış. Kategoriler sayfasına yönlendiriliyorsunuz.'
    ];

    header('refresh:2;url=campaigns.php');
}

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

    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "../uploads/";
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $image = $fileName;
        } else {
            $alerts[] = [
                'type' => 'danger',
                'message' => 'Ürün resmi yüklenirken bir hata oluştu.'
            ];
        }
    } else {
        $image = $campaign['image'];
    }

    if (empty(array_filter($alerts, 'array_filter'))) {
        $stmt = $db->prepare("UPDATE campaigns SET name = ?, image = ?, link = ?, type = ? WHERE id = ?");
        if ($stmt->execute([$name, $image, $link, $type, $id])) {
            $alerts[] = [
                'type' => 'success',
                'message' => 'Kampanya başarıyla düzenlendi. Lütfen bekleyin, yönlendiriliyorsunuz...'
            ];

            header('refresh:2;url=campaigns.php');
        } else {
            $alerts[] = [
                'type' => 'danger',
                'message' => 'Kampanya düzenlenirken veritabanı hatası oluştu. Lütfen tekrar deneyiniz.'
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

        <?php if (isset($campaign) && $campaign) { ?>
            <form method="POST" enctype="multipart/form-data" action="">
                <div class="form-group">
                    <label for="type">Kampanya Tipi</label>
                    <select class="form-control" name="type" id="type">
                        <option value="1" <?php echo ($_POST['type'] ?? $campaign['type'] ?? null) == 1 ? 'selected' : '' ?>>Slider</option>
                        <option value="2" <?php echo ($_POST['type'] ?? $campaign['type'] ?? null) == 2 ? 'selected' : '' ?>>Ürün Altı</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Kampanya İsmi</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $_POST['name'] ?? $campaign['name'] ?? "" ?>">
                </div>
                <div class="form-group">
                    <label for="image">Kampanya Görseli</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <div class="form-group">
                    <label for="link">Kampanya Linki</label>
                    <input type="text" class="form-control" id="link" name="link" value="<?php echo $_POST['link'] ?? $campaign['link'] ?? "" ?>">
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