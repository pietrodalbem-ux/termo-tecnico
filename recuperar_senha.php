<?php
session_start();
require_once 'config/conexao.php';

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $materia = $_POST['materia_recuperar'];
    $nova_senha = $_POST['nova_senha'];
    // Pega o nome digitado e tira os espaços vazios do começo e do fim
    $nome_digitado = trim($_POST['nome_seguranca']); 

    // 1. Busca o Nome de Segurança correto do professor no banco
    $stmt = $conn->prepare("SELECT nome_seguranca FROM professores WHERE materia = ?");
    $stmt->bind_param("s", $materia);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        $professor = $resultado->fetch_assoc();
        
        // 2. Verifica se o Nome bate (strcasecmp ignora maiúsculas e minúsculas!)
        if (strcasecmp($nome_digitado, $professor['nome_seguranca']) === 0) {
            
            // 3. Se bater, atualiza a senha!
            $stmt_update = $conn->prepare("UPDATE professores SET senha = ? WHERE materia = ?");
            $stmt_update->bind_param("ss", $nova_senha, $materia);
            
            if ($stmt_update->execute()) {
                $mensagem = '<div class="alert alert-success py-2 small fw-bold text-center"><i class="bi bi-check-circle"></i> Senha recuperada com sucesso! Você já pode fazer login.</div>';
            } else {
                $mensagem = '<div class="alert alert-danger py-2 small fw-bold text-center"><i class="bi bi-x-circle"></i> Erro ao alterar senha no banco.</div>';
            }
            $stmt_update->close();

        } else {
            $mensagem = '<div class="alert alert-danger py-2 small fw-bold text-center"><i class="bi bi-shield-x"></i> Nome de Segurança incorreto!</div>';
        }
    } else {
        $mensagem = '<div class="alert alert-danger py-2 small fw-bold text-center"><i class="bi bi-exclamation-triangle"></i> Matéria não encontrada.</div>';
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - SESI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-dark d-flex align-items-center justify-content-center vh-100 p-3">
    <div class="card bg-dark border-secondary shadow-lg w-100" style="max-width: 420px;">
        <div class="card-body p-4 p-md-5">
            
            <div class="text-center mb-4">
                <h4 class="text-white"><i class="bi bi-unlock text-warning me-2"></i>Recuperar Senha</h4>
                <p class="text-secondary small mt-2">Use o seu Nome de Segurança para provar que é você e redefinir sua senha.</p>
            </div>
            
            <?php echo $mensagem; ?>

            <form method="POST" action="recuperar_senha.php">
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">1. Qual é a sua matéria?</label>
                    <select class="form-select bg-dark text-white border-secondary shadow-sm" name="materia_recuperar" required>
                        <option value="" disabled selected>Selecione...</option>
                        <option value="portugues">Português</option>
                        <option value="matematica">Matemática</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">2. Digite sua NOVA senha</label>
                    <input type="password" name="nova_senha" class="form-control bg-dark text-white border-secondary shadow-sm" placeholder="Sua nova senha..." required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary small fw-bold text-warning">3. Seu Nome Completo (Segurança)</label>
                    <input type="text" name="nome_seguranca" class="form-control bg-dark text-warning border-warning shadow-sm" placeholder="Ex: João Silva da Costa" required>
                    <div class="form-text text-secondary" style="font-size: 0.75rem;">O nome padrão inicial é <b>Professor Sesi</b>. Você pode alterá-lo no seu painel.</div>
                </div>

                <button type="submit" class="btn btn-warning w-100 fw-bold mb-3 shadow"><i class="bi bi-arrow-repeat"></i> Redefinir Senha</button>
                <a href="admin.php" class="btn btn-outline-secondary w-100"><i class="bi bi-arrow-left"></i> Voltar para o Login</a>
            </form>
        </div>
    </div>
</body>
</html>