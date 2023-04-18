<?php
if (!isset($_SESSION)) {//Verificar se a sessão não já está aberta.
  session_start();
}
require __DIR__ . '/../includes_php/connect_db.php';
$user_id = $_SESSION['id_usuario'];


// Filtrar por mês, caso a variável 'month' esteja presente no URL

if (isset($_GET['release_id'])) {
  $releaseId = $_GET['release_id'];
  $sql = "SELECT long_description FROM releases WHERE id = " . $releaseId;
  $resultado = mysqli_query($connect, $sql);
  if (mysqli_num_rows($resultado) > 0) {
    $row = mysqli_fetch_assoc($resultado);
    $long_description = $row['long_description'];
    echo $long_description;
  } else {
    echo "Nenhum registro encontrado.";
  }
  exit; // adiciona esta linha para impedir a exibição da tabela inteira
}


$whereClause = '';

if (isset($_GET['month'])) {
  $monthYear = explode('-', $_GET['month']);
  $year = $monthYear[0];
  $month = $monthYear[1];
  
  $whereClause = "WHERE user_id = '$user_id' AND MONTH(datetime) = $month";
  if (isset($year)) {
    $whereClause .= " AND YEAR(datetime) = $year";
  }

  $sql = "SELECT * FROM releases $whereClause ORDER BY datetime DESC";
  $resultado = mysqli_query($connect, $sql);

  // Verificar se a consulta retornou resultados
  if (mysqli_num_rows($resultado) > 0) {
    // Imprimir as linhas da tabela usando um loop foreach
    while ($row = mysqli_fetch_assoc($resultado)) {
      $datetime    = date('d/m/Y', strtotime($row['datetime']));
      $type        = $row['type'];
      $subtype     = $row['subtype'];
      $description = $row['description'];
      $launch_value = number_format($row['launch_value'], 2, ',', ',');

      echo "<tr>"; 
      echo "<td>$datetime </td>";
      echo "<td>$type</td>";
      echo "<td>$subtype</td>";
      echo "<td>$description</td>";
      echo "<td><span class='badge " . ($type == 'despesa' ? 'badge-negative' : 'badge-positive') . "'> R\$  $launch_value </span></td>";

      // echo "<td> R\$   $launch_value</td>";
      echo "<td class='icon-container'>";
      echo "<i class='bi bi-eye            view-icon  ' data-id= '"  . $row['id'] . "'></i>";
      echo "<i class='bi bi-pencil-square  update-icon' data-id='"   . $row['id'] . "'></i>";
      echo "<i class='bi bi-trash          delete-icon' data-id='"   . $row['id'] . "' ></i>";
      echo "</td>";
      echo "</tr>";
    }

  } else {
    echo "<tr><td colspan='6'>Nenhum registro encontrado.</td></tr>";
  }
} else {
  echo "<tr><td colspan='6'>Nenhum registro encontrado.</td></tr>";
}



mysqli_close($connect);
