<?php

require "functions/functions.php";

if (isset($_GET['del'])) {
    $categoriaid = $_GET['del'];
    $deletedata = new Publicidade();
    $sql = $deletedata->delete($categoriaid);

    if ($sql) {
        echo "<script>alert('Publicidade apagada com sucesso!');</script>";
        echo "<script>window.location.href='lista_publicidade'</script>";
    }
}
