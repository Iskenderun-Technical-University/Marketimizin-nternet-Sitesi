<?php
require_once 'init.php';

include 'partial/head.php';
include 'partial/header.php';

$id = $_GET['id'] ?? null;

$stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $db->prepare("SELECT * FROM products WHERE id != ? ORDER BY RAND() LIMIT 5");
$stmt->execute([$id]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div id="product" class="mt-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <img src="uploads/<?php echo $product['image'] ?>" class="img-fluid" alt="<?php echo $product['name'] ?>">
            </div>
            <div class="col-md-7 align-self-center">
                <h2><?php echo $product['name'] ?></h2>
                <p><?php echo $product['description'] ?></p>
                <p class="lead"><?php echo $product['price'] ?> TL</p>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                    <div class="d-flex">
                        <select name="count" id="count" class="form-control mr-2" style="width: 70px;">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                        <button class="btn btn-primary">Sepete Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="home-products" class="mb-4">
    <div class="container">
        <div class="products">
            <h2 class="text-center text-success mb-4">Diğer Ürünler</h2>
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

<?php
include 'partial/footer.php';
?>