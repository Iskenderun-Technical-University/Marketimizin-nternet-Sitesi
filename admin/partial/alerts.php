<?php if (isset($alerts) && !empty(array_filter($alerts, 'array_filter'))) { ?>
    <div class="mb-4">
        <?php foreach ($alerts as $alert) { ?>
            <div class="alert alert-<?php echo $alert['type'] ?>" role="alert">
                <?php echo $alert['message'] ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>