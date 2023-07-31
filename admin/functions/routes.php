<?php 
    function routesURL(){
        if (isset($_GET["url"])) {
            $url = $_GET["url"] ? $_GET["url"] : "home";
        } else {
            $url = "home";
        }
        
        switch ($url) {
            case 'home':
                include_once("home.php");
            break;
            case 'lista_usuario':
                include_once("lista_usuario.php");
            break;
            case 'cadastro_usuario':
                include_once("cadastro_usuario.php");
            break;
            case 'lista_post':
                include_once("lista_post.php");
            break;
            case 'cadastro_post':
                include_once("cadastro_post.php");
            break;
            case 'lista_categoria':
                include_once("lista_categoria.php");
            break;
            case 'cadastro_categoria':
                include_once("cadastro_categoria.php");
            break;
            case 'backup_blog':
                include_once("backup_blog.php");
            break;
            case 'politica':
                include_once("politica.php");
            break;
            // default:
            //     include_once("404.php");
            // break;
        }
    }
?>