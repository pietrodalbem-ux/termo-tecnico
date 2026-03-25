<?php
session_start();
require_once 'config/conexao.php'; // Conectando ao banco de dados

// =========================================================================
// 1. LÓGICA DE EDIÇÃO INTEGRADA (VIA AJAX)
// =========================================================================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'editar_termo') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

    // Verifica se uma nova imagem foi enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $diretorio = 'uploads/';
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }
        
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $novo_nome = uniqid() . '.' . $extensao;
        $caminho_imagem = $diretorio . $novo_nome;
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_imagem)) {
            $stmt = $conn->prepare("UPDATE termos SET nome = ?, descricao = ?, imagem = ? WHERE id = ?");
            $stmt->bind_param("sssi", $nome, $descricao, $caminho_imagem, $id);
        }
    } else {
        $stmt = $conn->prepare("UPDATE termos SET nome = ?, descricao = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nome, $descricao, $id);
    }
    
    if (isset($stmt) && $stmt->execute()) {
        http_response_code(200);
        echo json_encode(["sucesso" => true]);
    } else {
        http_response_code(500);
        echo json_encode(["erro" => "Falha ao atualizar no banco de dados."]);
    }
    
    if (isset($stmt)) $stmt->close();
    exit;
}

// =========================================================================
// 2. LÓGICA DE LOGOUT E LOGIN
// =========================================================================
if (isset($_GET['sair'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

$erro = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['senha_admin'])) {
    $materia_escolhida = $_POST['materia_login'];
    $senha_digitada = $_POST['senha_admin'];
    $stmt = $conn->prepare("SELECT * FROM professores WHERE materia = ? AND senha = ?");
    $stmt->bind_param("ss", $materia_escolhida, $senha_digitada);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $_SESSION['logado'] = true;
        $_SESSION['materia_admin'] = $materia_escolhida;
        $_SESSION['usuario_id'] = $materia_escolhida; 
        header("Location: admin.php");
        exit;
    } else {
        $erro = "Senha incorreta para a matéria selecionada!";
    }
    $stmt->close();
}

// =========================================================================
// 3. TELA DE LOGIN (USUÁRIO NÃO LOGADO)
// =========================================================================
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Professor - SESI</title>
    
    <script>
        const temaInicial = localStorage.getItem('temaEscolhido') || 'dark';
        document.documentElement.setAttribute('data-bs-theme', temaInicial);
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
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
    </style>
</head>
<body class="bg-dark d-flex align-items-center justify-content-center vh-100 p-3 position-relative">
    
    <div class="position-absolute top-0 end-0 p-4">
        <i class="bi bi-sun-fill text-warning btn-tema icone-tema" onclick="alternarTema()" title="Mudar Tema"></i>
    </div>

    <div class="card bg-dark border-warning shadow-lg w-100" style="max-width: 420px;">
        <div class="card-body p-4 p-md-5 text-center">
            <h2 class="fw-bolder text-danger tracking-tight mb-0">SESI</h2>
            <span class="text-secondary fw-bold fs-6 text-uppercase letter-spacing-1">Dicionário</span>
            
            <h4 class="text-white mt-4 mb-4"><i class="bi bi-shield-lock text-warning me-2"></i>Área do Professor</h4>
            
            <?php if ($erro !== ""): ?>
                <div class="alert alert-danger py-2 small fw-bold"><?php echo $erro; ?></div>
            <?php endif; ?>

            <form method="POST" action="admin.php">
                <div class="mb-3">
                    <select class="form-select bg-dark text-white border-secondary mb-3 shadow-sm" name="materia_login" required>
                        <option value="" disabled selected>Sou professor(a) de...</option>
                        <option value="portugues">Português</option>
                        <option value="matematica">Matemática</option>
                    </select>
                </div>
                <div class="mb-4">
                    <input type="password" name="senha_admin" class="form-control bg-dark text-white border-secondary text-center shadow-sm" placeholder="Senha do professor..." required>
                </div>
                
                <button type="submit" class="btn btn-warning w-100 fw-bold mb-3 shadow">Acessar Meu Painel</button>
                <a href="index.php" class="btn btn-outline-secondary w-100 mb-3">Voltar para o Site</a>
                
                <div class="text-center mt-2">
                    <a href="recuperar_senha.php" class="text-secondary small text-decoration-none" style="transition: color 0.3s;" onmouseover="this.classList.replace('text-secondary', 'text-warning')" onmouseout="this.classList.replace('text-warning', 'text-secondary')">
                        <i class="bi bi-question-circle"></i> Esqueci minha senha
                    </a>
                </div>
            </form>
        </div>
    </div>

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
        
        document.addEventListener('DOMContentLoaded', () => aplicarTema(localStorage.getItem('temaEscolhido') || 'dark'));
    </script>
