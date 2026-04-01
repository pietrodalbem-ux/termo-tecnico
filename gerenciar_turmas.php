<?php
session_start();
require_once 'config/conexao.php'; 

// Verifica se está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: admin.php");
    exit;
}

$materia_logada = $_SESSION['materia_admin'];
$nome_materia = ($materia_logada === 'portugues') ? 'Português' : 'Matemática';
$cor_badge = ($materia_logada === 'portugues') ? 'bg-primary' : 'bg-danger';

// VARIÁVEL ADICIONADA: Define a cor do texto do Dicionário no menu baseado na matéria
$cor_texto = ($materia_logada === 'portugues') ? 'text-primary' : 'text-danger';

$toast_html = ""; // Variável para guardar nosso alerta flutuante

// =======================================================
// LÓGICA PARA CRIAR NOVA TURMA
// =======================================================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['criar_turma'])) {
    $nome_turma = $_POST['nome_turma'];
    $senha_turma = $_POST['senha_turma'];
    $criado_por = $_POST['criado_por']; 

    $stmt = $conn->prepare("INSERT INTO turmas (nome, senha, criado_por) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome_turma, $senha_turma, $criado_por);
    
    if ($stmt->execute()) {
        $toast_html = "
        <div class='toast align-items-center text-bg-success border-0 mb-2 shadow-lg' role='alert' aria-live='assertive' aria-atomic='true'>
            <div class='d-flex'>
                <div class='toast-body fw-bold'>
                    <i class='bi bi-check-circle-fill me-2'></i> Turma <strong>$nome_turma</strong> criada com sucesso!
                </div>
                <button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
            </div>
        </div>";
    } else {
        $toast_html = "
        <div class='toast align-items-center text-bg-danger border-0 mb-2 shadow-lg' role='alert' aria-live='assertive' aria-atomic='true'>
            <div class='d-flex'>
                <div class='toast-body fw-bold'>
                    <i class='bi bi-exclamation-triangle-fill me-2'></i> Erro ao criar a turma.
                </div>
                <button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
            </div>
        </div>";
    }
    $stmt->close();
}

// =======================================================
// LÓGICA PARA EDITAR TURMA
// =======================================================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar_turma'])) {
    $id_turma = $_POST['id_turma'];
    $nome_turma = $_POST['nome_turma'];
    $senha_turma = $_POST['senha_turma'];
    $criado_por = $_POST['criado_por']; 

    $stmt = $conn->prepare("UPDATE turmas SET nome = ?, senha = ?, criado_por = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nome_turma, $senha_turma, $criado_por, $id_turma);
    
    if ($stmt->execute()) {
        $toast_html = "
        <div class='toast align-items-center text-bg-warning border-0 mb-2 shadow-lg' role='alert' aria-live='assertive' aria-atomic='true'>
            <div class='d-flex'>
                <div class='toast-body fw-bold text-dark'>
                    <i class='bi bi-pencil-square me-2'></i> Turma <strong>$nome_turma</strong> atualizada com sucesso!
                </div>
                <button type='button' class='btn-close btn-close-dark me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
            </div>
        </div>";
    } else {
        $toast_html = "
        <div class='toast align-items-center text-bg-danger border-0 mb-2 shadow-lg' role='alert' aria-live='assertive' aria-atomic='true'>
            <div class='d-flex'>
                <div class='toast-body fw-bold'>
                    <i class='bi bi-exclamation-triangle-fill me-2'></i> Erro ao atualizar a turma.
                </div>
                <button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
            </div>
        </div>";
    }
    $stmt->close();
}

