<?php
/**
 * Creates item.
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, x-requested-with");
header("Access-Control-Max-Age: 86400");

require 'database.php';

echo "I am in create.php";

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
  
  // Validate.
  if(trim($request->item) === '')
  {
    return http_response_code(400);
  }

  // Sanitize.
  $item = mysqli_real_escape_string($con, trim($request->item));

  // Create.
  $sql = "INSERT INTO `items`(`ID`,`item`) VALUES (null,'$item')";

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $item1 = [
      'item' => $item,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode($item1);
  }
  else
  {
    http_response_code(422);
  }
}