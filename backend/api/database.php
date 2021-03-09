<?php
/**
 * Connects to the database.
 */
// The lines below are used to add response headers such as CORS and the allowed methods (PUT, GET, DELETE and 
// POST).
// Setting CORS to * will allow PHP server to accept requests from another domain 
// where the Angular server is running from without getting blocked by the browser by reason of the Same 
// Origin Policy. In development,  the PHP server is running from localhost:8080 port and Angular 
// from localhost:4200 which are considered as two distinct domains.
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

echo "I am in database.php";

//Declare constants for database connection
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'todolist');

function connect()
{
  //$connect = mysqli_connect(DB_HOST ,DB_USER ,DB_PASS ,DB_NAME);

  $connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if (isset($connect->connect_error))) {
    die("Failed to connect:" . $mysqli->connect_error;
  }

  mysqli_set_charset($connect, "utf8");

  return $connect;
}

$con = connect();
?>