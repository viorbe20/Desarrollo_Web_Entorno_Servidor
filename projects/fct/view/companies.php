<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Virginia Ordoño Bernier">
    <link rel='stylesheet' href="http://localhost/dwes/projects/fct/assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="http://localhost/dwes/projects/fct/assets/js/companies.js
    "></script>
    <script src="http://localhost/dwes/projects/fct/assets/js/header.js"></script>
    <title>FCT Companies</title>
</head>

<body>
    <?php
    require_once '../view/require/header.php';
    require_once '../view/require/modal_delete_company.php';
    ?>
    <!--Content-->
    <div class="container d-flex-column justify-content-center mt-5">
        <div id="form_search_company" class="d-flex justify-content-center" role="search">
            <!--Search company bar and icon-->
            <div class='d-flex w-50 mx-5'>
                <input name="input_search_company" id="input_search_company" class="form-control" type="text" placeholder="Buscar empresa">
            </div>
        </div>

        <section class='d-flex justify-content-lg-end my-2 mt-5'>
            <a href="<?php echo DIRBASEURL; ?>/companies/add_company" class="btn btn-primary mx-1">Nueva Empresa</a>
        </section>


        <!--Table with las 5 last inserted companies from js-->
        <table id="table-companies" class="table text-center mt-1">
            <thead>
                <tr>
                    <th scope="col">Logo</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Empleados</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody class="table-group-divider" id="table_body_companies">
            </tbody>
        </table>

    </div>
</body>

</html>