<?php
include('config/conexao.php');

$email = $_POST['email'];
$senha_antiga = $_POST['senha_antiga'];
$nova_senha = $_POST['nova_senha'];

// 1. Primeiro, verificamos se o usuário e a senha antiga existem
$sql = "SELECT * FROM professores WHERE email = '$email' AND senha = '$senha_antiga'";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    // 2. Se achou o professor, atualiza para a nova senha
    $sql_update = "UPDATE professores SET senha = '$nova_senha' WHERE email = '$email'";
    
    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Senha alterada com sucesso!'); window.location.href='index.php';</script>";
    } else {
        echo "Erro ao atualizar: " . $conn->error;
    }
} else {
    echo "<script>alert('E-mail ou senha antiga incorretos!'); history.back();</script>";
}
?>