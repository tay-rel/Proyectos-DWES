<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$data['titulo'] ?></title>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

    <!-- JavaScript Bundle with Popper -->
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a href="<?=ROOT?>" class="navbar-brand">Tienda</a>
    <div class="collapse navbar-collapse" id="menu">
        <!-- Enlaces del menu -->
        <?php if($data['menu']): ?>
            <!-- UBicacion del menu para usuarios logueados-->
        <?php endif; ?>
        <!-- Codigo html para el menu -->
    </div>
</nav>
<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-2">

        </div>
        <div class="col-sm-8">
            <?php if(isset($data['errors']) && count($data['errors']) > 0)  : ?>
            <div class="alert alert-danger mt-3">
                <ul class="list-group ">
                    <?php foreach ($data['errors'] as $value) : ?>
                   <li class="list-group-item alert alert-danger">
                       <strong><?= $value?></strong><br>
                   </li>
                    <?php endforeach;?>
                </ul>

            </div>
            <?php endif; ?>
