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
                <?php foreach ($data['data'] as $user ) : ?>
                    <tr>
                        <td class="text-center"><?= $user->id ?></td>
                        <td class="text-center"><?= $user->name ?></td>
                        <td class="text-center"><?= $user->email ?></td>
                    </tr>

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