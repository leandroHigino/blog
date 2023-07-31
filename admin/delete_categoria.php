<?php 

    require "functions/functions.php";

    if (isset($_GET['del'])) {
        $categoriaid = $_GET['del'];
        $deletedata = new Categoria();
        $sql = $deletedata->delete($categoriaid);

        if ($sql) {
            echo "<script>alert('Categoria apagada com sucesso!');</script>";
            echo "<script>window.location.href='lista_categoria'</script>";
        }
    }

?>