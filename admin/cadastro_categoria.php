<?php 
    require_once "functions/protect.php";
    require_once "functions/functions.php";

    $fetchdata = new Categoria();

    $insertdata = new Categoria();

    if (isset($_POST['insert'])) {
        $categoria = $_POST['categoria'];

        $sql = $insertdata->insert($categoria);

        if ($sql) {
            echo "<script>alert('Categoria inserida com sucesso!');</script>";
            echo "<script>window.location.href='lista_categoria'</script>";
        } else {
            echo "<script>alert('Algo deu errado! Tente novamente!');</script>";
            echo "<script>window.location.href='cadastro_categoria'</script>";
        }
    }


    require_once "header.php"; 
?>

    
    <?php require_once "sidebar.php"; ?>
        
        <?php require_once "topbar.php"; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Cadastro de Categoria</h1>

            <!-- Forms Example -->
            <div class="card shadow mb-4">
                    <div class="card-body">
                    <form method="post">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="categoria">Categoria</label>
                                        <input type="text" class="form-control form-control-user"
                                            id="categoria" name="categoria" aria-describedby="emailHelp"
                                            placeholder="Categoria">
                                    </div>
                                </div>
                            </div>
                            <br>
                           
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary" name="insert">Cadastrar Categoria</button>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
<!-- /.container-fluid -->


<?php require_once "footer.php"; ?>