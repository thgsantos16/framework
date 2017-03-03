<?php

session_start();

$url = $_GET['url'];
$explodir = explode("/", $url);
if(count($explodir) < 2) $lnk = "./";
for($i = 1; $i < count($explodir); $i++) {
	$lnk .= "../";
}

/*

FRAMEWORK PIÁ, para Desenvlvimento e Gestão de Projetos.
Autor: Thiago Santos
Data Inicial: 19/07/2016


*/

// Redireciona para o Login caso falhe a Autenticação
if(empty($_SESSION['loginUser'])) {
	header("location: ".$lnk."login.php");
}


else {

	
// Insere o Cabeçalho Padrão
include "includes/headers.html";

// Inicia  a Estrutura da Página HTML
echo "<body><div id='container'>

<script>$( function() { $('#sombraBranca').click(function() { $('#sombraBranca').fadeOut(); $('.divModal').fadeOut(); }); });</script>
<div id='sombraBranca'></div>


";

// Insere a estrutura HTML que representa o Cabeçalho Visual
include "includes/cabecalho.html";

if(strstr($nomePagina, "projeto")) include "includes/menuProjeto.html";

// Inicia a Renderização do Conteúdo HTML
echo "<div id='conteudo'>";

//echo "<p>AQUI: ".$nomePagina;
// Verifica qual Conteúdo será incluido
if(empty($paginaURI)) include "includes/dashboard.html";
else if(file_exists("includes/".$paginaURI.".html")) include "includes/".$paginaURI.".html"; // Busca o Arquivo pelo nome
else if(strstr($url, '/')) { // Verifica a existência de Páginas Filhas
	$paginaMae = explode("/", $url); // Separa a Página Mãe
	
	if(file_exists("includes/".$paginaMae[0].".html")) include "includes/".$paginaMae[0].".html"; // Busca o Arquivo pelo nome
	else include "includes/404.html"; // Nenhuma Página foi Encontrada

}
else include "includes/404.html";// Nenhuma Página foi Encontrada

echo "</div>"; // Marcação de Final do Conteúdo


// Inclusão do Arquivo de Rodapé
if(empty($nomePagina)) include "includes/rodape.html";
else if(strstr($nomePagina, "projeto")) include "includes/rodapeProjeto.html";
else include "includes/rodape.html";

echo "</div></body>";// Fechamos a Marcação do HTML

}