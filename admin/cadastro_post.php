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

    $imagem = "";
    $video = "";
    $media_path = "uploads/" . basename($_FILES["media"]["name"]);
    $media_type = mime_content_type($_FILES["media"]["tmp_name"]);

    if (strpos($media_type, 'image') !== false) {
        $imagem = $media_path;
    } elseif (strpos($media_type, 'video') !== false) {
        $video = $media_path;
    }

    if (move_uploaded_file($_FILES["media"]["tmp_name"], $media_path)) {
        echo "<script>alert('Arquivo enviado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao enviar o arquivo!');</script>";
    }

    $titulo = mb_convert_encoding($titulo, 'UTF-8', 'UTF-8');

    $sql = $insertdata->insert($titulo, $autor, $categoria, $data_post, $imagem, $video, $conteudo, $slug, $destaque);

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

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Cadastro de Post</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="destaque" name="destaque">
                                <label class="form-check-label" for="flexCheckIndeterminate">Destaque</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" class="form-control form-control-user" id="titulo" name="titulo" placeholder="Título" oninput="generateSlug()">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="categoria">Categoria</label>
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
                            <input type="text" class="form-control form-control-user" id="slug" name="slug" placeholder="Slug" readonly>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="autor">Autor</label>
                            <input type="text" class="form-control form-control-user" id="autor" name="autor">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="data_post">Data do Post</label>
                            <input type="date" class="form-control form-control-user" id="data_post" name="data_post">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="media">Imagem ou Vídeo</label>
                            <input type="file" class="form-control-file" id="media" name="media" accept="image/*,video/*">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="conteudo">Conteúdo</label>
                            <textarea class="form-control form-control-user" id="conteudo" name="conteudo" rows="5"></textarea>
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

<script>
    function generateSlug() {
        var titulo = document.getElementById('titulo').value;
        var slug = slugify(titulo);
        document.getElementById('slug').value = slug;
    }

    function slugify(text) {
        return text.toString().toLowerCase()
            .normalize('NFD')
            .replace(/[̀-ͯ]/g, '')
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }
</script>
<?php require_once "footer.php"; ?>