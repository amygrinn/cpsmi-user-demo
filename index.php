<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ( $path === "/" ) {
  include 'main.html';
  exit(0);
}

class Api {

  function handleRequest($path, $method, $query_params) {

    // Only one endpoint: users
    if($path[0] === "users") {
      
      // Only one method: get
      if($method === "GET") {
        return $this->getUser($query_params);
      } 
    }
    
    http_response_code(400);
    echo "<h1>Incorrect request format</h1>";
  }

  function getUser($query) {
    
    $search = $query["search"] ? $query["search"] : ""; // match all users if no search string
    
    $sql = new mysqli(
      $_ENV["SQL_LOCATION"], 
      $_ENV["SQL_USER"],
      $_ENV["SQL_PASSWORD"],
      $_ENV["SQL_DB_NAME"]
    );

    // Check connection
    if ($sql->connect_error) {
      http_response_code(500);
      echo("Connection failed: " . $sql->connect_error);
      return;
    }

    $query_str =
<<<EOT

SELECT * 
FROM `users`
WHERE ( 
  `name` like '%$search%'
  OR `phone` like '%$search%'
  OR `email` like '%$search%'
);

EOT;

    $result = $sql->query($query_str);

    if ($result->num_rows > 0) {
      
      // Turn sql result into json
      $rows = array();
      while($row = $result->fetch_assoc()) {
        $rows[] = $row;
      }

      echo json_encode($rows);

    } else {
      // No results found
      echo json_encode(array());
    }


    $sql->close();
  }

}

// Split path into tokens
$tokens = explode("/", $path);

// tokens[0] should be empty
if( $tokens[1] === "api" ) {

  // Handle API request
  $api = new Api;

  parse_str($_SERVER["QUERY_STRING"], $query_params);
  
  $api->handleRequest(
    array_splice($tokens, 2), // Send everything after /api/
    $_SERVER["REQUEST_METHOD"],
    $query_params
  );
  
  exit(0);
}

// Did not match any paths
http_response_code(404);
echo "<h1>404: Not found</h1>";
