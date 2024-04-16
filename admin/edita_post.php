<?php
require_once "functions/protect.php";
require_once "functions/functions.php";

// Inicializar objetos
$fetchonerecord = new Categoria();
$updatepost = new Post();

// Processar formulário de atualização
if (isset($_POST['update'])) {
    $postid = $_GET['id'];
    $titulo = htmlspecialchars($_POST['titulo']); // Sanitize título
    $categoria = $_POST['categoria'];
    $slug = $_POST['slug'];
    $autor = $_POST['autor'];
    $data_post = $_POST['data_post'];
    $conteudo = $_POST['conteudo'];
    $destaque = isset($_POST['destaque']) ? 1 : 0;

    // Obter o post atual para verificar a imagem atual
    $post = $updatepost->fetchonerecord($postid);
    $row = mysqli_fetch_array($post);
    $imagem_atual = $row['imagem']; // Caminho da imagem atual

    // Verificar se uma nova imagem foi enviada
    if (!empty($_FILES["imagem"]["name"])) {
        $imagem_path = "uploads/" . basename($_FILES["imagem"]["name"]);

        // Validar o tipo de arquivo
        $check = getimagesize($_FILES["imagem"]["tmp_name"]);
        if ($check !== false) {
            // Mover o arquivo para o diretório de uploads
            if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem_path)) {
                $imagem_atual = $imagem_path; // Usar o caminho da nova imagem
                echo "<script>alert('Imagem enviada com sucesso!');</script>";
            } else {
                echo "<script>alert('Erro ao enviar a imagem!');</script>";
            }
        } else {
            echo "<script>alert('O arquivo selecionado não é uma imagem válida!');</script>";
        }
    }

    // Atualizar o post no banco de dados
    $sql = $updatepost->update($titulo, $autor, $categoria, $data_post, $imagem_atual, $conteudo, $slug, $destaque, $postid);

    if ($sql) {
        echo "<script>alert('Post atualizado com sucesso!');</script>";
        echo "<script>window.location.href='lista_post'</script>";
    } else {
        echo "<script>alert('Algo deu errado! Tente novamente!');</script>";
        echo "<script>window.location.href='edita_post?id=$postid'</script>";
    }
}

require_once "header.php";
require_once "sidebar.php";
require_once "topbar.php";
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Editar Post</h1>

    <!-- Forms Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <?php
            $postid = $_GET['id'];
            $post = $updatepost->fetchonerecord($postid);
            while ($row = mysqli_fetch_array($post)) {
            ?>
                <form method="post" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $row['destaque']; ?>" id="destaque" name="destaque" <?php echo ($row['destaque'] == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="destaque">
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
                                <input type="text" class="form-control form-control-user" id="titulo" name="titulo" aria-describedby="emailHelp" placeholder="Título" value="<?php echo htmlspecialchars($row['titulo']); ?>" oninput="generateSlug()">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="categoria">Categoria</label>
                                <select class="form-control" id="categoria" name="categoria">
                                    <?php
                                    $categorias = $fetchonerecord->fetchdata("categoria");
                                    foreach ($categorias as $categoria) {
                                        $selected = '';
                                        if (($categoria['id'] == $row['categoria'] && is_numeric($row['categoria'])) ||
                                            ($categoria['categoria'] == $row['categoria'] && !is_numeric($row['categoria']))
                                        ) {
                                            $selected = 'selected';
                                        }
                                        echo "<option value='" . $categoria['id'] . "' $selected>" . $categoria['categoria'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control form-control-user" id="slug" name="slug" aria-describedby="emailHelp" placeholder="Título" value="<?php echo $row['slug']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="autor">Autor</label>
                                <input type="text" class="form-control form-control-user" id="autor" name="autor" aria-describedby="emailHelp" placeholder="" value="<?php echo htmlspecialchars($row['autor']); ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="data_post">Data do Post</label>
                                <input type="date" class="form-control form-control-user" id="data_post" name="data_post" aria-describedby="emailHelp" placeholder="" value="<?php echo $row['data_post']; ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="imagem">Imagem</label>
                                <input type="file" class="form-control-file" id="imagem" name="imagem" accept="image/*">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="imagem">Imagem</label><br>
                                <img src="<?php echo $row['imagem']; ?>" width="100%" height="auto" />
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="conteudo">Conteúdo</label>
                                <textarea class="form-control form-control-user" id="conteudo" name="conteudo" row="5" value="<?php echo $row['conteudo']; ?>"><?php echo $row['conteudo']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary" name="update">Atualizar Post</button>
                        </div>
                    </div>
                </form>
            <?php } ?>
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
            .normalize('NFD') // Normaliza os caracteres acentuados
            .replace(/[\u0300-\u036f]/g, '') // Remove os diacríticos
            .replace(/\s+/g, '-') // Substitui espaços em branco por hífens
            .replace(/[^\w\-]+/g, '') // Remove caracteres não alfanuméricos
            .replace(/\-\-+/g, '-') // Substitui múltiplos hífens por um único hífen
            .replace(/^-+/, '') // Remove hífens no início
            .replace(/-+$/, ''); // Remove hífens no final
        return slug;
    }
</script>
<?php require_once "footer.php"; ?>