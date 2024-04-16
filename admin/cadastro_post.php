<?php
require_once "functions/protect.php";
require_once "functions/functions.php";

$fetchdata = new Post();
$fetchonerecord = new Categoria();
$insertdata = new Post();

// Processar o formulário de inserção
if (isset($_POST['insert'])) {
    $titulo = $_POST['titulo'];
    $categoria = $_POST['categoria'];
    $slug = $_POST['slug'];
    $autor = $_POST['autor'];
    $data_post = $_POST['data_post'];
    $conteudo = $_POST['conteudo'];
    $destaque = isset($_POST['destaque']) ? 1 : 0;

    $imagem = ""; // Caminho da imagem no banco de dados
    $imagem_path = "";

    // Verificar se um arquivo de imagem foi enviado
    if (isset($_FILES["imagem"]["name"]) && $_FILES["imagem"]["error"] === UPLOAD_ERR_OK) {
        $imagem_path = "uploads/" . basename($_FILES["imagem"]["name"]);

        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem_path)) {
            $imagem = $imagem_path;
            echo "<script>alert('Imagem enviada com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao enviar a imagem!');</script>";
        }
    }

    // Converta o título para UTF-8 de forma segura
    $titulo = mb_convert_encoding($titulo, 'UTF-8', 'UTF-8');

    // Insira o post no banco de dados
    $sql = $insertdata->insert($titulo, $autor, $categoria, $data_post, $imagem, $conteudo, $slug, $destaque);

    if ($sql) {
        echo "<script>alert('Post inserido com sucesso!');</script>";
        echo "<script>window.location.href='lista_post';</script>";
    } else {
        echo "<script>alert('Algo deu errado! Tente novamente!');</script>";
        echo "<script>window.location.href='cadastro_post';</script>";
    }
}

require_once "header.php";
?>


<?php require_once "sidebar.php"; ?>

<?php require_once "topbar.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Cadastro de Post</h1>

    <!-- Forms Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="destaque" name="destaque">
                                <label class="form-check-label" for="flexCheckIndeterminate">
                                    Destaque
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" class="form-control form-control-user" id="titulo" name="titulo" aria-describedby="emailHelp" placeholder="Título" oninput="generateSlug()">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="categoria_id">Categoria</label>
                            <select class="form-control" id="categoria" name="categoria">
                                <?php
                                $categorias = $fetchonerecord->fetchdata("categoria");
                                foreach ($categorias as $row) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['categoria'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control form-control-user" id="slug" name="slug" aria-describedby="emailHelp" placeholder="Slug" readonly>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="autor">Autor</label>
                            <input type="text" class="form-control form-control-user" id="autor" name="autor" aria-describedby="emailHelp" placeholder="">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="data_post">Data do Post</label>
                            <input type="date" class="form-control form-control-user" id="data_post" name="data_post" aria-describedby="emailHelp" placeholder="">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="imagem">Imagem</label>
                            <input type="file" class="form-control-file" id="imagem" name="imagem" accept="image/*">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="conteudo">Conteúdo</label>
                            <textarea class="form-control form-control-user" id="conteudo" name="conteudo" row="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-primary" name="insert">Cadastrar Post</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<script>
    function generateSlug() {
        var titulo = document.getElementById('titulo').value;
        var slug = slugify(titulo);
        document.getElementById('slug').value = slug;
    }

    function slugify(text) {
        var slug = text.toString().toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
        return slug;
    }
</script>
<?php require_once "footer.php"; ?>