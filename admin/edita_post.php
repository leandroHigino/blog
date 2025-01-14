<?php
require_once "functions/protect.php";
require_once "functions/functions.php";

//Inicializar objetos
$fetchonerecord = new Categoria();
$updatepost = new Post();

//Processar formulário de atualização
if (isset($_POST['update'])) {
    $postid = $_GET['id'];
    $titulo = htmlspecialchars($_POST['titulo']);
    $categoria = $_POST['categoria'];
    $slug = $_POST['slug'];
    $autor = $_POST['autor'];
    $data_post = $_POST['data_post'];
    $conteudo = $_POST['conteudo'];
    $destaque = isset($_POST['destaque']) ? 1 : 0;
    $video = $_POST['video'];

    // Obter o post atual para recuperar o caminho da imagem ou vídeo atual
    $post = $updatepost->fetchonerecord($postid);
    if ($post && $post->num_rows > 0) {
        $row = $post->fetch_assoc();
        $imagem_atual = $row['imagem']; // Caminho da imagem atual do post
        $video_atual = $row['video'];  // Caminho do vídeo atual
    } else {
        echo "<script>alert('Post não encontrado!');</script>";
        echo "<script>window.location.href='edita_post?id=$postid'</script>";
        exit;
    }

    // Verificar se uma nova imagem foi enviada
    if (!empty($_FILES["imagem"]["name"])) {
        $imagem_name = str_replace(' ', '_', $_FILES["imagem"]["name"]);
        $imagem_path = "uploads/" . basename($imagem_name);
        $check = getimagesize($_FILES["imagem"]["tmp_name"]);
        if ($check !== false && move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem_path)) {
            $imagem_atual = $imagem_path;
            $video_atual = null; // Remover o vídeo se a imagem for substituída
        } else {
            echo "<script>alert('Erro ao enviar a imagem!');</script>";
        }
    }

    //Verificar se um novo vídeo foi enviado
    if (!empty($_FILES["video"]["name"])) {
        $video_name = str_replace(' ', '_', $_FILES["video"]["name"]);
        $video_path = "uploads/" . basename($video_name);
        $video_type = mime_content_type($_FILES["video"]["tmp_name"]);
        if (strpos($video_type, 'video') !== false && move_uploaded_file($_FILES["video"]["tmp_name"], $video_path)) {
            $video_atual = $video_path;
            $imagem_atual = null; //Remover a imagem se o vídeo for substituído
        } else {
            echo "<script>alert('Erro ao enviar o vídeo!');</script>";
        }
    }

    // Se não houver imagem ou vídeo, manter os arquivos atuais
    $imagem_atual = empty($_FILES["imagem"]["name"]) ? ($imagem_atual ? $imagem_atual : null) : $imagem_atual;
    $video_atual = empty($_FILES["video"]["name"]) ? ($video_atual ? $video_atual : null) : $video_atual;

    // Atualizar o post no banco de dados
    $sql = $updatepost->update($titulo, $autor, $categoria, $data_post, $imagem_atual, $video_atual, $conteudo, $slug, $destaque, $postid);

    if ($sql) {
        echo "<script>alert('Post atualizado com sucesso!');</script>";
        echo "<script>window.location.href='lista_post'</script>";
    } else {
        echo "<script>alert('Algo deu errado! Tente novamente!');</script>";
        echo "<script>window.location.href='edita_post?id=$postid'</script>";
    }
}

// Carregar dados do post para edição
$postid = $_GET['id'];
$post = $updatepost->fetchonerecord($postid);

// Incluir cabeçalho, barra lateral e barra superior
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
            <?php while ($row = mysqli_fetch_array($post)) { ?>
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
                                <input type="text" class="form-control form-control-user" id="titulo" name="titulo" value="<?php echo htmlspecialchars($row['titulo']); ?>" oninput="generateSlug()">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="categoria">Categoria</label>
                                <select class="form-control" id="categoria" name="categoria">
                                    <?php
                                    $categorias = $fetchonerecord->fetchdata("categoria");
                                    foreach ($categorias as $categoria) {
                                        $selected = ($categoria['id'] == $row['categoria']) ? 'selected' : '';
                                        echo "<option value='" . $categoria['id'] . "' $selected>" . $categoria['categoria'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control form-control-user" id="slug" name="slug" value="<?php echo $row['slug']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="autor">Autor</label>
                                <input type="text" class="form-control form-control-user" id="autor" name="autor" value="<?php echo htmlspecialchars($row['autor']); ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="data_post">Data do Post</label>
                                <input type="date" class="form-control form-control-user" id="data_post" name="data_post" value="<?php echo $row['data_post']; ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="media">Imagem ou Vídeo</label>
                                <!-- Exibe apenas um input file para imagem ou vídeo -->
                                <div>
                                    <input type="file" class="form-control-file" id="media" name="media" accept="image/*,video/*">
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="imagem">Mídia atual</label>
                                <?php if (!empty($row['imagem'])) { ?>
                                    <img src="<?php echo $row['imagem']; ?>" alt="Imagem atual" width="100%">
                                <?php } elseif (!empty($row['video'])) { ?>
                                    <video width="100%" controls>
                                        <source src="<?php echo $row['video']; ?>" type="video/mp4">
                                        Seu navegador não suporta o elemento de vídeo.
                                    </video>
                                <?php } else { ?>
                                    <p>Não há mídia registrada.</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="conteudo">Conteúdo</label>
                                <textarea name="conteudo" id="conteudo" class="form-control"><?php echo $row['conteudo']; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <input type="submit" class="btn btn-success" value="Atualizar" name="update">
                </form>
            <?php } ?>
        </div>
    </div>
</div>
<!-- End of Page Content -->

<script>
    function generateSlug() {
        var titulo = document.getElementById('titulo').value;
        var slug = slugify(titulo);
        document.getElementById('slug').value = slug;
    }

    function slugify(text) {
        var slug = text.toString().toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, "") // Remove acentos
            .replace(/[^a-z0-9-]/g, '-') // Substitui caracteres especiais por -
            .replace(/\-\-+/g, '-') // Substitui múltiplos --
            .replace(/^-+/, '') // Remove hífens no início
            .replace(/-+$/, ''); // Remove hífens no final
        return slug;
    }
</script>

<?php require_once "footer.php"; ?>