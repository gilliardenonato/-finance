<?php

session_start();
require __DIR__ . '/../includes_php/connect_db.php';
$user_id = $_SESSION['id_usuario'];


if (isset($_GET['month'])) {

$monthYear = explode('-', $_GET['month']);
$year  = $monthYear[0];
$month = $monthYear[1];

// Consultar o banco de dados para obter as despesas
$sql = "SELECT SUM(launch_value) AS expenses FROM releases WHERE user_id = ? AND type = 'despesa' AND MONTH(datetime) = ? AND YEAR(datetime) = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, 'iii', $user_id, $month, $year);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) > 0) {
  $row = mysqli_fetch_assoc($resultado);
  $expenses = $row['expenses'];
}

// Consultar o banco de dados para obter as receitas
$sql = "SELECT SUM(launch_value) AS income FROM releases WHERE user_id = ? AND type = 'renda' AND MONTH(datetime) = ? AND YEAR(datetime) = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, 'iii', $user_id, $month, $year);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) > 0) {
  $row = mysqli_fetch_assoc($resultado);
  $income = $row['income'];
}

// Calcular o lucro do mês atual
$profit = $income - $expenses;

echo json_encode([
  'expenses' => !empty($expenses) ? number_format($expenses, 2, ',', '.')   : 0,
  'income'   => !empty($income)   ? number_format($income,   2, ',', '.')   : 0,
  'profit'   => !empty($profit)   ? number_format($profit,   2, ',', '.')   : 0,
]);

mysqli_close($connect);

}

