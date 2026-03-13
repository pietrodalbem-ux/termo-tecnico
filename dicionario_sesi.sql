-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/03/2026 às 03:22
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
-- Banco de dados: `dicionario_sesi`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `professores`
--

CREATE TABLE `professores` (
  `id` int(11) NOT NULL,
  `materia` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome_seguranca` varchar(100) NOT NULL DEFAULT 'Professor Sesi'
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
  `autor` varchar(20) DEFAULT 'aluno'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `termos`
--

INSERT INTO `termos` (`id`, `materia`, `nome`, `descricao`, `imagem`, `status`, `data_criacao`, `autor`) VALUES
(1, 'portugues', 'Efêmero', 'Aquilo que dura pouco tempo; que é passageiro, transitório, de curta duração.', 'https://images.unsplash.com/photo-1518837695005-2083093ee35b?auto=format&fit=crop&w=600&q=80', 'aprovado', '2026-03-12 14:39:03', 'aluno'),
(2, 'matematica', 'Teorema de Pitágoras', 'Em qualquer triângulo retângulo, o quadrado da hipotenusa é igual à soma dos quadrados dos catetos.', 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d2/Pythagorean.svg/600px-Pythagorean.svg.png', 'aprovado', '2026-03-12 14:39:03', 'aluno'),
(9, 'portugues', 'teste 01', 'testeeee', 'uploads/69b36c9816747.png', 'aprovado', '2026-03-13 01:47:04', 'pietro eduardo'),
(11, 'portugues', 'teste 02 professor', 'teste 0222222', '', 'aprovado', '2026-03-13 01:57:50', 'professor'),
(12, 'matematica', 'verbo', 'gkkvu', '', 'aprovado', '2026-03-13 02:09:23', 'pietro eduardo'),
(14, 'matematica', 'teste 03', 'ydjyhd', '', 'aprovado', '2026-03-13 02:12:11', 'pietro eduardo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `turmas`
--

CREATE TABLE `turmas` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `turmas`
--

INSERT INTO `turmas` (`id`, `nome`, `senha`) VALUES
(1, '9º Ano', 'sesi1234'),
(2, '1º Ano do Ensino Médio', 'sesi1234'),
(3, '2º Ano do Ensino Médio', 'sesi1234'),
(4, '3º Ano do Ensino Médio', 'sesi1234');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `turmas`
--
ALTER TABLE `turmas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
