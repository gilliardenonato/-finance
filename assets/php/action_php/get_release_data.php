<?php
 require __DIR__ . '/../includes_php/connect_db.php';

  $release_id = $_GET['id'];

  $query = "SELECT * FROM releases WHERE id = $release_id";
  $result = mysqli_query($connect, $query);

  if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode($row);
  } else {
    echo json_encode([]);
  }

  mysqli_close($connect);
?>