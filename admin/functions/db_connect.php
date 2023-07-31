<?php 
    // Mostrar o erro prontado na tela 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    


    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $mysqli = new mysqli('localhost', 'root', '', 'blog');

    $mysqli->set_charset('utf8mb4');

    // printf("Success... %s\n", $mysqli->host_info);

?>