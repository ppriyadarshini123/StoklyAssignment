 <?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, x-requested-with");
header("Access-Control-Max-Age: 86400");

require 'database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");
echo $postdata;

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);

  // Validate.
  if ((int)$request->data->ID < 1 || trim($request->data->item) == '') {
    return http_response_code(400);
  }

   // Sanitize.
  $ID = mysqli_real_escape_string($con, (int)$request->data->ID);
  $item = mysqli_real_escape_string($con, trim($request->data->item));
   
  // Update.
  $sql = "UPDATE `items` SET `item`='$item' WHERE `ID` = '{$ID}' LIMIT 1";

  if(mysqli_query($con, $sql))
  {
    http_response_code(204);
  }
  else
  {
    return http_response_code(422);
  }  
}