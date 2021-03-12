<?php
/**
 * Returns the list of items.
 */

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, x-requested-with");
header("Access-Control-Max-Age: 86400");

require 'database.php';

$items = [];
$sql = "SELECT ID, item FROM items";

if($result = mysqli_query($con,$sql))
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $items[$i]['ID'] = $row['ID'];
    $items[$i]['item'] = $row['item'];    
    $i++;
  }

  echo json_encode(['data'=>$items]);
}
else
{
  http_response_code(404);
}