// =======================================================
// LÓGICA PARA EXCLUIR TURMA
// =======================================================
if (isset($_GET['deletar_id'])) {
    $id_deletar = $_GET['deletar_id'];
    
    $stmt = $conn->prepare("DELETE FROM turmas WHERE id = ?");
    $stmt->bind_param("i", $id_deletar);
    
    if ($stmt->execute()) {
        $toast_html = "
        <div class='toast align-items-center text-bg-danger border-0 mb-2 shadow-lg' role='alert' aria-live='assertive' aria-atomic='true'>
            <div class='d-flex'>
                <div class='toast-body fw-bold'>
                    <i class='bi bi-trash-fill me-2'></i> Turma excluída com sucesso!
                </div>
                <button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
            </div>
        </div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Turmas - <?php echo $nome_materia; ?></title>
    
    <script>
        const temaInicial = localStorage.getItem('temaEscolhido') || 'dark';
        document.documentElement.setAttribute('data-bs-theme', temaInicial);
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-thumb { background: #495057; border-radius: 4px; }
        @media (max-width: 767.98px) { .offcanvas-md { max-width: 80%; } }

        .btn-tema { font-size: 1.8rem; cursor: pointer; user-select: none; }
        @keyframes girarIcone {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.3); }
            100% { transform: rotate(360deg) scale(1); }
        }
        .animar-giro { animation: girarIcone 0.5s ease-in-out; }

        /* ========================================================= */
        /* REGRAS DO MODO CLARO (Ajustes Finais Pastel/Areia)        */
        /* ========================================================= */
        [data-bs-theme="light"] body, [data-bs-theme="light"] .bg-body { background-color: #E2DCD0 !important; }
        [data-bs-theme="light"] #menuLateral { background-color: #D6CFC1 !important; }
        
        [data-bs-theme="light"] .card.bg-dark, 
        [data-bs-theme="light"] .modal-content.bg-dark { 
            background-color: #F0EBE1 !important; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.06) !important; 
        } 
        
        [data-bs-theme="light"] .text-white { color: #2C3034 !important; } 
        [data-bs-theme="light"] .text-light, [data-bs-theme="light"] .text-secondary { color: #5C636A !important; } 
        [data-bs-theme="light"] .border-secondary, 
        [data-bs-theme="light"] .modal-header.border-bottom { border-color: #C2BBAA !important; } 
        [data-bs-theme="light"] .btn-close-white { filter: invert(1); } 
        
        [data-bs-theme="light"] input.bg-dark, 
        [data-bs-theme="light"] select.bg-dark, 
        [data-bs-theme="light"] textarea.bg-dark { 
            background-color: #D6CFC1 !important; 
            color: #212529 !important; 
            border-color: #C2BBAA !important;
        }

        [data-bs-theme="light"] .d-md-none.bg-dark.border-bottom { background-color: #F0EBE1 !important; border-bottom-color: #C2BBAA !important; }
        
        /* Ajustes específicos para as tabelas no modo claro */
        [data-bs-theme="light"] .table-dark { 
            --bs-table-bg: #F0EBE1; 
            --bs-table-color: #2C3034; 
            --bs-table-border-color: #C2BBAA; 
            --bs-table-hover-bg: #E2DCD0; 
        }
        [data-bs-theme="light"] .table-dark th { background-color: #D6CFC1; color: #2C3034; }
        [data-bs-theme="light"] .table-dark td.text-white { color: #2C3034 !important; }
        /* ========================================================= */
    </style>
</head>
<body class="bg-body">

    <div class="d-md-none bg-dark border-bottom border-warning p-3 d-flex justify-content-between align-items-center shadow-sm sticky-top" id="headerMobile">
        <div>
            <span class="fw-bolder <?php echo $cor_texto; ?> fs-4 tracking-tight">Dicionário </span>
            <span class="text-secondary fw-bold ms-1 text-uppercase small">de termos</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-sun-fill text-warning btn-tema icone-tema" onclick="alternarTema()"></i>
            <button class="btn btn-outline-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral">
                <i class="bi bi-list fs-3"></i>
            </button>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            
            <nav class="col-md-3 col-lg-2 offcanvas-md offcanvas-start bg-dark border-end border-warning border-4 position-fixed vh-100 p-3 d-flex flex-column shadow-lg" id="menuLateral">
                <div class="offcanvas-header d-md-none mb-0 pb-0">
                    <h5 class="offcanvas-title fw-bolder <?php echo $cor_texto; ?>">Dicionário <span class="text-secondary fs-6">de termos</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#menuLateral"></button>
                </div>

                <div class="text-center mb-3 mt-md-3 d-none d-md-block">
                    <h2 class="fw-bolder <?php echo $cor_texto; ?> tracking-tight mb-0">Dicionário</h2>
                    <span class="text-secondary fw-bold fs-6 text-uppercase letter-spacing-1">de termos</span>
                </div>
                
                <div class="text-center mb-4 mt-3 mt-md-0">
                    <span class="badge <?php echo $cor_badge; ?> fs-6 mt-1 shadow-sm w-100">Prof. de <?php echo $nome_materia; ?></span>
                </div>
                
                <ul class="nav nav-pills flex-column mb-auto mt-3">
                    <li>
                        <a href="index.php" class="nav-link text-white mb-2 text-nowrap">
                            <i class="bi bi-house me-2"></i> Ir para o Site
                        </a>
                    </li>
                    <hr class="border-secondary">
                    
                    <li class="nav-item">
                        <a href="admin.php" class="nav-link text-white mb-2 text-nowrap">
                            <i class="bi bi-inbox-fill me-2"></i> Pendentes da Turma
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="gerenciar.php" class="nav-link text-white mb-2 text-nowrap">
                            <i class="bi bi-collection me-2"></i> Gerir Aprovados
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="alterar_senha.php" class="nav-link text-white mb-2 text-nowrap">
                            <i class="bi bi-shield-lock me-2"></i> Mudar Minha Senha
                        </a>
                    </li>
                    
                    <li class="mt-4">
                        <a href="admin.php?sair=true" class="nav-link text-danger border border-danger mb-2 text-nowrap">
                            <i class="bi bi-box-arrow-left me-2"></i> Sair da Conta
                        </a>
                    </li>
                </ul>

                <div class="mt-auto pb-2 text-center">
                    <hr class="border-secondary mt-0 mb-3">
                    <span class="text-secondary" style="font-size: 0.75rem;">Desenvolvido por</span><br>
                    <span class="fw-bold text-white" style="font-size: 0.8rem;">Pietro Dalbem & Luiz Gustavo</span>
                </div>
            </nav>

            <main class="col-md-9 offset-md-3 col-lg-10 offset-lg-2 px-3 px-md-5 py-4 py-md-5 min-vh-100 position-relative">
                
                <div class="position-absolute top-0 end-0 p-4 d-none d-md-block">
                    <i class="bi bi-sun-fill text-warning btn-tema icone-tema" onclick="alternarTema()" title="Alternar Tema"></i>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 border-bottom border-warning pb-3 gap-3 pe-md-5">
                    <div>
                        <h1 class="fw-bold text-warning"><i class="bi bi-people-fill"></i> Gerenciar Turmas</h1>
                        <p class="text-secondary fs-6 fs-md-5 mb-0">Adicione, edite ou remova as turmas cadastradas no sistema.</p>
                    </div>
                    
                    <div class="d-flex flex-column flex-sm-row gap-2">
                        <a href="admin.php" class="btn btn-outline-secondary fw-bold p-2 p-md-3 shadow-sm">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button class="btn btn-success fw-bold p-2 p-md-3 shadow" data-bs-toggle="modal" data-bs-target="#modalNovaTurma">
                            <i class="bi bi-plus-lg"></i> Criar Nova Turma
                        </button>
                    </div>
                </div>

                <div class="card bg-dark shadow-sm border-secondary">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0 align-middle">
                                <thead>
                                    <tr class="border-bottom border-warning">
                                        <th scope="col" class="p-3 text-warning">Nome da Turma</th>
                                        <th scope="col" class="p-3 text-warning">Criado Por</th>
                                        <th scope="col" class="p-3 text-warning">Data de Criação</th>
                                        <th scope="col" class="p-3 text-warning text-center">Postagens</th>
                                        <th scope="col" class="p-3 text-warning text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_turmas = "
                                        SELECT t.id, t.nome, t.senha, t.criado_por, t.data_criacao,
                                        (SELECT COUNT(*) FROM termos WHERE turma_id = t.id) AS total_postagens 
                                        FROM turmas t
                                        ORDER BY 
                                            CASE 
                                                WHEN t.nome LIKE '%6º%' THEN 1
                                                WHEN t.nome LIKE '%7º%' THEN 2
                                                WHEN t.nome LIKE '%8º%' THEN 3
                                                WHEN t.nome LIKE '%9º%' THEN 4
                                                WHEN t.nome LIKE '%1º%' THEN 5
                                                WHEN t.nome LIKE '%2º%' THEN 6
                                                WHEN t.nome LIKE '%3º%' THEN 7
                                                ELSE 8
                                            END ASC, t.nome ASC
                                    ";
                                    $resultado = $conn->query($sql_turmas);

                                    if ($resultado && $resultado->num_rows > 0) {
                                        while ($turma = $resultado->fetch_assoc()) {
                                            $data_formatada = !empty($turma['data_criacao']) ? date('d/m/Y \à\s H:i', strtotime($turma['data_criacao'])) : '-';
                                            $criador = !empty($turma['criado_por']) ? htmlspecialchars($turma['criado_por']) : '-';
                                    ?>
                                        <tr>
                                            <td class="p-3 fw-bold text-white"><?php echo htmlspecialchars($turma['nome']); ?></td>
                                            <td class="p-3 text-secondary"><?php echo $criador; ?></td>
                                            <td class="p-3 text-secondary small"><?php echo $data_formatada; ?></td>
                                            <td class="p-3 text-center">
                                                <span class="badge <?php echo ($turma['total_postagens'] > 0) ? 'bg-primary' : 'bg-secondary text-white'; ?> rounded-pill px-3 py-2">
                                                    <?php echo $turma['total_postagens']; ?>
                                                </span>
                                            </td>
                                            <td class="p-3 text-end">
                                                <button class="btn btn-sm btn-outline-warning me-2" data-bs-toggle="modal" data-bs-target="#modalEditarTurma<?php echo $turma['id']; ?>">
                                                    <i class="bi bi-pencil-square"></i> Editar
                                                </button>
                                                
                                                <a href="gerenciar_turmas.php?deletar_id=<?php echo $turma['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja apagar a turma <?php echo htmlspecialchars($turma['nome']); ?>? As postagens continuarão no site, mas a turma sumirá daqui.');">
                                                    <i class="bi bi-trash"></i> Excluir
                                                </a>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="modalEditarTurma<?php echo $turma['id']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content bg-dark border-warning shadow-lg">
                                                    <div class="modal-header border-bottom border-warning">
                                                        <h5 class="modal-title fw-bold text-warning"><i class="bi bi-pencil-square"></i> Editar Turma</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4 text-start">
                                                        <form action="gerenciar_turmas.php" method="POST">
                                                            <input type="hidden" name="editar_turma" value="1">
                                                            <input type="hidden" name="id_turma" value="<?php echo $turma['id']; ?>">
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label text-secondary fw-bold">Nome da Turma</label>
                                                                <input type="text" name="nome_turma" class="form-control bg-dark text-white shadow-sm border-secondary" value="<?php echo htmlspecialchars($turma['nome']); ?>" required>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label text-secondary fw-bold">Senha de Postagem</label>
                                                                <input type="text" name="senha_turma" class="form-control bg-dark text-white shadow-sm border-secondary" value="<?php echo htmlspecialchars($turma['senha']); ?>" required>
                                                            </div>

                                                            <div class="mb-4">
                                                                <label class="form-label text-secondary fw-bold">Criado Por (Professor)</label>
                                                                <input type="text" name="criado_por" class="form-control bg-dark text-white shadow-sm border-secondary" value="<?php echo htmlspecialchars($turma['criado_por'] ?? ''); ?>" required>
                                                            </div>
                                                            
                                                            <button type="submit" class="btn btn-warning w-100 fw-bold shadow py-2 text-dark">Salvar Alterações</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php 
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center p-4 text-secondary'>Nenhuma turma cadastrada no momento.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <div class="modal fade" id="modalNovaTurma" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark border-success shadow-lg">
                <div class="modal-header border-bottom border-success">
                    <h5 class="modal-title fw-bold text-success"><i class="bi bi-people"></i> Adicionar Nova Turma</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="gerenciar_turmas.php" method="POST">
                        <input type="hidden" name="criar_turma" value="1">
                        
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-bold">Nome da Turma (Ex: 1º Ano A)</label>
                            <input type="text" name="nome_turma" class="form-control bg-dark text-white shadow-sm border-secondary" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary fw-bold">Nome do Professor (Criado por)</label>
                            <input type="text" name="criado_por" class="form-control bg-dark text-white shadow-sm border-secondary" required value="Prof. de <?php echo $nome_materia; ?>">
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label text-secondary fw-bold">Senha de Postagem para os alunos</label>
                            <input type="text" name="senha_turma" class="form-control bg-dark text-white shadow-sm border-secondary" required placeholder="Crie uma senha forte e fácil">
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100 fw-bold shadow py-2">Criar Turma</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if(!empty($toast_html)): ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-4" style="z-index: 1055;">
        <?php echo $toast_html; ?>
    </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
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
            
            const headerMobile = document.getElementById('headerMobile');
            if(headerMobile) {
                if(tema === 'light') {
                    headerMobile.classList.replace('bg-dark', 'bg-light');
                } else {
                    headerMobile.classList.replace('bg-light', 'bg-dark');
                }
            }

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
            
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            var toastList = toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl, { delay: 4000 }); 
            });
            toastList.forEach(toast => toast.show());
        });
    </script>
</body>
</html>