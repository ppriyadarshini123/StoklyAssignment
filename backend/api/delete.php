<?php

require 'database.php';

// Extract, validate and sanitize the id.
$id = ($_GET['ID'] !== null && (int)$_GET['ID'] > 0)? mysqli_real_escape_string($con, (int)$_GET['ID']) : false;

if(!$id)
{
  return http_response_code(400);
}

// Delete.
$sql = "DELETE FROM `items` WHERE `ID` ='{$id}' LIMIT 1";

if(mysqli_query($con, $sql))
{
  http_response_code(204);
}
else
{
  return http_response_code(422);
}