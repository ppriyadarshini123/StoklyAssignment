<?php
/**
 * Returns the list of items.
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

echo "I am in read.php";

$items = [];
$sql = "SELECT ID, item FROM items";

if($result = mysqli_query($con,$sql))
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $items[$i]['ID']    = $row['ID'];
    $items[$i]['item'] = $row['item'];    
    $i++;
  }

  echo json_encode($items);
}
else
{
  http_response_code(404);
}
?>