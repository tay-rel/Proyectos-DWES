
<?php include_once(VIEWS . 'header.php')?><!--Muestra los datos que va a borrar-->
<div class="card p-4 bg-light">
    <div class="card-header">
        <h1 class="text-center">Eliminacion ed un usuario administrador</h1>
    </div>
    <div class="card-body">
        <form action="<?= ROOT ?>AdminUser/delete/<?= $data['data']->id ?>" method="POST">
            <div class="form-group text-left">
                <label for="name">Usuario:</label>
                <input type="text" name="name" class="form-control"
                       placeholder="Escribe tu nombre completo" disabled<!--DEsabilitado apra el usauiro-->
                       value="<?= $data['data']->name ?? '' ?>"
                >
            </div>
            <div class="form-group text-left">
                <label for="email">Correo Electrónico:</label>
                <input type="email" name="email" class="form-control"
                       placeholder="Escribe el correo electrónico" disabled
                       value="<?= $data['data']->email ?? '' ?>"
                >
            </div>
            <div class="form-group">
                <label for="status">Selecciona un estado</label><!--El estado debe tener memoria-->
                <select name="status" id="status" class="form-control" disabled>
                    <option value="">Selecciona el estado del usuario</option>
                    <?php foreach($data['status'] as $status): ?><!--gENERA DOS ELEMENTOS ACTIVO E INACTIVO-->
                    <option value="<?= $status->value ?>"<?= $status->value == $data['data'] -> status ? ' selected' : '' ?> ><?= $status->description ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group text-left">
                <input type="submit" value="Enviar" class="btn btn-success">
                <a href="<?= ROOT ?>AdminUser" class="btn btn-info">Regresar</a>
                <p>Una vez borrado la informacion no sera recuperable</p>
            </div>
        </form>
    </div>
</div>
<?php include_once(VIEWS . 'footer.php');