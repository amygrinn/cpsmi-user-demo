<?php

class Api {

  private $sql;

  function __construct($sql) {
    $this->sql = $sql;
  }

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
    
    $search = $query["search"] ? "%${query['search']}%" : "%%"; // match all users if no search string

    $query_str =
<<<EOT

SELECT * 
FROM `users`
WHERE (
  `name` LIKE :search
  OR `phone` LIKE :search
  OR `email` LIKE :search
);

EOT;

    try {
      $stmt = $this->sql->prepare($query_str);

      $stmt->bindParam(':search', $search);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      echo json_encode($result);

    } catch(PDOException $e) {
      http_response_code(500);
      echo("Error: " . $e->getMessage());
    }

    $stmt = null;
  }
}
