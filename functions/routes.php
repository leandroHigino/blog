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

            case 'categoria':
                include_once("categoria.php");
            break;
            case 'post':
                include_once("post.php");
            break;
            
        }
    }
?>