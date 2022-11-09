<?php 
// Obter o ID da notícia a ser alterada
print_r($_GET['id']);

try {
    $pdo = new PDO('mysql:host=localhost;dbname=noticias', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    echo 'Conexão realizada com sucesso!';
} catch (PDOException $e) {
    echo 'Falha ao conectar ao banco de dados';
    die($e->getMessage());
}

// Buscar as informações no banco de dados
try {
    // Montar SQL para inserção dos dados
    $query = 'SELECT * FROM noticia WHERE id = :id';

    // Preparar a SQL com PDO
    $stmt = $pdo->prepare($query);

    // Definir os dados para SQL
    /*
    $dados = array(
        ':tit' => $_POST['titulo'],
        ':descr' => $_POST['descricao']
    );
    */

    $stmt->bindValue(':id', $_GET['id']);

    // (Tentar) Executar SQL de inserção dos dados com o PHP
    //$resultado = $stmt->execute($dados);
    $stmt->execute();
    $noticia = $stmt->fetchAll();
    $noticia = $noticia[0];

} catch (PDOException $e) {
    echo 'Falha ao obter informações da notícia';
    die($e->getMessage());
}

// Carregar as informações no formulário
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alteração de Notícia</title>
    
    <style>
        th {
            border: 1px solid;
        }
    </style>
</head>
<body>
    <?php echo $_GET['msg']; ?>
    <h1>Alteração de Notícia</h1>
    <form action="processarAlteracaoNoticia.php" method="post" id="formularioNoticia">
        <input type="hidden" name="idNoticia" value="<?php echo $noticia['id']; ?>">
        <div>
            <label for="titulo">Título</label><br/>
            <input type="text" name="titulo" id="titulo" value="<?php echo $noticia['titulo']; ?>">
        </div>
        <br/>
        <div>
            <label for="descricao">Descrição</label><br/>
            <textarea name="descricao" id="descricao" cols="30" rows="10"><?php echo $noticia['descricao'] ?></textarea>
        </div>
        <br/>
        <button type="submit" name="enviarDados">Alterar</button>
    </form>
</body>
</html>