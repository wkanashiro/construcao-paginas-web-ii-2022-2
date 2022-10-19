<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=noticias', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    echo 'Conexão realizada com sucesso!';
} catch (PDOException $e) {
    echo 'Falha ao conectar ao banco de dados';
    die($e->getMessage());
}

$sql = 'SELECT * FROM noticia';
$noticias = array();

try {
    $stmt = $pdo->prepare($sql);

    $resultado = $stmt->execute();
    
    if ($resultado) {
        $noticias = $stmt->fetchAll();
    } 
    else {
        die('Falha ao executar a SQL');
    }
}
catch (PDOException $e) {
    die($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de uma Nova Notícia</title>
    <script>
        function validarDados() {
            let titulo = document.getElementById('titulo').value;
            let descricao = document.getElementById('descricao').value;
            let formulario = document.getElementById('formularioNoticia');

            if (titulo && descricao) {
                return true;
            }
            else {
                alert('Preencha os dados!');
                return false;
            }            
        }
    </script>
    <style>
        th {
            border: 1px solid;
        }
    </style>
</head>
<body>
    <?php echo $_GET['msg']; ?>
    <h1>Cadastro de uma Nova Notícia</h1>
    <form action="processarCadastroNoticia.php" method="post" id="formularioNoticia">
        <div>
            <label for="titulo">Título</label><br/>
            <input type="text" name="titulo" id="titulo">
        </div>
        <br/>
        <div>
            <label for="descricao">Descrição</label><br/>
            <textarea name="descricao" id="descricao" cols="30" rows="10"></textarea>
        </div>
        <br/>
        <button type="submit" name="enviarDados" onclick="return validarDados();">Cadastrar</button>
    </form>
    <?php if (empty($noticias)) { ?>
        <h2>Nenhum registro encontrado.</h2>
    <?php } else { ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($noticias as $n) { ?>
                    <tr>
                        <th><?php echo $n['id']; ?></th>
                        <th><?php echo $n['titulo']; ?></th>
                        <th><?php echo $n['descricao']; ?></th>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</body>
</html>