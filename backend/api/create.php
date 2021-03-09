<?php
/**
 * Creates item.
 */
require 'database.php';
// The lines below are used to add response headers such as CORS and the allowed methods (PUT, GET, DELETE and 
// POST).
// Setting CORS to * will allow PHP server to accept requests from another domain 
// where the Angular server is running from without getting blocked by the browser by reason of the Same 
// Origin Policy. In development,  the PHP server is running from localhost:8080 port and Angular 
// from localhost:4200 which are considered as two distinct domains.

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");



echo "I am in create.php";

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);

  // Validate.
  if(trim($request->number) === '' || (float)$request->amount < 0)
  {
    return http_response_code(400);
  }

  // Sanitize.
  $string = mysqli_real_escape_string($con, (int)$request->item);

  // Create.
  $sql = "INSERT INTO `items`(`ID`,`item`) VALUES (null,'{$string}')";

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $item = [
      'item' => $string,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode($item);
  }
  else
  {
    http_response_code(422);
  }
}