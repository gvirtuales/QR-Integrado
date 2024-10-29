<?php
include 'config.inc.php';

function getBaseUrl($environment) {
  switch ($environment) {
    case 'T':
      return BASE_URL_TEST;
     
    case 'P':
      return BASE_URL_PROD;
    default:
  }
}

function generateToken($environment, $user, $password) {
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => getBaseUrl($environment).URL_SECURITY,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => array(
      "Accept: */*",
      'Authorization: ' . 'Basic ' . base64_encode($user . ":" . $password)
    ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  return array(
    "url" => getBaseUrl($environment).URL_SECURITY,
    "request" => "",
    "response" => $response
  );
}

function generateSesion($environment, $amount, $token, $merchantId , $tipoqr, $currency ,
 $adicional, $fecha , $idc ,$merchantId2, $name, $mcci ,$address ,$phone) {
  // Obtiene la URL base según el entorno y la concatena con la ruta de la sesión
  $url = getBaseUrl($environment) . URL_SESSION;

  // Crea el objeto de sesión con los parámetros requeridos
  $session = array(
    'enabled' => true,
    'param' => array(
      array(
        'name' => 'merchantId',
        'value' => $merchantId
      ),
      array(
        'name' => 'transactionCurrency',
        'value' => $currency,
      ),
      array(
        'name' => 'additionalData',
        'value' => $adicional,
      ),
      array(
        'name' => 'idc',
        'value' => $idc,
      ),
      array(
        'name' => 'transactionAmount',
        'value' => $amount
      )
    ),
    'tagType' => $tipoqr,
    'validityDate' => $fecha
  );

// Agregar parámetros adicionales si la sesión es dinámica
 if ($tipoqr == 'STATIC') {
  $session = array(
    'enabled' => true,
    'param' => array(
      array(
        'name' => 'merchantId',
        'value' => $merchantId
      ),
      array(
        'name' => 'transactionCurrency',
        'value' => $currency,
      ),
      array(
        'name' => 'transactionAmount',
        'value' => $amount
      )
    ),
    'tagType' => $tipoqr,
    'validityDate' => $fecha
  );
}

if ($tipoqr == 'PF Estatico') {
  $session = array(
    'enabled' => true,
    'param' => array(
      array(
        'name' => 'merchantId',
        'value' => $merchantId
      ),
      array(
        'name' => 'transactionCurrency',
        'value' => $currency,
      ),
      array(
        'name' => 'transactionAmount',
        'value' => $amount
      )
    ),
    'tagType' => 'STATIC',
    'validityDate' => $fecha,
    'sponsored' => array(
      'merchantId' => $merchantId2,
      'name' => $name,
      'mcci' => $mcci,
      'address' => $address,
      'phoneNumber' => $phone
    )
  );
}

if ($tipoqr == 'PF Dinamico') {
  $session = array(
    'enabled' => true,
    'param' => array(
      array(
        'name' => 'merchantId',
        'value' => $merchantId
      ),
      array(
        'name' => 'transactionCurrency',
        'value' => $currency,
      ),
      array(
        'name' => 'transactionAmount',
        'value' => $amount
      ),
      array(
        'name' => 'additionalData',
        'value' => $adicional,
      ),
      array(
        'name' => 'idc',
        'value' => $idc,
      ),
    ),
    'tagType' => 'DYNAMIC',
    'validityDate' => $fecha,
    'sponsored' => array(
      'merchantId' => $merchantId2,
      'name' => $name,
      'mcci' => $mcci,
      'address' => $address,
      'phoneNumber' => $phone
    )
  );
}





















  // Convierte el objeto de sesión a formato JSON
  $json = json_encode($session);

  // Envía la solicitud POST a la URL especificada con los datos JSON y el token
  $response = json_decode(postRequest($url, $json, $token));

  // Retorna un array con la URL de la solicitud, los datos enviados y la respuesta recibida
  return array(
    "url" => $url,
    "request" => $json,
    "response" => $response
  );
}





function postRequest($url, $postData, $token)
{
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => array(
      'Authorization: ' . $token,
      'Content-Type: application/json'
    ),
    CURLOPT_POSTFIELDS => $postData
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}

