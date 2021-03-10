<?php
/**
 * Returns the list of items.
 */
include 'database.php';
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