<?php
header('Content-Type: application/json');
require_once '../config/conexao.php';

if (isset($_GET['materia'])) {
    $materia = $_GET['materia'];
    
    // O "ORDER BY nome ASC" garante a ordem alfabética no dicionário
    $sql = "SELECT * FROM termos WHERE materia = ? AND status = 'aprovado' ORDER BY nome ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $materia);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    $termos = array();
    while ($row = $resultado->fetch_assoc()) {
        $termos[] = $row;
    }
    
    echo json_encode($termos);
    
    $stmt->close();
    $conn->close();
} else {
    echo json_encode([]);
}
?>