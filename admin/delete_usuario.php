<?php 

    require "functions/functions.php";

    if (isset($_GET['del'])) {
        $userid = $_GET['del'];
        $deletedata = new Usuario();
        $sql = $deletedata->delete($userid);

        if ($sql) {
            echo "<script>alert('Usuário apagado com sucesso!');</script>";
            echo "<script>window.location.href='lista_usuario'</script>";
        }
    }

?>