</body>
</html>
<?php
    exit; 
}

// =========================================================================
// 4. PAINEL LOGADO: MODO ESPECÍFICO DA MATÉRIA
// =========================================================================
$materia_logada = $_SESSION['materia_admin'];
$nome_materia = ($materia_logada === 'portugues') ? 'Português' : 'Matemática';
$cor_badge = ($materia_logada === 'portugues') ? 'bg-primary' : 'bg-danger';
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - <?php echo $nome_materia; ?></title>
    
    <script>
        const temaInicial = localStorage.getItem('temaEscolhido') || 'dark';
        document.documentElement.setAttribute('data-bs-theme', temaInicial);
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        .card-termo { transition: all 0.3s ease; }
        .card-termo:hover { transform: translateY(-8px); box-shadow: 0 12px 24px rgba(0,0,0,0.3) !important; }
        .card-clicavel { cursor: pointer; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-thumb { background: #495057; border-radius: 4px; }
        @media (max-width: 767.98px) { .offcanvas-md { max-width: 80%; } }

        .btn-tema { font-size: 1.8rem; cursor: pointer; user-select: none; }
        @keyframes girarIcone { 0% { transform: rotate(0deg) scale(1); } 50% { transform: rotate(180deg) scale(1.3); } 100% { transform: rotate(360deg) scale(1); } }
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
        [data-bs-theme="light"] .text-light { color: #5C636A !important; } 
        [data-bs-theme="light"] .border-secondary, 
        [data-bs-theme="light"] .card-footer.bg-transparent,
        [data-bs-theme="light"] .border-top.border-secondary { border-color: #C2BBAA !important; } 
        [data-bs-theme="light"] .btn-close-white { filter: invert(1); } 
        
        /* Ajuste dos inputs, textareas e selects */
        [data-bs-theme="light"] input.bg-dark, 
        [data-bs-theme="light"] select.bg-dark, 
        [data-bs-theme="light"] textarea.bg-dark { 
            background-color: #D6CFC1 !important;
            color: #212529 !important; 
            border-color: #C2BBAA !important;
        }

        [data-bs-theme="light"] .d-md-none.bg-dark.border-bottom { background-color: #F0EBE1 !important; border-bottom-color: #C2BBAA !important; }
        /* ========================================================= */
    </style>
</head>
<body class="bg-body">

    <div class="d-md-none bg-dark border-bottom border-warning p-3 d-flex justify-content-between align-items-center shadow-sm sticky-top">
        <div>
            <span class="fw-bolder text-danger fs-4 tracking-tight">SESI</span>
            <span class="text-secondary fw-bold ms-1 text-uppercase small">Dicionário</span>
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
                    <h5 class="offcanvas-title fw-bolder text-danger">SESI <span class="text-secondary fs-6">Dicionário</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#menuLateral"></button>
                </div>

                <div class="text-center mb-3 mt-md-3 d-none d-md-block">
                    <h2 class="fw-bolder text-danger tracking-tight mb-0">SESI</h2>
                    <span class="text-secondary fw-bold fs-6 text-uppercase letter-spacing-1">Dicionário</span>
                </div>
                
                <div class="text-center mb-4 mt-3 mt-md-0">
                    <span class="badge <?php echo $cor_badge; ?> fs-6 mt-1 shadow-sm w-100">Prof. de <?php echo $nome_materia; ?></span>
                </div>
                
                <ul class="nav nav-pills flex-column mb-auto mt-3">
                    <li><a href="index.php" class="nav-link text-white mb-2 text-nowrap"><i class="bi bi-house me-2"></i> Ir para o Site</a></li>
                    <hr class="border-secondary">
                    <li class="nav-item"><a href="admin.php" class="nav-link active bg-warning text-dark mb-2 fw-bold shadow-sm text-nowrap"><i class="bi bi-inbox-fill me-2"></i> Pendentes da Turma</a></li>
                    <li class="nav-item"><a href="gerenciar.php" class="nav-link text-white mb-2 text-nowrap"><i class="bi bi-collection me-2"></i> Gerir Aprovados</a></li>
                    <li class="nav-item">
                        <a href="alterar_senha.php" class="nav-link text-white mb-2 text-nowrap">
                            <i class="bi bi-shield-lock me-2"></i> Mudar Minha Senha
                        </a>
                    </li>
                    <li class="mt-4"><a href="admin.php?sair=true" class="nav-link text-danger border border-danger mb-2 text-nowrap"><i class="bi bi-box-arrow-left me-2"></i> Sair da Conta</a></li>
                </ul>

                <div class="mt-4 pt-3 border-top border-secondary text-center">
                    <span class="text-secondary" style="font-size: 0.75rem;">
                        Desenvolvido por <br>
                        <strong class="text-light">Pietro Dalbem & Luiz Gustavo</strong>
                    </span>
                </div>
            </nav>

            <main class="col-md-9 offset-md-3 col-lg-10 offset-lg-2 px-3 px-md-5 py-4 py-md-5 min-vh-100 position-relative">
                
                <div class="position-absolute top-0 end-0 mt-4 me-4 d-none d-md-block">
                    <i class="bi bi-sun-fill text-warning btn-tema icone-tema" onclick="alternarTema()" title="Mudar Tema"></i>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 border-bottom border-warning pb-3 gap-3">
                    <div>
                        <h1 class="fw-bold text-warning"><i class="bi bi-inbox-fill"></i> Para Aprovação</h1>
                        <p class="text-secondary fs-6 fs-md-5 mb-0">Clique nos cards para expandir e editar. Avalie os termos de <b><?php echo $nome_materia; ?></b>.</p>
                    </div>
                    
                    <div class="d-flex flex-column flex-sm-row gap-2">
                        <a href="gerenciar_turmas.php" class="btn btn-primary fw-bold p-2 p-md-3 shadow-sm">
                            <i class="bi bi-people-fill"></i> Gerenciar Turmas
                        </a>
                        
                        <button class="btn btn-outline-warning fw-bold p-2 p-md-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalSenhas">
                            <i class="bi bi-key"></i> Senhas das Turmas
                        </button>
                        
                        <button class="btn btn-success fw-bold p-2 p-md-3 shadow" data-bs-toggle="modal" data-bs-target="#modalProfessor">
                            <i class="bi bi-stars"></i> Criar Termo Oficial
                        </button>
                    </div>
                </div>

                <div class="row" id="listaPendentes">
                    </div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="modalProfessor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark border-success shadow-lg">
                <div class="modal-header border-bottom border-success">
                    <h5 class="modal-title fw-bold text-success"><i class="bi bi-award"></i> Novo Termo Oficial</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="api/salvar_termo_professor.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="materia" value="<?php echo $materia_logada; ?>">

                        <div class="mb-3">
                            <label class="form-label text-secondary fw-bold">Palavra/Conceito</label>
                            <input type="text" name="palavra" class="form-control bg-dark text-white shadow-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-bold">Significado (Gabarito)</label>
                            <textarea name="significado" class="form-control bg-dark text-white shadow-sm" rows="3" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-secondary fw-bold">Imagem (Opcional)</label>
                            <input type="file" name="imagem" class="form-control bg-dark text-white shadow-sm" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold shadow py-2">Postar e Aprovar Imediatamente</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSenhas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark border-warning shadow-lg">
                <div class="modal-header border-bottom border-warning">
                    <h5 class="modal-title fw-bold text-warning"><i class="bi bi-key-fill"></i> Gerenciar Senhas das Turmas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-secondary small">Altere a senha que os alunos usam para postar novos termos.</p>
                    <?php
                    $sql_turmas = "
                        SELECT * FROM turmas 
                        ORDER BY 
                            CASE 
                                WHEN nome LIKE '%6º%' THEN 1 
                                WHEN nome LIKE '%7º%' THEN 2 
                                WHEN nome LIKE '%8º%' THEN 3 
                                WHEN nome LIKE '%9º%' THEN 4 
                                WHEN nome LIKE '%1º%' THEN 5 
                                WHEN nome LIKE '%2º%' THEN 6 
                                WHEN nome LIKE '%3º%' THEN 7 
                                ELSE 8 
                            END ASC, 
                            nome ASC
                    ";
                    $result_turmas = $conn->query($sql_turmas);
                    
                    if ($result_turmas && $result_turmas->num_rows > 0):
                        while ($turma = $result_turmas->fetch_assoc()):
                    ?>
                    <form action="api/mudar_senha_turma.php" method="POST" class="mb-3 border-bottom border-secondary pb-3">
                        <input type="hidden" name="turma_id" value="<?php echo $turma['id']; ?>">
                        <label class="form-label text-white fw-bold"><?php echo $turma['nome']; ?></label>
                        <div class="input-group">
                            <input type="text" name="nova_senha" class="form-control bg-dark text-warning border-secondary" value="<?php echo htmlspecialchars($turma['senha']); ?>" required>
                            <button type="submit" class="btn btn-warning fw-bold">Salvar</button>
                        </div>
                    </form>
                    <?php 
                        endwhile;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDetalhesTermo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark border-info shadow-lg">
                <div class="modal-header border-bottom border-info">
                    <h5 class="modal-title fw-bold text-info"><i class="bi bi-card-text"></i> Detalhes do Termo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-white">
                    
                    <div id="modoVisualizacao">
                        <div id="detalheImagem" class="mb-3 text-center"></div>
                        <h4 id="detalheNome" class="fw-bold text-warning mb-3 text-break"></h4>
                        <div class="bg-secondary bg-opacity-25 p-3 rounded mb-3">
                            <p id="detalheDescricao" class="mb-0 text-white text-break"></p>
                        </div>
                        <p class="text-secondary small mb-4"><i class="bi bi-pen"></i> Autor: <span id="detalheAutor" class="text-white fw-bold"></span></p>
                        
                        <div class="d-flex justify-content-end border-top border-secondary pt-3">
                            <button type="button" class="btn btn-outline-warning w-100" onclick="alternarEdicao(true)">
                                <i class="bi bi-pencil-square"></i> Editar 
                            </button>
                        </div>
                    </div>

                    <form id="formEditarTermo" style="display: none;" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="editar_termo"> 
                        <input type="hidden" id="editTermoId" name="id">
                        
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-bold">Palavra/Conceito</label>
                            <input type="text" id="editTermoNome" name="nome" class="form-control bg-dark text-white border-secondary shadow-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-bold">Significado / Descrição</label>
                            <textarea id="editTermoDescricao" name="descricao" class="form-control bg-dark text-white border-secondary shadow-sm" rows="4" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-secondary fw-bold">Substituir Imagem (Opcional)</label>
                            <input type="file" id="editTermoImagem" name="imagem" class="form-control bg-dark text-white border-secondary shadow-sm" accept="image/*">
                            <small class="text-secondary mt-1 d-block">Se não quiser alterar a imagem, deixe este campo vazio.</small>
                        </div>
                        
                        <div class="d-flex justify-content-between gap-2 border-top border-secondary pt-3">
                            <button type="button" class="btn btn-secondary" onclick="alternarEdicao(false)">Cancelar</button>
                            <button type="submit" class="btn btn-success fw-bold shadow"><i class="bi bi-floppy"></i> Salvar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

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
        
        document.addEventListener('DOMContentLoaded', () => aplicarTema(localStorage.getItem('temaEscolhido') || 'dark'));
        const materiaLogada = '<?php echo $materia_logada; ?>';
        let termosGlobais = [];
        
        async function carregarPendentes() {
            const divLista = document.getElementById('listaPendentes');
            try {
                const resposta = await fetch(`api/buscar_pendentes.php?materia=${materiaLogada}`);
                const termos = await resposta.json();
                
                termosGlobais = termos; 
                divLista.innerHTML = '';
                if (termos.length === 0) {
                    divLista.innerHTML = `
                        <div class="col-12 text-center text-secondary mt-5">
                            <i class="bi bi-emoji-smile fs-1"></i>
                            <h4 class="mt-3">Tudo limpo!</h4>
                            <p>Nenhuma pendência no momento.</p>
                        </div>`;
                    return;
                }

                termos.forEach(termo => {
                    let imagemHtml = (termo.imagem && termo.imagem !== "") 
                        ? `<img src="${termo.imagem}" class="card-img-top border-bottom border-secondary" style="height: 150px; object-fit: cover;">` 
                        : '';
                    
                    const cartao = `
                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="card h-100 shadow border-warning bg-dark card-termo overflow-hidden position-relative">
                                ${imagemHtml}
                                
                                <div class="card-body card-clicavel" onclick="abrirModalDetalhes(${termo.id})" title="Clique para ver ou editar">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge bg-secondary"><i class="bi bi-person"></i> ${termo.autor}</span>
                                    </div>
                                    <h5 class="card-title fw-bold text-white text-break">${termo.nome}</h5>
                                    <p class="card-text text-secondary small text-truncate" style="max-height: 40px;">${termo.descricao}</p>
                                </div>
                                
                                <div class="card-footer bg-transparent border-top border-secondary d-flex justify-content-between p-3">
                                    <button onclick="mudarStatus(${termo.id}, 'recusar')" class="btn btn-outline-danger btn-sm" title="Recusar Termo">
                                        <i class="bi bi-trash"></i> Recusar
                                    </button>
                                    <button onclick="mudarStatus(${termo.id}, 'aprovar')" class="btn btn-success btn-sm fw-bold">
                                        <i class="bi bi-check-lg"></i> Aprovar
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    divLista.innerHTML += cartao;
                });
            } catch (erro) { 
                console.error("Erro ao carregar pendentes:", erro);
            }
        }

        async function mudarStatus(id, acao) {
            if (acao === 'recusar' && !confirm("Tem certeza que deseja recusar e excluir o termo permanentemente?")) return;
            await fetch(`api/atualizar_status.php?id=${id}&acao=${acao}`);
            carregarPendentes(); 
        }

        function abrirModalDetalhes(id) {
            const termo = termosGlobais.find(t => t.id === id);
            if (!termo) return;

            document.getElementById('detalheNome').textContent = termo.nome;
            document.getElementById('detalheDescricao').textContent = termo.descricao;
            document.getElementById('detalheAutor').textContent = termo.autor;
            
            const divImagem = document.getElementById('detalheImagem');
            if (termo.imagem && termo.imagem !== "") {
                divImagem.innerHTML = `<img src="${termo.imagem}" class="img-fluid rounded border border-secondary shadow-sm" style="max-height: 200px;">`;
            } else {
                divImagem.innerHTML = "";
            }

            document.getElementById('editTermoId').value = termo.id;
            document.getElementById('editTermoNome').value = termo.nome;
            document.getElementById('editTermoDescricao').value = termo.descricao;
            document.getElementById('editTermoImagem').value = ""; 
            
            alternarEdicao(false);

            const modal = new bootstrap.Modal(document.getElementById('modalDetalhesTermo'));
            modal.show();
        }

        function alternarEdicao(mostrarFormulario) {
            const visualizacao = document.getElementById('modoVisualizacao');
            const formulario = document.getElementById('formEditarTermo');
            
            if (mostrarFormulario) {
                visualizacao.style.display = 'none';
                formulario.style.display = 'block';
            } else {
                visualizacao.style.display = 'block';
                formulario.style.display = 'none';
            }
        }

        document.getElementById('formEditarTermo').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            try {
                const resposta = await fetch('admin.php', {
                    method: 'POST',
                    body: formData
                });
                
                if (resposta.ok) {
                    const modalEl = document.getElementById('modalDetalhesTermo');
                    const modalInst = bootstrap.Modal.getInstance(modalEl);
                    modalInst.hide();
                    
                    carregarPendentes();
                } else {
                    alert('Erro ao tentar atualizar o termo.');
                }
            } catch (erro) {
                console.error('Erro na requisição AJAX:', erro);
                alert('Erro de conexão ao salvar.');
            }
        });
        
        carregarPendentes(); 
    </script>
</body>
</html>