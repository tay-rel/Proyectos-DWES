<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo e ($title)?>/title>
</head>
<body>
<h1>Usuarios</h1>
<ul>
    <?php
    foreach ($users as $user ):
    ?>
    <li><?php echo e($user) ?></li>
    <?php endforeach;?>
</ul>
</body>
</html>