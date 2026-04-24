<?php
// config/conexao.php

$host = "localhost";
$usuario = "root"; // Padrão do XAMPP
$senha = "";       // Padrão do XAMPP (vazio)
$banco = "dicionario_termos"; // O nome do banco que vamos criar no MySQL

// Cria a conexão com o banco de dados
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica se deu algum erro na conexão e avisa
if ($conn->connect_error) {
    die("Erro fatal na conexão com o banco de dados: " . $conn->connect_error);
}

// Se o código passar daqui, significa que conectou com sucesso!
?>