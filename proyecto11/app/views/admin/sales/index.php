<?php include_once(VIEWS . 'header.php')?>

    <div class="card p-4 bg-light">
        <div class="card-header">
            <h1 class="text-center">Registro venta de Productos</h1>
        </div>
        <div class="card-body">
            <table class="table table-stripped" width="100%">
                <tr>
                    <th>ID-</th>
                    <th>Nombre Usuario</th>
                    <th>ID-</th>
                    <th>Producto</th>
                    <th>Precio/th>
                    <th>Cantidad</th>
                    <th>Descuento</th>
                    <th>Envio</th>
                    <th>Total</th>
                    <th>Fecha de pago </th>
                </tr>

                <tbody>
                <?php foreach ($data['carrito'] as $carrito): ?>
                    <tr>
                        <td class="text-center"><?= $carrito->ID ?></td>
                        <td class="text-center"><?= $carrito->Nombre ?></td>
                        <td class="text-center"><?= $carrito->ID ?></td>
                        <td class="text-center"><?= $carrito->Producto ?></td>
                        <td class="text-center"><?= $carrito->Precio?></td>
                        <td class="text-center"><?= $carrito->Cantidad?></td>
                        <td class="text-center"><?= $carrito->Descuento?></td>
                        <td class="text-center"><?= $carrito->Envio?></td>
                        <td class="text-center"><?= $carrito->Total?></td>
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