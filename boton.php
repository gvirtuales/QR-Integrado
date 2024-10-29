<?php
    // print_r($_POST);
    include 'config/functions.php';
    $environment = $_POST["environment"];
    $merchantId = $_POST["merchantId"];
    $user = $_POST["user"];
    $password = $_POST["password"];
    $amount = $_POST["amount"];
    $currency = $_POST["currency"];
    $adicional = $_POST["adicional"];
    $fecha = $_POST["fecha"];
    $idc = $_POST["idc"];
    $merchantId2 = $_POST["merchantId2"];
    $tipoqr = $_POST['tipoqr']; // Obtener el valor del campo tipoqr del formulario
    $name = $_POST['name']; // Obtener el valor del campo tipoqr del formulario
    $mcci= $_POST['mcci'];
    $address = $_POST['address']; // Obtener el valor del campo
    $phone = $_POST['phone']; // Obtener el valor

    $tokenResponse = generateToken($environment, $user, $password);
    $sesionResponse = generateSesion($environment, $amount, $tokenResponse['response'], $merchantId , $tipoqr ,$currency ,
    $adicional, $fecha, $idc,$merchantId2, $name , $mcci ,$address , $phone);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="shortcut icon" href="assets/img/favicon.png">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <title>QR Integrado</title>
    </head>

    <body>
        <div class="p-3 mb-2 bg-primary text-white">
            <h1><center><b>QR INTEGRADO</b></center></h1>
        </div>
        <br>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a href="https://soporteqa.vnportalqr.com.pe/qrdemo/" class="btn btn-success float-right" target="_blank">Simulador de Pagos</a>
                    <div class="form-group">
                        <div class="row align-items-center">
                            <div class="col-2 col-md-1">
                                <label  class="label-white"><b>API SEGURIDAD:</b></label>
                            </div>
                            <div class="col-9 col-md-11">
                                <input type="text"  name="" id="" class="form-control transparent-input" value="<?php echo $tokenResponse['url'] ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <b><label  class="label-white">RESPONSE</label></b>
                        <textarea name="" id="" cols="30" rows="2" class="form-control transparent-textarea" disabled><?php echo $tokenResponse['response']; ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <div class="row align-items-center">
                    <div class="col-2 col-md-1">
                        <label class="label-white"><b>API QR :<?php echo $tipoqr?></b></label>
                    </div>
                    <div class="col-9 col-md-11">
                        <input type="text" name="" id="" class="form-control transparent-input" value="<?php echo $sesionResponse['url'] ?>" disabled>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-2">
                            <b><label class="label-white">REQUEST</label></b>
                            <textarea name="" id="" cols="30" rows="5" class="form-control transparent-textarea" disabled><?php echo json_encode(json_decode($sesionResponse['request']), JSON_PRETTY_PRINT); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-2">
                            <b><label class="label-white">RESPONSE</label></b>
                            <textarea name="" id="" cols="30" rows="5" class="form-control transparent-textarea" disabled><?php echo json_encode($sesionResponse['response'], JSON_PRETTY_PRINT); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  
        <?php
            // Convertir el objeto stdClass a una cadena JSON
            $jsonResponse = json_encode($sesionResponse['response']);

            // Decodificar la cadena JSON a un array asociativo
            $responseArray = json_decode($jsonResponse, true);

            // Obtener el valor de "tagImg" del array de respuesta
            $tagImg = $responseArray['tagImg'];

            // Eliminar las comillas del principio y del final si es necesario
            $tagImg = trim($tagImg, '"');
            $filename = "brando_qr.png";

            // Mostrar la imagen directamente en el HTML
            echo '<center><a href="'  . $tagImg . '" download=" ' . $filename . '"><img src="' . $tagImg . '" alt="Código QR generado"></a></center>';
        ?>

        <div id="result"></div>
        <script>
            const resultDiv = document.getElementById('result');
            // Función para decodificar el código QR de la imagen
            function decodeQRCodeFromImage(imageUrl) {
                const image = new Image();
                image.onload = () => {
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    canvas.width = image.width;
                    canvas.height = image.height;
                    context.drawImage(image, 0, 0, image.width, image.height);
                    const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                    const code = jsQR(imageData.data, imageData.width, imageData.height);

                    if (code) {
                        resultDiv.innerHTML = '<div class="d-flex justify-content-center align-items-center">' +
                                        '<div class="me-2">' + code.data + '</div>' +
                                        '</div>' +
                                        '<div class="mt-2 text-center">' +
                                        '<button class="btn btn-primary" onclick="copyToClipboard(\'' + code.data + '\')"><i class="fas fa-copy me-2"></i>Copiar</button>' +
                                        '</div>';
                    } else {
                        resultDiv.innerText = "No se encontró ningún código QR en la imagen.";
                    }
                };
                image.src = imageUrl;
            }

            // Llama a la función para decodificar el código QR automáticamente cuando se carga la página
            window.onload = () => {
                const imageUrl = "<?php echo $tagImg ?>"; // Obtener la URL de la imagen generada desde PHP
                decodeQRCodeFromImage(imageUrl);
            };

            function copyToClipboard(text) {
                const el = document.createElement('textarea');
                el.value = text;
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
                alert('¡Texto copiado correctamente !');
            }
        </script>
        </div>
        <br>
        <footer>Neconplus - Niubiz</footer>
    </body>
</html>