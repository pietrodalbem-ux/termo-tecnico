<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../config/conexao.php';

// Pega a matéria que veio pela URL
$materia = isset($_GET['materia']) ? $_GET['materia'] : '';

// ADICIONADO A COLUNA 'autor' NO SELECT ABAIXO:
$sql = "SELECT id, materia, nome, descricao, imagem, autor FROM termos WHERE status = 'pendente' AND materia = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $materia);
$stmt->execute();
$resultado = $stmt->get_result();

$termos = array();
if ($resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        $termos[] = $linha;
    }
}
echo json_encode($termos);
$stmt->close();
$conn->close();
?>