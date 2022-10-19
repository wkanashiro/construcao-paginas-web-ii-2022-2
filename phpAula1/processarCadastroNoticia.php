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
    // Montar SQL para inserção dos dados
    $query = 'INSERT INTO noticia (titulo, descricao) VALUES (:tit, :descr)';

    // Preparar a SQL com PDO
    $stmt = $pdo->prepare($query);

    // Definir os dados para SQL
    $dados = array(
        ':tit' => $_POST['titulo'],
        ':descr' => $_POST['descricao']
    );

    // (Tentar) Executar SQL de inserção dos dados com o PHP
    $resultado = $stmt->execute($dados);

    if ($resultado == true) {
        header('Location: cadastrarNoticia.php?msg=Notícia cadastrada com sucesso!');
    }
} catch (PDOException $e) {
    echo 'Falha ao inserir notícia';
    die($e->getMessage());
}

?>