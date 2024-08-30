<?php
require_once "functions/protect.php";
require_once "functions/functions.php";
require_once "header.php";

// Instancia a classe Publicidade
$publicidade = new Publicidade();

// Verifica se o ID da publicidade está presente na URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID da publicidade não fornecido.</div>";
    exit();
}

$id = intval($_GET['id']);

// Carrega os dados da publicidade a ser editada
$publicidadeData = $publicidade->fetchonerecord($id);
if ($publicidadeData->num_rows == 0) {
    echo "<div class='alert alert-danger'>Publicidade não encontrada.</div>";
    exit();
}
$row = $publicidadeData->fetch_assoc();

// Verifica se o formulário foi enviado
if (isset($_POST['update'])) {
    // Verifica se o arquivo foi enviado sem erros
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        // Chama a função update da classe Publicidade
        if ($publicidade->update($id, $_FILES['imagem'])) {
            // Se a atualização for bem-sucedida, redireciona para a página lista_publicidade.php
            header("Location: lista_publicidade.php");
            exit(); // Encerra o script após o redirecionamento
        } else {
            echo "<div class='alert alert-danger'>Erro ao atualizar publicidade.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Nenhuma imagem foi selecionada ou houve um erro no upload.</div>";
    }
}

?>

<?php require_once "sidebar.php"; ?>
<?php require_once "topbar.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Editar Publicidade</h1>

    <!-- Forms Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label for="imagem">Nova Imagem</label>
                            <input type="file" class="form-control-file" id="imagem" name="imagem" accept="image/*">
                            <small class="form-text text-muted">Deixe em branco se não deseja alterar a imagem.</small>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="imagem">Imagem Atual</label>
                            <img src="uploads/publicidade/<?php echo htmlspecialchars($row['imagem']); ?>" width="100%" height="auto" alt="Imagem Atual" />
                        </div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-primary" name="update">Atualizar Publicidade</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php require_once "footer.php"; ?>