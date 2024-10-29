<?php
    include 'config/functions.php';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="assets/img/favicon.png">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <title>QR Integrado</title>
    </head>

    <body>
    <?php
        // Ruta del archivo que guardará el último IDC generado
        $archivoIDC = 'ultimo_idc.txt';

        // Verificar si el archivo existe, si no, inicializarlo con 1000000
        if (!file_exists($archivoIDC)) {
            file_put_contents($archivoIDC, '1000000');
        }

        // Leer el último IDC generado desde el archivo
        $ultimoIDC = (int)file_get_contents($archivoIDC);

        // Incrementar el IDC en 1
        $nuevoIDC = $ultimoIDC + 1;

        // Guardar el nuevo IDC en el archivo
        file_put_contents($archivoIDC, $nuevoIDC);
    ?>
        <div class="p-3 mb-2 bg-primary text-white">
            <h1><center><b>QR INTEGRADO</b></center></h1>
        </div>
        <br>
        <form action="<?php echo BASE_PROJECT_URL; ?>boton.php" method="POST">
            <div class="content">
                <div class="container mt-3">
                    <div class="card">
                        <div class="card-header" style="text-align: center;" >       
                            Configuración General de QR Integrado
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="environment" class="bold-label">Entorno (*)</label>
                                        <select name="environment" id="environment" class="form-control transparent-select" required class="bold-label">
                                            <option value="T" selected>Test</option>
                                            <option value="P">Producción</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="merchantId" class="bold-label">Código comercio (*)</label>
                                        <input type="text" name="merchantId" id="merchantId" class="form-control transparent-input" required value="750005733">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="user" class="bold-label">Usuario (*)</label>
                                        <input type="text" name="user" id="user" class="form-control transparent-input" required value="integraciones.visanet@necomplus.com">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="password" class="bold-label">Contraseña (*)</label>
                                        <input type="text" name="password" id="password" class="form-control transparent-input" required value="d5e7nk$M">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                    <label for="currency" class="bold-label">Moneda(*)</label>
                                        <select name="currency" id="currency" class="form-control transparent-select" required>
                                            <option value="604" selected >Soles</option>
                                            <option value="840" >Dólares</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tipoqr" class="bold-label">Tipo de QR(*)</label>
                                        <select name="tipoqr" id="tipoqr" class="form-control transparent-select" required>
                                            <option value="STATIC" >Estático</option>
                                            <option value="DYNAMIC" >Dinámico</option>
                                            <option value="PF Estatico" >PF Estático</option>
                                            <option value="PF Dinamico" >PF Dinámico</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="amount" class="bold-label">Importe (*)</label>
                                        <input type="number" name="amount" id="amount" class="form-control transparent-input" step=".01" required value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="adicional" class="bold-label transparent-input">Información adicional (*)</label>
                                        <input type="text" name="adicional" id="adicional"
                                            class="form-control transparent-input" required value="prueba">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php
                                            // Obtener la fecha actual y sumar 3 días
                                            $fechaVencimiento = date('dmY', strtotime('+3 days'));
                                        ?>
                                        <label for="fecha" class="bold-label">Fecha</label>
                                        <input type="text" name="fecha" id="fecha" class="form-control transparent-input" value="<?php echo $fechaVencimiento; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="idc" class="bold-label">IDC-Dinámico </label>
                                        <input type="text" name="idc" id="idc" class="form-control transparent-input" value="<?php echo str_pad($nuevoIDC, 7, '0', STR_PAD_LEFT); ?>">
                                    </div>
                                </div>
                                <div class="container mt-3">
                                    <div class="card">
                                        <div class="card-header" style="text-align: center;" >       
                                                QR INTEGRADO PF
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="merchantId2" class="bold-label">Código de Sponsor (*) </label>
                                                        <input type="text" name="merchantId2" id="merchantId2" class="form-control transparent-input" value="202021802">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="name" class="bold-label">Nombre Comercio</label>
                                                        <input type="text" name="name" id="name" class="form-control transparent-input" value="Niubiz brando">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="mcci" class="bold-label">MCCI</label>
                                                        <input type="text" name="mcci" id="mcci" class="form-control transparent-input" value="5732">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="address" class="bold-label">Dirección</label>
                                                        <input type="text" name="address" id="address" class="form-control transparent-input" value="Av. Brand Vargas 27">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="phone" class="bold-label">Celular</label>
                                                        <input type="text" name="phone" id="phone" class="form-control transparent-input" value="977456123">
                                                    </div>
                                                </div>
                                            </div>               
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <label>&nbsp;</label>
                                    <div class="centered-buttons">
                                        <button type="submit" class="btn btn-primary mr-2">Enviar >></button>
                                        <a href="https://docs.google.com/spreadsheets/d/1Du0hh3NBj3i6DQs1T4VMhM901gJ3UvwEejx-4XfS2Wk/edit#gid=0" class="btn btn-success" target="_blank">Código de pruebas</a>
                                        <a href="https://drive.google.com/file/d/1S2N6ZiXzaIU1m9b5de5rFZYpFIZ-_Gpo/view?usp=drive_link" class="btn btn-danger" target="_blank">Manual QR Integrado</a>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </form>
        <footer style="display: flex; justify-content: center; align-items: center; height: 100px;">Necomplus - Niubiz</footer>
    </body>
</html>