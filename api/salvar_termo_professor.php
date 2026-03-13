<?php
session_start();
require_once '../config/conexao.php'; 

// Segurança: Garante que só um professor logado consiga acessar esse arquivo
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: ../admin.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $materia = $_POST['materia'];
    $palavra = trim($_POST['palavra']);
    $significado = trim($_POST['significado']);
    
    // Configurações exclusivas do professor:
    $autor = 'professor'; 
    $status = 'aprovado'; // Entra no ar na mesma hora!

    // Lógica para upload de imagem (Opcional)
    $caminho_imagem = ""; 
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $diretorio_destino = "../uploads/"; // Pasta onde as imagens ficam salvas
        
        // Cria a pasta uploads automaticamente caso você ainda não tenha criado
        if (!is_dir($diretorio_destino)) {
            mkdir($diretorio_destino, 0777, true);
        }

        $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
        $novo_nome = uniqid() . "." . $extensao;
        
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio_destino . $novo_nome)) {
            $caminho_imagem = "uploads/" . $novo_nome; 
        }
    }

    // Insere o termo no banco de dados
    $stmt = $conn->prepare("INSERT INTO termos (nome, descricao, materia, autor, status, imagem) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $palavra, $significado, $materia, $autor, $status, $caminho_imagem);
    
    if ($stmt->execute()) {
        // Deu certo! Redireciona o professor para a aba "Gerir Aprovados" para ele ver a palavra lá
        header("Location: ../gerenciar.php");
        exit;
    } else {
        echo "Erro ao salvar termo: " . $conn->error;
    }
    
    $stmt->close();
}
?>