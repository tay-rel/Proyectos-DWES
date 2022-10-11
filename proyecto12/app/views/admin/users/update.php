
<?php include_once(VIEWS . 'header.php')?>
<div class="card p-4 bg-light">
    <div class="card-header">
        <h1 class="text-center">Edición de un usuario administrador</h1>
    </div>
    <div class="card-body">
        <form action="<?= ROOT ?>AdminUser/update/<?= $data['data']->id ?>" method="POST">
            <div class="form-group text-left">
                <label for="name">Usuario:</label>
                <input type="text" name="name" class="form-control"
                       placeholder="Escribe tu nombre completo" required
                       value="<?= $data['data']->name ?? '' ?>"
                >
            </div>
            <div class="form-group text-left">
                <label for="email">Correo Electrónico:</label>
                <input type="email" name="email" class="form-control"
                       placeholder="Escribe el correo electrónico" required
                       value="<?= $data['data']->email ?? '' ?>"
                >
            </div>
            <div class="form-group text-left">
                <label for="password1">Clave de acceso: (dejar en blanco si no desea modificarla)</label>
                <input type="password" name="password1" class="form-control"
                       placeholder="Escribe tu contraseña">
            </div>
            <div class="form-group text-left">
                <label for="password2">Clave de acceso:</label>
                <input type="password" name="password2" class="form-control"
                       placeholder="Repite tu contraseña">
            </div>
            <div class="form-group">
                <label for="status">Selecciona un estado</label><!--El estado debe tener memoria-->
                <select name="status" id="status" class="form-control">
                    <option value="">Selecciona el estado del usuario</option>
                    <?php foreach($data['status'] as $status): ?><!--gENERA DOS ELEMENTOS ACTIVO E INACTIVO-->
                        <option value="<?= $status->value ?>"<?= $status->value == $data['data'] -> status ? ' selected' : '' ?> ><?= $status->description ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group text-left">
                <input type="submit" value="Enviar" class="btn btn-success">
                <a href="<?= ROOT ?>AdminUser" class="btn btn-info">Regresar</a>
            </div>
        </form>
    </div>
    <div class="card-footer">

    </div>
</div>
<?php include_once(VIEWS . 'footer.php')?>