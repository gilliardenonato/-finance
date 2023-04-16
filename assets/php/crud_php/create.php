<?php 
include('../includes_php/connect_db.php');
session_start();
$date    = $_POST["date"];
$tipo    = $_POST["select"];
$subTipo = $_POST["select-sub"];
$desc    = $_POST["desc"];
$long_descr = $_POST["desc-detalhada"];
$valor = str_replace('.', '', $_POST['valor']); // remove todos os pontos
$valor = str_replace(',', '.', $valor); // substitui a vírgula pelo ponto
$valor = floatval($valor); // converte para número decimal
$user_id = $_SESSION['id_usuario'];


$response = array();



// Executar a consulta SQL para inserir os dados na tabela
$sql = "INSERT INTO releases (user_id, datetime, type, subtype, description, long_description, launch_value ) values('$user_id', '$date', '$tipo', '$subTipo', '$desc', '$long_descr', '$valor')";

if (mysqli_query($connect, $sql)) {
    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
}

// Fechar a conexão com o banco de dados


mysqli_close($connect); 
echo json_encode($response);