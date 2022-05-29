<?php

require_once '../init.php';
require_once '../src/admin.php';

include 'partial/head.php';
include 'partial/header.php';

$stmt = $db->prepare("SELECT * FROM products ORDER BY id DESC");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="mt-4">
    <div class="container">
        <div class="mb-4 text-right">
            <a href="product-add.php" class="btn btn-info">Ürün Ekle</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ürün Görseli</th>
                    <th scope="col">Ürün İsmi</th>
                    <th scope="col">Ürün Fiyatı</th>
                    <th scope="col">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) { ?>
                    <tr>
                        <th class="align-middle" scope="row"><?php echo $product['id'] ?></th>
                        <td class="align-middle">
                            <?php if ($product['image']) { ?>
                                <img src="../uploads/<?php echo $product['image'] ?>" class="img-fluid" width="100" alt="">
                            <?php } ?>
                        </td>
                        <td class="align-middle"><?php echo $product['name'] ?></td>
                        <td class="align-middle"><?php echo $product['price'] ?> TL</td>
                        <td class="align-middle">
                            <a href="product-edit.php?id=<?php echo $product['id'] ?>" class="btn btn-primary">Düzenle</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include 'partial/footer.php';
?>