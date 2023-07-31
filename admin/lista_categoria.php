<?php 
    require_once "functions/functions.php";
    require_once "functions/protect.php";

    $fetchonerecord = new Categoria();

    require_once "header.php"; 

?>
        <!-- Sidebar -->
        <?php require_once("sidebar.php"); ?>

            <?php require_once("topbar.php"); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Lista de Categoria</h1>

                            <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Categoria</th>
                                            <th class="text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql = $fetchonerecord->fetchdata();
                                            while ($row = mysqli_fetch_array($sql)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['categoria']; ?></td>
                                            <td class="text-center">
                                                <a href="edita_categoria?id=<?php echo $row['id']; ?>" class="btn btn-warning" ><i class="fas fa-edit"></i></a>
                                                <a href="delete_categoria?del=<?php echo $row['id']; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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