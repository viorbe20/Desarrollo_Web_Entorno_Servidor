<?php
require_once 'config/config.php';
require_once 'lib/myutils.php';


//Recuperate session variables
session_start();
$_SESSION['tickets_info'] = array();

//Click on purchase confirmation button
if (isset($_POST['btn_confirm_purchase']) && (!empty($_SESSION['cart']['purchase']))) {
    
    $ticket_file = fopen("ticket.txt", "a") or die("Error al abrir el archivo de tickets");
    $ticket_file_content = "";
    $ticket_file_content .= "Usuario: " . $_SESSION['cart']['username'] . "\n";
    $ticket_file_content .= "Fecha: " . date("d/m/Y") . "\n";
    $ticket_file_content .= "Hora: " . date("H:i:s") . "\n";
    $ticket_file_content .= "----------------------------------------\n";
    $ticket_file_content .= "Entradas compradas: \n";
    $ticket_file_content .= "----------------------------------------\n";
    $total = 0;
    foreach ($_SESSION['cart']['purchase'] as $key => $value) {
        foreach ($value['tickets'] as $key => $seatNumber) {
            $ticket_file_content .= "Equipo rival: " . $value['team'] . "\n";
            $ticket_file_content .= "Zona: " . $value['zone'] . "\n";
            $ticket_file_content .= "Localidad: " . $seatNumber . "\n";
            $ticket_file_content .= "Precio: " . $value['price']. "\n";
            $ticket_file_content .= "----------------------------------------\n";
            $total += $value['price'];
            }
        }
    $ticket_file_content .= "Total: " . $total . "€\n";

    fwrite($ticket_file, $ticket_file_content);
    fclose($ticket_file);

    //Clear cart
    $_SESSION['cart']['purchase'] = array();

}

//If user is not logged, redirect to login page
if (!isset($_SESSION['user']['profile']) || $_SESSION['user']['profile'] == 'guest') {
    header('location: login.php');
} else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel='stylesheet' href="./assets/css/styles.css">
        <link rel='stylesheet' href="./assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <title>Pokemons Basket Club</title>
    </head>

    <body>
        <header>
            <h1 id='h1_general' class="text-bg-dark p-1 text-center m-0">Pokemons Basket Club</h1>
        </header>
        <a href="logout.php">Cerrar sesión</a>

        <!--Navigation bar-->
        <?php
        require_once 'require/navBar.php';
        ?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="form_cart">
        <?php
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Equipo Rival</th>
                                        <th scope="col">Zona</th>
                                        <th scope="col">Localidad</th>
                                        <th scope="col">Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        $total = 0;
                                        foreach ($_SESSION['cart']['purchase'] as $key => $value) {
                                            foreach ($value['tickets'] as $key => $seatNumber) {
                                                print('<td>' . $value['team'] . '</td>');
                                                print('<td>' . $value['zone'] . '</td>');
                                                print('<td>' . $seatNumber . '</td>');
                                                print('<td>' . $value['price'] . '</td>');
                                                $total += $value['price'];
                                                echo '</tr>';
                                            }
                                        }
                                        ?>

                                </tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="p-3 bg-secondary text-white">Total</td>
                                    <td class="p-3 bg-secondary text-white"><?php echo $total; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!--Confirmation-->
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" name="btn_confirm_purchase">Confirmar compra</button>
                        </div>
                    </div>
                </form>
                
                
                </body>
                
                </html>
<?php
}
?>