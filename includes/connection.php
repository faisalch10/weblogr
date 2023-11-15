<?php

$conn = mysqli_connect("localhost", "root", "", "weblogr");

if ($conn) {
  // echo "Database Connected!";
} else {
  echo "Connection Failed!";
}

?>