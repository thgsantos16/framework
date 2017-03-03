<?php

session_start();

/*

FRAMEWORK PIÁ, para Desenvlvimento e Gestão de Projetos.
Autor: Thiago Santos
Data Inicial: 19/07/2016


*/

// Seta a hora e data para Horário de Brasília
date_default_timezone_set('America/Sao_Paulo');


// Conexão com banco de Dados 
$db_server = '10.1.10.130\Producao'; // Inatância de Produção
$db_database = 'integracoes'; // Banco de dados "integracoes"
$db_user = 'soa'; // Usuário com acesso nível Owner
$db_passwd = 'Fr@m3work'; // Senha


$connectionInfo = array("Database"=>$db_database, "UID"=>$db_user, "PWD"=>$db_passwd); // Seta os Parâmetros de Conexão
$conn = sqlsrv_connect($db_server, $connectionInfo); // Executa o Connect via SQLSRV


// Verifica se o Formulário de Login foi Preenchido
if(isset($_POST)) {
	$sql = "SELECT * FROM pw_usuarios WHERE login LIKE '".$_POST['login']."' AND senha LIKE '".$_POST['senha']."'"; // Prepara SQL
	$query = sqlsrv_query($conn, $sql); // Executa a Query
	$num = sqlsrv_has_rows($query); // Verifica a Existência linhas = Confirma o Login
	$row = sqlsrv_fetch_array($query); // Pega os Dados do Respectivo Usuário

	// Seta as Variáveis de Sessão SE o Login ocorreu
	if($num) $_SESSION['loginUser'] = $_POST['login'];
	if($num) $_SESSION['loginNome'] = $row['nome'];
	if($num) $_SESSION['loginId'] = $row['id'];
}

// Caso o Usuário esteja Logado Impede de acessar a página de Login.
if(isset($_SESSION['loginUser'])) {
	header("location: ./");
}

else {

// Chama o Arquivo de Header Padrão
include "includes/headers.html";

echo "<body><div id='container'>";

// Chama o Arquivo Contendo o Formulário de Login
include "includes/login.html";

echo "</div></body";

}


