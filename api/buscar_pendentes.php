<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../config/conexao.php';

// Pega a matéria que veio pela URL
$materia = isset($_GET['materia']) ? $_GET['materia'] : '';

// Busca apenas os pendentes DAQUELA matéria específica
$sql = "SELECT id, materia, nome, descricao, imagem FROM termos WHERE status = 'pendente' AND materia = ?";
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