<?php include_once(VIEWS . 'header.php')?>
    <div class="card p-4 bg-light">
        <div class="card-header">
            <h1 class="text-center">Registro venta de Productos</h1>
        </div>
        <div class="card-body">
            <table class="table table-stripped" width="100%">
                <tr>
                    <th>ID user</th>
                    <th>ID producto</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Total pagado</th>
                </tr>
                <?php foreach ($data['data'] as $key => $value) : ?>
                    <tr>
                        <td><b><?= $value->name ?></b><?= substr(html_entity_decode($value->description),0,200) ?>...</td>
                        <td class="text-right"><?= number_format($value->quantity,0) ?></td>
                        <td class="text-right"><?= number_format($value->price,2) ?> &euro;</td>
                        <td class="text-right"><?= number_format($value->price * $value->quantity,2) ?> &euro;</td>
                    </tr>
                    <?php $subtotal += $value->price * $value->quantity; $discount += $value->discount; $send += $value->send ?>
                <?php endforeach ?>
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