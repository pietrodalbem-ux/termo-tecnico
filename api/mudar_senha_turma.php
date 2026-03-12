<?php
session_start();
require_once '../config/conexao.php';

// Garante que só um professor logado pode mudar a senha
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    die("Acesso negado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $turma_id = $_POST['turma_id'];
    $nova_senha = $_POST['nova_senha'];

    $sql = "UPDATE turmas SET senha = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nova_senha, $turma_id);

    if ($stmt->execute()) {
        echo "<script>alert('Senha atualizada com sucesso!'); window.location.href='../admin.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar senha.'); window.location.href='../admin.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>