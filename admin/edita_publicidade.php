<?php
require_once "functions/protect.php";
require_once "functions/functions.php";
require_once "header.php";

// Instancia a classe Publicidade
$publicidade = new Publicidade();

// Inicializa variáveis para mensagens de sucesso e erro
$alertMessage = '';
$alertType = '';

// Verifica se o ID da publicidade está presente na URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $alertMessage = "ID da publicidade não fornecido.";
    $alertType = "danger";
} else {
    $id = intval($_GET['id']);

    // Carrega os dados da publicidade a ser editada
    $publicidadeData = $publicidade->fetchonerecord($id);
    if ($publicidadeData->num_rows == 0) {
        $alertMessage = "Publicidade não encontrada.";
        $alertType = "danger";
    } else {
        $row = $publicidadeData->fetch_assoc();

        // Verifica se o formulário foi enviado
        if (isset($_POST['update'])) {
            // Verifica se o arquivo foi enviado sem erros
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
                // Chama a função update da classe Publicidade
                if ($publicidade->update($id, $_FILES['imagem'])) {
                    $alertMessage = "Publicidade atualizada com sucesso!";
                    $alertType = "success";
                    // Redireciona após 2 segundos para mostrar a mensagem
                    header("Refresh: 2; url=lista_publicidade.php");
                } else {
                    $alertMessage = "Erro ao atualizar publicidade.";
                    $alertType = "danger";
                }
            } else {
                $alertMessage = "Nenhuma imagem foi selecionada ou houve um erro no upload.";
                $alertType = "danger";
            }
        }
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
            <!-- Exibe mensagem de sucesso ou erro -->
            <?php if (!empty($alertMessage)): ?>
                <div id="alert-message" class="alert alert-<?php echo htmlspecialchars($alertType); ?>" role="alert">
                    <?php echo htmlspecialchars($alertMessage); ?>
                </div>
            <?php endif; ?>

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
                            <img src="<?php echo htmlspecialchars($row['imagem']); ?>" width="100%" height="auto" alt="Imagem Atual" />
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

<!-- JavaScript para ocultar o alerta após 3 segundos -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var alertMessage = document.getElementById('alert-message');
        if (alertMessage) {
            setTimeout(function() {
                alertMessage.style.display = 'none';
            }, 3000); // 3000 milissegundos = 3 segundos
        }
    });
</script>