<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

    <!-- CSS query -->
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

</head>
<body>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a href="index.php" class="navbar-brand">Tienda</a>
    </nav>

    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-2">

            </div>
            <div class="col-sm-8">
                <form >
                    <table>
                        <tr>
                            <td>Usuario:</td>
                            <td><input type="text" name="user"></td>
                        </tr>
                        <tr>
                            <td>Clave de acceso:</td>
                            <td><input type="password" name="password"></td>
                        </tr>
                        <tr>
                            <td>&nbsp</td>
                            <td><input type="submit" name="enviar"></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="col-sm-2">

            </div>

        </div>
    </div>


</body>
</html>