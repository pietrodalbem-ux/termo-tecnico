<?php
session_start();

$usuarios = [
    'portugues' => 'port123',
    'matematica' => 'mat123'
];

if (isset($_GET['sair'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

$erro = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['senha_admin'])) {
    $materia_escolhida = $_POST['materia_login'];
    $senha_digitada = $_POST['senha_admin'];

    if (isset($usuarios[$materia_escolhida]) && $usuarios[$materia_escolhida] === $senha_digitada) {
        $_SESSION['logado'] = true;
        $_SESSION['materia_admin'] = $materia_escolhida;
        header("Location: admin.php");
        exit;
    } else {
        $erro = "Senha incorreta para a matéria selecionada!";
    }
}

// =========================================================================
// TELA DE LOGIN DUPLO 
// =========================================================================
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Professor - SESI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-dark d-flex align-items-center justify-content-center vh-100 p-3">
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
                <a href="index.php" class="btn btn-outline-secondary w-100">Voltar para o Site</a>
            </form>
        </div>
    </div>
</body>
</html>
<?php
    exit; 
}

// =========================================================================
// PAINEL LOGADO: MODO ESPECÍFICO DA MATÉRIA
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .card-termo { transition: all 0.3s ease; }
        .card-termo:hover { transform: translateY(-8px); box-shadow: 0 12px 24px rgba(0,0,0,0.3) !important; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-thumb { background: #495057; border-radius: 4px; }
        /* Garante que o menu lateral cubra a tela no celular */
        @media (max-width: 767.98px) {
            .offcanvas-md { max-width: 80%; }
        }
    </style>
</head>
<body class="bg-body">

    <div class="d-md-none bg-dark border-bottom border-warning p-3 d-flex justify-content-between align-items-center shadow-sm sticky-top">
        <div>
            <span class="fw-bolder text-danger fs-4 tracking-tight">SESI</span>
            <span class="text-secondary fw-bold ms-1 text-uppercase small">Dicionário</span>
        </div>
        <button class="btn btn-outline-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral">
            <i class="bi bi-list fs-3"></i>
        </button>
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
                    <li><a href="index.php" class="nav-link text-white mb-2"><i class="bi bi-house me-2"></i> Ir para o Site</a></li>
                    <hr class="border-secondary">
                    <li class="nav-item">
                        <a href="admin.php" class="nav-link active bg-warning text-dark mb-2 fw-bold shadow-sm" aria-current="page">
                            <i class="bi bi-inbox-fill me-2"></i> Pendentes da Turma
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="gerenciar.php" class="nav-link text-white mb-2">
                            <i class="bi bi-collection me-2"></i> Gerir Aprovados
                        </a>
                    </li>
                    <li class="mt-4">
                        <a href="admin.php?sair=true" class="nav-link text-danger border border-danger mb-2">
                            <i class="bi bi-box-arrow-left me-2"></i> Sair da Conta
                        </a>
                    </li>
                </ul>
            </nav>

            <main class="col-md-9 offset-md-3 col-lg-10 offset-lg-2 px-3 px-md-5 py-4 py-md-5 min-vh-100">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 border-bottom border-warning pb-3 gap-3">
                    <div>
                        <h1 class="fw-bold text-warning"><i class="bi bi-inbox-fill"></i> Para Aprovação</h1>
                        <p class="text-secondary fs-6 fs-md-5 mb-0">Avalie os termos postados pelos alunos em <b><?php echo $nome_materia; ?></b>.</p>
                    </div>
                    
                    <div class="d-flex flex-column flex-sm-row gap-2">
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
                    <form action="api/salvar_termo.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="autor" value="professor">
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
                    require_once 'config/conexao.php';
                    $sql_turmas = "SELECT * FROM turmas";
                    $result_turmas = $conn->query($sql_turmas);
                    
                    if($result_turmas && $result_turmas->num_rows > 0):
                        while($turma = $result_turmas->fetch_assoc()):
                    ?>
                    <form action="api/mudar_senha_turma.php" method="POST" class="mb-3 border-bottom border-secondary pb-3">
                        <input type="hidden" name="turma_id" value="<?php echo $turma['id']; ?>">
                        <label class="form-label text-white fw-bold"><?php echo $turma['nome']; ?></label>
                        <div class="input-group">
                            <input type="text" name="nova_senha" class="form-control bg-dark text-warning border-secondary" value="<?php echo $turma['senha']; ?>" required>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const materiaLogada = '<?php echo $materia_logada; ?>';

        async function carregarPendentes() {
            const divLista = document.getElementById('listaPendentes');
            try {
                const resposta = await fetch(`api/buscar_pendentes.php?materia=${materiaLogada}`);
                const termos = await resposta.json();
                divLista.innerHTML = '';

                if (termos.length === 0) {
                    divLista.innerHTML = `<div class="col-12 text-center text-secondary mt-5"><i class="bi bi-emoji-smile fs-1"></i><h4 class="mt-3">Tudo limpo!</h4><p>Os alunos ainda não postaram nada de ${materiaLogada}.</p></div>`;
                    return;
                }

                termos.forEach(termo => {
                    let imagemHtml = termo.imagem && termo.imagem !== "" ? `<img src="${termo.imagem}" class="card-img-top" style="height: 150px; object-fit: cover;">` : '';
                    const cartao = `
                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="card h-100 shadow border-warning bg-dark card-termo overflow-hidden">
                                ${imagemHtml}
                                <div class="card-body">
                                    <span class="badge bg-secondary mb-2"><i class="bi bi-person"></i> Aluno</span>
                                    <h5 class="card-title fw-bold text-white">${termo.nome}</h5>
                                    <p class="card-text text-secondary small">${termo.descricao}</p>
                                    <div class="mt-3 text-warning small fw-bold"><i class="bi bi-pen"></i> Postado por: ${termo.autor}</div>
                                </div>
                                <div class="card-footer bg-transparent border-top border-secondary d-flex justify-content-between p-3">
                                    <button onclick="mudarStatus(${termo.id}, 'recusar')" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Recusar</button>
                                    <button onclick="mudarStatus(${termo.id}, 'aprovar')" class="btn btn-success btn-sm fw-bold"><i class="bi bi-check-lg"></i> Aprovar</button>
                                </div>
                            </div>
                        </div>
                    `;
                    divLista.innerHTML += cartao;
                });
            } catch (erro) { console.error("Erro:", erro); }
        }

        async function mudarStatus(id, acao) {
            if(acao === 'recusar' && !confirm("Apagar permanentemente?")) return;
            await fetch(`api/atualizar_status.php?id=${id}&acao=${acao}`);
            carregarPendentes(); 
        }

        carregarPendentes(); 
    </script>
</body>
</html>