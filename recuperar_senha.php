<?php
session_start();
require_once 'config/conexao.php';

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $materia = $_POST['materia_recuperar'];
    $nova_senha = $_POST['nova_senha'];
    $nome_digitado = trim($_POST['nome_seguranca']); 

    $stmt = $conn->prepare("SELECT nome_seguranca FROM professores WHERE materia = ?");
    $stmt->bind_param("s", $materia);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        $professor = $resultado->fetch_assoc();
        
        if (strcasecmp($nome_digitado, $professor['nome_seguranca']) === 0) {
            $stmt_update = $conn->prepare("UPDATE professores SET senha = ? WHERE materia = ?");
            $stmt_update->bind_param("ss", $nova_senha, $materia);
            
            if ($stmt_update->execute()) {
                $mensagem = '<div class="alert alert-success py-2 small fw-bold text-center border-0 shadow-sm"><i class="bi bi-check-circle"></i> Senha redefinida! Faça login agora.</div>';
            } else {
                $mensagem = '<div class="alert alert-danger py-2 small fw-bold text-center border-0 shadow-sm"><i class="bi bi-x-circle"></i> Erro ao atualizar banco.</div>';
            }
            $stmt_update->close();
        } else {
            $mensagem = '<div class="alert alert-danger py-2 small fw-bold text-center border-0 shadow-sm"><i class="bi bi-shield-x"></i> Nome de Segurança incorreto!</div>';
        }
    } else {
        $mensagem = '<div class="alert alert-danger py-2 small fw-bold text-center border-0 shadow-sm"><i class="bi bi-exclamation-triangle"></i> Matéria não encontrada.</div>';
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
    
    <script>
        const temaInicial = localStorage.getItem('temaEscolhido') || 'dark';
        document.documentElement.setAttribute('data-bs-theme', temaInicial);
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        .btn-tema { font-size: 1.8rem; cursor: pointer; user-select: none; transition: transform 0.3s; }
        @keyframes girarIcone {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.3); }
            100% { transform: rotate(360deg) scale(1); }
        }
        .animar-giro { animation: girarIcone 0.5s ease-in-out; }

        /* ========================================================= */
        /* REGRAS DO MODO CLARO (Ajustes Finais Pastel/Areia)        */
        /* ========================================================= */
        [data-bs-theme="light"] body { background-color: #E2DCD0 !important; }
        
        [data-bs-theme="light"] .card.bg-dark { 
            background-color: #F0EBE1 !important; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.06) !important; 
        } 
        
        [data-bs-theme="light"] .text-white { color: #2C3034 !important; } 
        [data-bs-theme="light"] .border-secondary { border-color: #C2BBAA !important; } 
        
        [data-bs-theme="light"] input.bg-dark,
        [data-bs-theme="light"] select.bg-dark { 
            background-color: #D6CFC1 !important; 
            color: #212529 !important; 
            border-color: #C2BBAA !important;
        }
        /* ========================================================= */
    </style>
</head>
<body class="bg-dark d-flex align-items-center justify-content-center vh-100 p-3 position-relative">

    <div class="position-absolute top-0 end-0 p-4">
        <i class="bi bi-sun-fill text-warning btn-tema icone-tema" onclick="alternarTema()" title="Mudar Tema"></i>
    </div>

    <div class="card bg-dark border-secondary shadow-lg w-100" style="max-width: 420px;">
        <div class="card-body p-4 p-md-5">
            
            <div class="text-center mb-4">
                <div class="mb-2"><i class="bi bi-unlock text-warning display-6"></i></div>
                <h4 class="text-white fw-bold">Recuperar Senha</h4>
                <p class="text-secondary small">Prove sua identidade para redefinir o acesso.</p>
            </div>
            
            <?php echo $mensagem; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">1. Qual é a sua matéria?</label>
                    <select class="form-select bg-dark text-white border-secondary shadow-sm" name="materia_recuperar" required>
                        <option value="" disabled selected>Selecione...</option>
                        <option value="portugues">Português</option>
                        <option value="matematica">Matemática</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">2. Digite a NOVA senha</label>
                    <input type="password" name="nova_senha" class="form-control bg-dark text-white border-secondary shadow-sm" placeholder="Mínimo 4 caracteres" required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-warning small fw-bold">3. Nome Completo (Segurança)</label>
                    <input type="text" name="nome_seguranca" class="form-control bg-dark text-warning border-warning shadow-sm" placeholder="Seu nome cadastrado" required>
                </div>

                <button type="submit" class="btn btn-warning w-100 fw-bold mb-3 shadow py-2"><i class="bi bi-arrow-repeat me-1"></i> Redefinir Senha</button>
                <a href="admin.php" class="btn btn-outline-secondary w-100 py-2 border-0 small"><i class="bi bi-arrow-left"></i> Voltar para o Login</a>
            </form>
        </div>
    </div>

    <script>
        function aplicarTema(tema) {
            document.documentElement.setAttribute('data-bs-theme', tema);
            const icone = document.querySelector('.icone-tema');
            if (tema === 'light') {
                icone.classList.replace('bi-sun-fill', 'bi-moon-stars-fill');
                icone.classList.replace('text-warning', 'text-secondary');
            } else {
                icone.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
                icone.classList.replace('text-secondary', 'text-warning');
            }
            localStorage.setItem('temaEscolhido', tema);
        }

        function alternarTema() {
            const temaAtual = document.documentElement.getAttribute('data-bs-theme');
            const novoTema = temaAtual === 'dark' ? 'light' : 'dark';
            const icone = document.querySelector('.icone-tema');
            icone.classList.remove('animar-giro'); 
            void icone.offsetWidth; 
            icone.classList.add('animar-giro');
            aplicarTema(novoTema);
        }

        document.addEventListener('DOMContentLoaded', () => {
            aplicarTema(localStorage.getItem('temaEscolhido') || 'dark');
        });
    </script>
</body>
</html>