<?php
if (!isset($_SESSION)) {//Verificar se a sessão não já está aberta.
  session_start();
}
require __DIR__ . '/../includes_php/connect_db.php';

$user_id = $_SESSION['id_usuario'];
$data    = json_decode(file_get_contents('php://input'), true);

$releaseId = $_POST['release_id'];
$date      = $_POST['date-update'];
$type      = $_POST['select-update'];
$subtype   = $_POST['select-sub-update'];
$desc      = $_POST['desc-update'];
$long_desc = $_POST['desc-detalhada-update'];

$valor = str_replace('.', '', $_POST['valor-update']); // remove todos os pontos
$valor = str_replace(',', '.', $valor); // substitui a vírgula pelo ponto
$valor = floatval($valor); // converte para número decimal

// Inicializa a variável $response como um array vazio
$response = [];


if (!isset($releaseId) || !isset($date) || !isset($type) || !isset($desc) || !isset($valor)) {
  $response['status']  = 'error';
  http_response_code(400); // Bad Request
  echo json_encode($response);
  exit();
}


if ($valor > 1000000) {
  http_response_code(400);
  echo json_encode(array('status' => 'error', 'message' => 'O valor máximo permitido é de 1.000.000,00'));
  exit();
}





// Define a query SQL para atualizar o registro
$sql = "UPDATE releases SET datetime=?, type=?, subtype=?, description=?, long_description=?, launch_value=? WHERE id=? AND user_id=?";

// Prepara a query SQL
$stmt = mysqli_prepare($connect, $sql);

// Passa os parâmetros para a query SQL e executa-a
mysqli_stmt_bind_param($stmt, 'ssssssii', $date, $type, $subtype, $desc, $long_desc, $valor, $releaseId, $user_id);
mysqli_stmt_execute($stmt);

// Verifica se o update foi bem sucedido
if (mysqli_affected_rows($connect) > 0) {
    $response['status']  = 'success';
    $response['message'] = 'Release updated successfully';
    http_response_code(200); // OK
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to update release';
    http_response_code(500); // Internal Server Error
}

// Fecha a conexão com o banco de dados
mysqli_stmt_close($stmt);
mysqli_close($connect);  

// Retorna a resposta como JSON
echo json_encode($response);
