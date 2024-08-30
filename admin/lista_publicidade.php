<?php
require_once "functions/functions.php";
require_once "functions/protect.php";

$fetchonerecord = new Publicidade();

require_once "header.php";

?>
<!-- Sidebar -->
<?php require_once("sidebar.php"); ?>

<?php require_once("topbar.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Lista de Publicidades</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Imagem</th>
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
                                <td><img src="<?php echo $row['imagem']; ?>" width="30" height="30" /></td>
                                <td class="text-center">
                                    <a href="edita_publicidade?id=<?php echo $row['id']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    <a href="delete_publicidade?del=<?php echo $row['id']; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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