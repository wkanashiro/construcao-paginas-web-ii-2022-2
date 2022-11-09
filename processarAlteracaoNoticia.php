<?php 
// Inserir a notícia no banco de dados
// Obter dados do formulário
print_r($_POST);
// Conectar ao banco de dados (com PDO)
try {
    $pdo = new PDO('mysql:host=localhost;dbname=noticias', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    echo 'Conexão realizada com sucesso!';
} catch (PDOException $e) {
    echo 'Falha ao conectar ao banco de dados';
    die($e->getMessage());
}

try {
    // Montar SQL para ALTERAÇÃO dos dados
    $query = 'UPDATE 
                noticia 
              SET 
                titulo = :tit, descricao = :descr
              WHERE 
                id = :id';

    // Preparar a SQL com PDO
    $stmt = $pdo->prepare($query);

    // Definir os dados para SQL
    
    $dados = array(
        ':id' => $_POST['idNoticia'],
        ':tit' => $_POST['titulo'],
        ':descr' => $_POST['descricao']
    );

    // (Tentar) Executar SQL de inserção dos dados com o PHP
    $resultado = $stmt->execute($dados);

    if ($resultado == true) {
        header('Location: cadastrarNoticia.php?msg=Notícia ALTERADA com sucesso!');
    }
} catch (PDOException $e) {
    echo 'Falha ao ALTERAR notícia';
    die($e->getMessage());
}

?>