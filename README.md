# 📚 Dicionário de termos - Termos Técnicos

Este é um sistema web desenvolvido como projeto escolar para catalogar e organizar termos técnicos das disciplinas de **Português** e **Matemática**. 

O projeto permite que alunos colaborem enviando novas palavras e conceitos, que passam por uma moderação antes de serem exibidos publicamente.

## 🚀 Funcionalidades
* **Separação por Disciplina:** Áreas dedicadas para Português (Azul) e Matemática (Vermelho).
* **Colaboração de Alunos:** Formulário de envio de termos protegido por senha da turma.
* **Upload de Imagens:** Suporte para imagens explicativas nos termos cadastrados.
* **Painel Administrativo (Professor):** Área restrita para aprovar, editar ou excluir as palavras enviadas pelos alunos.
* **Busca Dinâmica:** Pesquisa em tempo real na tela inicial.
* **Design Responsivo:** Interface moderna adaptada para celulares e computadores usando Bootstrap 5.

## 🛠️ Tecnologias Utilizadas
* **Front-end:** HTML5, CSS3, JavaScript, Bootstrap 5, Bootstrap Icons.
* **Back-end:** PHP 8+
* **Banco de Dados:** MySQL
* **Servidor Local:** XAMPP (Apache)

## ⚙️ Como rodar este projeto na sua máquina (Professor/Avaliador)

Siga os passos abaixo para testar o sistema localmente usando o XAMPP:

1. **Baixe o projeto:** Faça o download ou clone este repositório.
2. **Mova para o XAMPP:** Coloque a pasta do projeto dentro do diretório `htdocs` do seu XAMPP (ex: `C:\xampp\htdocs\dicionario-sesi`).
3. **Ligue o Servidor:** Abra o painel do XAMPP e inicie os módulos **Apache** e **MySQL**.
4. **Importe o Banco de Dados:**
   * Acesse `http://localhost/phpmyadmin` no seu navegador.
   * Crie um novo banco de dados (recomenda-se o nome que você usou originalmente, ex: `dicionario_sesi`).
   * Selecione o banco criado, vá na aba **Importar** e envie o arquivo `banco_de_dados.sql` que está na raiz deste projeto.
5. **Acesse o Sistema:** Abra o navegador e digite `http://localhost/nome-da-pasta-do-projeto`.

---
*Desenvolvido por Pietro e Luiz para o projeto escolar SESI (2025/2026).*