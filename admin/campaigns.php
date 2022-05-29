<?php

require_once '../init.php';
require_once '../src/admin.php';

include 'partial/head.php';
include 'partial/header.php';

$stmt = $db->prepare("SELECT * FROM campaigns ORDER BY id DESC");
$stmt->execute();
$campaigns = $stmt->fetchAll(PDO::FETCH_ASSOC);

$types = [
    1 => 'Slider',
    2 => 'Ürün Altı',
];

?>

<div class="mt-4">
    <div class="container">
        <div class="mb-4 text-right">
            <a href="campaign-add.php" class="btn btn-info">Kampanya Ekle</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Afiş</th>
                    <th scope="col">Tip</th>
                    <th scope="col">Kapmanya</th>
                    <th scope="col">Link</th>
                    <th scope="col">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($campaigns as $campaign) { ?>
                    <tr>
                        <th scope="row"><?php echo $campaign['id'] ?></th>
                        <td>
                            <img src="../uploads/<?php echo $campaign['image'] ?>" width="200" alt="">
                        </td>
                        <td><?php echo $types[$campaign['type']] ?></td>
                        <td><?php echo $campaign['name'] ?></td>
                        <td>
                            <?php if ($campaign['link']) { ?>
                                <a href=" <?php echo $campaign['link'] ?>" target="_blank"><?php echo $campaign['link'] ?></a>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="campaign-edit.php?id=<?php echo $campaign['id'] ?>" class="btn btn-primary">Düzenle</a>
                            <a href="delete.php?table=campaigns&id=<?php echo $campaign['id'] ?>" class="btn btn-danger">Sil</a>
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