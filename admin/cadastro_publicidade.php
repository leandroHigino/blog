<?php
require_once "functions/protect.php";
require_once "functions/functions.php";
require_once "header.php";

// Instancia a classe Publicidade
$publicidade = new Publicidade();

// Verifica se o formulário foi enviado
if (isset($_POST['insert'])) {
    // Verifica se o arquivo foi enviado sem erros
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        // Chama a função insert da classe Publicidade
        if ($publicidade->insert($_FILES['imagem'])) {
            // Se o cadastro for bem-sucedido, redireciona para a página lista_publicidade.php
            header("Location: lista_publicidade");
            exit(); // Encerra o script após o redirecionamento
        } else {
            echo "<div class='alert alert-danger'>Erro ao cadastrar publicidade.</div>";
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
    <h1 class="h3 mb-4 text-gray-800">Cadastro de Publicidade</h1>

    <!-- Forms Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="imagem">Imagem</label>
                            <input type="file" class="form-control-file" id="imagem" name="imagem" accept="image/*" required>
                        </div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-primary" name="insert">Cadastrar Publicidade</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php require_once "footer.php"; ?>