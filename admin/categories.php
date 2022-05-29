<?php

require_once '../init.php';
require_once '../src/admin.php';

include 'partial/head.php';
include 'partial/header.php';

$stmt = $db->prepare("SELECT * FROM categories ORDER BY id DESC");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="mt-4">
    <div class="container">
        <div class="mb-4 text-right">
            <a href="category-add.php" class="btn btn-info">Kategori Ekle</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kategori İsmi</th>
                    <th scope="col">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category) { ?>
                    <tr>
                        <th scope="row"><?php echo $category['id'] ?></th>
                        <td><?php echo $category['name'] ?></td>
                        <td>
                            <a href="category-edit.php?id=<?php echo $category['id'] ?>" class="btn btn-primary">Düzenle</a>
                            <a href="delete.php?table=categories&id=<?php echo $category['id'] ?>" class="btn btn-danger">Sil</a>
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