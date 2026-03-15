<?php
require_once 'config/conexao.php';
$sql_turmas = "SELECT id, nome FROM turmas 
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
            END ASC, nome ASC";
$resultado_turmas = $conn->query($sql_turmas);
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Termo - Dicionário SESI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-thumb { background: #495057; border-radius: 4px; }
        @media (max-width: 767.98px) { .offcanvas-md { max-width: 80%; } }
    </style>
</head>
<body class="bg-body">

    <div class="d-md-none bg-dark border-bottom border-success p-3 d-flex justify-content-between align-items-center shadow-sm sticky-top" style="z-index: 1050;">
        <div>
            <span class="fw-bolder text-danger fs-4 tracking-tight">SESI</span>
            <span class="text-secondary fw-bold ms-1 text-uppercase small">Dicionário</span>
        </div>
        <button class="btn btn-outline-success" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral">
            <i class="bi bi-list fs-3"></i>
        </button>
    </div>

    <div class="container-fluid">
        <div class="row flex-nowrap">
            
            <nav class="col-md-3 col-lg-2 offcanvas-md offcanvas-start bg-dark border-end border-success border-4 position-fixed vh-100 p-3 d-flex flex-column shadow-lg" id="menuLateral">
                <div class="offcanvas-header d-md-none mb-0 pb-0">
                    <h5 class="offcanvas-title fw-bolder text-danger">SESI <span class="text-secondary fs-6">Dicionário</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#menuLateral"></button>
                </div>

                <div class="text-center mb-4 mt-3 d-none d-md-block">
                    <h2 class="fw-bolder text-danger tracking-tight mb-0">SESI</h2>
                    <span class="text-secondary fw-bold fs-6 text-uppercase letter-spacing-1">Dicionário</span>
                </div>
                
                <ul class="nav nav-pills flex-column mb-auto mt-4 mt-md-0">
                    <li><a href="index.php" class="nav-link text-white mb-2"><i class="bi bi-book me-2"></i> Português</a></li>
                    <li><a href="matematica.php" class="nav-link text-white mb-2"><i class="bi bi-calculator me-2"></i> Matemática</a></li>
                    <li class="nav-item">
                        <a href="postar_termo.php" class="nav-link active bg-success text-white mb-2 fw-bold shadow-sm" aria-current="page">
                            <i class="bi bi-bookmark-plus-fill me-2"></i> Adicionar Termo
                        </a>
                    </li>
                    <hr class="border-secondary">
                    <li>
                        <a href="admin.php" class="nav-link text-warning mb-2 border border-warning">
                            <i class="bi bi-shield-lock me-2"></i> Área do Professor
                        </a>
                    </li>
                </ul>
            </nav>

            <main class="col-md-9 offset-md-3 col-lg-10 offset-lg-2 px-3 px-md-5 py-4 py-md-5 min-vh-100">
                
                <div class="mb-5 border-bottom border-success pb-3">
                    <h1 class="fw-bold text-success"><i class="bi bi-bookmark-plus-fill"></i> Contribuir com o Dicionário</h1>
                    <p class="text-secondary fs-6 fs-md-5">Envie uma nova palavra. Você precisará da senha da sua turma para postar.</p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-11 col-lg-9 col-xl-7">
                        <div class="card bg-dark border-success shadow-lg">
                            <div class="card-body p-4 p-md-5">

                                <?php if(isset($_GET['sucesso'])): ?>
                                    <div class="alert alert-success alert-dismissible fade show fw-bold shadow-sm mb-4" role="alert">
                                        <i class="bi bi-check-circle-fill me-2"></i> Sucesso! Seu termo foi enviado e está aguardando aprovação do professor.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>

                                <?php if(isset($_GET['erro']) && $_GET['erro'] == 'senha'): ?>
                                    <div class="alert alert-danger alert-dismissible fade show fw-bold shadow-sm mb-4" role="alert">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Erro! A senha da turma está incorreta.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>

                                <?php if(isset($_GET['erro']) && $_GET['erro'] == 'banco'): ?>
                                    <div class="alert alert-danger alert-dismissible fade show fw-bold shadow-sm mb-4" role="alert">
                                        <i class="bi bi-x-circle-fill me-2"></i> Ocorreu um erro ao salvar no banco de dados. Tente novamente.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>

                                <?php if(isset($_GET['erro']) && $_GET['erro'] == 'repetido'): ?>
                                    <div class="alert alert-warning alert-dismissible fade show fw-bold shadow-sm mb-4" role="alert">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Ops! Esta palavra já existe no dicionário.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>

                                <form action="api/salvar_termo.php" method="POST" enctype="multipart/form-data">
                                    <div class="row mb-4">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <label class="form-label text-secondary fw-bold">Seu Nome e Sobrenome</label>
                                            <input type="text" name="nome_aluno" class="form-control bg-dark text-white border-secondary shadow-sm" placeholder="Ex: João Silva" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-secondary fw-bold">Sua Turma</label>
                                            <select class="form-select bg-dark text-white border-secondary shadow-sm" name="turma_id" required>
                                                <option value="" disabled selected>Selecione...</option>
                                                <?php while($turma = $resultado_turmas->fetch_assoc()): ?>
                                                    <option value="<?php echo $turma['id']; ?>"><?php echo htmlspecialchars($turma['nome']); ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <hr class="border-secondary mb-4">

                                    <div class="mb-4">
                                        <label class="form-label text-secondary fw-bold">Disciplina</label>
                                        <select class="form-select bg-dark text-white border-secondary shadow-sm" name="materia" required>
                                            <option value="" disabled selected>Escolha a matéria...</option>
                                            <option value="portugues">Português</option>
                                            <option value="matematica">Matemática</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label text-secondary fw-bold">Palavra ou Conceito</label>
                                        <input type="text" name="palavra" class="form-control bg-dark text-white border-secondary shadow-sm" placeholder="Ex: Metáfora..." required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label text-secondary fw-bold">Significado</label>
                                        <textarea name="significado" class="form-control bg-dark text-white border-secondary shadow-sm" rows="3" placeholder="Explique com as suas palavras..." required></textarea>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label text-secondary fw-bold">Imagem Explicativa (Opcional)</label>
                                        <input type="file" name="imagem" class="form-control bg-dark text-white border-secondary shadow-sm" accept="image/*">
                                    </div>

                                    <hr class="border-secondary mb-4">

                                    <div class="mb-4">
                                        <label class="form-label text-warning fw-bold"><i class="bi bi-key-fill"></i> Senha de Acesso da Turma</label>
                                        <input type="password" name="senha_turma" class="form-control bg-dark text-warning border-warning shadow-sm" placeholder="Digite a senha fornecida pelo professor..." required>
                                    </div>

                                    <button type="submit" class="btn btn-success w-100 fw-bold py-3 shadow">
                                        <i class="bi bi-send-fill"></i> Enviar para Aprovação
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>