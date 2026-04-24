-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/04/2026 às 20:16
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dicionario_termos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `professores`
--

CREATE TABLE `professores` (
  `id` int(11) NOT NULL,
  `materia` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome_seguranca` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `professores`
--

INSERT INTO `professores` (`id`, `materia`, `senha`, `nome_seguranca`) VALUES
(1, 'portugues', 'port123', 'Gilmara Beraldo'),
(2, 'matematica', 'mat123', 'Felipe');

-- --------------------------------------------------------

--
-- Estrutura para tabela `termos`
--

CREATE TABLE `termos` (
  `id` int(11) NOT NULL,
  `materia` varchar(50) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pendente',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `autor` varchar(20) DEFAULT 'aluno',
  `turma_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `turmas`
--

CREATE TABLE `turmas` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `criado_por` varchar(50) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `turmas`
--

INSERT INTO `turmas` (`id`, `nome`, `senha`, `criado_por`, `data_criacao`) VALUES
(1, '9º Ano Ensino Fundamental', 'sesi1234', NULL, '2026-03-13 13:21:41'),
(2, '1º Ano do Ensino Médio', 'sesi1234', NULL, '2026-03-13 13:21:41'),
(3, '2º Ano do Ensino Médio', 'sesi1234', NULL, '2026-03-13 13:21:41'),
(4, '3º Ano do Ensino Médio', 'sesi1234', NULL, '2026-03-13 13:21:41'),
(5, '8º ano Ensino Fundamental', 'sesi1234', NULL, '2026-03-13 13:21:41'),
(7, '7º ano Ensino Fundamental', 'sesi1234', NULL, '2026-03-13 13:21:41'),
(8, '6º ano Ensino Fundamental', 'sesi1234', 'Prof. Gilmara', '2026-03-13 13:47:47');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `professores`
--
ALTER TABLE `professores`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `termos`
--
ALTER TABLE `termos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `turmas`
--
ALTER TABLE `turmas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `professores`
--
ALTER TABLE `professores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `termos`
--
ALTER TABLE `termos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de tabela `turmas`
--
ALTER TABLE `turmas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
