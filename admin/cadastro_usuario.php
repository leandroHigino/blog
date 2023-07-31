<?php 
    require_once "functions/protect.php";
    require_once "functions/functions.php";

    $fetchdata = new Usuario();

    $insertdata = new Usuario();

    if (isset($_POST['insert'])) {
        $nome           = $_POST['nome'];
        $email          = $_POST['email'];
        $data_cadastro  = $_POST['data_cadastro'];
        $senha          = $_POST['senha'];
    
        // Criptografa a senha usando password_hash()
        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
    
        $sql = $insertdata->insert($nome, $email, $data_cadastro, $senhaCriptografada);
    
        if ($sql) {
            echo "<script>alert('Usuário inserido com sucesso!');</script>";
            echo "<script>window.location.href='lista_usuario'</script>";
        } else {
            echo "<script>alert('Algo deu errado! Tente novamente!');</script>";
            echo "<script>window.location.href='cadastro_usuario'</script>";
        }
    }
    
    
    
    require_once "header.php"; 
?>
<!-- Sidebar -->
<?php require_once "sidebar.php";

    require_once "topbar.php"; ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">

              <!-- Page Heading -->
              <h1 class="h3 mb-4 text-gray-800">Cadastro de Usuários</h1>
                
            <!-- Forms Example -->
            <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="post">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nome">Nome</label>
                                        <input type="nome" class="form-control form-control-user"
                                            id="nome" name="nome" aria-describedby="emailHelp"
                                            placeholder="Nome">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="email" class="form-control form-control-user"
                                            id="email" name="email" aria-describedby="emailHelp"
                                            placeholder="E-mail">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="data_cadastro">Data de Cadastro</label>
                                        <input type="date" class="form-control form-control-user"
                                            id="data_cadastro" name="data_cadastro" aria-describedby="emailHelp"
                                            placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="senha">Senha</label>
                                        <input type="password" class="form-control form-control-user"
                                            id="senha" name="senha" aria-describedby="emailHelp"
                                            placeholder="Senha">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary" name="insert">Cadastrar Usuário</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                    <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

    <?php require "footer.php"; ?>