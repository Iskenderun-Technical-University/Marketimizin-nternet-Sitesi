<?php

require_once '../init.php';
require_once '../src/admin.php';

include 'partial/head.php';
include 'partial/header.php';

$stmt = $db->prepare("SELECT * FROM categories ORDER BY name ASC");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_POST) {
    $category = trim($_POST['category']);
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $description = trim($_POST['description']);

    $alerts = [];

    if (!is_numeric($price)) {
        $alerts[] = [
            'type' => 'danger',
            'message' => 'Kategori geçersiz.'
        ];
    }

    if (empty($name)) {
        $alerts[] = [
            'type' => 'danger',
            'message' => 'Ürün ismi boş olamaz.'
        ];
    }

    if (!is_numeric($price)) {
        $alerts[] = [
            'type' => 'danger',
            'message' => 'Ürün fiyatı geçersiz.'
        ];
    }

    if (empty($_FILES["image"]["name"])) {
        $alerts[] = [
            'type' => 'danger',
            'message' => 'Ürün resmi boş olamaz.'
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
                'message' => 'Ürün resmi yüklenirken bir hata oluştu.'
            ];
        }
    }

    if (empty(array_filter($alerts, 'array_filter'))) {
        $stmt = $db->prepare("INSERT INTO products(category_id, name, price, image, description) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$category, $name, $price, $image, $description])) {
            $alerts[] = [
                'type' => 'success',
                'message' => 'Ürün başarıyla eklendi. Lütfen bekleyin, yönlendiriliyorsunuz...'
            ];

            header('refresh:2;url=products.php');
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
        <form method="POST" enctype="multipart/form-data" action="">
            <div class="form-group">
                <label for="category">Ürün Kategorisi</label>
                <select class="form-control" name="category" id="category">
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?php echo $category['id'] ?>" <?php echo ($_POST['category'] ?? null) === $category['id'] ? 'selected' : '' ?>><?php echo $category['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Ürün İsmi</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $_POST['name'] ?? "" ?>">
            </div>
            <div class="form-group">
                <label for="price">Ürün Fiyatı</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $_POST['price'] ?? "" ?>">
            </div>
            <div class="form-group">
                <label for="image">Ürün Görseli</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <div class="form-group">
                <label for="description">Ürün Açıklaması</label>
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