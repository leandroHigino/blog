<?php 
    require_once "functions/functions.php";
    require_once "functions/protect.php";

    $fetchdata = new Usuario();

    require_once "header.php"; 

?>
        <!-- Sidebar -->
        <?php require_once("sidebar.php"); ?>

            <?php require_once("topbar.php"); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Lista de Usuários</h1>

                            <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nome</th>
                                            <th>E-mail</th>
                                            <th>Data de Cadastro</th>
                                            <th class="text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql = $fetchdata->fetchdata();
                                            while ($row = mysqli_fetch_array($sql)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['nome']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td>
                                                <?php 
                                                    $data = $row['data_cadastro'];
                                                    $data = date("d/m/Y", strtotime($data));
                                                    echo $data;
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="edita_usuario?id=<?php echo $row['id']; ?>" class="btn btn-warning" ><i class="fas fa-edit"></i></a>
                                                <a href="delete_usuario?del=<?php echo $row['id']; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

    <?php require "footer.php"; ?>