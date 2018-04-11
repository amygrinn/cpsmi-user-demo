<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ( $path === "/" ) {
  include 'main.html';
  exit(0);
}

// Split path into tokens
$tokens = explode("/", $path);

// tokens[0] should be empty
if( $tokens[1] === "api" ) {

  // Connect to mysql database
  $location = getenv('SQL_LOCATION');
  $dbname = getenv('SQL_DB_NAME');
  $user = getenv('SQL_USER');
  $password = getenv('SQL_PASSWORD');
  
  $sql = new PDO(
    "mysql:host=$location;dbname=$dbname",
    $user,
    $password,
    array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    )
  );

  // Check connection
  if ($sql->connect_error) {
    http_response_code(500);
    echo("Connection failed: " . $sql->connect_error);
    return;
  }

  // Handle API request
  include 'api.php';
  $api = new Api($sql);

  parse_str($_SERVER["QUERY_STRING"], $query_params);
  
  $api->handleRequest(
    array_splice($tokens, 2), // Send everything after /api/
    $_SERVER["REQUEST_METHOD"],
    $query_params
  );
  
  $sql = null;
  exit(0);
}

// Did not match any paths
http_response_code(404);
echo "<h1>404: Not found</h1>";
