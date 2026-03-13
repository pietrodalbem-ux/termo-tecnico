<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matemática - Dicionário SESI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .card-termo { transition: all 0.3s ease; }
        .card-termo:hover { transform: translateY(-8px); box-shadow: 0 12px 24px rgba(0,0,0,0.3) !important; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-thumb { background: #495057; border-radius: 4px; }
        @media (max-width: 767.98px) { .offcanvas-md { max-width: 80%; } }
    </style>
</head>
<body class="bg-body">

    <div class="d-md-none bg-dark border-bottom border-danger p-3 d-flex justify-content-between align-items-center shadow-sm sticky-top">
        <div>
            <span class="fw-bolder text-danger fs-4 tracking-tight">SESI</span>
            <span class="text-secondary fw-bold ms-1 text-uppercase small">Dicionário</span>
        </div>
        <button class="btn btn-outline-danger" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral">
            <i class="bi bi-list fs-3"></i>
        </button>
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
                        <a href="index.php" class="nav-link text-white mb-2">
                            <i class="bi bi-book me-2"></i> Português
                        </a>
                    </li>
                    <li>
                        <a href="matematica.php" class="nav-link active bg-danger text-white mb-2 fw-bold shadow-sm" aria-current="page">
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
            </nav>

            <main class="col-md-9 offset-md-3 col-lg-10 offset-lg-2 px-3 px-md-5 py-4 py-md-5 min-vh-100">
                <div class="mb-5 border-bottom border-danger pb-3">
                    <h1 class="fw-bold text-danger"><i class="bi bi-calculator"></i> Matemática</h1>
                    <p class="text-secondary fs-6 fs-md-5">Fórmulas, conceitos e teorias matemáticas explicadas.</p>
                    <span class="badge bg-danger fs-6"><i class="bi bi-hash"></i> <span id="totalTermos">0</span> termos cadastrados</span>
                </div>

                <div class="row mb-5">
                    <div class="col-md-8 col-lg-6">
                        <div class="input-group input-group-lg shadow-sm">
                            <span class="input-group-text bg-dark border-danger text-danger"><i class="bi bi-search"></i></span>
                            <input type="text" id="campoBusca" class="form-control bg-dark text-white border-danger" placeholder="Pesquisar termo...">
                        </div>
                    </div>
                </div>

                <div class="row" id="listaTermos">
                </div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="modalImagem" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark border-danger">
                <div class="modal-header border-bottom border-danger">
                    <h5 class="modal-title text-white fw-bold" id="modalImagemTitulo">Imagem</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-0">
                    <img id="modalImagemSrc" src="" class="img-fluid w-100" alt="Imagem do Termo">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const materiaPagina = 'matematica';
        let termosGlobais = [];

        async function carregarTermos() {
            try {
                const resposta = await fetch(`api/buscar_todos_aprovados.php?materia=${materiaPagina}`);
                termosGlobais = await resposta.json();
                renderizarTermos(termosGlobais);
            } catch (erro) { console.error("Erro:", erro); }
        }

        function renderizarTermos(lista) {
            const divLista = document.getElementById('listaTermos');
            divLista.innerHTML = '';
            
            // Atualiza a contagem na tela
            document.getElementById('totalTermos').innerText = lista.length;
            
            if (lista.length === 0) {
                divLista.innerHTML = `<div class="col-12 text-center text-secondary mt-5"><i class="bi bi-search fs-1"></i><h4 class="mt-3">Nenhum termo encontrado.</h4></div>`;
                return;
            }

            // FEATURE 2: ORDENA E SEPARA POR LETRAS (A-Z)
            lista.sort((a, b) => a.nome.localeCompare(b.nome));
            const alfabeto = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');

            alfabeto.forEach(letra => {
                // Remove acentos para agrupar certo (Ex: Água vai para A)
                const termosDaLetra = lista.filter(t => t.nome.normalize("NFD").replace(/[\u0300-\u036f]/g, "").charAt(0).toUpperCase() === letra);
                
                if (termosDaLetra.length > 0) {
                    // Cria o título da Letra (Vermelho para Matemática)
                    divLista.innerHTML += `<div class="col-12 mt-4 mb-3 border-bottom border-secondary"><h2 class="text-danger fw-bold">${letra}</h2></div>`;
                    
                    termosDaLetra.forEach(termo => {
                        let iconeAutor = termo.autor.toLowerCase() === 'professor' 
                            ? '<span class="badge bg-warning text-dark mb-2"><i class="bi bi-star-fill"></i> Oficial</span>' 
                            : '<span class="badge bg-danger mb-2"><i class="bi bi-person"></i> Aluno</span>';
                        
                        // FEATURE 3: IMAGEM CLICÁVEL (Aciona a função abrirImagem)
                        let imagemHtml = termo.imagem && termo.imagem !== "" 
                            ? `<img src="${termo.imagem}" class="card-img-top border-bottom border-secondary" style="height: 200px; object-fit: cover; cursor: pointer;" onclick="abrirImagem('${termo.imagem}', '${termo.nome}')" title="Clique para ampliar">` 
                            : '';

                        const cartao = `
                            <div class="col-md-6 col-xl-4 mb-4">
                                <div class="card h-100 shadow border-danger bg-dark card-termo overflow-hidden">
                                    ${imagemHtml}
                                    <div class="card-body p-4">
                                        ${iconeAutor}
                                        <h4 class="card-title fw-bold text-white mb-3">${termo.nome}</h4>
                                        <p class="card-text text-light" style="font-size: 1.1rem; line-height: 1.6;">${termo.descricao}</p>
                                    </div>
                                    <div class="card-footer bg-dark border-top border-danger text-danger small fw-bold px-4 py-3">
                                        <i class="bi bi-pen"></i> Autor: ${termo.autor}
                                    </div>
                                </div>
                            </div>
                        `;
                        divLista.innerHTML += cartao;
                    });
                }
            });
        }

        // Função para abrir o modal da imagem grande
        function abrirImagem(url, titulo) {
            document.getElementById('modalImagemSrc').src = url;
            document.getElementById('modalImagemTitulo').innerText = titulo;
            const modal = new bootstrap.Modal(document.getElementById('modalImagem'));
            modal.show();
        }

        document.getElementById('campoBusca').addEventListener('input', function(e) {
            const termoBuscado = e.target.value.toLowerCase();
            const filtrados = termosGlobais.filter(t => t.nome.toLowerCase().includes(termoBuscado) || t.descricao.toLowerCase().includes(termoBuscado));
            renderizarTermos(filtrados);
        });

        carregarTermos();
    </script>
</body>
</html>