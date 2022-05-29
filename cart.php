<?php
require_once 'init.php';

include 'partial/head.php';
include 'partial/header.php';

$cart = json_decode($_COOKIE['cart'] ?? "", true) ?? [];

if ($_POST) {
    $id = $_POST['id'];
    $count = $_POST['count'];

    if ($count == 0) {
        unset($cart[$id]);
    } else {
        $cart[$id] = $count;
    }

    setcookie('cart', json_encode($cart), time() + (86400 * 30), '/');
}

if (!empty($cart)) {
    $in  = str_repeat('?,', count($cart) - 1) . '?';
    $stmt = $db->prepare("SELECT * FROM products WHERE id IN ($in)");
    $stmt->execute(array_keys($cart));
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $db->prepare("SELECT * FROM products ORDER BY RAND() LIMIT 5");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$total_count = 0;
$total = 0;

?>

<div class="mt-4">
    <div class="container">
        <?php if (!empty($cart)) { ?>
            <h2 class="text-center text-success font-weight-bold mb-4">Sepet</h2>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Ürün</th>
                        <th scope="col">Birim Fiyatı</th>
                        <th scope="col">Adet</th>
                        <th scope="col"></th>
                        <th scope="col">Tutar</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) { ?>
                        <tr>
                            <td class="align-middle" width="120">
                                <?php if ($product['image']) { ?>
                                    <img src="uploads/<?php echo $product['image'] ?>" class="img-fluid" width="100" alt="">
                                <?php } ?>
                            </td>
                            <td class="align-middle"><?php echo $product['name'] ?></td>
                            <td class="align-middle"><?php echo $product['price'] ?> TL</td>
                            <td class="align-middle">
                                <div class="mb-2"><?php echo $cart[$product['id']] ?></div>
                            </td>
                            <td class="align-middle" width="160">
                                <form method="POST" action="cart.php">
                                    <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                                    <select name="count" id="count" class="form-control form-control-sm mx-auto mb-2" style="width: 50px;">
                                        <option value="1" <?php echo $cart[$product['id']] == 1 ? 'selected' : '' ?>>1</option>
                                        <option value="2" <?php echo $cart[$product['id']] == 2 ? 'selected' : '' ?>>2</option>
                                        <option value="3" <?php echo $cart[$product['id']] == 3 ? 'selected' : '' ?>>3</option>
                                        <option value="4" <?php echo $cart[$product['id']] == 4 ? 'selected' : '' ?>>4</option>
                                        <option value="5" <?php echo $cart[$product['id']] == 5 ? 'selected' : '' ?>>5</option>
                                        <option value="6" <?php echo $cart[$product['id']] == 6 ? 'selected' : '' ?>>6</option>
                                        <option value="7" <?php echo $cart[$product['id']] == 7 ? 'selected' : '' ?>>7</option>
                                        <option value="8" <?php echo $cart[$product['id']] == 8 ? 'selected' : '' ?>>8</option>
                                        <option value="9" <?php echo $cart[$product['id']] == 9 ? 'selected' : '' ?>>9</option>
                                        <option value="10" <?php echo $cart[$product['id']] == 10 ? 'selected' : '' ?>>10</option>
                                    </select>
                                    <button type="submit" class="btn btn-warning btn-sm">Adedi Güncelle</button>
                                </form>
                            </td>
                            <?php
                            $total_count += $cart[$product['id']];
                            $total += $product['price'] * $cart[$product['id']];
                            ?>
                            <td class="align-middle"><?php echo $product['price'] * $cart[$product['id']] ?> TL</td>
                            <td class="align-middle" width="160">
                                <form method="POST" action="cart.php">
                                    <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                                    <input type="hidden" name="count" value="0">
                                    <button type="submit" class="btn btn-danger btn-sm">Sepetten Çıkar</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Toplam</th>
                        <th><?php echo $total_count ?></th>
                        <th></th>
                        <th><?php echo $total ?> TL</th>
                        <th></th>
                    </tr>
                </tbody>
            </table>
        <?php } else { ?>
            <h2 class="text-center text-success font-weight-bold mb-4">Sepetiniz Boş</h2>

            <div id="home-products" class="mb-4">
                <div class="container">
                    <div class="products">
                        <p class="text-center mb-4">Sizin için seçtiklerimiz</p>
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
        <?php } ?>
    </div>
</div>


<?php
include 'partial/footer.php';
?>