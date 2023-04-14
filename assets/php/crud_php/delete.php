<?php
session_start();
require __DIR__ . '/../includes_php/connect_db.php';
$user_id = $_SESSION['id_usuario'];
$data = json_decode(file_get_contents('php://input'), true);
$id = $_GET["release_id"];
// 3. Executar a exclusão usando mysqli
// $sql = "DELETE FROM releases WHERE id = ?";
$sql = "DELETE FROM releases WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $id, $user_id);
mysqli_stmt_execute($stmt);

// 4. Verificar se a exclusão foi bem sucedida
if (mysqli_affected_rows($connect) > 0) {
    echo json_encode(array('message' => 'Lançamento excluído com sucesso.'));
    http_response_code(200); // OK
} else {
    // 5. Retornar uma resposta HTTP adequada
    echo json_encode(array('error' => 'Ocorreu um erro ao excluir o lançamento.'));
    http_response_code(500); // Internal Server Error
}

// 6. Fechar a conexão com o banco de dados
mysqli_stmt_close($stmt);
mysqli_close($connect);
?>
