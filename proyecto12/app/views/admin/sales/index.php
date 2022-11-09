<?php include_once(VIEWS . 'header.php')?>

    <div class="card p-4 bg-light">
        <div class="card-header">
            <h1 class="text-center">Registro venta de Productos</h1>
        </div>
        <div class="card-body">
            <table class="table table-stripped" width="100%">
                <tr>
                    <th>ID user</th>
                    <th>Nombre Usuario</th>
                    <th>ID producto</th>
                    <th>Nombre Producto</th>
                    <th>Fecha de pago</th>
                    <th>Total pagado</th>
                </tr>

                <tbody>
                <?php foreach ($data['carrito'] as $carrito): ?>
                    <tr>
                        <td class="text-center"><?= $carrito->userId ?></td>
                        <td class="text-center"><?= $carrito->userName ?></td>
                        <td class="text-center"><?= $carrito->productId ?></td>
                        <td class="text-center"><?= $carrito->nameProduct ?></td>
                        <td class="text-center"><?= $carrito->datePay?></td>

                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>
<?php include_once(VIEWS . 'footer.php')?>