<?php include_once 'header.php'?>
<!--Desarrollamos el registro--->

<div class="card-4 bg-light">
    <div class="card-header">
        <h1 class="text-center">Registro</h1>
    </div>
    <div class="card-body">
        <form action="login/registro" method="post">
            <div class="form-group text-left">
                <label for="first_name">Nombre:</label>
                <input type="text" name="first_name" id="first_name" class="form-control"
                required placeholder="Escriba su nombre">
            </div>
            <div class="form-group text-left">
                <label for="last_name_1">Apellido 1:</label>
                <input type="text" name="last_name_1" id="last_name_1" class="form-control"
                       required placeholder="Escriba su apellido">
            </div>
            <div class="form-group text-left">
                <label for="last_name_2">Apellido 2:</label>
                <input type="text" name="last_name_2" id="last_name_2" class="form-control"
                       required placeholder="Escriba su apellido 2">
            </div>
            <div class="form-group text-left">
                <label for="email">Correo electronico:</label>
                <input type="text" name="email" id="email" class="form-control"
                       required placeholder="Escriba su correo">
            </div>
            <div class="form-group text-left">
                <label for="password">Clave de acceso:</label>
                <input type="text" name="password" id="password" class="form-control"
                       required placeholder="Escriba su contraseña">
            </div>
            <div class="form-group text-left">
                <label for="password2">Repita su clave de acceso:</label>
                <input type="text" name="password2" id="password2" class="form-control"
                       required placeholder="Repita su contraseña">
            </div>
            <div class="form-group text-left">
                <label for="address">Direccion:</label>
                <input type="text" name="address" id="address" class="form-control"
                       required placeholder="Escriba su direccion">
            </div>
            <div class="form-group text-left">
                <label for="city">Ciudad:</label>
                <input type="text" name="city" id="city" class="form-control"
                       required placeholder="Escriba su ciudad">
            </div>
            <div class="form-group text-left">
                <label for="state">Provincia:</label>
                <input type="text" name="state" id="state" class="form-control"
                       required placeholder="Escriba su provincia">
            </div>
            <div class="form-group text-left">
                <label for="cod_post">Codigo postal:</label>
                <input type="text" name="cod_post" id="cod_post" class="form-control"
                       required placeholder="Escriba su codigo postal">
            </div>
            <div class="form-group text-left">
                <label for="country">Pais:</label>
                <input type="text" name="country" id="country" class="form-control"
                       required placeholder="Escriba su pais">
            </div>
            <div class="form-group text-left">
                <input type="submit" name="enviar datos" class="btn btn-success">
                <a href="login/" class="btn btn-info">Cancelar</a>
            </div>
        </form>
    </div>
</div>



<?php include_once 'footer.php'?>
