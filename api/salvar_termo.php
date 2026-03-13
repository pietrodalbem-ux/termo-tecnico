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
    
    // FEATURE 1: BARRAR PALAVRAS REPETIDAS NO BANCO
    $sql_check = "SELECT id FROM termos WHERE nome = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $palavra);
    $stmt_check->execute();
    $res_check = $stmt_check->get_result();
    
    if ($res_check->num_rows > 0) {
        // Se já existe uma palavra igual, bloqueia e avisa
        header("Location: ../postar_termo.php?erro=repetido");
        exit;
    }
    $stmt_check->close();

    // 2. Lógica para imagem
    $caminho_imagem = "";
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
        $novo_nome = uniqid() . '.' . $extensao;
        $destino = '../uploads/' . $novo_nome; 
        
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
            $caminho_imagem = 'uploads/' . $novo_nome;
        }
    }

    // 3. Inserir no banco (AGORA COM O TURMA_ID)
    $sql_insert = "INSERT INTO termos (nome, descricao, materia, autor, status, imagem, turma_id) VALUES (?, ?, ?, ?, 'pendente', ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    
    // O "sssssi" significa 5 Strings (textos) e 1 Integer (número, que é o ID da turma)
    $stmt_insert->bind_param("sssssi", $palavra, $significado, $materia, $nome_aluno, $caminho_imagem, $turma_id);
    
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