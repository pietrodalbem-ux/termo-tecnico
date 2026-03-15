<?php
session_start();
require_once 'config/conexao.php'; 

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: admin.php");
    exit;
}

$materia_logada = $_SESSION['materia_admin'];
$nome_materia = ($materia_logada === 'portugues') ? 'Português' : 'Matemática';
$cor_badge = ($materia_logada === 'portugues') ? 'bg-primary' : 'bg-danger';

$mensagem = "";

// Quando o professor clica no botão de Salvar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nova_senha = $_POST['nova_senha']; // Pode estar vazio
    $novo_nome_seguranca = trim($_POST['novo_nome_seguranca']); // Obrigatório
    
    // Verifica se o professor preencheu a nova senha também ou só o nome
    if (!empty($nova_senha)) {
        $stmt = $conn->prepare("UPDATE professores SET senha = ?, nome_seguranca = ? WHERE materia = ?");
        $stmt->bind_param("sss", $nova_senha, $novo_nome_seguranca, $materia_logada);
    } else {
        $stmt = $conn->prepare("UPDATE professores SET nome_seguranca = ? WHERE materia = ?");
        $stmt->bind_param("ss", $novo_nome_seguranca, $materia_logada);
    }
    
    if ($stmt->execute()) {
        $mensagem = '<div class="alert alert-success py-2 small fw-bold shadow-sm"><i class="bi bi-check-circle me-1"></i> Dados atualizados com sucesso!</div>';
    } else {
        $mensagem = '<div class="alert alert-danger py-2 small fw-bold shadow-sm"><i class="bi bi-x-circle me-1"></i> Erro ao atualizar os dados.</div>';
    }
    $stmt->close();
}

// Busca o Nome de Segurança atual para mostrar no campo
$stmt_busca = $conn->prepare("SELECT nome_seguranca FROM professores WHERE materia = ?");
$stmt_busca->bind_param("s", $materia_logada);
$stmt_busca->execute();
$resultado = $stmt_busca->get_result();
$prof = $resultado->fetch_assoc();
$nome_atual = $prof['nome_seguranca'];
$stmt_busca->close();

?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Segurança - <?php echo $nome_materia; ?></title>

    <script>
        const temaInicial = localStorage.getItem('temaEscolhido') || 'dark';
        document.documentElement.setAttribute('data-bs-theme', temaInicial);
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* ANIMAÇÃO DO SOL/LUA */
        .btn-tema { font-size: 1.8rem; cursor: pointer; user-select: none; }
        @keyframes girarIcone {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.3); }
            100% { transform: rotate(360deg) scale(1); }
        }
        .animar-giro { animation: girarIcone 0.5s ease-in-out; }

        /* REGRAS DO MODO CLARO (Invertido) */
        [data-bs-theme="light"] body { background-color: #f8f9fa !important; }
        [data-bs-theme="light"] .card.bg-dark, [data-bs-theme="light"] .bg-body-tertiary { background-color: #ffffff !important; } 
        [data-bs-theme="light"] .text-white { color: #212529 !important; } 
        [data-bs-theme="light"] input.bg-dark { background-color: #e9ecef !important; color: #212529 !important; }
        [data-bs-theme="light"] .border-secondary { border-color: #ced4da !important; }
    </style>
</head>
<body class="bg-dark d-flex align-items-center justify-content-center vh-100 p-3 position-relative">

    <div class="position-absolute top-0 end-0 p-4">
        <i class="bi bi-sun-fill text-warning btn-tema icone-tema" onclick="alternarTema()" title="Mudar Tema"></i>
    </div>

    <div class="card bg-dark border-warning shadow-lg w-100" style="max-width: 500px;">
        <div class="card-body p-4 p-md-5">
            
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary pb-3">
                <h4 class="fw-bold text-white mb-0"><i class="bi bi-shield-lock text-warning me-2"></i>Segurança</h4>
                <span class="badge <?php echo $cor_badge; ?> shadow-sm px-3 py-2"><?php echo $nome_materia; ?></span>
            </div>

            <?php echo $mensagem; ?>

            <form method="POST" action="alterar_senha.php">
                
                <div class="bg-body-tertiary p-3 rounded mb-3 border border-secondary">
                    <label class="form-label text-secondary fw-bold small"><i class="bi bi-key"></i> Definir Nova Senha de Login</label>
                    <input type="password" name="nova_senha" class="form-control bg-dark text-white border-secondary shadow-sm" placeholder="Deixe em branco se não quiser mudar a senha">
                </div>

                <div class="bg-body-tertiary p-3 rounded mb-4 border border-warning">
                    <label class="form-label text-warning fw-bold small"><i class="bi bi-person-badge"></i> Nome Completo (Código de Segurança)</label>
                    <input type="text" name="novo_nome_seguranca" value="<?php echo $nome_atual; ?>" class="form-control bg-dark text-warning border-warning shadow-sm" required>
                    <div class="form-text text-secondary" style="font-size: 0.75rem;">Você usará este Nome caso esqueça sua senha no futuro.</div>
                </div>
                
                <div class="d-flex gap-2 mt-2">
                    <a href="admin.php" class="btn btn-outline-secondary w-50"><i class="bi bi-arrow-left"></i> Voltar</a>
                    <button type="submit" class="btn btn-warning w-50 fw-bold shadow"><i class="bi bi-check2"></i> Salvar Dados</button>
                </div>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // SCRIPT DO TEMA 
        function aplicarTema(tema) {
            document.documentElement.setAttribute('data-bs-theme', tema);
            document.querySelectorAll('.icone-tema').forEach(icone => {
                if (tema === 'light') {
                    icone.classList.replace('bi-sun-fill', 'bi-moon-stars-fill');
                    icone.classList.replace('text-warning', 'text-secondary');
                } else {
                    icone.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
                    icone.classList.replace('text-secondary', 'text-warning');
                }
            });
            localStorage.setItem('temaEscolhido', tema);
        }

        function alternarTema() {
            const temaAtual = document.documentElement.getAttribute('data-bs-theme');
            const novoTema = temaAtual === 'dark' ? 'light' : 'dark';
            
            document.querySelectorAll('.icone-tema').forEach(icone => {
                icone.classList.remove('animar-giro'); 
                void icone.offsetWidth; 
                icone.classList.add('animar-giro');
            });
            
            aplicarTema(novoTema);
        }

        document.addEventListener('DOMContentLoaded', () => {
            aplicarTema(localStorage.getItem('temaEscolhido') || 'dark');
        });
    </script>
</body>
</html>