<?php

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
    // header("Access-Control-Allow-Origin: https://code.dailywith.me");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: *");
    header("Access-Control-Allow-Headers: Content-Type, *");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Max-Age: 86400");
  }
  exit;
}

// $allowedOrigins = [
//   'http://localhost:5173',
//   'https://code.dailywith.me'
// ];
// if (in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
//     header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
//     header("Access-Control-Allow-Methods: *");
//     header("Access-Control-Allow-Headers: *");
//     header("Access-Control-Allow-Credentials: true");
// }

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Credentials: true");

header('Content-type: application/json');

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/app/router/routes.php";
require_once __DIR__ . "/app/core/Core.php";
require_once __DIR__ . "/vendor/autoload.php";

spl_autoload_register(function ($file) {
  if (file_exists(__DIR__ . "/app/models/$file.php")) {
    require_once __DIR__ . "/app/models/$file.php";
  } else if (file_exists(__DIR__ . "/app/utils/$file.php")) {
    require_once __DIR__ . "/app/utils/$file.php";
  }
});

$core = new Core($routes);
$core->run();
