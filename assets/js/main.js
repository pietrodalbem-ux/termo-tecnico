// Função para carregar os termos do banco de dados e exibir na tela
async function carregarTermos(materia) {
    const divLista = document.getElementById('listaTermos');

    try {
        const resposta = await fetch(`api/buscar_termos.php?materia=${materia}`);
        const termos = await resposta.json();

        divLista.innerHTML = '';

        if (termos.erro) {
            console.error(termos.erro);
            return;
        }

        if (termos.length === 0) {
            divLista.innerHTML = `
                <div class="col-12 text-center text-secondary mt-5">
                    <i class="bi bi-inbox fs-1"></i>
                    <h4 class="mt-3">Nenhum conceito aprovado ainda.</h4>
                    <p>Os termos postados aparecerão aqui após a aprovação do professor.</p>
                </div>
            `;
            return;
        }

        termos.forEach(termo => {
            let imagemHtml = '';
            if (termo.imagem && termo.imagem.trim() !== "") {
                imagemHtml = `<img src="${termo.imagem}" class="card-img-top" alt="${termo.nome}" style="height: 180px; object-fit: cover;">`;
            }

            // Define as cores e badges dependendo de quem postou (Aluno ou Professor)
            let etiquetaAutor = '';
            let bordaDestaque = 'border-secondary'; 

            if (termo.autor === 'professor') {
                etiquetaAutor = `<span class="badge bg-warning text-dark mb-3"><i class="bi bi-star-fill"></i> Termo Oficial do Professor</span>`;
                bordaDestaque = 'border-warning border-4'; 
            } else {
                let corBadge = materia === 'portugues' ? 'bg-primary' : 'bg-danger';
                let nomeMateria = materia === 'portugues' ? 'Português' : 'Matemática';
                etiquetaAutor = `<span class="badge ${corBadge} mb-3"><i class="bi bi-person"></i> Postado por Aluno (${nomeMateria})</span>`;
            }

            // ATENÇÃO: A classe "item-termo" foi adicionada aqui para a pesquisa funcionar
            const cartao = `
                <div class="col-md-4 mb-4 item-termo">
                    <div class="card h-100 shadow-sm border-0 border-start ${bordaDestaque} bg-dark overflow-hidden">
                        ${imagemHtml}
                        <div class="card-body">
                            ${etiquetaAutor}
                            <h4 class="card-title fw-bold text-white mb-3">${termo.nome}</h4>
                            <p class="card-text text-secondary">${termo.descricao}</p>
                        </div>
                    </div>
                </div>
            `;
            
            divLista.innerHTML += cartao;
        });

    } catch (erro) {
        console.error("Erro de conexão com a API:", erro);
        divLista.innerHTML = `<p class="text-danger text-center mt-5">Erro ao carregar os dados do servidor.</p>`;
    }
}

// ==========================================
// SISTEMA DE BUSCA INSTANTÂNEA (FILTRO JS)
// ==========================================
document.addEventListener('DOMContentLoaded', () => {
    const campoBusca = document.getElementById('campoBusca');
    
    // Só executa se o campo de busca existir na página
    if (campoBusca) {
        campoBusca.addEventListener('input', function() {
            let termoBuscado = this.value.toLowerCase(); 
            let cartoes = document.querySelectorAll('.item-termo'); // Pega todos os cartões

            cartoes.forEach(cartao => {
                let titulo = cartao.querySelector('.card-title').innerText.toLowerCase();
                let descricao = cartao.querySelector('.card-text').innerText.toLowerCase();

                // Mostra ou esconde o cartão dependendo se a palavra foi encontrada
                if (titulo.includes(termoBuscado) || descricao.includes(termoBuscado)) {
                    cartao.style.display = ''; 
                } else {
                    cartao.style.display = 'none'; 
                }
            });
        });
    }
});