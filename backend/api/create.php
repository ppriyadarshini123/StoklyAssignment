<?php
/**
 * Adds item in database.
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, x-requested-with");
header("Access-Control-Max-Age: 86400");

require 'database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
  
  // Validate.
  if(trim($request->data->item) === '')
  {
    return http_response_code(400);
  }//if

  // Sanitize.
  $item = mysqli_real_escape_string($con, trim($request->data->item));

  // Create.
  $sql = "INSERT INTO `items`(`ID`,`item`) VALUES (null,'{$item}')";

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $item1 = [
      'item' => $item,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode($item1);
  }//if
  else
  {
    http_response_code(422);
  }//else
}//if