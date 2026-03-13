<?php
session_start();
include('../config/conexao.php'); // Sobe uma pasta para achar a config

$id_professor = $_SESSION['usuario_id'];
$senha_atual = $_POST['senha_atual'];
$nova_senha = $_POST['nova_senha'];
$confirma_senha = $_POST['confirma_senha'];

// Validação básica
if ($nova_senha !== $confirma_senha) {
    echo "<script>alert('As novas senhas não coincidem!'); history.back();</script>";
    exit();
}

// Verifica se a senha antiga está certa
$sql = "SELECT * FROM professores WHERE id = '$id_professor' AND senha = '$senha_atual'";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    // Atualiza a senha
    $sql_update = "UPDATE professores SET senha = '$nova_senha' WHERE id = '$id_professor'";
    $conn->query($sql_update);
    
    // Volta para o painel que está uma pasta acima
    echo "<script>alert('Senha alterada com sucesso!'); window.location.href='../painel.php';</script>";
} else {
    echo "<script>alert('Senha atual incorreta!'); history.back();</script>";
}
?>