<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: admin.php"); 
    exit;
}

$materia_logada = $_SESSION['materia_admin'];
$nome_materia = ($materia_logada === 'portugues') ? 'Português' : 'Matemática';
$cor_badge = ($materia_logada === 'portugues') ? 'bg-primary' : 'bg-danger';
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerir Termos - <?php echo $nome_materia; ?></title>
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
                        <a href="admin.php" class="nav-link text-white mb-2">
                            <i class="bi bi-inbox-fill me-2"></i> Pendentes da Turma
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="gerenciar.php" class="nav-link active bg-warning text-dark mb-2 fw-bold shadow-sm" aria-current="page">
                            <i class="bi bi-collection me-2"></i> Gerir Aprovados
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="alterar_senha.php" class="nav-link text-white mb-2">
                            <i class="bi bi-shield-lock me-2"></i> Mudar Minha Senha
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
                <div class="mb-5 border-bottom border-warning pb-3">
                    <h1 class="fw-bold text-warning"><i class="bi bi-collection"></i> Termos no Ar (<?php echo $nome_materia; ?>)</h1>
                    <p class="text-secondary fs-6 fs-md-5 mb-0">Estas palavras já estão publicadas no site. Você pode apagá-las aqui, se necessário.</p>
                </div>

                <div class="row" id="listaAprovados">
                    </div>
            </main>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const materiaLogada = '<?php echo $materia_logada; ?>';

        async function carregarAprovados() {
            const divLista = document.getElementById('listaAprovados');
            try {
                const resposta = await fetch(`api/buscar_todos_aprovados.php?materia=${materiaLogada}`);
                const termos = await resposta.json();
                divLista.innerHTML = '';

                if (termos.length === 0) {
                    divLista.innerHTML = `<div class="col-12 text-center text-secondary mt-5"><i class="bi bi-wind fs-1"></i><h4 class="mt-3">Nenhum termo no ar.</h4></div>`;
                    return;
                }

                termos.forEach(termo => {
                    let iconeAutor = termo.autor === 'professor' 
                        ? '<span class="badge bg-warning text-dark mb-2"><i class="bi bi-star-fill"></i> Oficial</span>' 
                        : '<span class="badge bg-secondary mb-2"><i class="bi bi-person"></i> Aluno</span>';

                    const cartao = `
                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="card h-100 shadow-sm border-secondary bg-dark card-termo">
                                <div class="card-body">
                                    ${iconeAutor}
                                    <h5 class="card-title fw-bold text-white">${termo.nome}</h5>
                                    <p class="card-text text-secondary small">${termo.descricao}</p>
                                    <div class="mt-3 text-warning small fw-bold"><i class="bi bi-pen"></i> Autor: ${termo.autor}</div>
                                </div>
                                <div class="card-footer bg-transparent border-top border-secondary text-end p-3">
                                    <button onclick="apagarTermo(${termo.id})" class="btn btn-danger btn-sm fw-bold"><i class="bi bi-trash"></i> Apagar do Site</button>
                                </div>
                            </div>
                        </div>
                    `;
                    divLista.innerHTML += cartao;
                });
            } catch (erro) {
                console.error("Erro:", erro);
            }
        }

        async function apagarTermo(id) {
            if(confirm("ATENÇÃO: Isto vai apagar esta palavra do site para sempre. Tens a certeza?")) {
                await fetch(`api/atualizar_status.php?id=${id}&acao=recusar`);
                carregarAprovados(); 
            }
        }

        carregarAprovados(); 
    </script>
</body>
</html>