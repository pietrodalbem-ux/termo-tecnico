create database dicionario_termos;
use dicionario_termos;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/03/2026 às 11:58
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

--
-- Despejando dados para a tabela `termos`
--

INSERT INTO `termos` (`id`, `materia`, `nome`, `descricao`, `imagem`, `status`, `data_criacao`, `autor`, `turma_id`) VALUES
(1, 'portugues', 'Adjetivo', 'Palavra que caracteriza o substantivo, indicando-lhe qualidade, estado ou condição.', 'https://images.unsplash.com/photo-1543165365-07232eda9670?w=600', 'aprovado', '2026-03-18 12:06:29', 'João Silva', NULL),
(2, 'portugues', 'Barbarismo', 'Vício de linguagem que consiste em errar a pronúncia, a grafia ou a flexão de uma palavra.', 'https://images.unsplash.com/photo-1510620868846-95f9c5a610f7?w=600', 'aprovado', '2026-03-18 12:06:29', 'Maria Oliveira', NULL),
(3, 'portugues', 'Conjunção', 'Palavra invariável que liga duas orações ou dois termos semelhantes de uma mesma oração.', 'https://images.unsplash.com/photo-1628102377317-06103e689d02?w=600', 'aprovado', '2026-03-18 12:06:29', 'Pedro Santos', NULL),
(4, 'portugues', 'Denotação', 'Uso da palavra em seu sentido literal, objetivo e dicionarizado, sem margem para duplas interpretações.', 'https://images.unsplash.com/photo-1512314889357-e157c22f938d?w=600', 'aprovado', '2026-03-18 12:06:29', 'Ana Souza', NULL),
(5, 'portugues', 'Elipse', 'Figura de sintaxe que consiste na omissão de um termo facilmente identificável pelo contexto.', 'https://images.unsplash.com/photo-1606132746197-f507b51d8b9d?w=600', 'aprovado', '2026-03-18 12:06:29', 'Lucas Costa', NULL),
(6, 'portugues', 'Fonema', 'A menor unidade sonora que compõe uma palavra e que tem o poder de diferenciar significados.', 'https://images.unsplash.com/photo-1598370725227-86c6be67272a?w=600', 'aprovado', '2026-03-18 12:06:29', 'Bruna Pereira', NULL),
(7, 'portugues', 'Gramática', 'Conjunto de regras e normas que regem o funcionamento de uma língua, seu uso e estrutura.', 'https://images.unsplash.com/photo-1589998059171-988d887df646?w=600', 'aprovado', '2026-03-18 12:06:29', 'Felipe Almeida', NULL),
(8, 'portugues', 'Hiato', 'Encontro de duas vogais na mesma palavra, mas que pertencem a sílabas diferentes (ex: sa-ú-de).', 'https://images.unsplash.com/photo-1513682121497-80211f36a7d3?w=600', 'aprovado', '2026-03-18 12:06:29', 'Camila Lima', NULL),
(9, 'portugues', 'Interjeição', 'Palavra invariável que exprime emoções, sensações, apelos ou sentimentos súbitos (ex: Uau!, Ah!).', 'https://images.pexels.com/photos/1031737/pexels-photo-1031737.jpeg?w=600', 'aprovado', '2026-03-18 12:06:29', 'Thiago Gomes', NULL),
(10, 'portugues', 'Jargão', 'Vocabulário específico usado por um determinado grupo profissional ou social (ex: jargão médico, jurídico).', 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=600', 'aprovado', '2026-03-18 12:06:29', 'Fernanda Rocha', NULL),
(11, 'portugues', 'Kafkaesco', 'Adjetivo literário usado para descrever situações absurdas, burocráticas ou angustiantes, inspirado no autor Franz Kafka.', 'https://images.unsplash.com/photo-1576081258607-0744c06b2909?w=600', 'aprovado', '2026-03-18 12:06:29', 'Gustavo Martins', NULL),
(12, 'portugues', 'Locução', 'Conjunto de duas ou mais palavras que têm o valor e a função de uma única classe gramatical.', 'https://images.unsplash.com/photo-1508780703310-449e782a0b12?w=600', 'aprovado', '2026-03-18 12:06:29', 'Letícia Fernandes', NULL),
(13, 'portugues', 'Metáfora', 'Figura de linguagem que emprega um termo com significado diferente do habitual, baseada em uma comparação implícita.', 'https://images.unsplash.com/photo-1490730141103-6cac27aaab94?w=600', 'aprovado', '2026-03-18 12:06:29', 'Rodrigo Ribeiro', NULL),
(14, 'portugues', 'Neologismo', 'Criação de uma nova palavra ou atribuição de um novo sentido a uma palavra já existente no idioma.', 'https://images.unsplash.com/photo-1629811653457-418086208a10?w=600', 'aprovado', '2026-03-18 12:06:29', 'Amanda Carvalho', NULL),
(15, 'portugues', 'Oxítona', 'Palavra cuja sílaba tônica (aquela pronunciada com mais intensidade) é a última (ex: ca-fé).', 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=600', 'aprovado', '2026-03-18 12:06:29', 'Maria Oliveira', NULL),
(16, 'portugues', 'Paradoxo', 'Figura de pensamento que une ideias contraditórias em uma mesma expressão, criando uma falta de lógica aparente.', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600', 'aprovado', '2026-03-18 12:06:29', 'Ana Souza', NULL),
(17, 'portugues', 'Quiasmo', 'Figura de linguagem caracterizada pelo cruzamento de termos em frases ou versos, formando uma estrutura em X.', 'https://images.unsplash.com/photo-1510133728162-ac42c75a4206?w=600', 'aprovado', '2026-03-18 12:06:29', 'João Silva', NULL),
(18, 'portugues', 'Redundância', 'Emprego de palavras ou expressões inúteis para a transmissão do recado (ex: subir para cima). Também chamado de pleonasmo vicioso.', 'https://images.unsplash.com/photo-1622328228318-79c2354c6020?w=600', 'aprovado', '2026-03-18 12:06:29', 'Camila Lima', NULL),
(19, 'portugues', 'Sintaxe', 'Parte da gramática que estuda a disposição e a relação das palavras dentro das frases e orações.', 'https://images.unsplash.com/photo-1520004434532-6684164f378d?w=600', 'aprovado', '2026-03-18 12:06:29', 'Fernanda Rocha', NULL),
(20, 'portugues', 'Trovadorismo', 'Primeiro movimento literário da língua portuguesa, caracterizado pelas cantigas cantadas por trovadores medievais.', 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600', 'aprovado', '2026-03-18 12:06:29', 'Thiago Gomes', NULL),
(21, 'portugues', 'Ufanismo', 'Atitude de orgulho exagerado em relação ao próprio país, frequentemente presente em textos literários patrióticos.', 'https://images.unsplash.com/photo-1582881515286-665e8a55e2d1?w=600', 'aprovado', '2026-03-18 12:06:29', 'Letícia Fernandes', NULL),
(22, 'portugues', 'Verbo', 'Palavra que indica ação, estado ou fenômeno da natureza, situando-os no tempo.', 'https://images.unsplash.com/photo-1585776245991-cf89dd7fc73a?w=600', 'aprovado', '2026-03-18 12:06:29', 'Pedro Santos', NULL),
(23, 'portugues', 'Webjornalismo', 'Neologismo para designar o jornalismo praticado e disseminado na internet, com características de multimídia e hipertexto.', 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=600', 'aprovado', '2026-03-18 12:06:29', 'Lucas Costa', NULL),
(24, 'portugues', 'Xenismo', 'Emprego de palavra estrangeira na língua materna sem que ela sofra adaptações na grafia ou na pronúncia (ex: show, design).', 'https://images.unsplash.com/photo-1558238128-4f275e7a935b?w=600', 'aprovado', '2026-03-18 12:06:29', 'Bruna Pereira', NULL),
(25, 'portugues', 'Youtuber', 'Neologismo incorporado ao idioma para designar o produtor de conteúdo de vídeo na plataforma YouTube.', 'https://images.unsplash.com/photo-1533130061792-64b345e4a833?w=600', 'aprovado', '2026-03-18 12:06:29', 'Amanda Carvalho', NULL),
(26, 'portugues', 'Zeugma', 'Figura de linguagem em que um termo já citado na frase anterior é omitido na seguinte para evitar repetição.', 'https://images.unsplash.com/photo-1510133728162-ac42c75a4206?w=600', 'aprovado', '2026-03-18 12:06:29', 'Rodrigo Ribeiro', NULL),
(27, 'matematica', 'Álgebra', 'Ramo da matemática que usa letras e símbolos para representar números e grandezas em equações.', 'https://images.unsplash.com/photo-1581093196277-9f6c20ba9673?w=600', 'aprovado', '2026-03-18 12:06:30', 'Bruno Pinto', NULL),
(28, 'matematica', 'Bissetriz', 'Semirreta com origem no vértice de um ângulo e que o divide em dois ângulos com medidas perfeitamente iguais.', 'https://images.pexels.com/photos/159711/geometrical-instruments-geometry-mathematics-drawing-159711.jpeg?w=600', 'aprovado', '2026-03-18 12:06:30', 'Larissa Moraes', NULL),
(29, 'matematica', 'Cosseno', 'Em um triângulo retângulo, é a razão entre o comprimento do cateto adjacente ao ângulo e o comprimento da hipotenusa.', 'https://images.unsplash.com/photo-1513682121497-80211f36a7d3?w=600', 'aprovado', '2026-03-18 12:06:30', 'Rafael Nunes', NULL),
(30, 'matematica', 'Denominador', 'O número inferior em uma fração, que indica em quantas partes iguais o número inteiro foi dividido.', 'https://images.unsplash.com/photo-1516321497487-e288fb19713f?w=600', 'aprovado', '2026-03-18 12:06:30', 'Carla Machado', NULL),
(31, 'matematica', 'Equação', 'Sentença matemática que possui uma igualdade e pelo menos uma incógnita (letra que representa um valor desconhecido).', 'https://images.unsplash.com/photo-1596495573175-979fd6a188ff?w=600', 'aprovado', '2026-03-18 12:06:30', 'Vitor Castro', NULL),
(32, 'matematica', 'Fatorial', 'Multiplicação de um número natural por todos os seus antecessores maiores que zero. Representado pelo símbolo de exclamação (!).', 'https://images.unsplash.com/photo-1533130061792-64b345e4a833?w=600', 'aprovado', '2026-03-18 12:06:30', 'Gabriela Barbosa', NULL),
(33, 'matematica', 'Geometria', 'Área da matemática dedicada ao estudo das formas, tamanhos, posições relativas de figuras e propriedades do espaço.', 'https://images.pexels.com/photos/1111368/pexels-photo-1111368.jpeg?w=600', 'aprovado', '2026-03-18 12:06:30', 'Matheus Vieira', NULL),
(34, 'matematica', 'Hipotenusa', 'O lado mais longo de um triângulo retângulo, sempre localizado em posição oposta ao ângulo reto (90 graus).', 'https://images.unsplash.com/photo-1518331647614-7a1f04cd34cf?w=600', 'aprovado', '2026-03-18 12:06:30', 'Isabela Dias', NULL),
(35, 'matematica', 'Incógnita', 'Um valor desconhecido em um problema ou equação matemática, geralmente representado por letras como x, y ou z.', 'https://images.unsplash.com/photo-1521791136064-7986c292321d?w=600', 'aprovado', '2026-03-18 12:06:30', 'André Correia', NULL),
(36, 'matematica', 'Juros', 'Remuneração cobrada pelo empréstimo de um dinheiro. É expresso como uma taxa percentual ao longo do tempo.', 'https://images.unsplash.com/photo-1553729459-efe14ef6055d?w=600', 'aprovado', '2026-03-18 12:06:30', 'Bianca Jesus', NULL),
(37, 'matematica', 'Kilobyte', 'Embora da informática, muito usado em raciocínio lógico-matemático de potências de base 2. Corresponde a 1.024 bytes (2 elevado a 10).', 'https://images.unsplash.com/photo-1629811653457-418086208a10?w=600', 'aprovado', '2026-03-18 12:06:30', 'Diego Marques', NULL),
(38, 'matematica', 'Logaritmo', 'O expoente ao qual uma base fixa deve ser elevada para produzir um determinado número.', 'https://images.unsplash.com/photo-1512411993214-41d9c647900c?w=600', 'aprovado', '2026-03-18 12:06:30', 'Jéssica Santana', NULL),
(39, 'matematica', 'Matriz', 'Arranjo bidimensional (tabela) de números, símbolos ou expressões, organizados em linhas e colunas.', 'https://images.unsplash.com/photo-1596495573175-979fd6a188ff?w=600', 'aprovado', '2026-03-18 12:06:30', 'Vitor Castro', NULL),
(40, 'matematica', 'Numerador', 'A parte superior de uma fração matemática, que mostra quantas partes do todo estão sendo consideradas.', 'https://images.unsplash.com/photo-1516321497487-e288fb19713f?w=600', 'aprovado', '2026-03-18 12:06:30', 'Matheus Vieira', NULL),
(41, 'matematica', 'Ortogonal', 'Diz-se de retas ou planos que se cruzam formando ângulos retos (90 graus), ou seja, são perpendiculares.', 'https://images.unsplash.com/photo-1581092916357-5896ebc48073?w=600', 'aprovado', '2026-03-18 12:06:30', 'Jéssica Santana', NULL),
(42, 'matematica', 'Polígono', 'Figura geométrica plana e fechada, formada por segmentos de reta (ex: triângulos, quadrados, pentágonos).', 'https://images.pexels.com/photos/1111368/pexels-photo-1111368.jpeg?w=600', 'aprovado', '2026-03-18 12:06:30', 'André Correia', NULL),
(43, 'matematica', 'Quociente', 'O resultado obtido a partir de uma operação de divisão matemática.', 'https://images.unsplash.com/photo-1516321497487-e288fb19713f?w=600', 'aprovado', '2026-03-18 12:06:30', 'Bianca Jesus', NULL),
(44, 'matematica', 'Radiciação', 'Operação matemática inversa da potenciação, cujo objetivo é encontrar a raiz de um determinado número.', 'https://images.unsplash.com/photo-1513682121497-80211f36a7d3?w=600', 'aprovado', '2026-03-18 12:06:30', 'Diego Marques', NULL),
(45, 'matematica', 'Seno', 'Razão trigonométrica entre o cateto oposto a um determinado ângulo agudo e a hipotenusa do triângulo retângulo.', 'https://images.unsplash.com/photo-1518331647614-7a1f04cd34cf?w=600', 'aprovado', '2026-03-18 12:06:30', 'Isabela Dias', NULL),
(46, 'matematica', 'Teorema', 'Afirmação matemática que pode ser provada como verdadeira com base em postulados, axiomas e lógicas preestabelecidas.', 'https://images.unsplash.com/photo-1589998059171-988d887df646?w=600', 'aprovado', '2026-03-18 12:06:30', 'Gabriela Barbosa', NULL),
(47, 'matematica', 'União', 'Em teoria dos conjuntos, é a operação que junta todos os elementos de dois ou mais conjuntos em um único conjunto.', 'https://images.unsplash.com/photo-1628102377317-06103e689d02?w=600', 'aprovado', '2026-03-18 12:06:30', 'Carla Machado', NULL),
(48, 'matematica', 'Vértice', 'O ponto em comum entre os lados de um ângulo, ou o ponto de encontro de dois ou mais segmentos de reta em figuras geométricas.', 'https://images.pexels.com/photos/159711/geometrical-instruments-geometry-mathematics-drawing-159711.jpeg?w=600', 'aprovado', '2026-03-18 12:06:30', 'Rafael Nunes', NULL),
(49, 'matematica', 'Watt', 'Unidade do Sistema Internacional usada para medir potência. Em cálculos matemáticos físicos, equivale a um Joule por segundo.', 'https://images.pexels.com/photos/331688/pexels-photo-331688.jpeg?w=600', 'aprovado', '2026-03-18 12:06:30', 'Larissa Moraes', NULL),
(50, 'matematica', 'X (Eixo das Abscissas)', 'No plano cartesiano, representa o eixo horizontal onde são localizados os valores iniciais de uma coordenada.', 'https://images.unsplash.com/photo-1521791136064-7986c292321d?w=600', 'aprovado', '2026-03-18 12:06:30', 'Bruno Pinto', NULL),
(51, 'matematica', 'Y (Eixo das Ordenadas)', 'No plano cartesiano, representa o eixo vertical que cruza perpendicularmente com as abscissas, completando as coordenadas.', 'https://images.unsplash.com/photo-1521791136064-7986c292321d?w=600', 'aprovado', '2026-03-18 12:06:30', 'Diego Marques', NULL),
(52, 'matematica', 'Zero', 'Número que representa uma quantidade nula. Em um sistema de coordenadas cartesiano, representa a origem.', 'https://images.unsplash.com/photo-1502691876148-a84978e59af8?w=600', 'aprovado', '2026-03-18 12:06:30', 'João Silva', NULL),
(53, 'matematica', 'uadfasd', 'auysgdua', 'uploads/69baa81667567.png', 'aprovado', '2026-03-18 13:26:46', 'Pietro ', 4),
(54, 'matematica', 'nilo', 'professor', '', 'aprovado', '2026-03-18 13:29:40', 'professor', NULL);

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
