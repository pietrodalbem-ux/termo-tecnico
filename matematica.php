<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matemática - Dicionário SESI</title>
    
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
        /* REGRAS DO MODO CLARO (Ajustes Finais Pastel/Areia)        */
        /* ========================================================= */
        [data-bs-theme="light"] body { background-color: #E2DCD0 !important; } 
        [data-bs-theme="light"] #menuLateral { background-color: #D6CFC1 !important; } 
        
        /* Barra de Alfabeto com fundo areia mantendo a borda da página */
        [data-bs-theme="light"] #barraAlfabeto { 
            background-color: #E2DCD0 !important; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.06) !important; 
        } 

        /* Botão Área do Professor: Corrigindo contraste SÓ no Modo Claro */
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

        /* Modais com a mesma cor do fundo da página */
        [data-bs-theme="light"] .modal-content.bg-dark {
            background-color: #E2DCD0 !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
        }

        /* Cards levemente escurecidos (off-white) para não ofuscar */
        [data-bs-theme="light"] .card.bg-dark { 
            background-color: #F0EBE1 !important; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.06) !important; 
        } 
        
        [data-bs-theme="light"] .text-white { color: #2C3034 !important; } 
        [data-bs-theme="light"] .text-light { color: #5C636A !important; } 
        [data-bs-theme="light"] .border-secondary { border-color: #C2BBAA !important; } 
        [data-bs-theme="light"] .btn-close-white { filter: invert(1); } 
        
        /* Ajuste dos inputs e rodapés */
        [data-bs-theme="light"] input.bg-dark { background-color: #D6CFC1 !important; color: #212529 !important; border-color: #C2BBAA !important;}
        [data-bs-theme="light"] .input-group-text.bg-dark { background-color: #C2BBAA !important; border-color: #C2BBAA !important; }
        
        /* Rodapés de cards e modais para combinar */
        [data-bs-theme="light"] .card-footer.bg-dark { background-color: #E6E0D4 !important; border-color: #D6CFC1 !important; }
        [data-bs-theme="light"] .modal-footer.bg-dark { background-color: #D6CFC1 !important; border-color: #C2BBAA !important; }
        /* ========================================================= */

        /* REGRAS DA BARRA DE PESQUISA E ALFABETO */
        .btn-pesquisa { width: 100%; padding: 0.8rem; font-size: 1rem; }
        .barra-alfabeto-container { flex-wrap: wrap; justify-content: center; width: 100%; }
        .btn-letra { padding: 0.3rem 0.6rem; font-size: 0.9rem; margin: 0.1rem; }

        @media (min-width: 1200px) { 
            .btn-pesquisa { width: auto; min-width: 240px; flex-shrink: 0; } 
            .barra-alfabeto-container { flex-wrap: nowrap !important; gap: 0.2rem !important; padding: 0.4rem !important; } 
            .btn-letra { flex: 1; padding: 0.2rem 0; font-size: 0.85rem; margin: 0; text-align: center; } 
        }

        /* REGRAS DO CARROSSEL DE NOVIDADES */
        .carousel-track {
            overflow-x: auto; scroll-behavior: smooth;
            scrollbar-width: none; -ms-overflow-style: none;
        }
        .carousel-track::-webkit-scrollbar { display: none; }
        .btn-carrossel {
            width: 45px; height: 45px; 
            display: flex; align-items: center; justify-content: center;
            opacity: 0.9; transition: 0.2s;
        }
        .btn-carrossel:hover { opacity: 1; transform: scale(1.1); }
    </style>
</head>
<body class="bg-body">

    <div class="d-md-none bg-dark border-bottom border-danger p-3 d-flex justify-content-between align-items-center shadow-sm sticky-top">
        <div>
            <span class="fw-bolder text-danger fs-4 tracking-tight">SESI</span>
            <span class="text-secondary fw-bold ms-1 text-uppercase small">Dicionário</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-sun-fill text-warning btn-tema icone-tema" onclick="alternarTema()"></i>
            <button class="btn btn-outline-danger" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral">
                <i class="bi bi-list fs-3"></i>
            </button>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            
            <nav class="col-md-3 col-lg-2 offcanvas-md offcanvas-start bg-dark border-end border-danger border-4 position-fixed vh-100 p-3 d-flex flex-column shadow-lg" id="menuLateral">
                <div class="offcanvas-header d-md-none mb-0 pb-0">
                    <h5 class="offcanvas-title fw-bolder text-danger">SESI <span class="text-secondary fs-6">Dicionário</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#menuLateral"></button>
                </div>

                <div class="text-center mb-4 mt-3 d-none d-md-block">
                    <h2 class="fw-bolder text-danger tracking-tight mb-0">SESI</h2>
                    <span class="text-secondary fw-bold fs-6 text-uppercase letter-spacing-1">Dicionário</span>
                </div>
                
                <ul class="nav nav-pills flex-column mb-auto mt-4 mt-md-0">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link text-white mb-2 shadow-sm" aria-current="page">
                            <i class="bi bi-book me-2"></i> Português
                        </a>
                    </li>
                    <li>
                        <a href="matematica.php" class="nav-link active bg-danger text-white mb-2 fw-bold">
                            <i class="bi bi-calculator me-2"></i> Matemática
                        </a>
                    </li>
                    <li><a href="postar_termo.php" class="nav-link text-white mb-2"><i class="bi bi-bookmark-plus me-2"></i> Adicionar Termo</a></li>
                    <hr class="border-secondary">
                    <li>
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

            <main class="col-md-9 offset-md-3 col-lg-10 offset-lg-2 px-3 px-md-5 py-4 py-md-5 min-vh-100 position-relative">
                
                <div class="position-absolute top-0 end-0 mt-4 me-4 d-none d-md-block">
                    <i class="bi bi-sun-fill text-warning btn-tema icone-tema" onclick="alternarTema()" title="Mudar Tema"></i>
                </div>

                <div class="mb-5 border-bottom border-danger pb-3">
                    <h1 class="fw-bold text-danger"><i class="bi bi-calculator"></i> Matemática</h1>
                    <p class="text-secondary fs-6 fs-md-5">Explore os termos e conceitos da matemática.</p>
                    <span class="badge bg-danger fs-6"><i class="bi bi-hash"></i> <span id="totalTermos">0</span> termos cadastrados</span>
                </div>

                <div class="d-flex flex-column flex-xl-row gap-3 mb-4 align-items-stretch">
                    <button class="btn btn-outline-danger fw-bold shadow-sm btn-pesquisa d-flex justify-content-center align-items-center" data-bs-toggle="modal" data-bs-target="#modalPesquisa">
                        <i class="bi bi-search me-2"></i> Pesquisar termo...
                    </button>
                    <div class="d-flex bg-dark rounded border border-danger flex-grow-1 barra-alfabeto-container" id="barraAlfabeto">
                        <button onclick="filtrarPorLetra('TODOS')" class="btn btn-danger fw-bold btn-letra">TODOS</button>
                        <script>
                            const letrasPort = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("");
                            letrasPort.forEach(l => document.write(`<button onclick="filtrarPorLetra('${l}')" class="btn btn-outline-secondary fw-bold btn-letra">${l}</button>`));
                        </script>
                    </div>
                </div>

                <div id="secaoCarrossel" class="mb-5 position-relative d-none">
                    <h4 class="text-danger fw-bold mb-3"><i class="bi bi-stars"></i> Adicionados Recentemente</h4>
                    <div class="position-relative">
                        <button class="btn btn-danger rounded-circle position-absolute start-0 top-50 translate-middle-y z-3 shadow btn-carrossel" id="btnScrollLeft" style="display: none; margin-left: -15px;"><i class="bi bi-chevron-left fs-4"></i></button>
                        <div class="d-flex carousel-track py-3 gap-3" id="trackCarrossel"></div>
                        <button class="btn btn-danger rounded-circle position-absolute end-0 top-50 translate-middle-y z-3 shadow btn-carrossel" id="btnScrollRight" style="margin-right: -15px;"><i class="bi bi-chevron-right fs-4"></i></button>
                    </div>
                    <hr class="border-secondary mt-4">
                </div>

                <div class="row" id="listaTermos"></div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="modalPesquisa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark border-danger shadow-lg">
                <div class="modal-header border-bottom border-danger">
                    <h5 class="modal-title text-danger fw-bold"><i class="bi bi-search"></i> Pesquisar Termo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="input-group input-group-lg shadow-sm">
                        <span class="input-group-text bg-dark border-danger text-danger"><i class="bi bi-search"></i></span>
                        <input type="text" id="campoBusca" class="form-control bg-dark text-white border-danger" placeholder="O que você está procurando?">
                    </div>
                    <p class="text-secondary small mt-3 text-center mb-0">Os resultados atualizam no fundo. Pressione <strong>Enter</strong> para fechar.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTermo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content bg-dark border-danger shadow-lg">
                <div class="modal-header border-bottom border-danger d-flex flex-column align-items-start gap-2">
                    <div class="w-100 d-flex justify-content-between align-items-center">
                        <div id="modalTermoBadge"></div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <h2 class="modal-title text-white fw-bolder mb-0" id="modalTermoTitulo"></h2>
                </div>
                <div class="modal-body p-0">
                    <img id="modalTermoImg" src="" class="img-fluid w-100 border-bottom border-secondary d-none" style="max-height: 450px; object-fit: cover;">
                    <div class="p-4 p-md-5">
                        <p class="text-light fs-5 mb-0" id="modalTermoDescricao" style="line-height: 1.8; text-align: justify;"></p>
                    </div>
                </div>
                <div class="modal-footer bg-dark border-top border-danger d-flex justify-content-between">
                    <span class="text-danger fw-bold fs-6"><i class="bi bi-pen"></i> Adicionado por: <span id="modalTermoAutor" class="text-white"></span></span>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>
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

        document.addEventListener('DOMContentLoaded', () => {
            aplicarTema(localStorage.getItem('temaEscolhido') || 'dark');
        });

        // === GLOBALS E EVENTOS (Ajustado para Matemática) ===
        const materiaPagina = 'matematica'; // ← AQUI buscaremos os termos de matemática!
        let termosGlobais = [];
        const modalPesquisaEl = document.getElementById('modalPesquisa');
        const campoBusca = document.getElementById('campoBusca');
        modalPesquisaEl.addEventListener('shown.bs.modal', () => { campoBusca.focus(); });
        campoBusca.addEventListener('keypress', function (e) { if (e.key === 'Enter') bootstrap.Modal.getInstance(modalPesquisaEl).hide(); });

        async function carregarTermos() {
            try {
                const resposta = await fetch(`api/buscar_todos_aprovados.php?materia=${materiaPagina}`);
                termosGlobais = await resposta.json();
                renderizarCarrossel(termosGlobais); renderizarTermos(termosGlobais);    
            } catch (erro) { console.error("Erro:", erro); }
        }

        function gerarCartao(termo, carrossel = false) {
            let iconeAutor = termo.autor.toLowerCase() === 'professor' 
                ? '<span class="badge bg-warning text-dark mb-2"><i class="bi bi-star-fill"></i> Oficial</span>' 
                : (carrossel ? '<span class="badge bg-primary mb-2 text-white"><i class="bi bi-fire"></i> Novo</span>' : '<span class="badge bg-danger mb-2 text-white"><i class="bi bi-person"></i> Aluno</span>');
            let imagemHtml = termo.imagem && termo.imagem !== "" ? `<img src="${termo.imagem}" class="card-img-top border-bottom border-secondary" style="height: ${carrossel ? '140px' : '200px'}; object-fit: cover;">` : '';
            const nomeEscapado = termo.nome.replace(/'/g, "\\'");
            
            // Bordas vermelhas nos cards
            const classesCartao = carrossel ? 'card shadow border-danger bg-dark card-termo flex-shrink-0' : 'card h-100 shadow border-danger bg-dark card-termo overflow-hidden';
            const estiloCarrossel = carrossel ? 'style="width: 280px;"' : '';
            const clampDescricao = carrossel ? 'display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;' : '';

            return `
                <div class="${carrossel ? '' : 'col-md-6 col-xl-4 mb-4'}">
                    <div class="${classesCartao}" ${estiloCarrossel} onclick="abrirModalTermo('${nomeEscapado}')">
                        ${imagemHtml}
                        <div class="card-body p-${carrossel ? '3' : '4'}">
                            ${iconeAutor}
                            <h${carrossel ? '5' : '4'} class="card-title fw-bold text-white mb-${carrossel ? '2' : '3'} text-truncate">${termo.nome}</h${carrossel ? '5' : '4'}>
                            <p class="card-text text-light" style="font-size: ${carrossel ? '0.95rem' : '1.1rem'}; line-height: 1.6; ${clampDescricao}">${termo.descricao}</p>
                        </div>
                        ${!carrossel ? `<div class="card-footer bg-dark border-top border-danger text-danger small fw-bold px-4 py-3"><i class="bi bi-pen"></i> Autor: ${termo.autor}</div>` : ''}
                    </div>
                </div>
            `;
        }

        function renderizarCarrossel(lista) {
            const track = document.getElementById('trackCarrossel');
            track.innerHTML = '';
            if (lista.length === 0) return;
            const recentes = [...lista].reverse().slice(0, 8);
            recentes.forEach(termo => track.innerHTML += gerarCartao(termo, true));
            document.getElementById('secaoCarrossel').classList.remove('d-none');
            atualizarBotoesCarrossel();
        }

        function renderizarTermos(lista) {
            const divLista = document.getElementById('listaTermos');
            divLista.innerHTML = '';
            document.getElementById('totalTermos').innerText = lista.length;
            if (lista.length === 0) { divLista.innerHTML = `<div class="col-12 text-center text-secondary mt-5"><i class="bi bi-search fs-1"></i><h4 class="mt-3">Nenhum termo encontrado.</h4></div>`; return; }
            lista.sort((a, b) => a.nome.localeCompare(b.nome));
            lista.forEach(termo => divLista.innerHTML += gerarCartao(termo, false));
        }

        function abrirModalTermo(nomeTermo) {
            const termo = termosGlobais.find(t => t.nome === nomeTermo);
            if(!termo) return;
            document.getElementById('modalTermoTitulo').innerText = termo.nome;
            document.getElementById('modalTermoDescricao').innerText = termo.descricao;
            document.getElementById('modalTermoAutor').innerText = termo.autor;
            document.getElementById('modalTermoBadge').innerHTML = termo.autor.toLowerCase() === 'professor' ? '<span class="badge bg-warning text-dark px-3 py-2 fs-6"><i class="bi bi-star-fill"></i> Termo Oficial</span>' : '<span class="badge bg-danger text-white px-3 py-2 fs-6"><i class="bi bi-person"></i> Adicionado por Aluno</span>';
            const imgElement = document.getElementById('modalTermoImg');
            if(termo.imagem && termo.imagem !== "") { imgElement.src = termo.imagem; imgElement.classList.remove('d-none'); } 
            else { imgElement.src = ""; imgElement.classList.add('d-none'); }
            new bootstrap.Modal(document.getElementById('modalTermo')).show();
        }

        const track = document.getElementById('trackCarrossel');
        const btnLeft = document.getElementById('btnScrollLeft');
        const btnRight = document.getElementById('btnScrollRight');
        btnLeft.addEventListener('click', () => track.scrollBy({ left: -300, behavior: 'smooth' }));
        btnRight.addEventListener('click', () => track.scrollBy({ left: 300, behavior: 'smooth' }));
        track.addEventListener('scroll', atualizarBotoesCarrossel);
        function atualizarBotoesCarrossel() {
            btnLeft.style.display = track.scrollLeft > 10 ? 'flex' : 'none';
            btnRight.style.display = track.scrollLeft < (track.scrollWidth - track.clientWidth - 10) ? 'flex' : 'none';
        }

        function filtrarPorLetra(letra) {
            document.querySelectorAll('.btn-letra').forEach(btn => {
                // Aqui mudamos para btn-danger na página de Matemática
                btn.classList.replace('btn-danger', 'btn-outline-secondary');
                if(btn.innerText === letra) btn.classList.replace('btn-outline-secondary', 'btn-danger');
            });
            if (letra === 'TODOS') { document.getElementById('secaoCarrossel').classList.remove('d-none'); renderizarTermos(termosGlobais); } 
            else { document.getElementById('secaoCarrossel').classList.add('d-none'); renderizarTermos(termosGlobais.filter(t => t.nome.normalize("NFD").replace(/[\u0300-\u036f]/g, "").charAt(0).toUpperCase() === letra)); }
        }

        campoBusca.addEventListener('input', function(e) {
            const t = e.target.value.toLowerCase();
            document.getElementById('secaoCarrossel').classList.toggle('d-none', t !== "");
            renderizarTermos(termosGlobais.filter(termo => termo.nome.toLowerCase().includes(t) || termo.descricao.toLowerCase().includes(t)));
            document.querySelectorAll('.btn-letra').forEach(btn => {
                btn.classList.replace('btn-danger', 'btn-outline-secondary');
                if(btn.innerText === 'TODOS') btn.classList.replace('btn-outline-secondary', 'btn-danger');
            });
        });

        carregarTermos();
    </script>
</body>
</html>