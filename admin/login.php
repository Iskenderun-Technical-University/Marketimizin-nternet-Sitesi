<?php

require_once '../init.php';

if ($_POST) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $db->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user'] = $user['username'];
        header('Location: products.php');
    } else {
        $message =  'Kullanıcı adı veya şifre yanlış.';
    }
}

include 'partial/head.php';
?>

<div class="d-flex align-items-center justify-content-center" style="height: 100%;">
    <form method="POST" action="">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="username">Kullanıcı Adı</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?php echo $_POST['username'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <label for="password">Şifre</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <?php if (isset($message) && !empty($message)) { ?>
                    <div class="form-group text-danger">
                        <?php echo $message ?>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Giriş Yap</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php
include 'partial/footer.php';
?>