<?php

require "functions/functions.php";

if (isset($_GET['del'])) {
    $postid = $_GET['del'];
    $deletedata = new post();
    $sql = $deletedata->delete($postid);

    if ($sql) {
        echo "<script>alert('Post apagado com sucesso!');</script>";
        echo "<script>window.location.href='lista_post'</script>";
    }
}
