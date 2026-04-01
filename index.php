<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início - Dicionário de termos</title>
    
    <script>
        const temaInicial = localStorage.getItem('temaEscolhido') || 'dark';
        document.documentElement.setAttribute('data-bs-theme', temaInicial);
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        .card-termo { transition: all 0.3s ease; cursor: pointer; } 
        .card-termo:hover { transform: translateY(-8px); box-shadow: 0 12px 24px rgba(0,0,0,0.3) !important; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: #495057; border-radius: 4px; }
        @media (max-width: 767.98px) { .offcanvas-md { max-width: 80%; } }
        
        /* ANIMAÇÃO DO SOL/LUA */
        .btn-tema { font-size: 1.8rem; cursor: pointer; user-select: none; }
        @keyframes girarIcone {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.3); }
            100% { transform: rotate(360deg) scale(1); }
        }
        .animar-giro { animation: girarIcone 0.5s ease-in-out; }

        /* ========================================================= */
        /* COR EXCLUSIVA DA PÁGINA INÍCIO (ROXO)                     */
        /* ========================================================= */
        .text-inicio { color: #a855f7 !important; } /* Roxo vibrante no tema escuro */
        .bg-inicio { background-color: #a855f7 !important; color: #fff !important; }
        .border-inicio { border-color: #a855f7 !important; }

        /* ========================================================= */
        /* REGRAS DO MODO CLARO (Ajustes Finais Pastel/Areia)        */
        /* ========================================================= */
        [data-bs-theme="light"] body { background-color: #E2DCD0 !important; }
        [data-bs-theme="light"] #menuLateral { background-color: #D6CFC1 !important; }
        
        /* Ajuste do roxo para o modo claro (mais escuro para dar contraste) */
        [data-bs-theme="light"] .text-inicio { color: #7e22ce !important; }
        [data-bs-theme="light"] .bg-inicio { background-color: #7e22ce !important; }
        [data-bs-theme="light"] .border-inicio { border-color: #7e22ce !important; }
        
        [data-bs-theme="light"] .nav-link.text-warning {
            color: #A66000 !important;
            border-color: #A66000 !important;
            font-weight: 700;
            background-color: rgba(166, 96, 0, 0.08) !important;
        }
        [data-bs-theme="light"] .nav-link.text-warning:hover {
            background-color: #A66000 !important;
            color: #ffffff !important;
        }

        [data-bs-theme="light"] .card.bg-dark { 
            background-color: #F0EBE1 !important; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.06) !important; 
        } 
        
        [data-bs-theme="light"] .text-white { color: #2C3034 !important; } 
        [data-bs-theme="light"] .text-light { color: #5C636A !important; } 
        [data-bs-theme="light"] .border-secondary { border-color: #C2BBAA !important; } 
        [data-bs-theme="light"] .btn-close-white { filter: invert(1); } 
        /* ========================================================= */
    </style>
</head>
<body class="bg-body">

    <div class="d-md-none bg-dark border-bottom border-inicio p-3 d-flex justify-content-between align-items-center shadow-sm sticky-top">
        <div>
            <span class="fw-bolder fs-4 tracking-tight" style="color: #a855f7;">Dicionário </span>
            <span class="text-secondary fw-bold ms-1 text-uppercase small">de termos</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-sun-fill text-warning btn-tema icone-tema" onclick="alternarTema()"></i>
            <button class="btn btn-outline-secondary border-inicio text-inicio" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral">
                <i class="bi bi-list fs-3"></i>
            </button>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            
            <nav class="col-md-3 col-lg-2 offcanvas-md offcanvas-start bg-dark border-end border-inicio border-4 position-fixed vh-100 p-3 d-flex flex-column shadow-lg" id="menuLateral">
                <div class="offcanvas-header d-md-none mb-0 pb-0">
                    <h5 class="offcanvas-title fw-bolder "style="color: #a855f7;">Dicionário <span class="text-secondary fs-6">de termos</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#menuLateral"></button>
                </div>

                <div class="text-center mb-4 mt-3 d-none d-md-block">
                    <h2 class="fw-bolder tracking-tight mb-0" style="color: #a855f7;">Dicionário </h2>
                    <span class="text-secondary fw-bold fs-6 text-uppercase letter-spacing-1">de termos</span>
                </div>
                
                <ul class="nav nav-pills flex-column mb-auto mt-4 mt-md-0">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link active bg-inicio text-white mb-2 fw-bold shadow-sm" aria-current="page">
                            <i class="bi bi-house-door me-2"></i> Início
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="portugues.php" class="nav-link text-white mb-2"><i class="bi bi-book me-2"></i> Português</a>
                    </li>
                    <li class="nav-item">
                        <a href="matematica.php" class="nav-link text-white mb-2"><i class="bi bi-calculator me-2"></i> Matemática</a>
                    </li>
                    <li class="nav-item">
                        <a href="postar_termo.php" class="nav-link text-white mb-2"><i class="bi bi-bookmark-plus me-2"></i> Adicionar Termo</a>
                    </li>
                    <hr class="border-secondary">
                    <li class="nav-item">
                        <a href="admin.php" class="nav-link text-warning mb-2 border border-warning">
                            <i class="bi bi-shield-lock me-2"></i> Área do Professor
                        </a>
                    </li>
                </ul>

                <div class="mt-4 pt-3 border-top border-secondary text-center">
                    <span class="text-secondary" style="font-size: 0.75rem;">
                        Desenvolvido por <br>
                        <strong class="text-light">Pietro Dalbem & Luiz Gustavo</strong>
                    </span>
                </div>
            </nav>

            <main class="col-md-9 offset-md-3 col-lg-10 offset-lg-2 px-3 px-md-5 py-4 py-md-5 min-vh-100 position-relative d-flex flex-column">
                
                <div class="position-absolute top-0 end-0 mt-4 me-4 d-none d-md-block">
                    <i class="bi bi-sun-fill text-warning btn-tema icone-tema" onclick="alternarTema()" title="Mudar Tema"></i>
                </div>

                <div class="mb-4 border-bottom border-inicio pb-3">
                    <h1 class="fw-bold text-inicio"><i class="bi bi-house-door"></i> Bem-vindo!</h1>
                    <p class="text-secondary fs-6 fs-md-5">Escolha abaixo qual dicionário você deseja explorar hoje.</p>
                </div>

                <div class="row g-4 flex-grow-1 justify-content-center align-items-center">
                    
                    <div class="col-md-6 col-xl-5">
                        <a href="portugues.php" class="text-decoration-none">
                            <div class="card shadow border-primary bg-dark card-termo text-center p-5">
                                <i class="bi bi-book text-primary" style="font-size: 5rem;"></i>
                                <h2 class="fw-bold text-white mt-4 mb-3">Português</h2>
                                <p class="text-light mb-4" style="font-size: 1.1rem;">Acesse os termos, significados e conceitos da língua portuguesa.</p>
                                <div class="btn btn-outline-primary fw-bold mt-auto py-2 rounded-pill w-100">Acessar Dicionário</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-xl-5">
                        <a href="matematica.php" class="text-decoration-none">
                            <div class="card shadow border-danger bg-dark card-termo text-center p-5">
                                <i class="bi bi-calculator text-danger" style="font-size: 5rem;"></i>
                                <h2 class="fw-bold text-white mt-4 mb-3">Matemática</h2>
                                <p class="text-light mb-4" style="font-size: 1.1rem;">Explore as fórmulas, operações e regras matemáticas.</p>
                                <div class="btn btn-outline-danger fw-bold mt-auto py-2 rounded-pill w-100">Acessar Dicionário</div>
                            </div>
                        </a>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // SCRIPT DO TEMA 100% CORRIGIDO
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