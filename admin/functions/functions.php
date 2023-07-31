<?php 
    define('DB_SERVER', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'blog');

    class Usuario {
        function __construct() {
            $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $this->dbcon = $conn;

            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL : " . mysqli_connect_error();
            }
        }
        public function insert($nome, $email, $data_cadastro, $senha) {
            // Criptografa a senha usando password_hash()
            $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
            
            $result = mysqli_query($this->dbcon, "INSERT INTO usuarios(nome, email, data_cadastro, senha) VALUES('$nome', '$email', '$data_cadastro', '$senhaCriptografada')");
            return $result;
        }

        public function fetchdata() {
            $result = mysqli_query($this->dbcon, "SELECT * FROM usuarios");
            return $result;
        }

        public function fetchonerecord($userid) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM usuarios WHERE id = '$userid'");
            return $result;
        }

        public function update($nome, $email, $data_cadastro, $senha, $userid) {
            // Criptografa a senha usando password_hash()
            $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
        
            $result = mysqli_query($this->dbcon, "UPDATE usuarios SET 
                nome             = '$nome', 
                email            = '$email', 
                data_cadastro    = '$data_cadastro', 
                senha            = '$senhaCriptografada'
                WHERE id         = '$userid'"
            );
            return $result;
        }
        

        public function delete($userid) {
            $deleterecord = mysqli_query($this->dbcon, "DELETE FROM usuarios WHERE id = '$userid'");
            return $deleterecord;
        }

        public function countUsers() {
            $result = mysqli_query($this->dbcon, "SELECT COUNT(*) AS total FROM usuarios");
            $row = mysqli_fetch_assoc($result);
            return $row['total'];
        }
    }


    class Categoria {

        function __construct() {
            $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $this->dbcon = $conn;

            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL : " . mysqli_connect_error();
            }
        }

        public function insert($categoria) {
            $result = mysqli_query($this->dbcon, "INSERT INTO categorias(categoria) VALUES('$categoria')");
            return $result;
        }

        public function fetchdata() {
            $result = mysqli_query($this->dbcon, "SELECT * FROM categorias");
            return $result;
        }

        public function fetchonerecord($categoria) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM categorias WHERE id = '$categoria'");
            return $result;
        }

        public function update($categoria, $categoriaid) {
            $result = mysqli_query($this->dbcon, "UPDATE categorias SET 
                categoria   = '$categoria'
                WHERE id    = '$categoriaid'"
            );
            return $result;
        }

        public function delete($categoriaid) {
            $deleterecord = mysqli_query($this->dbcon, "DELETE FROM categorias WHERE id = '$categoriaid'");
            return $deleterecord;
        }

        public function countCategorias() {
            $result = mysqli_query($this->dbcon, "SELECT COUNT(*) AS total FROM categorias");
            $row = mysqli_fetch_assoc($result);
            return $row['total'];
        }

    }

class Post {
    private $dbcon;

    public function __construct() {
        $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }

        $this->dbcon = $conn;
    }

    public function insert($titulo, $autor, $categoria, $data_post, $imagem, $conteudo, $slug, $destaque) {
        $titulo     = mysqli_real_escape_string($this->dbcon, $titulo);
        $autor      = mysqli_real_escape_string($this->dbcon, $autor);
        $categoria  = mysqli_real_escape_string($this->dbcon, $categoria);
        $data_post  = mysqli_real_escape_string($this->dbcon, $data_post);
        $imagem     = mysqli_real_escape_string($this->dbcon, $imagem);
        $conteudo   = mysqli_real_escape_string($this->dbcon, $conteudo);
        $slug       = mysqli_real_escape_string($this->dbcon, $slug);
        $destaque   = mysqli_real_escape_string($this->dbcon, $destaque);

        $query = "INSERT INTO posts (titulo, autor, categoria, data_post, imagem, conteudo, slug, destaque) VALUES ('$titulo', '$autor', '$categoria', '$data_post', '$imagem', '$conteudo', '$slug', '$destaque')";
        $result = mysqli_query($this->dbcon, $query);

        if (!$result) {
            echo "Error: " . mysqli_error($this->dbcon);
        }

        return $result;
    }

    public function fetchdata() {
        $query = "SELECT * FROM posts";
        $result = mysqli_query($this->dbcon, $query);
        return $result;
    }

    public function fetchonerecord($postid) {
        $postid = mysqli_real_escape_string($this->dbcon, $postid);

        $query = "SELECT * FROM posts WHERE id = '$postid'";
        $result = mysqli_query($this->dbcon, $query);
        return $result;
    }

    public function update($titulo, $autor, $categoria, $data_post, $imagem, $conteudo, $slug, $destaque, $postid) {
        $titulo = mysqli_real_escape_string($this->dbcon, $titulo);
        $autor = mysqli_real_escape_string($this->dbcon, $autor);   
        $data_post = mysqli_real_escape_string($this->dbcon, $data_post);
        $imagem = mysqli_real_escape_string($this->dbcon, $imagem);
        $conteudo = mysqli_real_escape_string($this->dbcon, $conteudo);
        $slug = mysqli_real_escape_string($this->dbcon, $slug);
        $destaque = mysqli_real_escape_string($this->dbcon, $destaque);
        $postid = mysqli_real_escape_string($this->dbcon, $postid);
    
        $categoria = mysqli_real_escape_string($this->dbcon, $categoria);
        $query = "UPDATE posts SET 
                    titulo = '$titulo', 
                    autor = '$autor',
                    categoria = '$categoria', 
                    data_post = '$data_post', 
                    imagem = '$imagem', 
                    conteudo = '$conteudo',
                    slug = '$slug',
                    destaque = '$destaque'
                    WHERE id = '$postid'";
    
        $result = mysqli_query($this->dbcon, $query);
    
        if ($result) {
            return true;
        } else {
            echo "Error: " . mysqli_error($this->dbcon);
            return false;
        }
    }
    
    public function delete($postid) {
        $postid = mysqli_real_escape_string($this->dbcon, $postid);

        $query = "DELETE FROM posts WHERE id = '$postid'";
        $result = mysqli_query($this->dbcon, $query);

        if (!$result) {
            echo "Error: " . mysqli_error($this->dbcon);
        }

        return $result;
    }

    public function countPosts() {
        $result = mysqli_query($this->dbcon, "SELECT COUNT(*) AS total FROM posts");
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    function generateSlug($str) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $str), '-'));
        return $slug;
    }

    function getSlugFromID($mysqli, $postID) {
        // Consulta ao banco de dados para obter o slug com base no ID
        $query = "SELECT slug FROM posts WHERE id = '$postID'";
        $result = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['slug'];
    }
}


class CategoriasManager {
    private $dbcon;

    public function __construct() {
        $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }

        $this->dbcon = $conn;
    }

    public function fetchCategorias() {
        $query = "SELECT id, categoria FROM categorias";
        $result = mysqli_query($this->dbcon, $query);

        if (!$result) {
            echo "Error: " . mysqli_error($this->dbcon);
            exit();
        }

        $categorias = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $categorias[] = $row;
        }

        return $categorias;
    }
}

?>

