<?php
require_once '../config/conexao.php';

// Pega o ID da palavra e a ação (aprovar ou recusar) via URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$acao = isset($_GET['acao']) ? $_GET['acao'] : '';

if ($id > 0) {
    if ($acao === 'aprovar') {
        // Se aprovou, muda o status para 'aprovado'
        $sql = "UPDATE termos SET status = 'aprovado' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

    } elseif ($acao === 'recusar') {
        // Se recusou, apaga do banco de dados para sempre
        $sql = "DELETE FROM termos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
?>