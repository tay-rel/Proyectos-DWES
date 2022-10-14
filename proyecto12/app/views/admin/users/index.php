<?php include_once(VIEWS . 'header.php')?>
    <div class="card p-4 bg-light">
        <div class="card-header">
            <h1 class="text-center">Usuarios Administradores</h1>
        </div>
        <div class="card-body">
            <table class="table text-center" width="100%">
                <thead>
                <th>Id</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Editar</th>
                <th>Borrar</th>
                </thead>
                <tbody>
                <?php foreach ($data['users'] as $user): ?>
                    <tr>
                        <td class="text-center"><?= $user->id ?></td>
                        <td class="text-center"><?= $user->name ?></td>
                        <td class="text-center"><?= $user->email ?></td>
                        <td class="text-center">
<<<<<<< HEAD
                            <a href="<?= ROOT ?>AdminUser/update<?= $user->id ?>"
                               class="btn btn-info"
                            >Editar</a>
                        </td>
                        <td class="text-center btn btn-danger">
                            <a href="<?= ROOT ?>AdminUser/delete<?= $user->id ?>"
=======
                            <a href="<?= ROOT ?>AdminUser/update/<?= $user->id ?>"
                               class="btn btn-info"
                            >Editar</a>
                        </td>
                        <td class="text-center">
                            <a href="<?= ROOT ?>AdminUser/delete/<?= $user->id ?>"
>>>>>>> e726dd6c1ff450fc85dfbcecc0fd97a078d68702
                               class="btn btn-danger"
                            >Borrar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-6">
                    <a href="<?= ROOT ?>AdminUser/create" class="btn btn-success">
                        Crear Usuario
                    </a>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>
<?php include_once(VIEWS . 'footer.php')?>