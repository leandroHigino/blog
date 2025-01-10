<?php
require_once "functions/protect.php";
require_once "functions/functions.php";

// Inicializar objetos
$fetchonerecord = new Categoria();
$updatepost = new Post();

// Processar formulário de atualização
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
    $video = $_POST['video']; // Novo campo de vídeo

    // Obter o post atual para recuperar o caminho da imagem ou vídeo atual
    $post = $updatepost->fetchonerecord($postid);
    if ($post && $post->num_rows > 0) {
        $row = $post->fetch_assoc();
        $imagem_atual = $row['imagem']; // Caminho da imagem atual do post
        $video_atual = $row['video'];  // Caminho do vídeo atual
    } else {
        // Lidar com o caso em que o post não é encontrado
        echo "<script>alert('Post não encontrado!');</script>";
        echo "<script>window.location.href='edita_post?id=$postid'</script>";
        exit; // Encerrar o script após redirecionar
    }

    // Verificar se uma nova imagem foi enviada
    if (!empty($_FILES["imagem"]["name"])) {
        // Novo arquivo de imagem selecionado
        $imagem_name = $_FILES["imagem"]["name"];
        $imagem_name = str_replace(' ', '_', $imagem_name); // Substituir espaços por underscores

        $imagem_path = "uploads/" . basename($imagem_name);

        // Validar o tipo de arquivo
        $check = getimagesize($_FILES["imagem"]["tmp_name"]);
        if ($check !== false) {
            // Mover o arquivo para o diretório de uploads
            if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem_path)) {
                // Usar o caminho da nova imagem
                $imagem_atual = $imagem_path;
                $video_atual = null; // Remover o vídeo se a imagem for substituída
            } else {
                echo "<script>alert('Erro ao enviar a imagem!');</script>";
            }
        } else {
            echo "<script>alert('O arquivo selecionado não é uma imagem válida!');</script>";
        }
    }

    // Verificar se um novo vídeo foi enviado
    if (!empty($_FILES["video"]["name"])) {
        // Novo arquivo de vídeo selecionado
        $video_name = $_FILES["video"]["name"];
        $video_name = str_replace(' ', '_', $video_name); // Substituir espaços por underscores

        $video_path = "uploads/" . basename($video_name);

        // Validar o tipo de arquivo
        $video_type = mime_content_type($_FILES["video"]["tmp_name"]);
        if (strpos($video_type, 'video') !== false) {
            // Mover o arquivo para o diretório de uploads
            if (move_uploaded_file($_FILES["video"]["tmp_name"], $video_path)) {
                // Usar o caminho do novo vídeo
                $video_atual = $video_path;
                $imagem_atual = null; // Remover a imagem se o vídeo for substituído
            } else {
                echo "<script>alert('Erro ao enviar o vídeo!');</script>";
            }
        } else {
            echo "<script>alert('O arquivo selecionado não é um vídeo válido!');</script>";
        }
    }

    // Se não houver imagem ou vídeo, manter os arquivos atuais
    if (empty($_FILES["imagem"]["name"]) && empty($_FILES["video"]["name"])) {
        // Não houve troca de mídia, manter os arquivos atuais
        $imagem_atual = $imagem_atual ? $imagem_atual : null;
        $video_atual = $video_atual ? $video_atual : null;
    }

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
            <?php
            // Exibir formulário para edição do post
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
                                    // Carregar opções de categorias
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
                                <input type="text" class="form-control form-control-user" id="slug" name="slug" aria-describedby="emailHelp" placeholder="Título" value="<?php echo $row['slug']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-2">
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
                                <label for="imagem">Imagem ou Vídeo</label>
                                <!-- Se existe imagem, exibe a imagem e permite alterar a imagem -->
                                <?php if (!empty($row['imagem'])) { ?>
                                    <div style="display: flex; align-items: center;">
                                        <input type="file" class="form-control-file" id="imagem" name="imagem" accept="image/*">
                                    </div>
                                <?php } ?>
                                <!-- Se existe vídeo, exibe o vídeo e permite alterar o vídeo -->
                                <?php if (!empty($row['video'])) { ?>
                                    <div style="display: flex; align-items: center;">
                                        <video width="50%" height="auto" style="margin-right: 10px;" controls>
                                            <source src="<?php echo $row['video']; ?>" type="video/mp4">
                                            Seu navegador não suporta o elemento de vídeo.
                                        </video>
                                        <input type="file" class="form-control-file" id="video" name="video" accept="video/*">
                                    </div>
                                <?php } ?>
                                <!-- Se não existe nem imagem nem vídeo, exibe ambos os inputs vazios -->
                                <?php if (empty($row['imagem']) && empty($row['video'])) { ?>
                                    <input type="file" class="form-control-file" id="imagem" name="imagem" accept="image/*">
                                    <input type="file" class="form-control-file" id="video" name="video" accept="video/*">
                                <?php } ?>
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
            .normalize('NFD') // Normaliza os caracteres acentuados
            .replace(/[\u0300-\u036f]/g, '') // Remove os diacríticos
            .replace(/\s+/g, '-') // Substitui espaços em branco por hífens
            .replace(/[^\w\-]+/g, '') // Remove caracteres especiais
            .replace(/\-\-+/g, '-') // Substitui múltiplos hífens por um único hífen
            .replace(/^-+/, '') // Remove hífens do início
            .replace(/-+$/, ''); // Remove hífens do final
        return slug;
    }
</script>

<!-- Incluir rodapé -->
<?php
require_once "footer.php";
?>