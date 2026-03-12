<?php
// api/buscar_termos.php
header('Content-Type: application/json; charset=utf-8');
require_once '../config/conexao.php';

$materia = isset($_GET['materia']) ? $_GET['materia'] : '';

if (empty($materia)) {
    echo json_encode(["erro" => "Nenhuma matéria especificada."]);
    exit;
}

// ADICIONADO: Selecionar a coluna 'autor'
$sql = "SELECT id, nome, descricao, imagem, autor FROM termos WHERE materia = ? AND status = 'aprovado' ORDER BY nome ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $materia);
$stmt->execute();
$resultado = $stmt->get_result();

$termos = array();
while ($linha = $resultado->fetch_assoc()) {
    $termos[] = $linha;
}

echo json_encode($termos);

$stmt->close();
$conn->close();
?>