<?php
require_once "admin/functions/db_connect.php";
require_once "admin/functions/functions.php";

// Criar uma instância da classe CategoriasManager
$categoriasManager = new CategoriasManager();

// Obter as categorias do banco de dados
$categorias = $categoriasManager->fetchCategorias();

?>

<!doctype html>
<html lang="pt-br" class="no-js">

<head>
    <title>Blog</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Delicious+Handrawn&family=Roboto:wght@300;400;700&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/mite-assets.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <!-- Container -->
    <div id="container">
        <!-- Header -->
        <header class="clearfix">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                    <a class="navbar-brand" href="home">
                        <img src="images/logo.png" alt="">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav m-auto">
                            <li><a href="home">Home</a></li>
                            <?php
                            foreach ($categorias as $categoria) {
                                $nomeCategoria = urlencode($categoria['categoria']); // Codifica o nome da categoria para usar na URL
                            ?>
                                <li><a href="categoria.php?categoria=<?php echo $nomeCategoria; ?>"><?php echo $categoria['categoria']; ?></a></li>
                            <?php } ?>

                        </ul>
                    </div>
                    <a class="search-button" href="#"><i class="fa fa-search"></i></a>
                    <form class="form-search">
                        <input type="search" placeholder="Buscar:" />
                    </form>
                </div>
            </nav>
        </header>
        <!-- End Header -->