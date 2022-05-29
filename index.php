<?php
require_once 'init.php';

include 'partial/head.php';
include 'partial/header.php';

$stmt = $db->prepare("SELECT * FROM products ORDER BY id DESC");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->prepare("SELECT * FROM campaigns WHERE type = 1 ORDER BY id DESC");
$stmt->execute();
$slides = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->prepare("SELECT * FROM campaigns WHERE type = 2 ORDER BY id DESC");
$stmt->execute();
$banners = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div id="home-banner" class="mt-4 mb-4">
    <div class="container">
        <div id="homeBannerCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php $i = 0; ?>
                <?php foreach ($slides as $slide) { ?>
                    <div class="carousel-item <?php if ($i == 0) { ?>active<?php } ?>">
                        <img src="uploads/<?php echo $slide['image'] ?>" class="d-block w-100" alt="">
                    </div>
                    <?php $i++; ?>
                <?php } ?>
            </div>
            <ol class="carousel-indicators">
                <?php $i = 0; ?>
                <?php foreach ($slides as $slide) { ?>
                    <li data-target="#homeBannerCarousel" data-slide-to="<?php echo $i ?>" <?php if ($i == 0) { ?>class="active" <?php } ?>></li>
                    <?php $i++; ?>
                <?php } ?>
            </ol>
            <button class="carousel-control-prev" type="button" data-target="#homeBannerCarousel" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Önceki Slayt</span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#homeBannerCarousel" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Sonraki Slayt</span>
            </button>
        </div>
    </div>
</div>

<div id="home-products" class="mb-4">
    <div class="container">
        <div class="products">
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-4 row-cols-xl-5">
                <?php foreach ($products as $product) { ?>
                    <div class="col">
                        <div class="product card">
                            <img src="uploads/<?php echo $product['image'] ?>" alt="<?php echo $product['name'] ?>">
                            <h5 class="title">
                                <a href="product.php?id=<?php echo $product['id'] ?>" class="stretched-link"><?php echo $product['name'] ?></a>
                            </h5>
                            <span class="price"><?php echo $product['price'] ?> TL</span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div id="home-campaigns" class="mb-4">
    <div class="container">
        <div class="row">
            <?php foreach ($banners as $banner) { ?>
                <div class="col-md-6 mb-4">
                    <a href="<?php echo ($banner['link'] ?? 'javascript:void(0)') ?>">
                        <img src="uploads/<?php echo $banner['image'] ?>" class="img-fluid" alt="<?php echo $banner['name'] ?>">
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
include 'partial/footer.php';
?>