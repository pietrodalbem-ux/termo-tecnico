<?php
require_once '../config/conexao.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_aluno = $_POST['nome_aluno'];
    $turma_id = $_POST['turma_id'];
    $materia = $_POST['materia'];
    $palavra = $_POST['palavra'];
    $significado = $_POST['significado'];
    $senha_turma = $_POST['senha_turma'];

    // 1. Verificar a senha da turma de forma segura
    $sql_turma = "SELECT senha FROM turmas WHERE id = ?";
    $stmt_turma = $conn->prepare($sql_turma);
    $stmt_turma->bind_param("i", $turma_id);
    $stmt_turma->execute();
    $resultado_turma = $stmt_turma->get_result();
    
    if ($row = $resultado_turma->fetch_assoc()) {
        if ($senha_turma !== $row['senha']) {
            // Senha errada, volta com erro
            header("Location: ../postar_termo.php?erro=senha");
            exit;
        }
    } else {
        header("Location: ../postar_termo.php?erro=turma");
        exit;
    }

    // 2. Lógica para imagem (Agora vai funcionar com a pasta criada)
    $caminho_imagem = "";
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
        $novo_nome = uniqid() . '.' . $extensao;
        $destino = '../uploads/' . $novo_nome; 
        
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
            $caminho_imagem = 'uploads/' . $novo_nome;
        }
    }

    // 3. Inserir no banco (Removi o turma_id daqui para não dar erro no seu banco)
    $sql_insert = "INSERT INTO termos (nome, descricao, materia, autor, status, imagem) VALUES (?, ?, ?, ?, 'pendente', ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    
    // O "sssss" significa que estamos enviando 5 Strings (textos)
    $stmt_insert->bind_param("sssss", $palavra, $significado, $materia, $nome_aluno, $caminho_imagem);
    
    if ($stmt_insert->execute()) {
        // Sucesso! Volta para a página de postar com aviso verde
        header("Location: ../postar_termo.php?sucesso=1");
    } else {
        // Falha no banco
        header("Location: ../postar_termo.php?erro=banco");
    }
    
    $stmt_turma->close();
    $stmt_insert->close();
    $conn->close();
}
?>