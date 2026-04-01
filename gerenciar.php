<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: admin.php"); 
    exit;
}

$materia_logada = $_SESSION['materia_admin'];
$nome_materia = ($materia_logada === 'portugues') ? 'Português' : 'Matemática';
$cor_badge = ($materia_logada === 'portugues') ? 'bg-primary' : 'bg-danger';

// VARIÁVEL ADICIONADA: Define a cor do texto do Dicionário no menu baseado na matéria
$cor_texto = ($materia_logada === 'portugues') ? 'text-primary' : 'text-danger';
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerir Termos<?php echo $nome_materia; ?></title>
    
    <script>
        const temaInicial = localStorage.getItem('temaEscolhido') || 'dark';
        document.documentElement.setAttribute('data-bs-theme', temaInicial);
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        .card-termo { transition: all 0.3s ease; }
        .card-termo:hover { transform: translateY(-8px); box-shadow: 0 12px 24px rgba(0,0,0,0.3) !important; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
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
        
        [data-bs-theme="light"] .card.bg-dark { 
            background-color: #F0EBE1 !important; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.06) !important; 
        } 
        
        [data-bs-theme="light"] .text-white { color: #2C3034 !important; } 
        [data-bs-theme="light"] .text-light, [data-bs-theme="light"] .text-secondary { color: #5C636A !important; } 
        [data-bs-theme="light"] .border-secondary, 
        [data-bs-theme="light"] .card-footer.bg-dark,
        [data-bs-theme="light"] .border-top.border-secondary { border-color: #C2BBAA !important; background-color: #F0EBE1 !important; } 
        [data-bs-theme="light"] .btn-close-white { filter: invert(1); } 
        
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
                    <li><a href="index.php" class="nav-link text-white mb-2 text-nowrap"><i class="bi bi-house me-2"></i> Ir para o Site</a></li>
                    <hr class="border-secondary">
                    <li class="nav-item">
                        <a href="admin.php" class="nav-link text-white mb-2 text-nowrap">
                            <i class="bi bi-inbox-fill me-2"></i> Pendentes da Turma
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="gerenciar.php" class="nav-link active bg-warning text-dark mb-2 fw-bold shadow-sm text-nowrap" aria-current="page">
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
                    <span class="fw-bold text-light" style="font-size: 0.8rem;">Pietro Dalbem & Luiz Gustavo</span>
                </div>
            </nav>

            <main class="col-md-9 offset-md-3 col-lg-10 offset-lg-2 px-3 px-md-5 py-4 py-md-5 min-vh-100 position-relative">
                
                <div class="position-absolute top-0 end-0 p-4 d-none d-md-block">
                    <i class="bi bi-sun-fill text-warning btn-tema icone-tema" onclick="alternarTema()" title="Alternar Tema"></i>
                </div>

                <div class="mb-5 border-bottom border-warning pb-3 pe-md-5">
                    <h1 class="fw-bold text-warning"><i class="bi bi-collection"></i> Termos no Ar (<?php echo $nome_materia; ?>)</h1>
                    <p class="text-secondary fs-6 fs-md-5 mb-0">Estas palavras já estão publicadas no site. Você pode apagá-las aqui, se necessário.</p>
                </div>

                <div class="row" id="listaAprovados"></div>
            </main>

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

        document.addEventListener('DOMContentLoaded', () => {
            aplicarTema(localStorage.getItem('temaEscolhido') || 'dark');
            carregarAprovados(); 
        });

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
                        : '<span class="badge bg-secondary mb-2 text-white"><i class="bi bi-person"></i> Aluno</span>';

                    const cartao = `
                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="card h-100 shadow border-secondary card-termo bg-dark">
                                <div class="card-body">
                                    ${iconeAutor}
                                    <h5 class="card-title fw-bold text-white">${termo.nome}</h5>
                                    <p class="card-text text-secondary small">${termo.descricao}</p>
                                    <div class="mt-3 text-warning small fw-bold"><i class="bi bi-pen"></i> Autor: ${termo.autor}</div>
                                </div>
                                <div class="card-footer bg-dark border-top border-secondary text-end p-3">
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
    </script>
</body>
</html>