<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>
<h1>Sistema de Cadastro</h1>
<?php
  /* Conectar ao MySQL e selecionar o banco de dados. */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
  if (mysqli_connect_errno()) echo "Falha na conexão com MySQL: " . mysqli_connect_error();
  $database = mysqli_select_db($connection, DB_DATABASE);
  
  /* Garantir que a tabela ESTUDANTES existe. */
  VerifyEstudantesTable($connection, DB_DATABASE);
  
  /* Se os campos de entrada estiverem preenchidos, adiciona uma linha à tabela ESTUDANTES. */
  $estudante_nome = htmlentities($_POST['NOME']);
  $estudante_idade = htmlentities($_POST['IDADE']);
  $estudante_email = htmlentities($_POST['EMAIL']);
  $estudante_ativo = isset($_POST['ATIVO']) ? 1 : 0;
  
  if (strlen($estudante_nome) || strlen($estudante_email)) {
    AddEstudante($connection, $estudante_nome, $estudante_idade, $estudante_email, $estudante_ativo);
  }
?>
<!-- Formulário de entrada -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>NOME</td>
      <td>IDADE</td>
      <td>EMAIL</td>
      <td>ATIVO</td>
    </tr>
    <tr>
      <td>
        <input type="text" name="NOME" maxlength="45" size="30" />
      </td>
      <td>
        <input type="number" name="IDADE" min="18" max="100" size="5" />
      </td>
      <td>
        <input type="email" name="EMAIL" maxlength="90" size="40" />
      </td>
      <td>
        <input type="checkbox" name="ATIVO" value="1" checked />
      </td>
      <td>
        <input type="submit" value="Adicionar Dados" />
      </td>
    </tr>
  </table>
</form>

<!-- Exibir dados da tabela. -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>NOME</td>
    <td>IDADE</td>
    <td>EMAIL</td>
    <td>ATIVO</td>
  </tr>
<?php
$result = mysqli_query($connection, "SELECT * FROM ESTUDANTES");
while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>",
       "<td>",$query_data[3], "</td>",
       "<td>", ($query_data[4] == 1 ? "Sim" : "Não"), "</td>";
  echo "</tr>";
}
?>
</table>

<!-- Limpar recursos. -->
<?php
  mysqli_free_result($result);
  mysqli_close($connection);
?>
</body>
</html>
<?php
/* Adicionar um estudante à tabela. */
function AddEstudante($connection, $nome, $idade, $email, $ativo) {
   $n = mysqli_real_escape_string($connection, $nome);
   $i = mysqli_real_escape_string($connection, $idade);
   $e = mysqli_real_escape_string($connection, $email);
   $a = $ativo ? 1 : 0;
   
   $query = "INSERT INTO ESTUDANTES (NOME, IDADE, EMAIL, ATIVO) VALUES ('$n', $i, '$e', $a);";
   if(!mysqli_query($connection, $query)) echo("<p>Erro ao adicionar dados do estudante.</p>");
}

/* Verificar se a tabela existe e, se não, criá-la. */
function VerifyEstudantesTable($connection, $dbName) {
  if(!TableExists("ESTUDANTES", $connection, $dbName))
  {
     $query = "CREATE TABLE ESTUDANTES (
         ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         NOME VARCHAR(45),
         IDADE INT(3),
         EMAIL VARCHAR(90),
         ATIVO BOOLEAN
       )";
     if(!mysqli_query($connection, $query)) echo("<p>Erro ao criar tabela.</p>");
  }
}

/* Verificar a existência de uma tabela. */
function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);
  
  $checktable = mysqli_query($connection,
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");
  if(mysqli_num_rows($checktable) > 0) return true;
  return false;
}
?>