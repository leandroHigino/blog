<?php
require_once "functions/functions.php";
require_once "functions/protect.php";

$fetchonerecord = new Post();

require_once "header.php";
?>
<!-- Sidebar -->
<?php require_once "sidebar.php"; ?>

<?php require_once "topbar.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Lista de Posts</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead style="font-size: 1rem;">
                        <tr>
                            <th>Id</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Categoria</th>
                            <th>Data</th>
                            <th>Mídia</th>
                            <th>Conteúdo</th>
                            <th>Destaque</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.8rem;">
                        <?php
                        $sql = $fetchonerecord->fetchdata();
                        while ($row = mysqli_fetch_array($sql)) {
                            $destaque = $row['destaque'] ? 'Sim' : 'Não';

                            // Buscar o nome da categoria com base no ID
                            $categoria_id = $row['categoria'];
                            $categoria_nome = $fetchonerecord->getCategoryName($categoria_id);
                            $imagem = $row['imagem'];
                            $video = $row['video'];
                        ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars(substr($row['titulo'], 0, 25)) . '...'; ?></td>
                                <td><?php echo $row['autor']; ?></td>
                                <td><?php echo $categoria_nome; ?></td>
                                <td><?php echo date("d/m/Y", strtotime($row['data_post'])); ?></td>
                                <td>
                                    <?php if ($video): ?>
                                        <!-- Exibe o vídeo como miniatura -->
                                        <video width="50" height="30" controls>
                                            <source src="<?php echo $video; ?>" type="video/mp4">
                                        </video>
                                    <?php elseif ($imagem): ?>
                                        <!-- Exibe a imagem como miniatura -->
                                        <img src="<?php echo $imagem; ?>" width="50" height="30" />
                                    <?php else: ?>
                                        <!-- Se não houver imagem ou vídeo, exibe um ícone genérico -->
                                        <i class="fas fa-file"></i>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars(substr(strip_tags($row['conteudo']), 0, 25)) . '...'; ?></td>
                                <td><?php echo $destaque; ?></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Ações">
                                        <a href="edita_post?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                        <a href="delete_post?del=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                    </div>
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

<?php require "footer.php"; ?>